<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Bill;
use App\Models\Order;
use App\Models\Service;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * Store a new order for an appointment and update/create the associated bill.
     *
     * This method merges two flows:
     *  - create the clinical order and its items
     *  - create / update the bill for the appointment, adding the ordered services
     *
     * Safety: performs a restriction check for formulary items and runs all DB writes inside a transaction.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment   $appointment
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Appointment $appointment, NotificationService $notificationService)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.service_id' => 'required|exists:services,id',
            'items.*.dosage' => 'nullable|string|max:255',
            'items.*.instructions' => 'nullable|string|max:255',
        ]);

        // Load the selected services
        $serviceIds = collect($validated['items'])->pluck('service_id');
        $services = Service::find($serviceIds);

        // Restriction check (formulary)
        foreach ($services as $service) {
            if ($service->formulary_status === 'Restricted') {
                throw ValidationException::withMessages([
                    'items' => "The medication/service '{$service->name}' is restricted."
                ]);
            }
        }

        DB::transaction(function () use ($validated, $appointment, $services, $notificationService) {
            // Create the clinical order
            $order = Order::create([
                'patient_id'         => $appointment->patient_id,
                'appointment_id'     => $appointment->id,
                'ordered_by_user_id' => Auth::id(),
                'status'             => 'Pending',
            ]);

            // Create order items and handle inpatient pharmacy auto-MAR population
            foreach ($validated['items'] as $itemData) {
                $item = $order->items()->create([
                    'service_id' => $itemData['service_id'],
                    'status' => 'Pending',
                    'dosage' => $itemData['dosage'] ?? null,
                    'instructions' => $itemData['instructions'] ?? null,
                    'placer_order_number' => 'ORD-' . Str::upper(Str::random(5)) . '-' . $order->id,
                ]);

                // If the patient is currently admitted and the ordered service is a pharmacy item,
                // auto-create a medication administration record on the current admission (MAR).
                $patient = $appointment->patient()->with('currentAdmission')->first();
                if ($patient && $patient->currentAdmission && $item->service && $item->service->department === 'Pharmacy') {
                    // Ensure relationship exists on the admission model
                    if (method_exists($patient->currentAdmission, 'medicationAdministrations')) {
                        $patient->currentAdmission->medicationAdministrations()->create([
                            'order_item_id'  => $item->id,
                            'scheduled_time' => now(),
                            'status'         => 'Due',
                        ]);
                    }
                }
            }

            // Send notifications based on department
            $hasLabItem = $services->contains(fn($service) => $service->department === 'Laboratory');
            if ($hasLabItem) {
                $patientName = $appointment->patient->full_name;
                $notificationService->sendToRole(
                    'lab',
                    "New lab order placed for patient: {$patientName}",
                    route('lab.index')
                );
            }

            // Billing logic: find or create a bill for this appointment
            $bill = Bill::firstOrCreate(
                ['appointment_id' => $appointment->id],
                [
                    'patient_id'   => $appointment->patient_id,
                    'total_amount' => 0,
                    'status'       => 'Unpaid',
                ]
            );

            // Add newly ordered services to the bill.
            // Prefer high-level addService() if model provides it, otherwise create bill items directly.
            foreach ($services as $service) {
                if (method_exists($bill, 'addService') && is_callable([$bill, 'addService'])) {
                    // If Bill::addService handles quantity/pricing/relationships internally
                    $bill->addService($service);
                } elseif (method_exists($bill, 'items')) {
                    // Fallback: create bill item record assuming bill->items() relation exists
                    $unitPrice = $service->price ?? 0;
                    $bill->items()->create([
                        'service_id'  => $service->id,
                        'quantity'    => 1,
                        'unit_price'  => $unitPrice,
                        'total_price' => $unitPrice * 1,
                    ]);
                } else {
                    // As a last resort, accumulate into total_amount (will be persisted below)
                    $bill->total_amount += ($service->price ?? 0);
                }
            }

            // Recalculate totals: prefer model's recalculateTotals() if available
            if (method_exists($bill, 'recalculateTotals') && is_callable([$bill, 'recalculateTotals'])) {
                $bill->recalculateTotals();
            } else {
                // Compute sum from related bill items if relation exists
                if (method_exists($bill, 'items')) {
                    $sum = (float) $bill->items()->sum('total_price');
                    $bill->total_amount = $sum;
                    $bill->save();
                } else {
                    // If no items relation, ensure we persist whatever total_amount we have
                    $bill->save();
                }
            }

            // If the bill was previously marked Paid or Void, reset to Unpaid because new items were added
            if (in_array($bill->status, ['Paid', 'Void'])) {
                $bill->update(['status' => 'Unpaid']);
            }
        });

        return redirect()
            ->back()
            ->with('success', 'Order placed and bill updated successfully.');
    }
}

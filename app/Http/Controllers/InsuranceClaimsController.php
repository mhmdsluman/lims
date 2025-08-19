<?php

namespace App\Http\Controllers;

use App\Models\BillItem;
use App\Models\InsuranceProvider;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InsuranceClaimsController extends Controller
{
    public function index(Request $request)
    {
        $providers = InsuranceProvider::where('is_active', true)->orderBy('name')->get();
        $reportData = null;

        if ($request->has(['provider_id', 'start_date', 'end_date'])) {
            $request->validate([
                'provider_id' => 'required|exists:insurance_providers,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            $reportData = BillItem::with(['bill.patient', 'service'])
                ->whereHas('bill.patient.insurancePolicies.plan', function ($query) use ($request) {
                    $query->where('insurance_provider_id', '=', $request->provider_id);
                })
                ->where('insurance_amount', '>', 0)
                ->whereBetween('created_at', [$request->start_date, $request->end_date])
                ->get();
        }

        return Inertia::render('InsuranceClaims/Index', [
            'providers' => $providers,
            'reportData' => $reportData,
            'filters' => $request->only(['provider_id', 'start_date', 'end_date']),
        ]);
    }
}

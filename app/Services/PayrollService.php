<?php

namespace App\Services;

use App\Models\User;
use App\Models\BillItem;
use App\Models\ServiceCommission;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class PayrollService
{
    /**
     * Calculate the payroll for a given user over a specific date range.
     *
     * @param User $user
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function calculate(User $user, string $startDate, string $endDate): array
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        // 1. Calculate pro-rata base salary (assuming salary is monthly)
        $daysInMonth = $start->daysInMonth;
        $daysInRange = $end->diffInDays($start) + 1;
        $proRataFactor = $daysInRange / $daysInMonth;
        $baseSalary = ($user->salary ?? 0) * $proRataFactor;

        // 2. Find billed services performed by the user
        // This logic assumes the user is the clinician on the appointment linked to the bill.
        $billedItems = BillItem::whereHas('bill.appointment', function ($query) use ($user) {
            $query->where('clinician_id', $user->id);
        })->whereBetween('created_at', [$start, $end])->with('service')->get();

        // 3. Calculate commissions
        $commissionEarnings = 0;
        $commissions = ServiceCommission::where('user_id', $user->id)->pluck('commission_percentage', 'service_id');

        foreach ($billedItems as $item) {
            if (isset($commissions[$item->service_id])) {
                $percentage = $commissions[$item->service_id];
                $commissionEarnings += $item->total_price * ($percentage / 100);
            }
        }

        // 4. Return results
        return [
            'base_salary' => round($baseSalary, 2),
            'commission_earnings' => round($commissionEarnings, 2),
            'total_pay' => round($baseSalary + $commissionEarnings, 2),
            'billed_items' => $billedItems, // For detailed report
        ];
    }
}

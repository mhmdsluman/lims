<?php

namespace App\Services;

use App\Models\Bill;

class BillingService
{
    /**
     * Calculate the insurance coverage and patient co-pay for a given bill based on the patient's insurance plan.
     *
     * @param Bill $bill
     * @return void
     */
    public function calculateBill(Bill $bill): void
    {
        $patient = $bill->patient;
        if (!$patient) {
            return; // Cannot calculate without a patient
        }

        $policy = $patient->insurancePolicies()->where('is_primary', true)->first();

        // If no policy or no plan, patient pays full amount
        if (!$policy || !$policy->plan) {
            foreach ($bill->items as $item) {
                $item->update([
                    'insurance_amount' => 0,
                    'patient_co_pay' => $item->total_price,
                ]);
            }
            $bill->recalculateTotals();
            return;
        }

        $planRules = $policy->plan->rules->keyBy('service_category');

        foreach ($bill->items as $item) {
            $serviceCategory = $item->service->category;
            $insuranceAmount = 0;

            if (isset($planRules[$serviceCategory])) {
                $rule = $planRules[$serviceCategory];
                $potentialCoverage = $item->total_price * ($rule->coverage_percentage / 100);

                // Apply coverage limit if it exists
                if ($rule->coverage_limit && $potentialCoverage > $rule->coverage_limit) {
                    $insuranceAmount = $rule->coverage_limit;
                } else {
                    $insuranceAmount = $potentialCoverage;
                }
            }

            $item->update([
                'insurance_amount' => $insuranceAmount,
                'patient_co_pay' => $item->total_price - $insuranceAmount,
            ]);
        }

        // The Bill model already has a method to sum up item totals
        $bill->recalculateTotals();
    }
}

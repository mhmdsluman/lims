<?php

namespace App\Http\Controllers;

use App\Models\InsurancePlan;
use App\Models\InsuranceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class InsurancePlanController extends Controller
{
    public function index()
    {
        $plans = InsurancePlan::with('provider')->latest()->paginate(10);
        return Inertia::render('InsurancePlans/Index', ['plans' => $plans]);
    }

    public function create()
    {
        $providers = InsuranceProvider::where('is_active', true)->orderBy('name')->get();
        return Inertia::render('InsurancePlans/Create', ['providers' => $providers]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'insurance_provider_id' => 'required|exists:insurance_providers,id',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $plan = InsurancePlan::create($validated);

        return redirect()->route('insurance-plans.edit', $plan->id)->with('success', 'Plan created. You can now add coverage rules.');
    }

    public function edit(InsurancePlan $insurancePlan)
    {
        $insurancePlan->load('rules');
        // Define service categories used in the hospital
        $serviceCategories = ['Consultation', 'Laboratory', 'Radiology', 'Pharmacy', 'Surgery', 'IPD'];

        return Inertia::render('InsurancePlans/Edit', [
            'plan' => $insurancePlan,
            'serviceCategories' => $serviceCategories,
        ]);
    }

    public function update(Request $request, InsurancePlan $insurancePlan)
    {
        $validatedPlan = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $validatedRules = $request->validate([
            'rules' => 'present|array',
            'rules.*.id' => 'nullable|exists:insurance_plan_rules,id',
            'rules.*.service_category' => 'required|string',
            'rules.*.coverage_percentage' => 'required|numeric|min:0|max:100',
            'rules.*.coverage_limit' => 'nullable|numeric|min:0',
            'rules.*.notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($insurancePlan, $validatedPlan, $validatedRules) {
            $insurancePlan->update($validatedPlan);

            $existingRuleIds = $insurancePlan->rules->pluck('id')->all();
            $incomingRuleIds = collect($validatedRules['rules'])->pluck('id')->filter()->all();

            // Delete rules that are no longer present
            $rulesToDelete = array_diff($existingRuleIds, $incomingRuleIds);
            if (!empty($rulesToDelete)) {
                $insurancePlan->rules()->whereIn('id', $rulesToDelete)->delete();
            }

            // Update or create rules
            foreach ($validatedRules['rules'] as $ruleData) {
                $insurancePlan->rules()->updateOrCreate(
                    ['id' => $ruleData['id'] ?? null],
                    $ruleData
                );
            }
        });

        return redirect()->back()->with('success', 'Plan updated successfully.');
    }

    public function destroy(InsurancePlan $insurancePlan)
    {
        $insurancePlan->delete();
        return redirect()->route('insurance-plans.index')->with('success', 'Plan deleted successfully.');
    }
}

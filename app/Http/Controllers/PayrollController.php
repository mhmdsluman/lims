<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\PayrollService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PayrollController extends Controller
{
    public function index(Request $request, PayrollService $payrollService)
    {
        $users = User::whereIn('role', ['clinician', 'nurse', 'radiology', 'ot_manager'])->orderBy('name')->get(['id', 'name', 'role']);
        $reportData = null;

        if ($request->has(['user_id', 'start_date', 'end_date'])) {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            $user = User::find($request->user_id);
            $reportData = $payrollService->calculate($user, $request->start_date, $request->end_date);
        }

        return Inertia::render('Payroll/Index', [
            'users' => $users,
            'reportData' => $reportData,
            'filters' => $request->only(['user_id', 'start_date', 'end_date']),
        ]);
    }
}

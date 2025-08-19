<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCommission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ServiceCommissionController extends Controller
{
    public function index()
    {
        $commissions = ServiceCommission::with(['user', 'service'])->latest()->paginate(10);
        return Inertia::render('ServiceCommissions/Index', ['commissions' => $commissions]);
    }

    public function create()
    {
        $services = Service::orderBy('name')->get(['id', 'name']);
        $users = User::whereIn('role', ['clinician', 'nurse', 'radiology', 'ot_manager'])->orderBy('name')->get(['id', 'name', 'role']);
        return Inertia::render('ServiceCommissions/Create', [
            'services' => $services,
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => [
                'required',
                'exists:services,id',
                Rule::unique('service_commissions')->where(function ($query) use ($request) {
                    return $query->where('user_id', $request->user_id);
                }),
            ],
            'user_id' => 'required|exists:users,id',
            'commission_percentage' => 'required|numeric|min:0|max:100',
        ]);

        ServiceCommission::create($request->all());

        return redirect()->route('service-commissions.index')->with('success', 'Commission rate created successfully.');
    }

    public function destroy(ServiceCommission $serviceCommission)
    {
        $serviceCommission->delete();
        return redirect()->route('service-commissions.index')->with('success', 'Commission rate deleted successfully.');
    }
}

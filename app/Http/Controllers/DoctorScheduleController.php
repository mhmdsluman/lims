<?php

namespace App\Http\Controllers;

use App\Models\DoctorSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DoctorScheduleController extends Controller
{
    public function index()
    {
        $schedules = DoctorSchedule::with('doctor')->latest()->paginate(10);
        return Inertia::render('DoctorSchedules/Index', ['schedules' => $schedules]);
    }

    public function create()
    {
        $doctors = User::where('role', 'clinician')->orderBy('name')->get(['id', 'name']);
        return Inertia::render('DoctorSchedules/Create', ['doctors' => $doctors]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_appointments' => 'required|integer|min:1',
        ]);

        DoctorSchedule::create($request->all());

        return redirect()->route('doctor-schedules.index')->with('success', 'Schedule created successfully.');
    }

    public function destroy(DoctorSchedule $doctorSchedule)
    {
        $doctorSchedule->delete();
        return redirect()->route('doctor-schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}

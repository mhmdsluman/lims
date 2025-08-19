<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Carbon;

class ReceptionController extends Controller
{
    public function index(): Response
    {
        $todaysAppointments = Appointment::with(['patient', 'clinician'])
            ->whereDate('appointment_time', Carbon::today())
            ->orderBy('appointment_time', 'asc')
            ->get();

        return Inertia::render('Reception/Index', [
            'appointments' => $todaysAppointments,
        ]);
    }
}

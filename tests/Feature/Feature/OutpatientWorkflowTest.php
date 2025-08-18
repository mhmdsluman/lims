<?php

namespace Tests\Feature\Feature;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Template;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OutpatientWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_register_a_new_patient()
    {
        $user = User::factory()->create();

        $patientData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1990-01-01',
            'gender' => 'Male',
            'primary_phone_country_code' => '+1',
            'primary_phone' => '1234567890',
            'email' => 'john.doe@example.com',
            'addresses' => [
                [
                    'type' => 'Home',
                    'street' => '123 Main St',
                    'city' => 'Anytown',
                    'state' => 'CA',
                    'postal_code' => '12345',
                    'country' => 'USA',
                ],
            ],
        ];

        $response = $this->actingAs($user)->post('/patients', $patientData);

        $this->assertDatabaseHas('patients', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
        ]);

        $response->assertRedirect('/patients/create');
    }

    public function test_a_user_can_book_a_new_appointment()
    {
        $user = User::factory()->create();
        $patient = Patient::factory()->create();
        $clinician = User::factory()->create(['role' => 'clinician']);
        $appointmentTime = now()->addDay()->setHour(10)->setMinute(0)->setSecond(0);

        $appointmentData = [
            'patient_id' => $patient->id,
            'clinician_id' => $clinician->id,
            'appointment_time' => $appointmentTime->format('Y-m-d\TH:i'),
            'reason_for_visit' => 'Annual Checkup',
        ];

        $response = $this->actingAs($user)->post('/appointments', $appointmentData);

        $this->assertDatabaseHas('appointments', [
            'patient_id' => $patient->id,
            'clinician_id' => $clinician->id,
            'reason_for_visit' => 'Annual Checkup',
        ]);

        $this->assertDatabaseHas('bills', [
            'patient_id' => $patient->id,
            'status' => 'Draft',
        ]);

        $response->assertRedirect('/appointments');
    }

    public function test_a_user_can_record_vitals_and_a_clinical_note()
    {
        $user = User::factory()->create();
        $patient = Patient::factory()->create();
        $appointment = Appointment::factory()->create(['patient_id' => $patient->id]);
        $template = Template::factory()->create(['type' => 'Clinical Note']);
        $field1 = $template->fields()->create(['label' => 'Chief Complaint', 'type' => 'text']);
        $field2 = $template->fields()->create(['label' => 'History of Presenting Illness', 'type' => 'textarea']);

        $vitalsData = [
            'bp_systolic' => 120,
            'bp_diastolic' => 80,
            'heart_rate' => 72,
        ];

        $this->actingAs($user)->post("/appointments/{$appointment->id}/vitals", $vitalsData);

        $this->assertDatabaseHas('vitals', [
            'appointment_id' => $appointment->id,
            'bp_systolic' => 120,
        ]);

        $clinicalNoteData = [
            'template_id' => $template->id,
            'fields' => [
                $field1->id => 'Headache',
                $field2->id => 'Patient reports a headache for the past 2 days.',
            ],
        ];

        $this->actingAs($user)->post("/appointments/{$appointment->id}/consultation", $clinicalNoteData);

        $this->assertDatabaseHas('clinical_notes', [
            'appointment_id' => $appointment->id,
            'template_id' => $template->id,
        ]);

        $this->assertDatabaseHas('clinical_note_data', [
            'value' => 'Headache',
        ]);

        $this->assertEquals('Completed', $appointment->fresh()->status);
    }

    public function test_a_user_can_create_and_verify_a_lab_order()
    {
        $user = User::factory()->create();
        $patient = Patient::factory()->create();
        $appointment = Appointment::factory()->create(['patient_id' => $patient->id]);
        $labService = Service::factory()->create(['department' => 'Laboratory']);

        $orderData = [
            'items' => [
                ['service_id' => $labService->id],
            ],
        ];

        $this->actingAs($user)->post("/appointments/{$appointment->id}/orders", $orderData);

        $this->assertDatabaseHas('orders', [
            'appointment_id' => $appointment->id,
        ]);

        $orderItem = $appointment->orders->first()->items->first();

        $labResultData = [
            'result_value' => '12.5',
            'result_numeric' => 12.5,
        ];

        $this->actingAs($user)->post("/lab/orders/{$orderItem->id}/result", $labResultData);

        $this->assertDatabaseHas('lab_results', [
            'order_item_id' => $orderItem->id,
            'result_value' => '12.5',
        ]);

        $this->assertEquals('Result Ready', $orderItem->fresh()->status);

        $labResult = $orderItem->labResult;

        $this->actingAs($user)->patch("/lab/results/{$labResult->id}/verify");

        $this->assertEquals('Completed', $orderItem->fresh()->status);
    }
}

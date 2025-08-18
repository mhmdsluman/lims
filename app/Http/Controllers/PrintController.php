<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\LabResult;
use App\Models\RadiologyReport;
use App\Models\Patient;
use App\Models\Admission;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;

class PrintController extends Controller
{
    /**
     * Generate a printable PDF for various document types.
     *
     * @param string $type The type of document to print (e.g., 'lab_result', 'bill_invoice').
     * @param int $id The ID of the model to print.
     * @return \Illuminate\Http\Response
     */
    public function show(string $type, int $id)
    {
        $pdf = null;
        $data = [];
        $view = '';

        switch ($type) {
            case 'lab_result':
                $result = LabResult::with([
                    'orderItem.service',
                    'orderItem.order.patient',
                    'verifier'
                ])->findOrFail($id);
                $data = ['result' => $result];
                $view = 'reports.lab_result';
                break;

            case 'bill_invoice':
                $bill = Bill::with(['patient', 'items.service'])->findOrFail($id);
                $data = ['bill' => $bill];
                $view = 'reports.bill_invoice';
                break;

            case 'radiology_report':
                $report = RadiologyReport::with([
                    'orderItem.service',
                    'orderItem.order.patient',
                    'reporter'
                ])->findOrFail($id);
                $data = ['report' => $report];
                $view = 'reports.radiology_report';
                break;

            case 'patient_summary':
                $patient = Patient::with(['insurancePolicies.provider'])->findOrFail($id);
                $data = ['patient' => $patient];
                $view = 'reports.patient_summary';
                break;

            case 'prescription':
                $order = Order::with(['patient', 'items.service', 'prescriber'])->findOrFail($id);
                $data = ['order' => $order];
                $view = 'reports.prescription';
                break;

            case 'admission_summary':
                $admission = Admission::with(['patient', 'admittingDoctor', 'bed'])->findOrFail($id);
                $data = ['admission' => $admission];
                $view = 'reports.admission_summary';
                break;

            // Add cases for other printable documents here...

            default:
                App::abort(404, 'Printable document type not found.');
        }

        $pdf = Pdf::loadView($view, $data);

        return $pdf->stream($type . '-' . $id . '.pdf');
    }
}

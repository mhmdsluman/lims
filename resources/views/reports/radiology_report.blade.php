<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radiology Report</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        .header { text-align: center; margin-bottom: 40px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 0; color: #555; }
        .patient-info { margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 20px; }
        .patient-info table { width: 100%; }
        .patient-info td { padding: 5px; }
        .report-content { margin-top: 20px; }
        .footer { text-align: center; margin-top: 40px; font-size: 12px; color: #777; }
    </style>
</head>
<body>

    <div class="header">
        <h1>HMS Radiology Report</h1>
        <p>Official Health Report</p>
    </div>

    <div class="patient-info">
        <table>
            <tr>
                <td><strong>Patient Name:</strong></td>
                <td>{{ $report->orderItem->order->patient->first_name }} {{ $report->orderItem->order->patient->last_name }}</td>
                <td><strong>UHID:</strong></td>
                <td>{{ $report->orderItem->order->patient->uhid }}</td>
            </tr>
            <tr>
                <td><strong>Age:</strong></td>
                <td>{{ $report->orderItem->order->patient->age }} years</td>
                <td><strong>Gender:</strong></td>
                <td>{{ $report->orderItem->order->patient->gender }}</td>
            </tr>
            <tr>
                <td><strong>Study Date:</strong></td>
                <td>{{ $report->created_at->format('Y-m-d H:i') }}</td>
                <td><strong>Reported By:</strong></td>
                <td>{{ $report->reporter->name ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <div class="report-content">
        <h2>{{ $report->orderItem->service->name }}</h2>
        <p>{!! nl2br(e($report->report_text)) !!}</p>
    </div>

    <div class="footer">
        <p>This is a computer-generated report and does not require a signature.</p>
    </div>

</body>
</html>

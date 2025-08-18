<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        .header { text-align: center; margin-bottom: 40px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 0; color: #555; }
        .patient-info { margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 20px; }
        .patient-info table { width: 100%; }
        .patient-info td { padding: 5px; }
        .prescription-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .prescription-table th, .prescription-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .prescription-table th { background-color: #f2f2f2; }
        .footer { text-align: center; margin-top: 40px; font-size: 12px; color: #777; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Prescription</h1>
        <p>Official Health Document</p>
    </div>

    <div class="patient-info">
        <table>
            <tr>
                <td><strong>Patient Name:</strong></td>
                <td>{{ $order->patient->first_name }} {{ $order->patient->last_name }}</td>
                <td><strong>UHID:</strong></td>
                <td>{{ $order->patient->uhid }}</td>
            </tr>
            <tr>
                <td><strong>Date:</strong></td>
                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                <td><strong>Prescribed By:</strong></td>
                <td>{{ $order->prescriber->name ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <table class="prescription-table">
        <thead>
            <tr>
                <th>Medication</th>
                <th>Dosage</th>
                <th>Instructions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                @if($item->service->department === 'Pharmacy')
                    <tr>
                        <td>{{ $item->service->name }}</td>
                        <td>{{ $item->dosage }}</td>
                        <td>{{ $item->instructions }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This is a computer-generated prescription and does not require a signature.</p>
    </div>

</body>
</html>

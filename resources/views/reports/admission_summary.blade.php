<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Summary</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        .header { text-align: center; margin-bottom: 40px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 0; color: #555; }
        .section { margin-bottom: 20px; }
        .section h2 { font-size: 18px; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; }
        .footer { text-align: center; margin-top: 40px; font-size: 12px; color: #777; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Admission Summary</h1>
        <p>Official Health Report</p>
    </div>

    <div class="section">
        <h2>Patient Information</h2>
        <table>
            <tr>
                <td><strong>Patient Name:</strong></td>
                <td>{{ $admission->patient->first_name }} {{ $admission->patient->last_name }}</td>
                <td><strong>UHID:</strong></td>
                <td>{{ $admission->patient->uhid }}</td>
            </tr>
            <tr>
                <td><strong>Age:</strong></td>
                <td>{{ $admission->patient->age }} years</td>
                <td><strong>Gender:</strong></td>
                <td>{{ $admission->patient->gender }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Admission Details</h2>
        <table>
            <tr>
                <td><strong>Admission Date:</strong></td>
                <td>{{ $admission->admission_time->format('Y-m-d H:i') }}</td>
            </tr>
            <tr>
                <td><strong>Admitting Doctor:</strong></td>
                <td>{{ $admission->admittingDoctor->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Reason for Admission:</strong></td>
                <td>{{ $admission->reason_for_admission }}</td>
            </tr>
            <tr>
                <td><strong>Bed:</strong></td>
                <td>{{ $admission->bed->bed_number ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    @if($admission->discharge_time)
        <div class="section">
            <h2>Discharge Details</h2>
            <table>
                <tr>
                    <td><strong>Discharge Date:</strong></td>
                    <td>{{ $admission->discharge_time->format('Y-m-d H:i') }}</td>
                </tr>
            </table>
        </div>
    @endif

    <div class="footer">
        <p>This is a computer-generated report and does not require a signature.</p>
    </div>

</body>
</html>

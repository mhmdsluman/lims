<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Summary</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        .header { text-align: center; margin-bottom: 40px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 0; color: #555; }
        .section { margin-bottom: 20px; }
        .section h2 { font-size: 18px; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .footer { text-align: center; margin-top: 40px; font-size: 12px; color: #777; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Patient Summary</h1>
        <p>Official Health Report</p>
    </div>

    <div class="section">
        <h2>Patient Demographics</h2>
        <table>
            <tr>
                <td><strong>Name:</strong></td>
                <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                <td><strong>UHID:</strong></td>
                <td>{{ $patient->uhid }}</td>
            </tr>
            <tr>
                <td><strong>Date of Birth:</strong></td>
                <td>{{ $patient->date_of_birth->format('Y-m-d') }} ({{ $patient->age }} years)</td>
                <td><strong>Gender:</strong></td>
                <td>{{ $patient->gender }}</td>
            </tr>
            <tr>
                <td><strong>Phone:</strong></td>
                <td>{{ $patient->primary_phone }}</td>
                <td><strong>Email:</strong></td>
                <td>{{ $patient->email }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Insurance Information</h2>
        @if($patient->insurancePolicies->isNotEmpty())
            @foreach($patient->insurancePolicies as $policy)
                <table>
                    <tr>
                        <td><strong>Provider:</strong></td>
                        <td>{{ $policy->provider->name }}</td>
                        <td><strong>Policy #:</strong></td>
                        <td>{{ $policy->policy_number }}</td>
                    </tr>
                    <tr>
                        <td><strong>Coverage Dates:</strong></td>
                        <td colspan="3">{{ $policy->start_date->format('Y-m-d') }} to {{ $policy->end_date->format('Y-m-d') }}</td>
                    </tr>
                </table>
            @endforeach
        @else
            <p>No insurance information on file.</p>
        @endif
    </div>

    <div class="footer">
        <p>This is a computer-generated report and does not require a signature.</p>
    </div>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Medical Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 20px; }
        .section { margin-bottom: 20px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Medical Report</h2>
        <p>Appointment ID: {{ $record->appointment_id }}</p>
    </div>

    <div class="section">
        <p><span class="label">Patient:</span> {{ $patient->name ?? "GUEST" }}</p>
        <p><span class="label">Doctor:</span> {{ $doctor->name }}</p>
    </div>

    <div class="section">
        <h4>Diagnosis</h4>
        <p>{{ $record->diagnosis }}</p>
    </div>

    @if($record->prescription)
        <div class="section">
            <h4>Prescription</h4>
            <p>{{ $record->prescription }}</p>
        </div>
    @endif

    <div class="section">
        <p><span class="label">Date:</span> {{ \Carbon\Carbon::parse($record->created_at)->format('d M, Y') }}</p>
    </div>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Discharge Summary</title>
</head>
<body>
    <h2>Discharge Summary</h2>
    <p><strong>Patient Name:</strong> {{ $patient->user->name }}</p>
    <p><strong>Discharge Date:</strong> {{ $discharge->discharge_date }}</p>
    <p><strong>Admission ID:</strong> {{ $discharge->admission_id }}</p>
    <p>{{$discharge->discharge_summary}}</p>
    <p><strong>Notes:</strong> {{ $discharge->notes ?? 'No notes provided.' }}</p>
</body>
</html>

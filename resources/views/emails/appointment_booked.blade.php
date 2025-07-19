<!DOCTYPE html>
<html>
<head>
    <title>Appointment Confirmation</title>
</head>
<body>
    <h2>Hello {{ $appointment->patient->user->name }},</h2>

    <p>Your appointment has been successfully booked.</p>

    <p><strong>Doctor:</strong> {{ $appointment->doctor->user->name }}</p>
    <p><strong>Department:</strong> {{ $appointment->department->name }}</p>
    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</p>
    <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>

    <p>Thank you,<br>Medinova Hospital Management Team</p>
</body>
</html>

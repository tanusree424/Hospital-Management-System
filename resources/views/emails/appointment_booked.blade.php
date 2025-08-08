<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Appointment Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h2>Hello {{ $appointment->patient->user->name ?? 'Patient' }},</h2>

    <p>Your appointment has been successfully booked. Here are the details:</p>

    <p><strong>Appointment Number:</strong> {{ $appointment->appointment_number ?? $appointment_number }}</p>
    <p><strong>Doctor:</strong> {{ $appointment->doctor->user->name ?? 'N/A' }}</p>
    <p><strong>Department:</strong> {{ $appointment->department->name ?? 'N/A' }}</p>
    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</p>
    <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>

    <p>Thank you,<br><strong>Medinova Hospital Management Team</strong></p>
</body>
</html>

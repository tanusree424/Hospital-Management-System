<!DOCTYPE html>
<html>
<head>
    <title>Appointment Payment Receipt</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">🏥 Appointment Payment Receipt</h3>
    <hr>
    <p><strong>Patient:</strong> {{ $appointment->patient->user->name }}</p>
    <p><strong>Doctor:</strong> {{ $appointment->doctor->user->name }}</p>
    <p><strong>Department:</strong> {{ $appointment->department->name }}</p>
    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d-m-Y') }}</p>
    <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
    <p><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</p>
    <p><strong>Amount:</strong> ₹{{ $payment->amount }}</p>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Admission Receipt</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">🏥 Admission Payment Receipt</h3>
    <hr>
    <p><strong>Patient Name:</strong> {{ $admission->patient->user->name }}</p>
    <p><strong>Doctor:</strong> {{ $admission->doctor->user->name ?? 'N/A' }}</p>
    <p><strong>Admission Date:</strong> {{ $admission->created_at->format('d-m-Y') }}</p>
    <p><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</p>
    <p><strong>Amount Paid:</strong> ₹{{ $payment->amount }}</p>
</body>
</html>

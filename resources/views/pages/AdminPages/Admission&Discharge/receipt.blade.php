<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center"> Admission Payment Receipt</h3>
    <hr>
    <p><strong>Patient Name:</strong> {{ $admission->patient->user->name }}</p>
    {{-- <p><strong>Doctor:</strong> {{ $admission->doctor->user->name}}</p> --}}
    <p><strong>Admission Date:</strong> {{ $admission->created_at->format('d-m-Y') }}</p>
    <p><strong>Transaction ID:</strong>
        @php
        $payment= $admission->payments->first();
        @endphp
        {{ $payment->transaction_id }}</p>
    <p><strong>Amount Paid:</strong> ₹{{ $payment->amount }}</p>

    <a href="{{ route('admission.receipt.download', $admission->id) }}" class="btn btn-danger no-print">
    {{-- <i class="bi bi-file-earmark-pdf"></i>  --}} Download PDF
</a>

</div>
</body>
</html>

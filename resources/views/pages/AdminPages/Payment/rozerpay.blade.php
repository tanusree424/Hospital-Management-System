@extends('layouts.AdminLayout.app')

@section('content')
<div class="container">
    <h3>Complete Your Payment</h3>

    <p><strong>Admission ID:</strong> {{ $admission_id }}</p>
    <p><strong>Amount to Pay:</strong> ₹{{ $amount }}</p>
<form action="{{ route('admission.payment.process', $admission->id) }}" method="POST">
    @csrf
    <input type="hidden" name="patient_id" value="{{ $admission->patient_id }}">
    <input type="hidden" name="amount" value="1500"> {{-- or dynamically assign --}}

    <button type="submit" name="payment_mode" value="online" class="btn btn-success">
        💸 Pay Now
    </button>

    <button type="submit" name="payment_mode" value="after_admission" class="btn btn-secondary">
        🕓 Pay at Admission Time
    </button>
</form>

</form>
@endsection
{{-- <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "{{ $razorpay_key }}",
        "amount": "{{ $amount * 100 }}",
        "currency": "INR",
        "name": "Hospital Management",
        "description": "Appointment Payment",
        "order_id": "{{ $order_id }}",
        "handler": function (response){
            // Submit the payment response to server
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;
            document.getElementById('razorpayForm').submit();
        }
    };

    var rzp1 = new Razorpay(options);
    rzp1.open(); // Automatically open Razorpay payment page
</script> --}}



@extends('layouts.AdminLayout.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-body text-center">
            <h2 class="text-success mb-4">
                Confirm Payment for Appointment #{{ $appointment->id }}
            </h2>
            <p class="lead">
                Amount: ₹{{ number_format($order->amount / 100, 2) }}
            </p>

            <button id="rzp-button1" class="btn btn-primary btn-lg mt-3">Pay Now</button>
        </div>
    </div>
</div>

<!-- Razorpay JS -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    var options = {
        "key": "{{ $api_key }}", // Razorpay Key ID
        "amount": "{{ $order->amount }}", // Amount in paise
        "currency": "INR",
        "name": "Hospital Management",
        "description": "Appointment Payment",
        "image": "{{ asset('path-to-your-logo.png') }}", // Optional logo
        "order_id": "{{ $order->id }}", // Razorpay order ID

        "handler": function (response) {
            // Create form for POST submission
            var form = document.createElement('form');
            form.setAttribute('method', 'POST');
            form.setAttribute('action', "{{ route('appointment.payment.success') }}");

            // CSRF Token
            var token = document.createElement('input');
            token.setAttribute('type', 'hidden');
            token.setAttribute('name', '_token');
            token.setAttribute('value', '{{ csrf_token() }}');
            form.appendChild(token);

            // Razorpay Payment ID
            var razorpay_payment_id = document.createElement('input');
            razorpay_payment_id.setAttribute('type', 'hidden');
            razorpay_payment_id.setAttribute('name', 'razorpay_payment_id');
            razorpay_payment_id.setAttribute('value', response.razorpay_payment_id);
            form.appendChild(razorpay_payment_id);

            // Razorpay Order ID
            var razorpay_order_id = document.createElement('input');
            razorpay_order_id.setAttribute('type', 'hidden');
            razorpay_order_id.setAttribute('name', 'razorpay_order_id');
            razorpay_order_id.setAttribute('value', response.razorpay_order_id);
            form.appendChild(razorpay_order_id);

            // Razorpay Signature
            var razorpay_signature = document.createElement('input');
            razorpay_signature.setAttribute('type', 'hidden');
            razorpay_signature.setAttribute('name', 'razorpay_signature');
            razorpay_signature.setAttribute('value', response.razorpay_signature);
            form.appendChild(razorpay_signature);

            // Appointment ID
            var appointment_id = document.createElement('input');
            appointment_id.setAttribute('type', 'hidden');
            appointment_id.setAttribute('name', 'appointment_id');
            appointment_id.setAttribute('value', '{{ $appointment->id }}');
            form.appendChild(appointment_id);

            // Patient ID (✅ hidden now)
            var patient_id = document.createElement('input');
            patient_id.setAttribute('type', 'hidden');
            patient_id.setAttribute('name', 'patient_id');
            patient_id.setAttribute('value', '{{ $appointment->patient_id }}');
            form.appendChild(patient_id);

            // Append form & submit
            document.body.appendChild(form);
            form.submit();
        },

        "prefill": {
            "name": "{{ auth()->user()->name }}",
            "email": "{{ auth()->user()->email }}"
        },

        "theme": {
            "color": "#0d6efd"
        }
    };

    var rzp1 = new Razorpay(options);

    document.getElementById('rzp-button1').onclick = function (e) {
        rzp1.open();
        e.preventDefault();
    };
</script>
@endsection

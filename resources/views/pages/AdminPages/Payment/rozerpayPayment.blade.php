@extends('layouts.AdminLayout.app')

@section('content')
<div class="container">
    <h2>Admission Payment</h2>
    <hr>

    <button id="rzp-button1" class="btn btn-primary">Pay Now</button>

    {{-- Payment Form --}}
    <form action="{{ route('admission.payment.store') }}" method="POST" id="payment-form">
        @csrf
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="admission_id" id="admission_id" value="{{ $admission->id }}">
        <input type="hidden" name="amount" id="amount" value="{{ $order->amount / 100 }}">
        <input type="hidden" name="patient_id" id="patient_id" value="{{ $admission->patient->id }}">
    </form>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    const options = {
        "key": "{{ $api_key }}",
        "amount": "{{ $order->amount }}", // in paise
        "currency": "INR",
        "name": "Hospital Management",
        "description": "Admission Payment",
        "order_id": "{{ $order->id }}",
        "handler": function (response) {
            console.log("Razorpay Payment Success", response);
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;

            const form = document.getElementById('payment-form');
            const formData = new FormData(form);

            // Log each form field (for debugging)
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    return response.json();
                }
            })
            .catch(error => {
                console.error("Payment submission failed:", error);
                alert("Something went wrong while processing your payment.");
            });
        },
        "theme": {
            "color": "#528FF0"
        }
    };

    const rzp1 = new Razorpay(options);

    document.getElementById('rzp-button1').onclick = function(e) {
        rzp1.open();
        e.preventDefault();
    };
</script>
@endsection

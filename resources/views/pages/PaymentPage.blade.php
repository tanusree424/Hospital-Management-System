@extends('layouts.app') {{-- Or your main layout --}}
@section('title', 'Payment Page')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5 text-center">
                    <h2 class="mb-4 fw-bold text-primary">Complete Your Payment</h2>
                    <p class="text-muted mb-5">
                        Please choose whether you would like to pay now or later.
                        You can always complete your payment at your convenience.
                    </p>

                    {{-- Pay Now --}}
                    <form action="" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" id="pay-now-btn" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-sm">
                            💳 Pay Now
                        </button>
                    </form>

                    {{-- Pay Later --}}
                    <form action="{{route('guest.payLater')}}" method="POST" class="d-inline ms-3">
                        @csrf
                        <input type="hidden" value="{{$appointment->id}}" name="appointment_id"/>
                        <button type="submit" class="btn btn-outline-secondary btn-lg px-5 py-3 rounded-pill">
                            ⏳ Pay Later
                        </button>
                    </form>

                    <div class="mt-4">
                        <small class="text-muted">* Secure payment processing powered by XYZ Payment Gateway</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.getElementById('pay-now-btn').onclick = function(e){
    e.preventDefault();

    var options = {
        "key": "{{ $key }}",
        "amount": "{{ $amount * 100 }}",
        "currency": "INR",
        "name": "Hospital Management",
        "description": "Appointment Payment",
        "order_id": "{{ $orderId }}",
        "handler": function (response){
            fetch("{{ route('payment.razorpay.success') }}", {
                method: 'POST',
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    razorpay_payment_id: response.razorpay_payment_id,
                    appointment_id: "{{ session('appointment_id') }}"
                })
            }).then(() => {
                window.location.href = "{{ route('home') }}";
            });
        },
        "theme": {
            "color": "#3399cc"
        }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
}
</script>
@endsection

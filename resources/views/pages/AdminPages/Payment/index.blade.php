@extends('layouts.AdminLayout.app')

@section('content')
<div class="card">
    <div class="card-header bg-success text-white">Admission Payment</div>
    <div class="card-body">
        <p class="fs-5">Your admission has been completed.</p>
        <p><strong>Payment Amount:</strong> ₹{{ session('amount') }}</p>

        <form action="" method="POST" class="d-inline">
            @csrf
            <input type="text" name="appointment_id" value="{{$appointment->id}}">
            <button type="submit" class="btn btn-primary" id="rzp-button1">Pay Now</button>
        </form>

        <form action="{{ route('payments.create') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-secondary">Pay Later</button>
        </form>
    </div>
</div>
@endsection

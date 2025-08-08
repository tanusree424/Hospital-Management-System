@extends('layouts.AdminLayout.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">🩺 Appointment Payment</h4>
        </div>

        <div class="card-body">
            <h5 class="mb-3">📌 Appointment Summary</h5>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Appointment No:</strong> {{ $appointment->appointment_number }}
                </div>
                <div class="col-md-6">
                    <strong>Department:</strong> {{ $appointment->department->name ?? '-' }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Doctor:</strong> {{ $appointment->doctor->user->name ?? '-' }}
                </div>
                <div class="col-md-6">
                    <strong>Date & Time:</strong> {{ $appointment->appointment_date }} at {{ $appointment->appointment_time }}
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <strong>Patient:</strong> {{ $appointment->patient->user->name ?? '-' }}
                </div>
                <div class="col-md-6">
                    <strong>Status:</strong> <span class="badge bg-warning">Pending Payment</span>
                </div>
            </div>

            <h5 class="mb-3">💳 Select Payment Option</h5>

           <form action="{{ route('appointment.payment.process', $appointment->id) }}" method="POST">
    @csrf
    <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
    <input type="hidden" name="patient_id" value="{{$appointment->patient->id}}">

    <div class="d-flex gap-3">


        <button type="submit" name="payment_mode" value="online" class="btn btn-success">
            💸 Pay Now
        </button>

        <button type="submit" name="payment_mode" value="after_admission" class="btn btn-secondary">
            🕓 Pay at the time of Appointment
        </button>
    </div>
</form>

        </div>
    </div>
</div>
@endsection

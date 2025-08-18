@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center vh-100 h-100">
        <div class="col-md-6 m-auto">
            <div class="card shadow">
                <div class="card-header" style="background-color:rgb(122, 222, 222);">
                    <h4 class="text-center">Add Appointment</h4>
                </div>
                <div class="card-body">
                    {{-- Flash Messages --}}
                    @if (session('success'))
                        <div class="alert alert-success text-center">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger text-center">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('guest.store') }}" method="POST">
                        @csrf

                        {{-- Department --}}
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold h5">Department:</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="hidden" name="department_id" value="{{ $department->id }}">
                                    <input type="text" class="form-control" value="{{ $department->name }}" style="height: 55px" readonly>
                                </div>
                            </div>
                        </div>

                        {{-- Doctor --}}
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold h5">Doctor:</label>
                                </div>
                                <div class="col-md-8">
                                    <select name="doctor_id" style="height: 55px" id="doctor_id" class="form-control">
                                        <option value="">-- Select Doctor --</option>
                                    </select>
                                    @error('doctor_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Patient --}}
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold h5">Patient:</label>
                                </div>
                                <div class="col-md-8">
                                    @if (Auth::check() && auth()->user()->hasRole('Patient'))
                                        <input type="hidden" name="patient_id" value="{{ auth()->user()->id }}">
                                        <input type="text" class="form-control" value="{{ auth()->user()->name }}"
                                            readonly>
                                    @else
                                        <p class="text-center">Booking for Guest</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- Appointment Name for --}}
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold h5">Name:</label>
                                </div>
                                <div class="col-8 col-sm-6">
                                    <div class="input-group date"
                                        style="position: relative;">
                                        <input type="text" name="name"
                                            class="form-control"
                                            placeholder="Enter Name "
                                            style="height: 55px;" />

                                    </div>
                                </div>
                            </div>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                        </div>
                         {{-- Appointment Email for --}}
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold h5">Email:</label>
                                </div>
                                <div class="col-8 col-sm-6">
                                    <div class="input-group date"
                                        style="position: relative;">
                                        <input type="text" name="email"
                                            class="form-control"
                                            placeholder="Enter Email "
                                            style="height: 55px;" />

                                    </div>
                                </div>
                            </div>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                        </div>


                        {{-- Appointment Date --}}
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold h5">Appointment Date:</label>
                                </div>
                                <div class="col-8 col-sm-6">
                                    <div class="input-group date" id="datetimepicker1" data-target-input="nearest"
                                        style="position: relative;">
                                        <input type="text" name="appointment_date"
                                            class="form-control datetimepicker-input bg-light border-0"
                                            placeholder="Select Date" data-target="#datetimepicker1"
                                            style="height: 55px;" />
                                        <div class="input-group-append" data-target="#datetimepicker1"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('appointment_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                        </div>

                        {{-- Appointment Time --}}
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold h5">Time:</label>
                                </div>
                                <div class="col-md-8">

                                    <div class="input-group time" id="timepicker1" data-target-input="nearest"
                                        style="position: relative;">
                                        <input type="text" name="appointment_time"
                                            class="form-control datetimepicker-input bg-light border-0"
                                            placeholder="Select Time" data-target="#timepicker1" style="height: 55px;" />
                                        <div class="input-group-append" data-target="#timepicker1"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                        </div>

                                        @error('appointment_time')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary rounded-pill py-3 px-5 my-2">Book
                                    Appointment</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const doctorSelect = $('#doctor_id');
        const departmentId = "{{ $department->id }}"; // Preselected department
        const fetchUrl = "/get-doctors/";

        doctorSelect.html('<option value="">Loading...</option>');

        $.ajax({
            url: fetchUrl,
            type: 'GET',
            data: {
                "department_id": departmentId
            },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                doctorSelect.empty().append('<option value="">-- Select Doctor --</option>');
                if (data.length > 0) {
                    $.each(data, function(index, doctor) {
                        doctorSelect.append(
                            `<option value="${doctor.id}">${doctor.user.name}</option>`);
                    });
                } else {
                    doctorSelect.append('<option disabled>No doctors available</option>');
                }
            },
            error: function() {
                doctorSelect.html('<option disabled>Error loading doctors</option>');
            }
        });
    });
</script>

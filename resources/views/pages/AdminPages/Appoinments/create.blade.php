@extends('layouts.AdminLayout.app')

@section('content')
    <div class="d-flex justify-content-center vh-100 h-100">
        <div class="col-md-6 m-auto">
            <div class="card shadow">
                <div class="card-header" style="background-color:rgb(122, 222, 222);">
                    <h4 class="text-center">Add Appointment</h4>
                </div>
                <div class="card-body">
                    {{-- Flash Message --}}
                    @if (session('success'))
                        <div class="alert alert-success text-center">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger text-center">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('appointment.store') }}" method="POST">
                        @csrf

                        {{-- Department --}}
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold h5">Department:</label>
                                </div>
                                <div class="col-md-8">
                                    {{-- Department Dropdown --}}
                                    @if ($isDoctor && $doctor)
                                        <input type="hidden" name="department_id" value="{{ $doctor->department_id }}">
                                        <input type="text" class="form-control" value="{{ $doctor->department->name }}"
                                            disabled>
                                    @else
                                        <select name="department_id" id="department_id"
                                            data-url="{{ url('admin/get-doctors') }}" class="form-control">
                                            <option value="">-- Select Department --</option>
                                            @foreach ($departments as $dept)
                                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                            @endforeach
                                        </select>
                                    @endif

                                    @error('department_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
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
                                    @if ($isDoctor && $doctor)
                                        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                                        <input type="text" class="form-control" value="{{ $doctor->user->name }}"
                                            disabled>


                                  @else
                                    <select name="doctor_id" id="doctor_id" class="form-control">
                                        <option value="">-- Select Doctor --</option>
                                    </select>
                                    @error('doctor_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                      @endif
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
                                    @if (auth()->user()->hasRole('Patient'))
                                    <input type="hidden" name="patient_id" value="{{auth()->user()->id}}">
                                    <input type="text" class="form-control" value="{{auth()->user()->name}}" disabled id="">


                                    @else
                                    <select name="patient_id" id="doctor_id" class="form-control form-select">
                                        <option value="">-- Select Patient --</option>
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('patient_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    @endif
                                </div>
                            </div>
                        </div>


                        {{-- Date --}}
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold h5">Appointment Date:</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="date" name="appointment_date" class="form-control">
                                    @error('appointment_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Time --}}
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold h5">Time:</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="time" name="appointment_time" class="form-control">
                                    @error('appointment_time')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="text-center">
                            <button class="btn btn-perm">Book Appointment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @section('scripts') --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const deptSelect = $('#department_id');
        const doctorSelect = $('#doctor_id');
        const fetchBaseUrl = deptSelect.data('url'); // Now it's: /admin/get-doctors

        deptSelect.on('change', function() {
            const deptId = $(this).val();
            const fetchUrl = `${fetchBaseUrl}/${deptId}`;

            doctorSelect.html('<option value="">Loading...</option>');

            if (deptId) {
                $.ajax({
                    url: fetchUrl,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        doctorSelect.empty().append(
                            '<option value="">-- Select Doctor --</option>');
                        if (data.length > 0) {
                            $.each(data, function(key, doctor) {
                                doctorSelect.append(
                                    `<option value="${doctor.id}">${doctor.name}</option>`
                                    );
                            });
                        } else {
                            doctorSelect.append(
                                '<option disabled>No doctors available</option>');
                        }
                    },
                    error: function() {
                        doctorSelect.html(
                        '<option disabled>Error loading doctors</option>');
                    }
                });
            } else {
                doctorSelect.html('<option value="">-- Select Doctor --</option>');
            }
        });
    });
</script>

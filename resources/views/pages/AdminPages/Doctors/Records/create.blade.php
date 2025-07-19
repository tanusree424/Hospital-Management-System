@extends('layouts.AdminLayout.app')

@section('content')
<div class="container-fluid">
    <h3 class="text-center">Create Medical Record</h3>
    <hr>
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif



    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow border-1 border-dark rounded-0 mt-4">
                <div class="card-header bg-info text-white text-center">
                    <h4 class="mb-0">Record Details</h4>
                </div>

                <div class="card-body">

                    {{-- ✅ Medical Record Create Form --}}
                    <form action="{{ route('medical_record.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="appointment_id" value="{{ request()->route('appointment_id') }}">

                        {{-- Diagnosis --}}
                        <div class="mb-3 row">
                            <label for="diagnosis" class="col-md-3 col-form-label fw-bold h5">Diagnosis:</label>
                            <div class="col-md-9">
                                <textarea name="diagnosis" id="diagnosis" class="form-control" rows="3" required></textarea>
                            </div>
                        </div>

                        {{-- Prescription --}}
                        <div class="mb-3 row">
                            <label for="prescription" class="col-md-3 col-form-label fw-bold h5">Prescription:</label>
                            <div class="col-md-9">
                                <textarea name="prescription" id="prescription" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">Add Medical Record</button>
                        </div>
                    </form>

                    {{-- ✅ PDF Download Button (if record exists) --}}
                    @if(\App\Models\Medical_records::where('appointment_id', request()->route('appointment_id'))->exists())
                        <form action="{{ route('medical_record.download') }}" method="POST" class="mb-3">
                            @csrf
                            <input type="hidden" name="appointment_id" value="{{ request()->route('appointment_id') }}">
                            <button type="submit" class="btn btn-success w-100">Download Report as PDF</button>
                        </form>
                    @endif

                    {{-- ✅ Test File Upload (only if record exists) --}}
                    @if ($appointment->medical_record)
                        <form action="{{route('medical_record.upload')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 row">
                                <input type="hidden" name="appointment_id" value="{{ request()->route('appointment_id') }}">
                                <label for="test_file" class="col-md-3 col-form-label fw-bold h5">Test File:</label>
                                <div class="col-md-9">
                                    <input type="file" name="test_file" id="test_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-warning w-100">Upload Test File</button>
                            </div>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

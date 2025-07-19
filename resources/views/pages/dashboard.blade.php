@extends('layouts.AdminLayout.app')

@section('content')
<div class="container-fluid">
    <!-- Dashboard Header -->
 <div class="row">
    <div class="col-12 m-0">
        <div class="p-4 rounded text-white shadow" style="background: linear-gradient(to right, #0062E6, #33AEFF);">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Left: Dashboard Title -->
                <div>
                    <h2 class="mb-1 fw-bold">🏥 Hospital Admin Dashboard</h2>
                    <p class="mb-0">Manage doctors, patients, appointments, and more</p>
                </div>

                <!-- Center: Dashboard Icon -->
                <div>
                    <img src="{{ asset('assets/images/dashboard-icon.png') }}" alt="Dashboard Icon" width="60" height="60">
                </div>

                <!-- Right: Auth User Info -->
                <div class="text-end">
                    @php
                        $user = auth()->user();
                        $isDoctor = $user->hasRole('Doctor');
                        $doctor = $isDoctor ? $user->doctor : null;

                          $user = auth()->user();
                        $isPatient = $user->hasRole('Patient');
                        $patient = $isPatient ? $user->patient : null;
                        $user = auth()->user();
                        $isAdmin = $user->hasRole('Admin');
                        $admin = $isAdmin ? $user->admin : null;
                    @endphp


                    @if($isDoctor && $doctor && $doctor->profile_picture)
                        <img src="{{ asset('storage/' . $doctor->profile_picture) }}"
                             class="rounded-circle mb-2"
                             width="50"
                             height="50"
                             style="object-fit: cover;"
                             alt="Doctor Profile Image">
                    @elseif ($isPatient && $patient && $patient->patient_image)
                        <img src="{{ asset('storage/' . $patient->patient_image) }}"
                             class="rounded-circle mb-2"
                             width="50"
                             height="50"
                             style="object-fit: cover;"
                             alt="Doctor Profile Image">
                    @elseif ($isAdmin && $admin->profile_picture)
                     <img src="{{asset('storage/'. $admin->profile_picture)}}" width="50" height="50" style="object-fit: cover;" alt="" class="rounded-circle mb-2 shadow">
                    @endif

                    <p class="mb-0 fw-bold">{{ $user->name }}</p>
                    @if($user->getRoleNames()->isNotEmpty())
                        <span class="badge bg-light text-dark fw-bold">
                            {{ $user->getRoleNames()->first() }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>



    <!-- Dashboard Cards -->
    <div class="row mt-5">
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4>Doctors</h4>
                    <hr>
                    <p>Total Doctors: <strong>5</strong></p>
                </div>
            </div>
        </div>

        <!-- Additional cards (example) -->
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4>Patients</h4>
                    <hr>
                    <p>Total Patients: <strong>12</strong></p>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4>Appointments</h4>
                    <hr>
                    <p>Total Appointments: <strong>8</strong></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.AdminLayout.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Dashboard Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="p-4 rounded shadow text-white" style="background: linear-gradient(135deg, #0062E6 0%, #33AEFF 100%);">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <!-- Left: Dashboard Title -->
                    <div class="mb-3 mb-md-0">
                        <h2 class="fw-bold mb-1">🏥 Hospital Admin Dashboard</h2>
                        <p class="mb-0 opacity-75">Manage doctors, patients, appointments, and more</p>
                    </div>

                    <!-- Center: Dashboard Icon -->
                    <div class="mx-4">
                        <img src="{{ asset('assets/images/dashboard-icon.png') }}" alt="Dashboard Icon" width="70" height="70" class="shadow rounded-circle" />
                    </div>

                    <!-- Right: Auth User Info -->
                    <div class="text-center text-md-end">
                        @php
                            $user = auth()->user();
                            $isDoctor = $user->hasRole('Doctor');
                            $doctor = $isDoctor ? $user->doctor : null;

                            $isPatient = $user->hasRole('Patient');
                            $patient = $isPatient ? $user->patient : null;

                            $isAdmin = $user->hasRole('Admin');
                            $admin = $isAdmin ? $user->admin : null;
                        @endphp

                        @if($isDoctor && $doctor && $doctor->profile_picture)
                            <img src="{{ asset('storage/' . $doctor->profile_picture) }}"
                                 class="rounded-circle mb-2 border border-white"
                                 width="60" height="60"
                                 style="object-fit: cover;"
                                 alt="Doctor Profile Image">
                        @elseif ($isPatient && $patient && $patient->patient_image)
                            <img src="{{ asset('storage/' . $patient->patient_image) }}"
                                 class="rounded-circle mb-2 border border-white"
                                 width="60" height="60"
                                 style="object-fit: cover;"
                                 alt="Patient Profile Image">
                        @elseif ($isAdmin && $admin && $admin->profile_picture)
                            <img src="{{ asset('storage/' . $admin->profile_picture) }}"
                                 class="rounded-circle mb-2 border border-white shadow"
                                 width="60" height="60"
                                 style="object-fit: cover;"
                                 alt="Admin Profile Image">
                        @else
                            <div class="bg-white rounded-circle mb-2 d-inline-block" style="width:60px; height:60px;"></div>
                        @endif

                        <p class="mb-0 fw-semibold fs-5">{{ $user->name }}</p>
                        @if($user->getRoleNames()->isNotEmpty())
                            <span class="badge bg-light text-primary fw-semibold fs-6">
                                {{ $user->getRoleNames()->first() }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Cards -->
    <div class="row g-4">
        <!-- Doctors -->
        <div class="col-md-4 col-lg-3">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-person-badge-fill fs-1 text-primary"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Doctors</h4>
                    <p class="fs-5">Total Doctors:</p>
                    <h2 class="display-5 text-primary fw-bold">{{$doctorsCount}}</h2>
                </div>
            </div>
        </div>

        <!-- Patients -->
        <div class="col-md-4 col-lg-3">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-people-fill fs-1 text-success"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Patients</h4>
                    <p class="fs-5">Total Patients:</p>
                    <h2 class="display-5 text-success fw-bold">{{$patientsCount}}</h2>
                </div>
            </div>
        </div>

        <!-- Appointments -->
        <div class="col-md-4 col-lg-3">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-calendar-check-fill fs-1 text-warning"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Appointments</h4>
                    <p class="fs-5">Total Appointments:</p>
                    <h2 class="display-5 text-warning fw-bold">{{$appointmentsCount}}</h2>
                </div>
            </div>
        </div>

        <!-- Beds -->
        <div class="col-md-4 col-lg-3">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-lamp-fill fs-1 text-info"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Beds</h4>
                    <p class="fs-5">Total Beds:</p>
                    <h2 class="display-5 text-info fw-bold">{{$bedsCount}}</h2>
                </div>
            </div>
        </div>

        <!-- Wards -->
        <div class="col-md-4 col-lg-3">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-house-fill fs-1 text-secondary"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Wards</h4>
                    <p class="fs-5">Total Wards:</p>
                    <h2 class="display-5 text-secondary fw-bold">{{$wardsCount}}</h2>
                </div>
            </div>
        </div>

        <!-- Departments -->
        <div class="col-md-4 col-lg-3">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-building fs-1 text-danger"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Departments</h4>
                    <p class="fs-5">Total Departments:</p>
                    <h2 class="display-5 text-danger fw-bold">{{$departmentsCount}}</h2>
                </div>
            </div>
        </div>

        <!-- Users -->
        <div class="col-md-4 col-lg-3">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-people fs-1 text-success"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Users</h4>
                    <p class="fs-5">Total Users:</p>
                    <h2 class="display-5 text-success fw-bold">{{$usersCount}}</h2>
                </div>
            </div>
        </div>

        <!-- Roles -->
        <div class="col-md-4 col-lg-3">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-shield-lock-fill fs-1 text-warning"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Roles</h4>
                    <p class="fs-5">Total Roles:</p>
                    <h2 class="display-5 text-warning fw-bold">{{$rolesCount}}</h2>
                </div>
            </div>
        </div>

        <!-- Permissions -->
        <div class="col-md-4 col-lg-3">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-key-fill fs-1 text-danger"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Permissions</h4>
                    <p class="fs-5">Total Permissions:</p>
                    <h2 class="display-5 text-danger fw-bold">{{$permissionsCount}}</h2>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

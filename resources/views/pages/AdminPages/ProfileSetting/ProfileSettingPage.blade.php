@extends('layouts.AdminLayout.app')

@section('content')
<div class="container-fluid">
    <h2 class="text-center fw-bold mb-4">Profile Settings</h2>

    {{-- Alerts --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        {{-- Profile Update --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white fw-bold">Update Profile</div>
                <div class="card-body">
                    <form action="{{ route('admin.profile_update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-control" required>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-control" required>
                        </div>

                        {{-- Phone --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $extra->phone ?? '') }}" class="form-control">
                        </div>

                        {{-- Profile Image --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Profile Picture</label>
                            <input type="file" name="profile_image" class="form-control">
                            @if ($extra && isset($extra->patient_image) && auth()->user()->hasRole('Patient'))
                                <div class="mt-2">

                                    <img src="{{ asset('storage/' . $extra->patient_image) }}"  width="80" class="rounded-circle shadow border">
                                </div>
                            @elseif ($extra && isset($extra->profile_picture) && auth()->user()->hasRole('Doctor'))
                             <div class="mt-2">

                                    <img src="{{ asset('storage/' . $extra->profile_picture) }}"  width="80" class="rounded-circle shadow border">
                                </div>
                            @else
                             <div class="mt-2">

                                    <img src="{{ asset('storage/' . $extra->profile_picture) }}"  width="80" class="rounded-circle shadow border">
                                </div>

                            @endif

                        </div>

                        {{-- Role-specific Fields --}}
                        @php $role = auth()->user()->roles->pluck('name')->first(); @endphp

                        @if ($role === 'Doctor')
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Qualification</label>
                                <input type="text" name="qualifications" class="form-control" value="{{ old('qualifications', $extra->qualifications ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Department</label>
                                <select name="department_id" class="form-select">
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ old('department_id', $extra->department_id ?? '') == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        @if ($role === 'Patient')
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Date of Birth</label>
                                <input type="date" name="dob" class="form-control" value="{{ old('dob', $extra->dob ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ (old('gender', $extra->gender ?? '') === 'male') ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ (old('gender', $extra->gender ?? '') === 'female') ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ (old('gender', $extra->gender ?? '') === 'other') ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Address</label>
                                <textarea name="address" rows="3" class="form-control">{{ old('address', $extra->address ?? '') }}</textarea>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-success px-4">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Password Change --}}
        <div class="col-md-6 mt-4 mt-md-0">
            <div class="card shadow-sm">
                <div class="card-header bg-warning fw-bold">Change Password</div>
                <div class="card-body">
                    <form action="{{ route('admin.change_password') }}" method="POST">
    @csrf
    @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">New Password</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary px-4">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

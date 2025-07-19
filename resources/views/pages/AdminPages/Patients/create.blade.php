@extends('layouts.AdminLayout.app')

@section('content')
<div class="d-flex justify-content-center vh-100 h-100">
    <div class="col-md-8 m-auto">
        <div class="card shadow">
            <div class="card-header bg-info">
                <h4 class="text-center">Add Patient Details</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('patients.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Name --}}
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">Name:</label>
                        <div class="col-md-8">
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">Email:</label>
                        <div class="col-md-8">
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">Password:</label>
                        <div class="col-md-8">
                            <input type="password" name="password" class="form-control">
                            @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">Confirm Password:</label>
                        <div class="col-md-8">
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">Phone:</label>
                        <div class="col-md-8">
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
                            @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">Address:</label>
                        <div class="col-md-8">
                            <textarea name="address" rows="3" class="form-control">{{ old('address') }}</textarea>
                            @error('address') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- DOB --}}
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">DOB:</label>
                        <div class="col-md-8">
                            <input type="date" name="dob" value="{{ old('dob') }}" class="form-control">
                            @error('dob') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Gender --}}
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">Gender:</label>
                        <div class="col-md-8 d-flex gap-3">
                            @php $gender = old('gender'); @endphp
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ $gender == 'male' ? 'checked' : '' }}>
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ $gender == 'female' ? 'checked' : '' }}>
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="other" value="other" {{ $gender == 'other' ? 'checked' : '' }}>
                                <label class="form-check-label" for="other">Other</label>
                            </div>
                        </div>
                        @error('gender') <div class="text-danger text-center mt-1">{{ $message }}</div> @enderror
                    </div>

                    {{-- Profile Picture --}}
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">Patient Picture:</label>
                        <div class="col-md-8">
                            <input type="file" name="patient_image" accept="image/*" id="profile_pic" class="form-control">
                            <img src="" id="preview" class="d-block mx-auto mt-2" style="max-width: 70px;" alt="">
                            @error('patient_image') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-4">Add Patient</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Image Preview Script --}}

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const pro_pic = document.getElementById('profile_pic');
        const preview = document.getElementById('preview');

        if (pro_pic && preview) {
            pro_pic.addEventListener('change', () => {
                const file = pro_pic.files[0];
                if (file) {
                    preview.src = URL.createObjectURL(file);
                }
            });
        }
    });
</script>


@extends('layouts.AdminLayout.app')

@section('content')
<div class="d-flex justify-content-center vh-100 h-100">
    <div class="col-md-6 m-auto">
        <div class="card shadow">
            <div class="card-header" style="background-color:rgb(122, 222, 222);">
                <h4 class="text-center">Edit Doctor Details - {{ $doctor->user->name }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('doctors.update', $doctor->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-label fw-bold h5">Name:</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="name" value="{{ old('name', $doctor->user->name) }}" class="form-control rounded-0 border-dark border-1">
                                @error('name')
                                    <div class="text-danger text-center">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-label fw-bold h5">Email:</label>
                            </div>
                            <div class="col-md-7">
                                <input type="email" name="email" value="{{ old('email', $doctor->user->email) }}" class="form-control rounded-0 border-dark border-1">
                                @error('email')
                                    <div class="text-danger text-center">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-label fw-bold h5">Phone:</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="phone" value="{{ old('phone', $doctor->phone) }}" class="form-control rounded-0 border-dark border-1">
                                @error('phone')
                                    <div class="text-danger text-center">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Qualification --}}
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-label fw-bold h5">Qualifications:</label>
                            </div>
                            <div class="col-md-7">
                                <textarea name="qualifications" rows="3" class="form-control border border-1 border-dark rounded-0" style="resize: none;">{{ old('qualifications', $doctor->qualifications) }}</textarea>
                                @error('qualifications')
                                    <div class="text-danger text-center">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Department --}}
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-label fw-bold h5">Department:</label>
                            </div>
                            <div class="col-md-7">
                                <select name="department" class="form-select rounded-0 border border-1 border-dark">
                                    <option value="" disabled>-- Select Department --</option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ old('department', $doctor->department_id) == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department')
                                    <div class="text-danger text-center">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Profile Picture --}}
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-label fw-bold h5">Profile Picture:</label>
                            </div>
                            <div class="col-md-7">
                                <input type="file" name="profile_picture" accept="image/*" id="profile_pic" class="form-control rounded-0 border border-1 border-dark">
                                @error('profile_picture')
                                    <div class="text-danger text-center">{{ $message }}</div>
                                @enderror

                                @if ($doctor->profile_picture)
                                    <img src="{{ asset('storage/' . $doctor->profile_picture) }}" id="preview" alt="Current Image" class="d-block mx-auto mt-2" style="max-width: 70px;">
                                @else
                                    <img src="" id="preview" alt="Preview" class="d-block mx-auto mt-2" style="max-width: 70px;">
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="mb-3 text-center">
                        <button class="btn btn-perm">Update Doctor</button>
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
        const preview_img = document.getElementById('preview');

        if (pro_pic) {
            pro_pic.addEventListener('change', () => {
                const file = pro_pic.files[0];
                if (file) {
                    const url = URL.createObjectURL(file);
                    preview_img.src = url;
                }
            });
        }
    });
</script>


@extends('layouts.AdminLayout.app')

@section('content')
    <div class="d-flex justify-content-center vh-100 h-100">
        <div class="col-md-6 m-auto">
            <div class="card shadow">
                <div class="card-header" style="background-color:rgb(122, 222, 222);">
                    <h4 class="text-center">Add Doctor Details</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('doctors.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-label fw-bold h5">Name:</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control rounded-0 border-dark border-1">
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
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control rounded-0 border-dark border-1">
                                    @error('email')
                                        <div class="text-danger text-center">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-label fw-bold h5">Password:</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="password" name="password"
                                        class="form-control rounded-0 border-dark border-1">
                                    @error('password')
                                        <div class="text-danger text-center">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                        </div>

                        {{-- Confirm Password --}}


                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-5">
                                    <label for="" class="form-label fw-bold h5">Confrom Password</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="password" class="form-control rounded-0  border border-1 border-dark"
                                        name="password_confirmation" id="">
                                </div>
                            </div>
                        </div>


                        {{-- Phone --}}
                        <div class="mb-3">
                            <div class="row ">
                                <div class="col-md-5">
                                    <label class="form-label fw-bold h5">Phone:</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        class="form-control rounded-0 border-dark border-1">
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
                                    <textarea name="qualifications" rows="3" class="form-control border border-1 border-dark rounded-0"
                                        style="resize: none;">{{ old('qualification') }}</textarea>
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
                                        <option value="" selected disabled>-- Select Department --</option>
                                        @foreach ($departments as $dept)
                                            <option value="{{ $dept->id }}"
                                                {{ old('department') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}
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
                                    <input type="file" name="profile_picture" accept="image/*" id="profile_pic"
                                        class="form-control rounded-0 border border-1 border-dark">
                                    @error('profile_picture')
                                        <div class="text-danger text-center">{{ $message }}</div>
                                    @enderror
                                    <img src="" id="preview" alt="" class="d-block mx-auto mt-2"
                                        style="max-width: 150px;">
                                </div>

                            </div>

                        </div>

                        {{-- Submit --}}
                        <div class="mb-3 text-center">
                            <button class="btn btn-perm">Add Doctor</button>
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
        if (pro_pic) {
            pro_pic.addEventListener('change', () => {
                const file = pro_pic.files[0];
                if (file) {
                    const url = URL.createObjectURL(file);
                    const preview_img = document.getElementById('preview');
                    preview_img.src = url;
                }
            });
        }
    });
</script>

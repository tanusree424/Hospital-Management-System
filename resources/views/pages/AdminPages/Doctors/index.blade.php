@extends('layouts.AdminLayout.app')

@section('content')
    <div class="card shadow">
        <div class="card-header mb-3 bg-primary d-flex justify-content-between">
            <h2 class="text-center fw-bold text-primary text-white">👨‍⚕️ Doctors Management</h2>
            @can('create_doctor')
                <div class=" mb-3">
                    <button data-bs-toggle="modal" data-bs-target="#addDoctorModal" class="btn btn-success text-white">+ Add
                        Doctor</button>
                </div>
                @push('modals')
                    <div class="modal fade" id="addDoctorModal" tabindex="-1" aria-labelledby="addDoctorModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content">
                                <div class="modal-header bg-success">
                                    <h5 class="modal-title text-white" id="addDoctorModalLabel">Add Doctor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
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
                                                    <input type="password"
                                                        class="form-control rounded-0  border border-1 border-dark"
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
                                                    <select name="department"
                                                        class="form-select rounded-0 border border-1 border-dark">
                                                        <option value="" selected disabled>-- Select Department --</option>
                                                        @foreach ($departments as $dept)
                                                            <option value="{{ $dept->id }}"
                                                                {{ old('department') == $dept->id ? 'selected' : '' }}>
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
                                                    <input type="file" name="profile_picture" accept="image/*"
                                                        id="profile_pic"
                                                        class="form-control rounded-0 border border-1 border-dark">
                                                    @error('profile_picture')
                                                        <div class="text-danger text-center">{{ $message }}</div>
                                                    @enderror
                                                    <img src="" id="preview" alt=""
                                                        class="d-block mx-auto mt-2" style="max-width: 150px;">
                                                </div>

                                            </div>

                                        </div>

                                        {{-- Submit --}}


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button class="btn btn-perm">Add Doctor</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endpush
            @endcan

        </div>
<div class="card-body">


        {{-- Flash Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                ✅ <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="col-md-10 m-auto">
            <table class="table table-bordered shadow  table-striped shadow-sm align-middle text-center" id="table_data">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($doctors->count() > 0)
                        @foreach ($doctors as $index => $doctor)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-bold">{{ $doctor->user->name }}</td>
                                <td class="fw-semibold">{{ $doctor->department->name }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2 flex-wrap">

                                        {{-- View Button --}}
                                        <div>
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#viewModal{{ $doctor->id }}">
                                                View
                                            </button>
                                        </div>

                                        {{-- View Modal --}}
                                        @push('modals')
                                            <div class="modal fade" id="viewModal{{ $doctor->id }}" tabindex="-1"
                                                aria-labelledby="viewModalLabel{{ $doctor->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content shadow rounded-4">
                                                        <div class="modal-header bg-info text-white rounded-top-4">
                                                            <h5 class="modal-title fw-bold">Doctor Profile:
                                                                {{ $doctor->user->name }}</h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="text-center mb-3">
                                                                <img src="{{ asset('storage/' . $doctor->profile_picture) }}"
                                                                    class="rounded-circle shadow" width="150"
                                                                    height="150" style="object-fit: cover;"
                                                                    alt="Doctor Image">
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-md-4 text-end fw-bold">Name:</div>
                                                                <div class="col-md-8">{{ $doctor->user->name }}</div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-md-4 text-end fw-bold">Email:</div>
                                                                <div class="col-md-8">{{ $doctor->user->email }}</div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-md-4 text-end fw-bold">Phone:</div>
                                                                <div class="col-md-8">{{ $doctor->phone }}</div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-md-4 text-end fw-bold">Qualification:</div>
                                                                <div class="col-md-8">{{ $doctor->qualifications }}</div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-md-4 text-end fw-bold">Department:</div>
                                                                <div class="col-md-8">{{ $doctor->department->name }}</div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary rounded-pill"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endpush
                                        {{-- Edit & Delete Buttons --}}
                                        @can('edit_doctor')
                                            <div>
                                                <button data-bs-toggle="modal"
                                                    data-bs-target="#editDoctorModal{{ $doctor->id }}"
                                                    class="btn btn-warning btn-sm">Edit</button>
                                                <!-- Modal -->
                                                @push('modals')
                                                    <div class="modal fade" id="editDoctorModal{{ $doctor->id }}"
                                                        tabindex="-1" aria-labelledby="editDoctorModalLabel{{ $doctor->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-centered modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-warning">
                                                                    <h5 class="modal-title text-white fw-bold"
                                                                        id="exampleModalLabel"> Edit Doctor Details -
                                                                        {{ $doctor->user->name }}
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{ route('doctors.update', $doctor->id) }}"
                                                                        method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PUT')

                                                                        {{-- Name --}}
                                                                        <div class="mb-3">
                                                                            <div class="row">
                                                                                <div class="col-md-5">
                                                                                    <label
                                                                                        class="form-label fw-bold h5">Name:</label>
                                                                                </div>
                                                                                <div class="col-md-7">
                                                                                    <input type="text" name="name"
                                                                                        value="{{ old('name', $doctor->user->name) }}"
                                                                                        class="form-control rounded-0 border-dark border-1">
                                                                                    @error('name')
                                                                                        <div class="text-danger text-center">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        {{-- Email --}}
                                                                        <div class="mb-3">
                                                                            <div class="row">
                                                                                <div class="col-md-5">
                                                                                    <label
                                                                                        class="form-label fw-bold h5">Email:</label>
                                                                                </div>
                                                                                <div class="col-md-7">
                                                                                    <input type="email" name="email"
                                                                                        value="{{ old('email', $doctor->user->email) }}"
                                                                                        class="form-control rounded-0 border-dark border-1">
                                                                                    @error('email')
                                                                                        <div class="text-danger text-center">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        {{-- Phone --}}
                                                                        <div class="mb-3">
                                                                            <div class="row">
                                                                                <div class="col-md-5">
                                                                                    <label
                                                                                        class="form-label fw-bold h5">Phone:</label>
                                                                                </div>
                                                                                <div class="col-md-7">
                                                                                    <input type="text" name="phone"
                                                                                        value="{{ old('phone', $doctor->phone) }}"
                                                                                        class="form-control rounded-0 border-dark border-1">
                                                                                    @error('phone')
                                                                                        <div class="text-danger text-center">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        {{-- Qualification --}}
                                                                        <div class="mb-3">
                                                                            <div class="row">
                                                                                <div class="col-md-5">
                                                                                    <label
                                                                                        class="form-label fw-bold h5">Qualifications:</label>
                                                                                </div>
                                                                                <div class="col-md-7">
                                                                                    <textarea name="qualifications" rows="3" class="form-control border border-1 border-dark rounded-0"
                                                                                        style="resize: none;">{{ old('qualifications', $doctor->qualifications) }}</textarea>
                                                                                    @error('qualifications')
                                                                                        <div class="text-danger text-center">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        {{-- Department --}}
                                                                        <div class="mb-3">
                                                                            <div class="row">
                                                                                <div class="col-md-5">
                                                                                    <label
                                                                                        class="form-label fw-bold h5">Department:</label>
                                                                                </div>
                                                                                <div class="col-md-7">
                                                                                    <select name="department"
                                                                                        class="form-select rounded-0 border border-1 border-dark">
                                                                                        <option value="" disabled>-- Select
                                                                                            Department --</option>
                                                                                        @foreach ($departments as $dept)
                                                                                            <option value="{{ $dept->id }}"
                                                                                                {{ old('department', $doctor->department_id) == $dept->id ? 'selected' : '' }}>
                                                                                                {{ $dept->name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    @error('department')
                                                                                        <div class="text-danger text-center">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        {{-- Profile Picture --}}
                                                                        <div class="mb-3">
                                                                            <div class="row">
                                                                                <div class="col-md-5">
                                                                                    <label class="form-label fw-bold h5">Profile
                                                                                        Picture:</label>
                                                                                </div>
                                                                                <div class="col-md-7">
                                                                                    <input type="file" name="profile_picture"
                                                                                        accept="image/*" id="profile_pic"
                                                                                        class="form-control rounded-0 border border-1 border-dark">
                                                                                    @error('profile_picture')
                                                                                        <div class="text-danger text-center">
                                                                                            {{ $message }}</div>
                                                                                    @enderror

                                                                                    @if ($doctor->profile_picture)
                                                                                        <img src="{{ asset('storage/' . $doctor->profile_picture) }}"
                                                                                            id="preview" alt="Current Image"
                                                                                            class="d-block mx-auto mt-2"
                                                                                            style="max-width: 70px;">
                                                                                    @else
                                                                                        <img src="" id="preview"
                                                                                            alt="Preview"
                                                                                            class="d-block mx-auto mt-2"
                                                                                            style="max-width: 70px;">
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        {{-- Submit --}}


                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                   <div class="mb-3 text-center">
                                                                            <button type="submit" class="btn btn-perm">Update Doctor</button>
                                                                        </div>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endpush
                                            </div>
                                            <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete {{ $doctor->user->name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        @endcan

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center text-muted">No Doctors Found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    </div>
    </div>
@endsection

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table_data').DataTable({
            responsive: true,
            dom: '<"row mb-3"<"col-md-4"l><"col-md-4 text-center"B><"col-md-4"f>>rt<"row mt-3"<"col-md-6"i><"col-md-6"p>>',
            buttons: ['copy', 'excel', 'print'],
            columnDefs: [{
                orderable: false,
                targets: [3] // Action column
            }],
            lengthMenu: [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "All"]
            ],
            language: {
                search: "Search:",
                zeroRecords: "No matching roles found",
                info: "Showing _START_ to _END_ of _TOTAL_ roles",
                infoEmpty: "No roles available",
                infoFiltered: "(filtered from _MAX_ total roles)",
                lengthMenu: "Show _MENU_ entries"
            }
        });

        $('.dataTables_filter input[type="search"]').addClass('form-control mb-3').attr("placeholder", "Search...");
    });
</script>
@stack('modals')

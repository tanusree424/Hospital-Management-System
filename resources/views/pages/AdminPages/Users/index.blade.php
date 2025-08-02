@extends('layouts.AdminLayout.app')

@section('title', 'User Management')


<!-- DataTables CSS -->
{{-- <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" /> --}}


@section('content')
    <div class="card shadow">
        <div class="card-header bg-primary d-flex justify-content-between">
            <h2 class="mb-4 text-center text-white">  <i class="fa fa-users me-2"></i> User Management</h2>
            <div>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
            </div>
            <!-- Modal -->
            @push('modals')


                <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('user.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="" class="form-label fw-bold"><strong
                                                        class="h6 fw-bold">Name:</strong></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="name" autocomplete="off" aria-autocomplete="off"
                                                    placeholder="Enter User Name.... " class="form-control">
                                            </div>

                                        </div>
                                        @error('name')
                                            <div class="text-danger text-center">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="" class="form-label fw-bold"><strong
                                                        class="h6 fw-bold">Email:</strong></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="email" name="email" placeholder="Enter User Email.... "
                                                    class="form-control">
                                            </div>
                                            @error('email')
                                                <div class="text-danger text-center">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="" class="form-label fw-bold"><strong
                                                        class="h6 fw-bold">Password:</strong></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="password" name="password" placeholder="Enter User Password.... "
                                                    class="form-control">
                                            </div>

                                        </div>
                                        @error('password')
                                            <div class="text-danger text-center">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="" class="form-label fw-bold"><strong
                                                        class=" h6 fw-bold">Confrim Password:</strong></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="password" name="password_confirmation" autocomplete="off"
                                                    aria-autocomplete="off" placeholder="Confrim Your Password.... "
                                                    class="form-control">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for=""
                                                    class="form-label h6 fw-bold"><strong>Roles</strong></label>
                                            </div>
                                            <div class="col-md-8">
                                                @foreach ($roles as $role)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input " type="radio" name="role"
                                                            value="{{ $role->name }}" id="role_{{ $role->id }}">
                                                        <label class="form-check-label"
                                                            for="role_{{ $role->id }}">{{ $role->name }}</label>
                                                    </div>
                                                @endforeach
                                                @error('role')
                                                    <div class="text-danger text-center">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>
                                    </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <div class="mb-3">
                                        <button class="btn btn-perm">Insert User</button>
                                    </div>
                            </div>
                             </form>
                        </div>
                    </div>
                </div>
            @endpush
        </div>

        <div class="card-body">


            <!-- Button trigger modal (if you have a create modal) -->
            {{-- <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
            Add New User
        </button> --}}

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered mt-3" id="user-table">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role(s)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach ($user->roles as $role)
                                            <span class="badge bg-info text-dark">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <!-- View Button -->
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#viewModal{{ $user->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        <!-- Edit Button -->
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $user->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <!-- Delete Form -->
                                        <form action="{{ route('user.delete', $user->id) }}" method="POST"
                                            style="display:inline-block;"
                                            onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                @push('modals')
                                    <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title">Edit User: {{ $user->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="mb-3 row">
                                                            <label class="col-md-4 col-form-label fw-bold">Name</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="name"
                                                                    value="{{ $user->name }}" class="form-control">
                                                                @error('name')
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row">
                                                            <label class="col-md-4 col-form-label fw-bold">Email</label>
                                                            <div class="col-md-8">
                                                                <input type="email" name="email"
                                                                    value="{{ $user->email }}" class="form-control">
                                                                @error('email')
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row">
                                                            <label class="col-md-4 col-form-label fw-bold">Password</label>
                                                            <div class="col-md-8">
                                                                <input type="password" name="password" class="form-control"
                                                                    placeholder="Leave blank to keep current password">
                                                                @error('password')
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row">
                                                            <label class="col-md-4 col-form-label fw-bold">Confirm
                                                                Password</label>
                                                            <div class="col-md-8">
                                                                <input type="password" name="password_confirmation"
                                                                    class="form-control" placeholder="Confirm password">
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row">
                                                            <label class="col-md-4 col-form-label fw-bold">Roles</label>
                                                            <div class="col-md-8">
                                                                @foreach ($roles as $role)
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="role" value="{{ $role->name }}"
                                                                            id="role_{{ $user->id }}_{{ $role->id }}"
                                                                            {{ $user->roles->contains('id', $role->id) ? 'checked' : '' }}>
                                                                        <label class="form-check-label"
                                                                            for="role_{{ $user->id }}_{{ $role->id }}">
                                                                            {{ $role->name }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                                @error('role')
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="text-end">
                                                            <button class="btn btn-success">Update User</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endpush

                                <!-- View Modal -->
                                @push('modals')
                                    <div class="modal fade" id="viewModal{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="viewModalLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-info text-white">
                                                    <h5 class="modal-title">User Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if ($user->hasRole('Admin') && $user->admin && $user->admin->profile_picture)
                                                        <img src="{{ asset('storage/' . $user->admin->profile_picture) }}"
                                                            alt="Admin Profile" class="img-thumbnail"
                                                            style="width: 200px; height: 200px;">
                                                    @elseif ($user->hasRole('Doctor') && $user->doctor && $user->doctor->profile_picture)
                                                        <img src="{{ asset('storage/' . $user->doctor->profile_picture) }}"
                                                            alt="Doctor Profile" class="img-thumbnail"
                                                            style="width: 200px; height: 200px;">
                                                    @elseif ($user->hasRole('Patient') && $user->patient && $user->patient->patient_image)
                                                        <img src="{{ asset('storage/' . $user->patient->patient_image) }}"
                                                            alt="Patient Profile" class="img-thumbnail"
                                                            style="width: 200px; height: 200px; object-fit:contain">
                                                    @else
                                                        <img src="{{ asset('default-user.png') }}" alt="Default Profile"
                                                            class="img-thumbnail"
                                                            style="width: 200px; object-fit:contain; height: 200px;">
                                                    @endif

                                                    <p><strong>Name:</strong> {{ $user->name }}</p>
                                                    <p><strong>Email:</strong> {{ $user->email }}</p>
                                                    <p><strong>Roles:</strong>
                                                        @foreach ($user->roles as $role)
                                                            <span class="badge bg-dark">{{ $role->name }}</span>
                                                        @endforeach
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endpush
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection



<!-- DataTables JS -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script>
    $(document).ready(function() {
        $('#user-table').DataTable({
            responsive: true,
            dom: '<"d-flex justify-content-between align-items-center mb-3"lBf>rtip',
            buttons: ['copy', 'excel', 'print'],
            pageLength: 5,
            lengthMenu: [
                [5,10, 25, 50, -1],
                [5,10, 25, 50, "All"]
            ],
            columnDefs: [{
                orderable: false,
                targets: [3]
            }],
        });
    });
</script>

@if (session('success') || session('error'))
    <script>
        Swal.fire({
            icon: '{{ session('success') ? 'success' : 'error' }}',
            title: '{{ session('success') ? 'Success' : 'Error' }}',
            text: '{{ session('success') ?? session('error') }}',
            confirmButtonColor: '{{ session('success') ? '#3085d6' : '#d33' }}'
        });
    </script>
@endif


{{-- Modals Section --}}
@stack('modals')

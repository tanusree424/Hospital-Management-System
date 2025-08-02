@extends('layouts.AdminLayout.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-primary d-flex justify-content-between">
            <h2 class="text-center fw-bold text-white"><strong><i class="fa fa-lock me-2"></i> Permission
                    Managemnent</strong></h2>
            @can('add permission')
                <div class="mb-3">
                    <button data-bs-toggle="modal" data-bs-target="#addPermissionModal" class="btn btn-success">
                        Add Permissions
                    </button>

                    <!-- Add Permission Modal -->
                    @push('modals')
                        <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-labelledby="addPermissionModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title" id="addPermissionModalLabel">Add Permission</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <form action="{{ route('permission.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="perm-name" class="form-label"><strong>Permission Name</strong></label>
                                                <input type="text" id="perm-name" name="name" class="form-control"
                                                    placeholder="Enter Permission Name">
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="perm-slug" class="form-label"><strong>Permission Slug</strong></label>
                                                <input type="text" id="perm-slug" name="permission_slug" class="form-control"
                                                    placeholder="Enter Permission Slug">
                                                @error('permission_slug')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success">Add Permission</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endpush


                </div>
            @endcan

        </div>
        <div class="card-body">



            <div class="col-md-8 mt-5 m-auto">
                <table class="table table-bordered shadow-sm shadow align-middle table-stripped table-hover"
                    id="table_data">
                    <thead class="text-center table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Permission slug</th>
                            <th>Guard Name</th>
                            <th>Created Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($permissions->count() > 0)
                            @php
                                $index = 1;
                            @endphp
                            @foreach ($permissions as $permission)
                                <tr class="text-center">
                                    <td>{{ $index++ }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->permission_slug }}</td>
                                    <td>{{ $permission->guard_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($permission->created_at)->timezone('asia/kolkata')->format('d-M-Y h:i A') }}
                                    </td>
                                    <td class="d-flex justify-content-center align-items-center gap-2">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editPermissionModal{{ $permission->id }}"
                                            class="btn btn-warning">Edit</button>
                                        <!-- Edit Permission -->
                                        @push('modals')
                                            <div class="modal fade" id="editPermissionModal{{ $permission->id }}"
                                                tabindex="-1" aria-labelledby="editPermissionModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title" id="editPermissionModalLabel">
                                                                Edit Permission #{{ $permission->id }} -
                                                                {{ $permission->name }}
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>

                                                        <!-- Modal Body -->
                                                        <form action="{{ route('permission.update', $permission->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <!-- Permission Name -->
                                                                <div class="mb-3 row">
                                                                    <label class="col-md-4 col-form-label fw-bold">Permission
                                                                        Name:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="name"
                                                                            value="{{ $permission->name }}"
                                                                            placeholder="Enter Permission Name Here..."
                                                                            class="form-control border-dark rounded-0" required>
                                                                    </div>
                                                                </div>
                                                                @error('name')
                                                                    <p class="text-danger">{{ $message }}</p>
                                                                @enderror

                                                                <!-- Permission Slug -->
                                                                <div class="mb-3 row">
                                                                    <label class="col-md-4 col-form-label fw-bold">Permission
                                                                        Slug:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="permission_slug"
                                                                            value="{{ $permission->permission_slug }}"
                                                                            placeholder="Enter Permission Slug Here..."
                                                                            class="form-control border-dark rounded-0"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                                @error('permission_slug')
                                                                    <p class="text-danger">{{ $message }}</p>
                                                                @enderror
                                                            </div>

                                                            <!-- Modal Footer -->
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Update
                                                                    Permission</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endpush


                                        <form action="{{ route('permission.delete', $permission->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                onclick="return confirm('Are you sure you want to delete: {{ $permission->name }}?')"
                                                class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">No Permission Found</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script>
    $(document).ready(function() {
        $("#table_data").DataTable({
            responsive: true,
            dom: '<"d-flex justify-content-between align-items-center mb-3"lBf>rtip',
            buttons: ['copy', 'excel', 'print'],
            columnDefs: [{
                    orderable: false,
                    targets: [4]
                } // Make sure this index is for the Action column
            ],
            lengthMenu: [
                [5, 10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            language: {
                search: "Search:",
                zeroRecords: "No matching users found",
                info: "Showing _START_ to _END_ of _TOTAL_ users",
                infoEmpty: "No users available",
                infoFiltered: "(filtered from _MAX_ total users)",
                lengthMenu: "Show _MENU_ entries"


            }
        });
    });
</script>
@stack('modals')

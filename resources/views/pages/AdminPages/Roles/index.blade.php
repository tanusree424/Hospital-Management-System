@extends('layouts.AdminLayout.app')

@section('content')
    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            ❌ {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Whoops!</strong> Please fix the following errors:
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @can('access-role')
        <div class="card mt-4 shadow-sm">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h2 class="fw-bold text-white m-0">  <i class="fa fa-user-shield me-2"></i>Roles Management</h2>

                @can('create-role')
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                        + Add Role
                    </button>
                @endcan
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mt-3 table-bordered table-hover table-striped" id="table_data">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @php $index = 1; @endphp
                            @forelse ($roles as $role)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($role->created_at)->timezone('Asia/Kolkata')->format('d-M-Y h:i A') }}</td>
                                    <td class="d-flex justify-content-center gap-2">
                                        @can('edit-role')
                                            <div>
                                                <button data-bs-toggle="modal" data-bs-target="#editRoleModal{{ $role->id }}"
                                                    class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                            </div>
                                        @endcan

                                        @can('delete-role')
                                            <form action="{{ route('role.destroy', $role->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Are you sure you want to delete this role?')"
                                                    class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>

                                @push('modals')
                                    <div class="modal fade" id="editRoleModal{{ $role->id }}" tabindex="-1"
                                        aria-labelledby="editRoleLabel{{ $role->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-xl">
                                            <div class="modal-content shadow rounded-4">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title" id="editRoleLabel{{ $role->id }}">
                                                        Edit Role #{{ $role->id }} - {{ $role->name }}
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('role.update', $role->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Role Name</label>
                                                            <input type="text" name="name" class="form-control"
                                                                value="{{ $role->name }}" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Assign Permissions</label>
                                                            <div class="row">
                                                                @foreach ($permissions as $permission)
                                                                    <div class="col-md-4">
                                                                        <div class="form-check">
                                                                            <input type="checkbox" name="permissions[]"
                                                                                value="{{ $permission->name }}"
                                                                                class="form-check-input"
                                                                                id="editPerm{{ $role->id }}_{{ $permission->id }}"
                                                                                {{ $role->permissions->pluck('name')->contains($permission->name) ? 'checked' : '' }}>
                                                                            <label class="form-check-label"
                                                                                for="editPerm{{ $role->id }}_{{ $permission->id }}">
                                                                                {{ $permission->name }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer px-0">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button class="btn btn-primary">Update Role</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endpush
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No Roles Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- <div class="d-flex justify-content-center mt-4">
                    {{ $roles->links() }}
                </div> --}}
            </div>
        </div>
    @else
        <div class="alert alert-danger text-center mt-5">
            You do not have permission to view this page.
        </div>
    @endcan
@endsection

{{-- Add Role Modal --}}
@push('modals')
    @can('create-role')
        <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content shadow rounded-4">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="addRoleModalLabel">Add Role</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ route('role.store') }}" method="POST">
                            @csrf

                            <div class="mb-3 row">
                                <label class="col-md-3 col-form-label fw-bold">Role Name</label>
                                <div class="col-md-9">
                                    <input type="text" name="name" placeholder="Enter role name..." class="form-control"
                                        required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold">Assign Permissions</label>
                                <div class="row">
                                    @foreach ($permissions as $permission)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                    class="form-check-input" id="perm{{ $permission->id }}">
                                                <label class="form-check-label" for="perm{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="modal-footer px-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary">Create Role</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endpush

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

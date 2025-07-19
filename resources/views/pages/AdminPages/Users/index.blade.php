@extends('layouts.AdminLayout.app')

@section('content')
<div class="container-fluid">
    <div class="col-md-12">
        <h2 class="text-center fw-bold">User Management</h2>
        <div class="d-flex justify-content-end mb-2">
            <a href="{{ route('user.create') }}" class="btn btn-primary">Add User</a>
        </div>
        <hr>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="col-md-8 mt-4 m-auto">
        <table class="table  table-bordered table-hover table-striped border-dark border-2" id="table_data">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Created Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($users->count() > 0)
                    @foreach ($users as $index => $user)
                    <tr class="text-center">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                        <td>{{ \Carbon\Carbon::parse($user->created_at)->timezone('Asia/Kolkata')->format('d-M-Y h:i A') }}</td>
                        <td class="d-flex justify-content-center align-items-center gap-2 flex-wrap">
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning">Edit</a>

                            <!-- View Button & Modal Trigger -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal{{ $user->id }}">
                                View
                            </button>

                            <!-- Delete Form -->
                            <form action="{{ route('user.delete', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete: {{ $user->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- View Modal -->
                    <div class="modal fade" id="viewModal{{ $user->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content border-0 shadow rounded-3">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="viewModalLabel{{ $user->id }}">User Details</h5>
                                    <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5><strong>Name:</strong> {{ $user->name }}</h5>
                                    <h5><strong>Email:</strong> {{ $user->email }}</h5>
                                    <h5><strong>Role:</strong> {{ $user->roles->pluck('name')->join(', ') }}</h5>
                                </div>
                                <div class="modal-footer bg-light">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                <tr>
                    <td colspan="5" class="text-center">No Users Found</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection


<!-- DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script>
$(document).ready(function () {
    $('#table_data').DataTable({
        responsive: true,
        dom: '<"d-flex justify-content-center mb-3"B>frtip',
        buttons: ['copy', 'excel', 'print'],
        columnDefs: [
            { orderable: false, targets: [4] } // Action column
        ],
        language: {
            search: "Search:",
            zeroRecords: "No matching users found",
            info: "Showing _START_ to _END_ of _TOTAL_ users",
            infoEmpty: "No users available",
            infoFiltered: "(filtered from _MAX_ total users)",
        }
    });
     $('.dataTables_filter input[type="search"]').addClass('form-control mb-3').attr("placeholder", "Search...");
});
</script>


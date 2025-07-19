@extends('layouts.AdminLayout.app')

@section('content')

@can('access-role')
    <h2 class="text-center fw-bold"><strong>Roles Management</strong></h2>

    <div class="d-flex justify-content-end">
        @can('create-role')
            <a href="{{ route('role.create') }}" class="btn btn-primary">Add Roles</a>
        @endcan
    </div>

    <hr>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Whoops!</strong> Please fix the following errors:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="col-md-8 m-auto">
        <table class="table mt-5 table-bordered border-2 border-dark table-hover table-striped" id="table_data" >
            <thead class="text-center table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $index = 1; @endphp
                @forelse ($roles as $role)
                    <tr class="text-center">
                        <td>{{ $index++ }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($role->created_at)->timezone('Asia/Kolkata')->format('d-M-Y h:i A') }}</td>
                        <td class="d-flex justify-content-center align-items-center gap-2">
                            @can('edit-role')
                                <a href="{{ route('role.edit', $role->id) }}" class="btn btn-warning">Edit</a>
                            @endcan

                            @can('delete-role')
                                <form action="{{ route('role.destroy', $role->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure you want to delete?')" class="btn btn-danger">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No Roles Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $roles->links() }}
        </div>
    </div>
@else
    <div class="alert alert-danger text-center mt-5">
        You do not have permission to view this page.
    </div>
@endcan

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script>
    $(document).ready(function(){
        $("#table_data").dataTable({
            responsive: true,

        dom: '<"d-flex justify-content-center mb-3"B>frtip',
        buttons: ['copy', 'excel', 'print'],
        columnDefs: [
            { orderable: false, targets: [3] } // Action column
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

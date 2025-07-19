@extends('layouts.AdminLayout.app')

@section('content')
<h2 class="text-center fw-bold"><strong>Permission Managemnent</strong></h2>
<div class="d-flex justify-content-end">
<a href="{{route('permission.create') }}" class="btn btn-primary">Add Permissions</a>
</div>
<hr>
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> {{session('success')}}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> {{session('error')}}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="col-md-8 mt-5 m-auto">
<table class="table table-bordered shadow-sm shadow align-middle table-stripped table-hover" id="table_data">
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
        @if ($permissions->count() >0)
        @php
            $index=1;
        @endphp
            @foreach ($permissions as $permission )
              <tr class="text-center">
                <td>{{$index++}}</td>
                <td>{{$permission->name}}</td>
                <td>{{$permission->permission_slug}}</td>
                <td>{{$permission->guard_name}}</td>
                <td>{{ \Carbon\Carbon::parse($permission->created_at)->timezone('asia/kolkata')->format('d-M-Y h:i A')}}</td>
               <td class="d-flex justify-content-center align-items-center gap-2">
    <a href="{{ route('permission.edit', $permission->id) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('permission.delete', $permission->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button onclick="return confirm('Are you sure you want to delete: {{ $permission->name }}?')" class="btn btn-danger">Delete</button>
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


        });

</script>

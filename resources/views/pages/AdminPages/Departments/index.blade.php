@extends('layouts.AdminLayout.app')
@section('content')
<div class="container-fluid">
    <div class="col-md-12">

        <h3 class="text-center fw-bold"><strong>Deaprtment Management</strong></h3>
    </div>
    <div class="d-flex justify-content-end">
         @can('create_department')
            <a href="{{route('departments.create')}}" class="btn btn-primary">Add Department</a>
        @endcan

    </div>
    <hr>
    @if (session('success'))
        <div class="alert-success alert alert-dismissible fade show" role="alert ">
            <strong>Success!</strong> {{session('success')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="col-md-7 m-auto">
       <table class="table table-bordered shadow  table-striped shadow-sm align-middle text-center" id="table_data">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Department name</th>
                    <th>Created Time</th>

                        <th>Action</th>


                </tr>
            </thead>
            <tbody class="text-center">
                @if ($departments->count() >0)
                @php
                    $index =1;
                @endphp
                @foreach ($departments as $dept)
                    <tr>
                        <td>{{$index++}}</td>
                        <td>{{$dept->name}}</td>
                        <td>{{\Carbon\Carbon::parse($dept->created_at)->timezone('asia/kolkata')->format('d-M-Y h:iA')}}</td>

                        <td class="d-flex justify-content-center align-items-center gap-2">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal{{$dept->id}}">
  View
</button>
<div class="modal fade" id="viewModal{{$dept->id}}" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewModalLabel{{$dept->id}}">{{$dept->name}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <h4>Department Name: {{$dept->name}}</h4>
       <h4>Description</h4>
       <p>
        {{$dept->description}}
       </p>
      </div>

    </div>
  </div>
</div>
                            @can('edit_permission')
                         <a href="{{route('departments.edit', $dept->id)}}" class="btn btn-warning">Edit</a>
                            <form action="{{route('departments.delete', $dept->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are You Sure want to delete department {{$dept->name}} ?')" class="btn btn-danger">Delete</button>
                            </form>

                    @endcan

                        </td>
                    </tr>
                @endforeach
                    @else
                    <tr>
                        <td class="text-center" colspan="4">No Department Found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>


</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>


<!-- And below scripts -->
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
                { orderable: false, targets: [2] } // Disable sorting on 'Actions' column
            ]
        });
         $('.dataTables_filter input[type="search"]').addClass('form-control mb-3').attr("placeholder", "Search...");
    });
</script>

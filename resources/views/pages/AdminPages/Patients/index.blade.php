@extends('layouts.AdminLayout.app')
@section('content')
<div class="container-fluid">
    <div class="col-md-12">
        <h2 class="text-center"><strong>Patients Management</strong></h2>
    </div>
    <div class="d-flex justify-content-end">
        <a href="{{route('patients.create')}}" class="btn btn-primary">Add Patients</a>
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
  <strong>Success!</strong> {{session('error')}}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
    <div class="col-md-8 p-4 m-auto">
         <table class="table table-bordered  table-hover table-striped border-dark border-2" id="table_data">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>#</th>
                    <th>Patient Name</th>
                    <th>Created At</th>
                    <th>Action</th>


                </tr>
            </thead>
            <tbody>
                @php
                    $index=1;
                @endphp
                @if ($patients->count() >0)
                  @foreach ($patients as $pat )
                      <tr class="text-center">
                        <td class="h5">{{$index++}}</td>
                        <td class="h5">{{$pat->user->name}}</td>
                        <td class="h5">{{\Carbon\carbon::parse($pat->created_at->timezone('asia/kolkata')->format('d-M-Y h:iA' ))}}</td>
                        <td class="d-flex justify-content-centeralign-items gap-2">
                            <div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewPatientModal{{$pat->id}}">
  View
</button>
</div>
<div>
    <a href="{{route('patients.edit',$pat->id)}}" type="button" class="btn btn-warning" >
  Edit
</a>
</div>
<form action="{{ route('patients.destroy', $pat->id) }}" method="POST" onsubmit="return confirm('Are you sure want to delete {{ $pat->user->name }}?')">
    @csrf
    @method('DELETE')
    <div>
    <button type="submit" class="btn btn-danger">Delete</button>
    </div>
</form>


<div class="modal fade" id="viewPatientModal{{$pat->id}}" tabindex="-1" aria-labelledby="viewPatientModalLabel{{$pat->id}}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewPatientModalLabel{{$pat->id}}">{{$pat->user->name}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img src="{{asset('storage/'. $pat->patient_image )}}" class="rounded-circle shadow" width="180" height="180" style="object-fit: cover;"">
    <hr>
    <hr>

        <div class="mt-4">
          <div class="row mb-3">
            <div class="col-md-4 text-end fw-bold">Name:</div>
            <div class="col-md-8">{{ $pat->user->name }}</div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4 text-end fw-bold">Email:</div>
            <div class="col-md-8">{{ $pat->user->email }}</div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4 text-end fw-bold">Phone:</div>
            <div class="col-md-8">{{ $pat->phone }}</div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4 text-end fw-bold">DOB:</div>
            <div class="col-md-8">{{ $pat->DOB }}</div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4 text-end fw-bold">Gender:</div>
            <div class="col-md-8">{{ $pat->gender }}</div>
          </div>
           <div class="row mb-3">
            <div class="col-md-4 text-end fw-bold">Total Appointment:</div>
            <div class="col-md-8">{{ $pat->appointment->count() }}</div>
          </div>
      <div class="row mb-3">
    <div class="col-md-4 text-end fw-bold">Appointments By:</div>
    <div class="col-md-8">
        @php
            $doctorNames = $pat->appointment
                ->filter(fn($a) => $a->doctor && $a->doctor->user)
                ->map(fn($a) => $a->doctor->user->name)
                ->unique(); // Remove duplicates
        @endphp

        @if($doctorNames->isNotEmpty())
            <ul class="mb-0">
                @foreach($doctorNames as $docName)
                    <li>{{ $docName }}</li>
                @endforeach
            </ul>
        @else
            N/A
        @endif
    </div>
</div>




    </div>
    <hr>
    <hr>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-5" data-bs-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>

                        </td>

                      </tr>
                  @endforeach
                  @else
                  <tr>
                    <td cols="3" class="text-center">No Patient Found</td>
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
        var table = $('#table_data').DataTable({
            responsive: true,
            scrollX: true,
            pageLength: 10,
            ordering: true,
            autoWidth: false,
            dom: '<"d-flex justify-content-center mb-3"B>frtip',
            buttons: ['copy', 'excel', 'print'],
            columnDefs: [
                { orderable: false, targets: [3] }
            ],
            language: {
                search: "Search all columns:",
                lengthMenu: "Show _MENU_ patients per page",
                zeroRecords: "No patients found",
                info: "Showing page _PAGE_ of _PAGES_",
                infoEmpty: "No patients available",
                infoFiltered: "(filtered from _MAX_ total patients)"
            }
        });

        // Add Bootstrap styling to search box
        $('.dataTables_filter input[type="search"]').addClass('form-control mb-3').attr("placeholder", "Search...");
    });
</script>


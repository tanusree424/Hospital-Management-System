@extends('layouts.AdminLayout.app')
@section('content')
<div class="container-fluid">
    <div class="col-md-12 text-center">
        <h4 class="text-center">Medical Records</h4>
    </div>
    <hr>
    <div class="col-md-8 m-auto">
        <table class="table table-bordered shadow-sm shadow align-middle table-stripped table-hover" id="table_data">
            <thead class="table-dark">
                <tr class="text-center">
                <th>#</th>
                <th>Name</th>
                <th>Doctor</th>
                <th>Department</th>
                <th>Download Report</th>
                </tr>
            </thead>
            <tbody>
                @if ($medical_records->count() >0 )
                @php
                    $index=1;

                @endphp
                    @foreach ($medical_records as $mr_record )
                        <tr class="text-center">
                            <td>{{$index++}}</td>
                            <td>{{$mr_record->patient->user->name}}</td>
                            <td>{{$mr_record->doctor->user->name}}</td>
                            <td>{{$mr_record->doctor->department->name}}</td>
                            <td>
                            @if ($mr_record->appointment->id)
    <form action="{{route('medical_record.download')}}" method="POST">
        @csrf

        <input type="hidden" name="appointment_id" value="{{$mr_record->appointment->id}}">
        <button type="submit" class="btn btn-sm btn-primary" target="_blank" download>
            Download Report
        </button>
        </form>
        </td>
   @else
   <td class="text-dark">No Report Uploaded</td>
   @endif

                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
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
     $(document).ready(function () {
        $('#table_data').DataTable({
            responsive: true,
            dom: '<"d-flex justify-content-center mb-3"B>frtip',
            buttons: ['copy', 'excel', 'print'],
            columnDefs: [
                { orderable: false, targets: [1,3] }
            ]
        });
    });
</script>

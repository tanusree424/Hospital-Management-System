@extends('layouts.AdminLayout.app')
@section('content')
<div class="card">
  <div class="card-header bg-primary d-flex justify-content-between">
     <h4 class="text-center text-white"><i class="fa fa-file-medical me-2"></i>Medical Records</h4>
  </div>

<div class="card-body">

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

    @if ($medical_records->count() > 0)
        @php $index = 1; @endphp
        @foreach ($medical_records as $index => $mr_record)

            <tr class="text-center">
                <td>{{$index+1}}</td>
              <td>{{ $mr_record->patient?->user?->name ?? 'GUEST' }}</td>
<td>{{ $mr_record->doctor?->user?->name ?? 'N/A' }}</td>
<td>{{ $mr_record->doctor?->department?->name ?? 'N/A' }}</td>

                <td>
                    @if (!is_null($mr_record->appointment) && $mr_record->appointment->id)
                        <form action="{{ route('medical_record.download') }}" method="POST" target="_blank">
                            @csrf
                            <input type="hidden" name="appointment_id" value="{{ $mr_record->appointment->id }}">
                            <button type="submit" class="btn btn-sm btn-primary" download>
                                <i class="fa fa-download"></i> Download Report
                            </button>
                        </form>
                    @else
                        <span class="text-dark">No Report Uploaded</span>
                    @endif
                </td>
            </tr>
        @endforeach
    @endif
</tbody>

        </table>
    </div>
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
     $(document).ready(function () {
        $('#table_data').DataTable({
            responsive: true,
            dom: '<"d-flex justify-content-between align-items-center mb-3"lBf>rtip',
            buttons: ['copy', 'excel', 'print'],
            columnDefs: [{
                orderable: false,
                targets: [2]
            }],
            lengthMenu: [
        [5, 10, 25, 50, 100, -1],
        [5, 10, 25, 50, 100, "All"]
    ],
            language: {
                search: "Search:",
                zeroRecords: "No matching patients found",
                info: "Showing _START_ to _END_ of _TOTAL_ patients",
                infoEmpty: "No patients available",
                infoFiltered: "(filtered from _MAX_ total patients)",
                lengthMenu: "Show _MENU_ entries"
            }
        });
        $('.dataTables_filter input[type="search"]').addClass('form-control mb-3').attr("placeholder",
            "Search...");
    });
</script>

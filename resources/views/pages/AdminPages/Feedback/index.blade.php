@extends('layouts.AdminLayout.app')

@section('content')
<div class="card shadow">
    <div class="card-header mb-3 bg-primary d-flex justify-content-between">
        <h2 class="text-center fw-bold text-white m-0">
            <i class="fas fa-comment-dots me-2"></i> Feedback Management
        </h2>
    </div>

    <div class="card-body">
        <div class="card">
            <table class="table table-bordered table-striped table-hover" id="table_data">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Sl No.</th>
                        <th>Patient</th>
                        <th>Rating</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($feedbacks as $feedback)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $feedback->patient->user->name ?? 'N/A' }}</td>
                            <td>
                                @php
                                    $rating = $feedback->rating ?? 0;
                                @endphp
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $rating ? 'text-warning' : 'text-secondary' }}"></i>
                                @endfor
                            </td>
                            <td>{{ $feedback->message ?? 'No message provided' }}</td>
                            <td class="text-center">

                                <form action="{{route('admin.feedback.delete',  $feedback->id)}}"
                                      method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this feedback?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No Feedback Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- DataTables Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function(){
        $("#table_data").DataTable({
            responsive: true,
            dom: '<"row mb-3"<"col-md-4"l><"col-md-4 text-center"B><"col-md-4"f>>rt<"row mt-3"<"col-md-6"i><"col-md-6"p>>',
            buttons: ['copy', 'excel', 'print'],
            columnDefs: [{
                orderable: false,
                targets: [4] // Action column index
            }],
            lengthMenu: [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "All"]
            ],
            language: {
                search: "Search:",
                zeroRecords: "No matching feedbacks found",
                info: "Showing _START_ to _END_ of _TOTAL_ feedbacks",
                infoEmpty: "No feedbacks available",
                infoFiltered: "(filtered from _MAX_ total feedbacks)",
                lengthMenu: "Show _MENU_ entries"
            }
        });
    });
</script>
@endsection

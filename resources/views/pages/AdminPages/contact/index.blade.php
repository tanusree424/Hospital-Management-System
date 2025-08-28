@extends('layouts.AdminLayout.app')

@section('content')
    <div class="card">
        <div class="card-header bg-primary d-flex gap-3">
            <i class="bi bi-envelope fs-2 text-white"></i>
            <h2 class="text-white">All Queries</h2>
        </div>

        <div class="card-body">
            <div class="col-md-10 m-auto">
                <table id="table_data" class="table table-bordered table-hover table-striped shadow">
                    <thead class="table-dark text-center">
                        <tr class="text-center">
                            <th>ID</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($contacts as $cont)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $cont->name }}</td>
                                <td>{{ $cont->email }}</td>
                                <td class="d-flex gap-2 justify-content-center">
                                    <!-- View Button -->
                                    <button data-bs-target="#viewContactModal{{ $cont->id }}" data-bs-toggle="modal"
                                        class="btn btn-info">
                                        <i class="bi bi-eye"></i> View
                                    </button>

                                    <!-- Delete Button -->
                                    <button class="btn btn-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>

                            <!-- VIEW Contact Modal -->
                            @push('modals')
                                <div class="modal fade" id="viewContactModal{{ $cont->id }}" tabindex="-1"
                                    aria-labelledby="viewContactModalLabel{{ $cont->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewContactModalLabel{{ $cont->id }}">
                                                    Contact Details
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Name:</strong> {{ $cont->name }}</p>
                                                <p><strong>Email:</strong> {{ $cont->email }}</p>
                                                <p><strong>Subject:</strong> {{ $cont->subject }}</p>
                                                <p><strong>Message:</strong> {{ $cont->message }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endpush
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No Message Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@stack('modals')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>


<!-- And below scripts -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script>
    $(document).ready(function(){
        $("#table_data").DataTable({
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
                zeroRecords: "No matching queries found",
                info: "Showing _START_ to _END_ of _TOTAL_ queries",
                infoEmpty: "No queries available",
                infoFiltered: "(filtered from _MAX_ total queries)",
                lengthMenu: "Show _MENU_ queries"
            }

        });
    })

</script>

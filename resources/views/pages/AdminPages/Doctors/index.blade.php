@extends('layouts.AdminLayout.app')

@section('content')
<div class="container-fluid">
    <div class="col-md-12">
        <h2 class="text-center fw-bold text-primary">👨‍⚕️ Doctors Management</h2>
    </div>

    @can('create_doctor')
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('doctors.create') }}" class="btn btn-primary">+ Add Doctor</a>
        </div>
    @endcan

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

   <div class="col-md-10 m-auto">
    <table class="table table-bordered shadow  table-striped shadow-sm align-middle text-center" id="table_data">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
            <tbody>
                @if ($doctors->count() > 0)
                    @foreach ($doctors as $index => $doctor)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $doctor->user->name }}</td>
                            <td class="fw-semibold">{{ $doctor->department->name }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">

                                    {{-- View Button --}}
                                    <div>
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal{{ $doctor->id }}">
                                        View
                                    </button>
                                    </div>

                                    {{-- View Modal --}}
                                    <div class="modal fade" id="viewModal{{ $doctor->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $doctor->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content shadow rounded-4">
                                                <div class="modal-header bg-info text-white rounded-top-4">
                                                    <h5 class="modal-title fw-bold">Doctor Profile: {{ $doctor->user->name }}</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-center mb-3">
                                                        <img src="{{ asset('storage/' . $doctor->profile_picture) }}" class="rounded-circle shadow" width="150" height="150" style="object-fit: cover;" alt="Doctor Image">
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-4 text-end fw-bold">Name:</div>
                                                        <div class="col-md-8">{{ $doctor->user->name }}</div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-4 text-end fw-bold">Email:</div>
                                                        <div class="col-md-8">{{ $doctor->user->email }}</div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-4 text-end fw-bold">Phone:</div>
                                                        <div class="col-md-8">{{ $doctor->phone }}</div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-4 text-end fw-bold">Qualification:</div>
                                                        <div class="col-md-8">{{ $doctor->qualifications }}</div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-4 text-end fw-bold">Department:</div>
                                                        <div class="col-md-8">{{ $doctor->department->name }}</div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Edit & Delete Buttons --}}
                                    @can('edit_doctor')
                                    <div>
                                        <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        </div>
                                        <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete {{ $doctor->user->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    @endcan

                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center text-muted">No Doctors Found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection

{{-- Scripts --}}
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
                { orderable: false, targets: [3] } // Disable sorting on 'Actions' column
            ]
        });
         $('.dataTables_filter input[type="search"]').addClass('form-control mb-3').attr("placeholder", "Search...");
    });
</script>

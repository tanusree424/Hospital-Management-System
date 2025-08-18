<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">

    <h5 class="fw-bold text-wahite">Ward Management</h5>
    @can('add_ward_access')


    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#createWardModal">
         <i class="fa fa-plus me-1"></i>  Add Ward
    </button>
     @endcan
</div>
  <div class="card-body table-responsive">
        @if(session('ward_success'))
            <div class="alert alert-success">{{ session('ward_success') }}</div>
        @endif
<table class="table table-bordered table-striped" id="ward_table">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Capacity</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($wards as $index => $ward)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $ward->name }}</td>
            <td>{{ $ward->capacity }}</td>
            <td>{{ $ward->description ?? 'N/A' }}</td>
            <td>

                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewWardModal{{ $ward->id }}">
                    <i class="bi bi-eye"></i>
                </button>
                @can('edit_ward_access')


                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editWardModal{{ $ward->id }}">
                    <i class="bi bi-pencil-square"></i>
                </button>
                 @endcan
                 @can('delete_ward_access')


                <form action="{{route('hospital.management.destroy', $ward->id)}}" method="POST" class="d-inline"
                    onsubmit="return confirm('Are you sure you want to delete this ward?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
                 @endcan
            </td>
        </tr>

        @include('pages.AdminPages.hospital.modals.Wards.view-ward', ['ward' => $ward])
        @include('pages.AdminPages.hospital.modals.Wards.edit-ward', ['ward' => $ward])
        @empty
        <tr>
            <td colspan="5" class="text-center text-muted">No wards available.</td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>
</div>


{{-- Create Ward Modal --}}
@include('pages.AdminPages.hospital.modals.Wards.add-ward')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script>
    $("#ward_table").dataTable({
         responsive: true,
            dom: '<"row mb-3"<"col-md-4"l><"col-md-4 text-center"B><"col-md-4"f>>rt<"row mt-3"<"col-md-6"i><"col-md-6"p>>',
            buttons: ['copy', 'excel', 'print'],
            columnDefs: [{
                orderable: false,
                targets: [3] // Action column
            }],
            lengthMenu: [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "All"]
            ],
            language: {
                search: "Search:",
                zeroRecords: "No matching roles found",
                info: "Showing _START_ to _END_ of _TOTAL_ roles",
                infoEmpty: "No roles available",
                infoFiltered: "(filtered from _MAX_ total roles)",
                lengthMenu: "Show _MENU_ entries"
            }
    })
</script>

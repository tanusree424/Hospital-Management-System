<div class="card mb-4 shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0 fw-bold">💊 Medicine Management</h4>
        @can('add_medicinne_access')


        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addMedicineModal">
            <i class="bi bi-plus-circle me-1"></i> Add Medicine
        </button>
        @endcan
    </div>

    <div class="card-body">
        @if (session('medicine_success'))
            <div class="alert alert-success">{{ session('medicine_success') }}</div>
        @endif

        <div class="table-responsive">
            <table id="medicine_table" class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Manufacturer</th>
                        <th>Dosage</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($medicines as $medicine)
                        <tr>
                            <td>{{ $medicine->name }}</td>
                            <td>{{ $medicine->category }}</td>
                            <td>{{ $medicine->manufacturer }}</td>
                            <td>{{ $medicine->dosage }}</td>
                            <td>{{ $medicine->description ?? '---' }}</td>
                            <td class="d-flex gap-2 no-warp">
                                <!-- View -->
                                <div>

                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                        data-bs-target="#viewMedicineModal{{ $medicine->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <!-- Edit -->
                                @can('edit_medicine_access')
                                    <div>
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#editMedicineModal{{ $medicine->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </div>
                                @endcan
                                <!-- Delete -->
                                @can('delete_bed_access')


                                <div>
                                    <form action="{{ route('hospital.management.medicine.destroy', $medicine->id) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this medicine?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                 @endcan
                            </td>
                        </tr>

                        <!-- Modals -->
                        @include('pages.AdminPages.hospital.modals.Medicine.view-medicine', [
                            'medicine' => $medicine,
                        ])
                        @include('pages.AdminPages.hospital.modals.Medicine.edit-medicine', [
                            'medicine' => $medicine,
                        ])
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted">No medicines available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('pages.AdminPages.hospital.modals.Medicine.add-medicine')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script>
    $("#medicine_table").dataTable({
        responsive: true,
        autoWidth: false,
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

@extends('layouts.AdminLayout.app')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center fw-bold text-primary mb-4">🏥 Hospital Management Dashboard</h2>

        <!-- Navigation Tabs -->
        <ul class="nav nav-pills mb-3 justify-content-center" id="hospital-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="ward-tab" data-bs-toggle="pill" data-bs-target="#ward" type="button"
                    role="tab" aria-controls="ward" aria-selected="true">
                    🏥 Ward
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="bed-tab" data-bs-toggle="pill" data-bs-target="#bed" type="button"
                    role="tab" aria-controls="bed" aria-selected="false">
                    🛏️ Bed
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="medicine-tab" data-bs-toggle="pill" data-bs-target="#medicine" type="button"
                    role="tab" aria-controls="medicine" aria-selected="false">
                    💊 Medicine
                </button>
            </li>
        </ul>

        <!-- Tab Contents -->
        <div class="tab-content border rounded bg-white p-4 shadow-sm" id="hospital-tabContent">

            <!-- Ward Content -->
            <div class="tab-pane fade show active" id="ward" role="tabpanel" aria-labelledby="ward-tab">
                @include('pages.AdminPages.hospital.partials.ward')
            </div>

            <!-- Bed Content -->
            <div class="tab-pane fade" id="bed" role="tabpanel" aria-labelledby="bed-tab">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                        <h5 class="mb-0">Bed Management</h5>
                        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addBedModal">
                            <i class="fa fa-plus me-1"></i> Add Bed
                        </button>
                    </div>
                    <div class="card-body table-responsive">
                        @if (session('bed_success'))
                            <div class="alert alert-success">{{ session('bed_success') }}</div>
                        @endif

                        <table class="table table-bordered table-striped table-hover" id="bed_table">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Bed Number</th>
                                    <th>Ward</th>
                                    <th>Status</th>
                                    <th>Description</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($beds as $index => $bed)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $bed->bed_number }}</td>
                                        <td>{{ $bed->ward->name ?? 'N/A' }}</td>
                                        <td>
                                            @if ($bed->status == 'available')
                                                <span class="badge bg-success">Available</span>
                                            @else
                                                <span class="badge bg-danger">Occupied</span>
                                            @endif
                                        </td>
                                        <td>{{ $bed->description ?? '---' }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#viewBedModal{{ $bed->id }}">
                                                <i class="fa fa-eye"></i>
                                            </button>

                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editBedModal{{ $bed->id }}">
                                                <i class="fa fa-edit"></i>
                                            </button>

                                            <form action="{{ route('hospital.management.bed.destroy', $bed->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this bed?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                            </form>
                                            @push('modals')


                                            <div class="modal fade" id="editBedModal{{ $bed->id }}" tabindex="-1"
                                                aria-labelledby="editBedModalLabel{{ $bed->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content border border-primary">
                                                        <form action="{{ route('hospital.management.bed.update') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="modal-header bg-primary text-white">
                                                                <h5 class="modal-title"
                                                                    id="editBedModalLabel{{ $bed->id }}">
                                                                    <i class="fa fa-edit me-2"></i>Edit Bed -
                                                                    {{ $bed->bed_number }}
                                                                </h5>
                                                                <button type="button" class="btn-close bg-white"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $bed->id }}">
                                                                    <label for="bedNumber{{ $bed->id }}"
                                                                        class="form-label">Bed Number</label>
                                                                    <input type="text" class="form-control border-dark"
                                                                        id="bedNumber{{ $bed->id }}"
                                                                        name="bed_number"
                                                                        value="{{ old('bed_number', $bed->bed_number) }}"
                                                                        required>
                                                                    @error('number')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="wardSelect{{ $bed->id }}"
                                                                        class="form-label">Ward</label>
                                                                    <select name="ward_id"
                                                                        id="wardSelect{{ $bed->id }}"
                                                                        class="form-select border-dark" required>
                                                                        <option value="">-- Select Ward --</option>
                                                                        @foreach ($wards as $ward)
                                                                            <option value="{{ $ward->id }}"
                                                                                {{ $bed->ward_id == $ward->id ? 'selected' : '' }}>
                                                                                {{ $ward->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('ward_id')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="statusSelect{{ $bed->id }}"
                                                                        class="form-label">Status</label>
                                                                    <select name="status"
                                                                        id="statusSelect{{ $bed->id }}"
                                                                        class="form-select border-dark" required>
                                                                        <option value="available"
                                                                            {{ $bed->status == 'available' ? 'selected' : '' }}>
                                                                            Available</option>
                                                                        <option value="occupied"
                                                                            {{ $bed->status == 'occupied' ? 'selected' : '' }}>
                                                                            Occupied</option>
                                                                    </select>
                                                                    @error('status')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="description{{ $bed->id }}"
                                                                        class="form-label">Description</label>
                                                                    <textarea name="description" id="description{{ $bed->id }}" rows="3" class="form-control border-dark">{{ old('description', $bed->description) }}</textarea>
                                                                    @error('description')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-success">
                                                                    <i class="fa fa-check me-1"></i> Update
                                                                </button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="fa fa-times me-1"></i> Cancel
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                             @endpush

                                            @push('modals')


                                            <div class="modal fade" id="viewBedModal{{ $bed->id }}" tabindex="-1"
                                                aria-labelledby="viewBedModalLabel{{ $bed->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-md">
                                                    <div class="modal-content border border-dark">
                                                        <div class="modal-header bg-info text-white">
                                                            <h5 class="modal-title"
                                                                id="viewBedModalLabel{{ $bed->id }}">
                                                                <i class="fa fa-bed me-2"></i> Bed Details -
                                                                {{ $bed->number }}
                                                            </h5>
                                                            <button type="button" class="btn-close bg-white"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <ul class="list-group list-group-flush">
                                                                <li class="list-group-item">
                                                                    <strong>Bed Number:</strong> {{ $bed->number }}
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <strong>Ward:</strong> {{ $bed->ward->name ?? 'N/A' }}
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <strong>Status:</strong>
                                                                    <span
                                                                        class="badge bg-{{ $bed->status === 'available' ? 'success' : 'danger' }}">
                                                                        {{ ucfirst($bed->status) }}
                                                                    </span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <strong>Description:</strong><br>
                                                                    {{ $bed->description ?? 'No additional information.' }}
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">
                                                                <i class="fa fa-times me-1"></i> Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endpush

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No beds available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Add Bed Modal --}}
                {{-- @include('pages.AdminPages.hospital.modals.Beds.add-beds') --}}
                @push('modals')


                <div class="modal fade" id="addBedModal" tabindex="-1" aria-labelledby="addBedModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border border-dark">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="addBedModalLabel"><i class="fa fa-bed me-2"></i> Add New Bed
                                </h5>
                                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form action="{{ route('hospital.management.bed.store') }}" method="POST">
                                @csrf
                                <div class="modal-body">

                                    {{-- Bed Number --}}
                                    <div class="mb-3">
                                        <label for="number" class="form-label">Bed Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="bed_number" class="form-control"
                                            placeholder="Enter bed number" required>
                                        @error('bed_number')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- Ward Selection --}}
                                    <div class="mb-3">
                                        <label for="ward_id" class="form-label">Select Ward <span
                                                class="text-danger">*</span></label>
                                        <select name="ward_id" class="form-select" required>
                                            <option value="">-- Select Ward --</option>
                                            @foreach ($wards as $ward)
                                                <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('ward_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- Status --}}
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" class="form-select">
                                            <option value="available">Available</option>
                                            <option value="occupied">Occupied</option>
                                            <option value="maintenance">Maintenance</option>
                                        </select>
                                        @error('status')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- Description --}}
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description (Optional)</label>
                                        <textarea name="description" class="form-control" rows="3" placeholder="Add optional description..."></textarea>
                                    </div>
                                    {{-- submit button --}}

                                    <div class="modal-footer">
                                        <div class="mb-3">
                                            <button class="btn btn-primary btn-sm">Add Beds</button>
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                data-bs-dismiss="modal">Cancel</button>

                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                 @endpush
            </div>

            <!-- Medicine Content -->
            <div class="tab-pane fade" id="medicine" role="tabpanel" aria-labelledby="medicine-tab">
                @include('pages.AdminPages.hospital.partials.medicines')
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
   $("#bed_table").dataTable({
    responsive: true,
    autoWidth: false, // Add this
    dom: '<"row mb-3"<"col-md-4"l><"col-md-4 text-center"B><"col-md-4"f>>rt<"row mt-3"<"col-md-6"i><"col-md-6"p>>',
    buttons: ['copy', 'excel', 'print'],
    columnDefs: [{
        orderable: false,
        targets: [3]
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
});

});


</script>
@stack('modals')



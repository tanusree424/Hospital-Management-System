@extends('layouts.AdminLayout.app')

@section('content')
    <div class="card card-shadow">
        {{-- Card Header --}}
        <div class="card-header bg-primary d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-white">
                <i class="bi bi-gear-fill me-2"></i> Manage Services
            </h4>

            {{-- Add Service Button --}}
            <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                <i class="bi bi-plus-circle me-1"></i> Add Service
            </button>
        </div>

        {{-- Card Body --}}
        <div class="card-body">
            <div class="table-responsive">
                <table id="table_data" class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Icon</th>
                            <th>Description</th>
                            <th>Link</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $service->title }}</td>
                                <td><i class="fa {{ $service->icon }}"></i></td>
                                <td>{{ Str::limit($service->description, 50) }}</td>
                                <td>{{ $service->link ?? '-' }}</td>
                                <td>
                                    {{-- View Button --}}
                                    <button data-bs-toggle="modal" data-bs-target="#viewServiceModal{{ $service->id }}"
                                        class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    {{-- Edit Button --}}
                                    <button data-bs-toggle="modal" data-bs-target="#editServiceModal{{ $service->id }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    {{-- Delete Form --}}
                                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this service?')"
                                            class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            {{-- Edit Service Modal --}}
                            @push('modals')
                                <div class="modal fade" id="editServiceModal{{ $service->id }}" tabindex="-1"
                                    aria-labelledby="editServiceModalLabel{{ $service->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning">
                                                <h5 class="modal-title text-white"
                                                    id="editServiceModalLabel{{ $service->id }}">
                                                    <i class="fa fa-edit"></i> Edit Service
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <form action="{{ route('admin.services.update', $service->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-body">
                                                    <div class="row">
                                                        {{-- Title --}}
                                                        <div class="col-md-6 mb-3">
                                                            <label for="title" class="form-label">Service Title</label>
                                                            <input type="text" name="title" class="form-control"
                                                                value="{{ old('title', $service->title) }}" required>
                                                        </div>

                                                        {{-- Icon --}}
                                                        <div class="col-md-6 mb-3">
                                                            <label for="icon" class="form-label">Icon (FontAwesome
                                                                class)</label>
                                                            <input type="text" name="icon" class="form-control"
                                                                value="{{ old('icon', $service->icon) }}"
                                                                placeholder="e.g. fa-heartbeat">
                                                            <small class="text-muted">Preview: <i
                                                                    class="fa {{ $service->icon }}"></i></small>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        {{-- Description --}}
                                                        <div class="col-md-12 mb-3">
                                                            <label for="description" class="form-label">Description</label>
                                                            <textarea name="description" rows="3" class="form-control" required>{{ old('description', $service->description) }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        {{-- Price --}}
                                                        <div class="col-md-4 mb-3">
                                                            <label for="price" class="form-label">Price</label>
                                                            <input type="number" name="price" min="3"
                                                                class="form-control"
                                                                value="{{ old('price', $service->price) }}" required />
                                                        </div>

                                                        {{-- Link --}}
                                                        <div class="col-md-4 mb-3">
                                                            <label for="link" class="form-label">Link</label>
                                                            <input type="url" name="link" class="form-control"
                                                                value="{{ old('link', $service->link) }}"
                                                                placeholder="https://example.com">
                                                        </div>

                                                        {{-- Status --}}
                                                        <div class="col-md-4 mb-3">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="active" @selected($service->status == 'active')>Active
                                                                </option>
                                                                <option value="deactive" @selected($service->status == 'deactive')>Deactive
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-warning text-white">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endpush



                            {{-- View Service Modal --}}
                            @push('modals')
                                <div class="modal fade" id="viewServiceModal{{ $service->id }}" tabindex="-1"
                                    aria-labelledby="viewServiceModalLabel{{ $service->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewServiceModalLabel{{ $service->id }}">
                                                    {{ $service->title }} - Details
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item"><strong>Title:</strong> {{ $service->title }}
                                                    </li>
                                                    <li class="list-group-item"><strong>Icon:</strong> <i
                                                            class="fa {{ $service->icon }}"></i></li>
                                                    <li class="list-group-item"><strong>Description:</strong>
                                                        {{ $service->description }}</li>
                                                    <li class="list-group-item"><strong>Link:</strong>
                                                        {{ $service->link ?? 'N/A' }}</li>
                                                    <li class="list-group-item"><strong>Status:</strong>
                                                        {{ $service->status ? 'Active' : 'Inactive' }}</li>
                                                </ul>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endpush
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('modals')
        <div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content shadow-lg border-0 rounded-3">
                    <form action="{{ route('admin.services.store') }}" method="POST">
                        @csrf
                        {{-- Modal Header --}}
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="addServiceModalLabel">
                                <i class="fas fa-plus-circle me-2"></i> Add New Service
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        {{-- Modal Body --}}
                        <div class="modal-body p-3">
                            {{-- Title --}}
                            <div class="row mb-2 align-items-center">
                                <label for="title" class="col-sm-3 col-form-label fw-semibold">Service Title <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="title" id="title" class="form-control"
                                        placeholder="Enter service title" required>
                                </div>
                            </div>

                            {{-- Price --}}
                            <div class="row mb-2 align-items-center">
                                <label for="price" class="col-sm-3 col-form-label fw-semibold">Service Price <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="number" step="0.01" name="price" id="price" class="form-control"
                                        placeholder="1000.00" required>
                                </div>
                            </div>

                            {{-- Icon --}}
                            <div class="row mb-2 align-items-center">
                                <label for="icon" class="col-sm-3 col-form-label fw-semibold">Icon</label>
                                <div class="col-sm-9">
                                    <input type="text" name="icon" id="icon" class="form-control"
                                        placeholder="e.g. fa-heartbeat">
                                    <small class="text-muted">Use FontAwesome classes, e.g. <code>fa fa-user</code></small>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="row mb-2">
                                <label for="description" class="col-sm-3 col-form-label fw-semibold">Description <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <textarea name="description" id="description" rows="3" class="form-control"
                                        placeholder="Enter service description" required></textarea>
                                </div>
                            </div>

                            {{-- Link --}}
                            <div class="row mb-2 align-items-center">
                                <label for="link" class="col-sm-3 col-form-label fw-semibold">Link</label>
                                <div class="col-sm-9">
                                    <input type="url" name="link" id="link" class="form-control"
                                        placeholder="https://example.com">
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="row mb-2 align-items-center">
                                <label for="status" class="col-sm-3 col-form-label fw-semibold">Status</label>
                                <div class="col-sm-9">
                                    <select name="status" id="status" class="form-select">
                                        <option value="active" selected>Active</option>
                                        <option value="deactive">Deactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Footer --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Service
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endpush





    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- DataTables Core --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    {{-- DataTables Buttons --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    {{-- Export Dependencies --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#table_data').DataTable({
                responsive: true,
                dom: '<"d-flex justify-content-between align-items-center mb-3"lBf>rtip',
                buttons: ['copy', 'excel', 'print'],
                columnDefs: [{
                        orderable: false,
                        targets: [4]
                    } // Make sure this index is for the Action column
                ],
                lengthMenu: [
                    [5, 10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                language: {
                    search: "Search:",
                    zeroRecords: "No matching services found",
                    info: "Showing _START_ to _END_ of _TOTAL_ services",
                    infoEmpty: "No users available",
                    infoFiltered: "(filtered from _MAX_ total services)",
                    lengthMenu: "Show _MENU_ services"


                }
            });
        });
    </script>



    {{-- Render stacked modals --}}
@endsection
@stack('modals')

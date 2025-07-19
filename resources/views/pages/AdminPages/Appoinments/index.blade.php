@extends('layouts.AdminLayout.app')

@section('content')
<div class="container-fluid">
    <div class="col-md-12 mb-3">
        <h2 class="text-center fw-bold">Appointments Management</h2>
    </div>
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('appointment.create') }}" class="btn btn-primary">Add Appointment</a>
    </div>

    {{-- Alerts --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Appointments Table --}}
    <div class="table-responsive">
        <table class="table table-bordered shadow table-striped table-hover display nowrap" id="table_data" style="width:100%">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Department</th>
                    <th>Doctor</th>
                    <th>Status</th>
                    <th>Actions</th>
                    <th>Report</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($appointments as $index => $appo)
                    @php
                        $status = $appo->status ?? 'pending';
                        $userRole = Auth::user()->roles->pluck('name')->first();
                    @endphp
                    <tr class="text-center">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $appo->patient->user->name }}</td>
                        <td>{{ $appo->department->name }}</td>
                        <td>{{ $appo->doctor->user->name }}</td>
                        <td>
                            <div class="dropdown">
                                @if ($status === 'approved')
                                    <button class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown">{{ ucfirst($status) }}</button>
                                @elseif ($status === 'completed')
                                    <button class="btn btn-primary" disabled>{{ ucfirst($status) }}</button>
                                @elseif ($status === 'cancelled')
                                    <button class="btn btn-danger" disabled>{{ ucfirst($status) }}</button>
                                    @if ($appo->cancelled_by)
                                        <br><small class="text-muted">(By {{ ucfirst($appo->cancelled_by) }})</small>
                                    @endif
                                @else
                                    <button class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">{{ ucfirst($status) }}</button>
                                @endif

                                @if (in_array($status, ['pending', 'approved']))
                                    <ul class="dropdown-menu">
                                        @if ($userRole === 'Patient' && is_null($appo->cancelled_by))
                                            <li><a class="dropdown-item status-option" href="#" data-id="{{ $appo->id }}" data-status="cancelled">Cancel</a></li>
                                        @elseif ($userRole !== 'Patient')
                                            @if ($status !== 'approved')
                                                <li><a class="dropdown-item status-option" href="#" data-id="{{ $appo->id }}" data-status="approved">Approve</a></li>
                                            @endif
                                            <li><a class="dropdown-item status-option" href="#" data-id="{{ $appo->id }}" data-status="completed">Completed</a></li>
                                            @if (is_null($appo->cancelled_by))
                                                <li><a class="dropdown-item status-option" href="#" data-id="{{ $appo->id }}" data-status="cancelled">Cancel</a></li>
                                            @endif
                                        @endif
                                    </ul>
                                @endif
                            </div>
                        </td>
                        <td class="d-flex justify-content-center gap-2 flex-wrap">
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewModal{{ $appo->id }}">View</button>

                            @if ($appo->status !== 'completed')
                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $appo->id }}">Edit</button>
                            @else
                                <button class="btn btn-warning" disabled>Edit</button>
                            @endif

                            @if ($userRole !== 'Patient' && $appo->status !== 'completed')
                                <form action="{{ route('appointment.destroy', $appo->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            @endif
                        </td>
                        <td>
                            @if ($appo->status === 'cancelled')
                                <span class="badge bg-danger">Cancelled by {{ ucfirst($appo->cancelled_by ?? 'Unknown') }}</span>
                            @elseif ($appo->medical_record)
                                <form action="{{ route('medical_record.download') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="appointment_id" value="{{ $appo->id }}">
                                    <button type="submit" class="btn btn-sm btn-primary">Download</button>
                                </form>
                            @else
                                @if ($userRole === 'Patient')
                                    <button class="btn btn-sm btn-secondary" disabled>Waiting</button>
                                @else
                                    <form action="{{ route('medical_record.create', $appo->id) }}">
                                        <button class="btn btn-sm btn-success">Create</button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>

                    {{-- View Modal --}}
                    <div class="modal fade" id="viewModal{{ $appo->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content rounded-4 shadow">
                                <div class="modal-header bg-info text-white rounded-top-4">
                                    <h5 class="modal-title">Appointment #{{ $appo->id }}</h5>
                                    <button type="button" class="btn-close bg-light" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body bg-light-subtle">
                                    <div class="row">
                                        <div class="col-md-6 text-center">
                                            <img src="{{ asset('storage/'.$appo->patient->patient_image) }}" class="rounded-circle shadow" width="180" height="180" style="object-fit:cover;">
                                            <p class="mt-3"><strong>Patient:</strong> {{ $appo->patient->user->name }}</p>
                                            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appo->appointment_date)->format('d M, Y') }}</p>
                                            <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appo->appointment_time)->format('h:i A') }}</p>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <img src="{{ asset('storage/'.$appo->doctor->profile_picture) }}" class="rounded shadow" width="180" height="180" style="object-fit:cover;">
                                            <p class="mt-3"><strong>Doctor:</strong> {{ $appo->doctor->user->name }}</p>
                                            <p><strong>Phone:</strong> {{ $appo->doctor->phone }}</p>
                                            <p><strong>Qualification:</strong> {{ $appo->doctor->qualifications }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer bg-white">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Edit Modal --}}
                    <div class="modal fade" id="editModal{{ $appo->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content rounded-4 shadow">
                                <form action="{{ route('appointment.update', $appo->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-header bg-info text-white rounded-top-4">
                                        <h5 class="modal-title">Edit Appointment #{{ $appo->id }}</h5>
                                        <button type="button" class="btn-close bg-light" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body bg-light-subtle">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Department</label>
                                            <select name="department_id" class="form-select department-dropdown" data-url="{{ url('admin/get-doctors') }}" data-target="#doctor_id_{{ $appo->id }}">
                                                <option value="">Select</option>
                                                @foreach($departments as $dept)
                                                    <option value="{{ $dept->id }}" {{ $appo->department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Doctor</label>
                                            <select name="doctor_id" id="doctor_id_{{ $appo->id }}" class="form-select">
                                                @foreach($doctors as $doc)
                                                    <option value="{{ $doc->id }}" {{ $appo->doctor_id == $doc->id ? 'selected' : '' }}>{{ $doc->user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Patient</label>
                                            <select name="patient_id" class="form-select">
                                                @foreach($patients as $pat)
                                                    <option value="{{ $pat->id }}" {{ $appo->patient_id == $pat->id ? 'selected' : '' }}>{{ $pat->user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Date</label>
                                            <input type="date" name="appointment_date" class="form-control" value="{{ $appo->appointment_date }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Time</label>
                                            <input type="time" name="appointment_time" class="form-control" value="{{ $appo->appointment_time }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-white">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No appointments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script>
    $(function () {
        $('#table_data').DataTable({
            responsive: true,
            scrollX: true,
            dom: 'Bfrtip',
            buttons: ['copy', 'excel', 'print'],
            columnDefs: [{ orderable: false, targets: [5, 6] }]
        });

        $('.department-dropdown').on('change', function () {
            const deptId = $(this).val();
            const url = $(this).data('url') + '/' + deptId;
            const target = $($(this).data('target'));

            $.get(url, function (data) {
                target.html('<option value="">Select Doctor</option>');
                $.each(data, function (_, doctor) {
                    target.append(`<option value="${doctor.id}">${doctor.name}</option>`);
                });
            }).fail(function () {
                target.html('<option disabled>Error loading doctors</option>');
            });
        });

        $('.status-option').on('click', function (e) {
            e.preventDefault();
            $.post("{{ route('appointment.updateStatus') }}", {
                _token: '{{ csrf_token() }}',
                id: $(this).data('id'),
                status: $(this).data('status')
            }, function (res) {
                if (res.success) location.reload();
                else alert("Update failed");
            });
        });
    });
</script>


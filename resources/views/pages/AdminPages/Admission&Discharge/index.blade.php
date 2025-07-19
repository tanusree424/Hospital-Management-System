@extends('layouts.AdminLayout.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-center text-primary w-100">🏥 Admission & Discharge Management</h2>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                ✅ {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ❌ {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center rounded-top-4">
                <h4 class="mb-0">📋 All Admissions</h4>
                <button class="btn btn-light btn-sm fw-bold rounded-pill" data-bs-toggle="modal"
                        data-bs-target="#createAdmissionModal">
                    + Admit Patient
                </button>
            </div>

            <div class="card-body bg-light-subtle">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle" id="table_data">
                        <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Patient Name</th>
                            <th>Ward</th>
                            <th>Bed</th>
                            <th>Admission Date</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Discharge Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $userRole = Auth::user()->roles->pluck('name')->first(); @endphp

                        @forelse($admissions as $index => $admission)
                            @if($userRole === 'Patient' && Auth::id() !== $admission->patient->user->id)
                                @continue
                            @endif

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $admission->patient->user->name }}</td>
                                <td>{{ $admission->ward }}</td>
                                <td>{{ $admission->bed }}</td>
                                <td>{{ \Carbon\Carbon::parse($admission->admission_date)->format('d-M-Y') }}</td>
                                <td>
                                    @if ($admission->discharge)
                                        <span class="badge bg-success">Discharged</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Admitted</span>
                                    @endif
                                </td>
                                <td>
                                    @if (!$admission->discharge)
                                        <button class="btn btn-warning rounded-pill" data-bs-toggle="modal"
                                                data-bs-target="#editAdmissionModal{{ $admission->id }}">Edit
                                        </button>
                                    @else
                                        <button class="btn btn-secondary rounded-pill" disabled>Edit</button>
                                    @endif
                                </td>
                                <td>
                                    @if (!$admission->discharge)
                                        <button class="btn btn-danger btn-sm rounded-pill" data-bs-toggle="modal"
                                                data-bs-target="#dischargeFormModal{{ $admission->id }}">Discharge
                                        </button>
                                    @else
                                        <button class="btn btn-secondary btn-sm rounded-pill" disabled>Discharged</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No admission records found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Admission Modal --}}
    <div class="modal fade" id="createAdmissionModal" tabindex="-1" aria-labelledby="createAdmissionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admissions.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title">Admit Patient</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label fw-bold text-dark">Patient:</label>
                            <div class="col-md-8">
                                <select name="patient_id" class="form-select border-dark" required>
                                    <option value="">-- Select Patient --</option>
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label fw-bold text-dark">Admission Date:</label>
                            <div class="col-md-8">
                                <input type="date" name="admission_date" class="form-control border-dark" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label fw-bold text-dark">Ward:</label>
                            <div class="col-md-8">
                                <input type="text" name="ward" class="form-control border-dark" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label fw-bold text-dark">Bed:</label>
                            <div class="col-md-8">
                                <input type="text" name="bed" class="form-control border-dark" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label fw-bold text-dark">Reason:</label>
                            <div class="col-md-8">
                                <textarea name="reason" class="form-control border-dark" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Admit Patient</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modals (outside of table) --}}
    @foreach($admissions as $admission)
        {{-- Edit Modal --}}
        <div class="modal fade" id="editAdmissionModal{{ $admission->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('admissions.update', $admission->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Edit Admission</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3 row">
                                <label class="col-md-4 form-label fw-bold">Patient</label>
                                <div class="col-md-8">
                                    <select name="patient_id" class="form-select" required>
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}" {{ $admission->patient_id == $patient->id ? 'selected' : '' }}>
                                                {{ $patient->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-md-4 form-label fw-bold">Admission Date</label>
                                <div class="col-md-8">
                                    <input type="date" name="admission_date" class="form-control" value="{{ $admission->admission_date }}">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-md-4 form-label fw-bold">Ward</label>
                                <div class="col-md-8">
                                    <input type="text" name="ward" class="form-control" value="{{ $admission->ward }}">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-md-4 form-label fw-bold">Bed</label>
                                <div class="col-md-8">
                                    <input type="text" name="bed" class="form-control" value="{{ $admission->bed }}">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-md-4 form-label fw-bold">Reason</label>
                                <div class="col-md-8">
                                    <textarea name="reason" class="form-control" rows="3">{{ $admission->reason }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Discharge Modal --}}
        @if (!$admission->discharge)
            <div class="modal fade" id="dischargeFormModal{{ $admission->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="" method="POST">
                            @csrf
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Discharge Patient</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to discharge <strong>{{ $admission->patient->user->name }}</strong>?</p>
                                <div class="mb-3">
                                    <label class="form-label">Discharge Reason</label>
                                    <textarea name="discharge_reason" class="form-control" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Discharge Date</label>
                                    <input type="date" name="discharge_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-danger" type="submit">Confirm Discharge</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
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
                { orderable: false, targets: [6, 7] }
            ]
        });
    });
</script>


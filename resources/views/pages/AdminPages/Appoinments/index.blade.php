@extends('layouts.AdminLayout.app')

@section('content')
    <div class="card">
        <div class="card-header bg-primary d-flex justify-content-between">
            <h2 class="text-center fw-bold text-white"> <i class="fa fa-calendar-check me-2"></i> Appointments Management</h2>
            <div class="d-flex justify-content-end mb-3">
                <button data-bs-toggle="modal" data-bs-target="#addAppointmentModal" class="btn btn-success"> <i
                        class="fa fa-calendar-check me-2"></i> + Add Appointment</button>
            </div>
        </div>
        @push('modals')
            <!-- Modal -->
            <div class="modal fade" id="addAppointmentModal" tabindex="-1" aria-labelledby="addAppointmentModal"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h5 class="modal-title text-white" id="exampleModalLabel">Add Doctor Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('appointment.store') }}" method="POST">
                                @csrf

                                {{-- Department --}}
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold h5">Department:</label>
                                        </div>
                                        <div class="col-md-8">
                                            {{-- Department Dropdown --}}
                                            @if ($isDoctor && $doctor)
                                                <input type="hidden" name="department_id" value="{{ $doctor->department_id }}">
                                                <input type="text" class="form-control"
                                                    value="{{ $doctor->department->name }}" disabled>
                                            @else
                                                <select name="department_id" id="department_id"
                                                    data-url="{{ url('admin/get-doctors') }}" class="form-control">
                                                    <option value="">-- Select Department --</option>
                                                    @foreach ($departments as $dept)
                                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                                    @endforeach
                                                </select>
                                            @endif

                                            @error('department_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Doctor --}}
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold h5">Doctor:</label>
                                        </div>
                                        <div class="col-md-8">
                                            @if ($isDoctor && $doctor)
                                                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                                                <input type="text" class="form-control" value="{{ $doctor->user->name }}"
                                                    disabled>
                                            @else
                                                <select name="doctor_id" id="doctor_id" class="form-control">
                                                    <option value="">-- Select Doctor --</option>
                                                </select>
                                                @error('doctor_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Patient --}}
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold h5">Patient:</label>
                                        </div>
                                        <div class="col-md-8">
                                            @if (auth()->user()->hasRole('Patient'))
                                                <input type="hidden" name="patient_id" value="{{ auth()->user()->id }}">
                                                <input type="text" class="form-control" value="{{ auth()->user()->name }}"
                                                    disabled id="">
                                            @else
                                                <select name="patient_id" id="doctor_id" class="form-control form-select">
                                                    <option value="">-- Select Patient --</option>
                                                    @foreach ($patients as $patient)
                                                        <option value="{{ $patient->id }}">{{ $patient->user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('patient_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                {{-- Date --}}
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold h5">Appointment Date:</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="date" name="appointment_date" class="form-control">
                                            @error('appointment_date')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Time --}}
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold h5">Time:</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="time" name="appointment_time" class="form-control">
                                            @error('appointment_time')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Submit --}}
                                <div class="text-center">

                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-perm">Book Appointment</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endpush

    <div class="card-body">




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
            <table class="table table-bordered shadow table-striped table-hover display nowrap" id="table_data"
                style="width:100%">
                <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Patient</th>
            <th>Department</th>
            <th>Status</th>
            <th>Actions</th>
            <th>Report</th>
            <th>Pay Now</th>
            <th>Download Receipt</th>
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
                            {{-- <td>{{ $appo->doctor->user->name }}</td> --}}
                            <td>
                                <div class="dropdown">
                                    @if ($status === 'approved')
                                        <button class="btn btn-success dropdown-toggle"
                                            data-bs-toggle="dropdown">{{ ucfirst($status) }}</button>
                                    @elseif ($status === 'completed')
                                        <button class="btn btn-primary" disabled>{{ ucfirst($status) }}</button>
                                    @elseif ($status === 'cancelled')
                                        <button class="btn btn-danger" disabled>{{ ucfirst($status) }}</button>
                                        @if ($appo->cancelled_by)
                                            <br><small class="text-muted">(By {{ ucfirst($appo->cancelled_by) }})</small>
                                        @endif
                                    @else
                                        <button class="btn btn-secondary dropdown-toggle"
                                            data-bs-toggle="dropdown">{{ ucfirst($status) }}</button>
                                    @endif

                                    @if (in_array($status, ['pending', 'approved']))
                                        <ul class="dropdown-menu">
                                            @if ($userRole === 'Patient' && is_null($appo->cancelled_by))
                                                <li><a class="dropdown-item status-option" href="#"
                                                        data-id="{{ $appo->id }}" data-status="cancelled">Cancel</a>
                                                </li>
                                            @elseif ($userRole !== 'Patient')
                                                @if ($status !== 'approved')
                                                    <li><a class="dropdown-item status-option" href="#"
                                                            data-id="{{ $appo->id }}"
                                                            data-status="approved">Approve</a>
                                                    </li>
                                                @endif
                                                <li><a class="dropdown-item status-option" href="#"
                                                        data-id="{{ $appo->id }}"
                                                        data-status="completed">Completed</a>
                                                </li>
                                                @if (is_null($appo->cancelled_by))
                                                    <li><a class="dropdown-item status-option" href="#"
                                                            data-id="{{ $appo->id }}"
                                                            data-status="cancelled">Cancel</a>
                                                    </li>
                                                @endif
                                            @endif
                                        </ul>
                                    @endif
                                </div>
                            </td>
                            <td class="d-flex justify-content-center gap-1 flex-nowrap">
                                <div>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#viewModal{{ $appo->id }}"><i title="View Appointment"
                                            class="bi bi-eye"></i></button>
                                </div>
                                @if ($appo->status !== 'completed' && $appo->status !== 'cancelled')
                                    <div>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $appo->id }}"><i title="Edit Doctor"
                                                class="bi bi-pencil"></i></button>
                                    </div>
                                @else
                                    <div>
                                        <div>
                                            <button class="btn btn-warning btn-sm" disabled><i
                                                    class="bi bi-pencil"></i></button>
                                        </div>
                                @endif

                                @if ($userRole !== 'Patient' && $appo->status !== 'completed' && $appo->status !== 'cancelled')
                                    <form action="{{ route('appointment.destroy', $appo->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm"><i title="Delete Doctor"
                                                class="bi bi-trash"></i></button>
                                    </form>
                                @endif
                            </td>
                            <td>
                                @if ($appo->status === 'cancelled')
                                    <span class="badge bg-danger">
                                        Cancelled by {{ ucfirst($appo->cancelled_by ?? 'Unknown') }}
                                    </span>
                                @else
                                    @if ($appo->status === 'approved')
                                        <span class="badge bg-warning">Please complete the appointment</span>
                                    @elseif ($appo->status === 'pending')
                                        <span class="badge bg-info text-danger">Please approved the appointment</span>
                                    @else
                                        @if ($appo->medical_record)
                                            <form action="{{ route('medical_record.download') }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="appointment_id" value="{{ $appo->id }}">
                                                <button type="submit" class="btn btn-sm btn-primary">Download</button>
                                            </form>
                                        @else
                                            <form action="{{ route('medical_record.create', $appo->id) }}" method="GET"
                                                style="display:inline;">
                                                <button type="submit" class="btn btn-sm btn-success">Create
                                                    Report</button>
                                            </form>
                                        @endif
                                    @endif
                                @endif
                            </td>
                            <td>

                                @php
                                    $payment = $payments
                                        ->where('appointment_id', $appo->id)
                                        ->WhereNotNull('transaction_id')
                                        ->first();
                                @endphp

                                @if ($payment)
                                    <button class="btn btn-success" disabled><i class="bi bi-check-circle-fill"
                                            title="Already Paid"></i></button>
                                @else
                                    <form action="{{ route('appointment.payment.process', $appo->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="appointment_id" value="{{ $appo->id }}">
                                        <input type="hidden" name="patient_id" value="{{ $appo->patient->id }}">
                                        <input type="hidden" name="payment_mode" value="online">
                                        <button class="btn btn-outline-warning text-dark"> <i title="Pay Now"
                                                class="bi bi-wallet2 me-1"></i></button>
                                    </form>
                                @endif


                            </td>
                            <td>
                                @php
                                    $payment = $payments
                                        ->where('appointment_id', $appo->id)
                                        ->whereNotNull('transaction_id')
                                        ->first();
                                @endphp

                                @if ($payment)
                                    <a href="{{ route('appointment.receipt.download', $appo->id) }}"
                                        class="btn btn-sm btn-outline-success" title="Download Receipt">
                                        <i class="bi bi-receipt-cutoff me-1"></i> Receipt
                                    </a>
                                @endif
                            </td>



                        </tr>

                        {{-- View Modal --}}
                        @push('modals')
                            <div class="modal fade" id="viewModal{{ $appo->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content rounded-4 shadow">
                                        <div class="modal-header bg-info text-white rounded-top-4">
                                            <h5 class="modal-title">Appointment #{{ $appo->id }}</h5>
                                            <button type="button" class="btn-close bg-light"
                                                data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body bg-light-subtle">
                                            <div class="row">
                                                <div class="col-md-6 text-center">
                                                    <img src="{{ asset('storage/' . $appo->patient->patient_image) }}"
                                                        class="rounded-circle shadow" width="180" height="180"
                                                        style="object-fit:cover;">
                                                    <p class="mt-3"><strong>Patient:</strong>
                                                        {{ $appo->patient->user->name }}
                                                    </p>
                                                    <p><strong>Date:</strong>
                                                        {{ \Carbon\Carbon::parse($appo->appointment_date)->format('d M, Y') }}
                                                    </p>
                                                    <p><strong>Time:</strong>
                                                        {{ \Carbon\Carbon::parse($appo->appointment_time)->format('h:i A') }}
                                                    </p>
                                                </div>
                                                <div class="col-md-6 text-center">
                                                    <img src="{{ asset('storage/' . $appo->doctor->profile_picture) }}"
                                                        class="rounded shadow" width="180" height="180"
                                                        style="object-fit:cover;">
                                                    <p class="mt-3"><strong>Doctor:</strong> {{ $appo->doctor->user->name }}
                                                    </p>
                                                    <p><strong>Phone:</strong> {{ $appo->doctor->phone }}</p>
                                                    <p><strong>Qualification:</strong> {{ $appo->doctor->qualifications }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-white">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endpush
                        @push('modals')
                            {{-- Edit Modal --}}
                            <div class="modal fade" id="editModal{{ $appo->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered ">
                                    <div class="modal-content rounded-4 shadow">
                                        <form action="{{ route('appointment.update', $appo->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="modal-header bg-info text-white rounded-top-4">
                                                <h5 class="modal-title">Edit Appointment #{{ $appo->id }}</h5>
                                                <button type="button" class="btn-close bg-light"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body bg-light-subtle">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Department</label>
                                                    <select name="department_id" class="form-select department-dropdown"
                                                        data-url="{{ url('admin/get-doctors') }}"
                                                        data-target="#doctor_id_{{ $appo->id }}">
                                                        <option value="">Select</option>
                                                        @foreach ($departments as $dept)
                                                            <option value="{{ $dept->id }}"
                                                                {{ $appo->department_id == $dept->id ? 'selected' : '' }}>
                                                                {{ $dept->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Doctor</label>
                                                    <select name="doctor_id" id="doctor_id_{{ $appo->id }}"
                                                        class="form-select">
                                                        @foreach ($doctors as $doc)
                                                            <option value="{{ $doc->id }}"
                                                                {{ $appo->doctor_id == $doc->id ? 'selected' : '' }}>
                                                                {{ $doc->user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Patient</label>
                                                    <select name="patient_id" class="form-select">
                                                        @foreach ($patients as $pat)
                                                            <option value="{{ $pat->id }}"
                                                                {{ $appo->patient_id == $pat->id ? 'selected' : '' }}>
                                                                {{ $pat->user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Date</label>
                                                    <input type="date" name="appointment_date" class="form-control"
                                                        value="{{ $appo->appointment_date }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Time</label>
                                                    <input type="time" name="appointment_time" class="form-control"
                                                        value="{{ $appo->appointment_time }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-white">
                                                <button type="submit" class="btn btn-success">Update</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endpush
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No appointments found.</td>
                        </tr>
                    @endforelse
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
    $(document).ready(function() {

        // ✅ Initialize DataTable

 $('#table_data').DataTable({
    // processing: true,
    // serverSide: true,
    // // ajax: '/appointments/data',
    // columns: [
    //     { data: 'id', name: 'id' },
    //     { data: 'patient', name: 'patient' },
    //     { data: 'department', name: 'department' },
    //     { data: 'status', name: 'status' },
    //     { data: 'actions', name: 'actions', orderable: false, searchable: false },
    //     { data: 'report', name: 'report', orderable: false, searchable: false },
    //     { data: 'pay_now', name: 'pay_now', orderable: false, searchable: false },
    //     { data: 'download_receipt', name: 'download_receipt', orderable: false, searchable: false }
    // ]
});












        // ✅ Department change -> fetch corresponding doctors
        $('#department_id').on('change', function() {
            var departmentId = $(this).val();
            var url = $(this).data('url');

            if (departmentId) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        department_id: departmentId
                    },
                    success: function(doctors) {
                        $('#doctor_id').empty().append(
                            '<option value="">-- Select Doctor --</option>');
                        $.each(doctors, function(index, doctor) {
                            $('#doctor_id').append('<option value="' + doctor.id +
                                '">' + doctor.user.name + '</option>');
                        });
                    },
                    error: function() {
                        console.error('Could not fetch doctors.');
                    }
                });
            } else {
                $('#doctor_id').empty().append('<option value="">-- Select Doctor --</option>');
            }
        });

        // ✅ Appointment status change via click
        $('.status-option').on('click', function(e) {
            e.preventDefault();
            $.post("{{ route('appointment.updateStatus') }}", {
                _token: '{{ csrf_token() }}',
                id: $(this).data('id'),
                status: $(this).data('status')
            }, function(res) {
                if (res.success) {
                    location.reload();
                } else {
                    alert("Update failed");
                }
            });
        });

    });
</script>




@stack('modals')

<tr class="text-center">
    <td>{{ $index + 1 }}</td>
    <td>{{ $appo->patient->user->name }}</td>
    <td>{{ $appo->department->name }}</td>
    <td>{{ $appo->doctor->user->name }}</td>
    <td>
        @php
            $status = $appo->status ?? 'pending';
        @endphp
        <div class="dropdown">
            @if ($status === 'approved')
                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    {{ ucfirst($status) }}
                </button>
            @elseif ($status === 'completed')
                <button class="btn btn-primary" disabled>{{ ucfirst($status) }}</button>
            @elseif ($status === 'cancelled')
                <button class="btn btn-danger" disabled>{{ ucfirst($status) }}</button>
                @if ($appo->cancelled_by)
                    <br><span class="small text-muted">(By {{ ucfirst($appo->cancelled_by) }})</span>
                @endif
            @else
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    {{ ucfirst($status) }}
                </button>
            @endif

            @if (in_array($status, ['pending', 'approved']))
                <ul class="dropdown-menu">
                    @if ($userRole === 'Patient')
                        @if (is_null($appo->cancelled_by))
                            <li><a class="dropdown-item status-option" href="#" data-id="{{ $appo->id }}" data-status="cancelled">Cancel</a></li>
                        @endif
                    @else
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
        {{-- View --}}
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewAppointmnetModal{{ $appo->id }}">View</button>

        {{-- Edit --}}
        @if ($appo->status !== 'completed')
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editAppointmnetModal{{ $appo->id }}">Edit</button>
        @else
            <button class="btn btn-warning" disabled title="Appointment Completed">Edit</button>
        @endif

        {{-- Delete --}}
        @if ($userRole !== 'Patient' && $appo->status !== 'completed')
            <form action="{{ route('appointment.destroy', $appo->id) }}" method="POST" onsubmit="return confirm('Delete appointment for {{ $appo->patient->user->name }}?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Delete</button>
            </form>
        @endif
    </td>

    {{-- Report Action --}}
    <td>
        @if ($appo->status === 'cancelled')
            <span class="badge bg-danger">Cancelled by {{ ucfirst($appo->cancelled_by ?? 'Unknown') }}</span>
        @elseif ($appo->medical_record)
            <form action="{{ route('medical_record.download') }}" method="POST">
                @csrf
                <input type="hidden" name="appointment_id" value="{{ $appo->id }}">
                <button type="submit" class="btn btn-sm btn-primary" target="_blank">Download Report</button>
            </form>
        @else
            @if ($userRole === 'Patient')
                <button class="btn btn-sm btn-secondary" disabled>Getting record soon</button>
            @else
                <form action="{{ route('medical_record.create', $appo->id) }}">
                    <button class="btn btn-sm btn-success">Create Record</button>
                </form>
            @endif
        @endif
    </td>
</tr>

{{-- Include View Modal --}}
@include('admin.appointments.modals.view', ['appo' => $appo])

{{-- Include Edit Modal --}}
@include('admin.appointments.modals.edit', [
    'appo' => $appo,
    'departments' => $departments,
    'doctors' => $doctors,
    'patients' => $patients
])

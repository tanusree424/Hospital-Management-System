@extends('layouts.AdminLayout.app')

@section('content')
    <div class="card">
        <div class=" card-header bg-primary d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-white text-primary w-100">🏥 Admission & Discharge Management</h2>
            <button class="btn btn-success btn-sm fw-bold rounded-pill" data-bs-toggle="modal"
                data-bs-target="#createAdmissionModal">
                +Admit Patient
            </button>
        </div>
        <div class="card-body bg-light-subtle">

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



            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="table_data">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Patient Name</th>
                            <th>Ward</th>
                            <th>Bed</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Discharge</th>
                            <th>Payment </th>

                            <th>Print</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php $userRole = Auth::user()->roles->pluck('name')->first(); @endphp

                        @forelse($admissions as $index => $admission)
                            @if ($userRole === 'Patient' && Auth::id() !== $admission->patient->user->id)
                                @continue
                            @endif

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $admission->patient->user->name }}</td>
                                <td>{{ $admission->ward->name }}</td>
                                <td>{{ optional($admission->bed)->bed_number ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($admission->admission_date)->format('d-M-Y') }}</td>

                                {{-- Status --}}
                                <td>
                                    @if ($admission->discharge)
                                        <span class="badge bg-success">Discharged</span>
                                    @else
                                        <span class="badge bg-warning text-dark"><i class="bi bi-hospital me-1"></i>
                                            Admitted</span>
                                    @endif
                                </td>

                                {{-- Edit --}}
                                <td>
                                    @if (!$admission->discharge)
                                        <div>
                                            <button class="btn btn-warning rounded-pill btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editAdmissionModal{{ $admission->id }}">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                        </div>
                                    @else
                                        <div>
                                            <button class="btn btn-secondary rounded-pill btn-sm" disabled>
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                        </div>
                                    @endif
                                </td>

                                {{-- Discharge --}}
                                <td>
                                    @php $payment = $admission->payments->first(); @endphp
                                    @if ($admission->discharge === 0 && $payment && !$payment->transaction_id)

                                        <div class="badge bg-danger">Please Pay Before Discharge</div>
                                    @else
                                        <div class="text-center">
                                            <button class="btn btn-danger btn-sm rounded-pill" data-bs-toggle="modal"
                                                data-bs-target="#dischargeFormModal{{ $admission->id }}">
                                                <i class="bi bi-box-arrow-right me-1"></i> Discharge
                                            </button>
                                        </div>
                                    @endif

                                </td>

                                {{-- Payment --}}
                                <td>
                                    @php $payment = $admission->payments->first(); @endphp
                                    @if ($admission->discharge === 0 && $payment && !$payment->transaction_id)
                                        <div>
                                            <button class="btn btn-success btn-sm pay-now-btn"
                                                data-admission-id="{{ $admission->id }}"
                                                data-amount="{{ $payment->amount ?? 1500 }}">
                                                💳 Pay Now
                                            </button>
                                        </div>
                                    @else
                                        <div>
                                            <button class="btn btn-secondary btn-sm" disabled>
                                                <i class="bi bi-currency-rupee"></i> Paid
                                            </button>
                                        </div>
                                    @endif
                                </td>

                                {{-- Print --}}
                                <td>
                                    @if ($payment && !$payment->transaction_id)
                                        <span class="text-muted">N/A</span>
                                    @elseif($payment && $payment->transaction_id)
                                        <a href="{{ route('admission.receipt.download', $admission->id) }}"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-printer"></i> Print Receipt
                                        </a>
                                    @else
                                        <div class="badge bg-danger">Payment not done</div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">No admission records found.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    </div>

    {{-- Admission Modal --}}
    @push('modals')
        @php
            $user = Auth::user();
        @endphp

        <div class="modal fade" id="createAdmissionModal" tabindex="-1" aria-labelledby="createAdmissionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('admissions.store') }}" method="POST">
                        @csrf

                        {{-- Patient Selection --}}
                        {{-- @if ($user->hasRole('Patient'))
                            @php
                                $alreadyAdmitted = \App\Models\Admission::where('patient_id', $user->patient->id)
                                    ->whereNull('discharge_date')
                                    ->exists();
                            @endphp

                            @if ($alreadyAdmitted)
                                <div class="alert alert-warning m-3">
                                    You are already admitted. Please contact the administration for further assistance.
                                </div>
                            @else
                                <select name="patient_id" class="form-select" required readonly>
                                    <option value="{{ $user->patient->id }}" selected>{{ $user->name }}</option>
                                </select>
                            @endif
                        @else
                            <select name="patient_id" class="form-select" required>
                                <option value="">Select Patient</option>
                                @foreach ($availablePatients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                                @endforeach
                            </select>
                        @endif --}}
                        @if ($user->hasRole('Patient'))
                            @php

                                $alreadyAdmitted = \App\Models\Admission::where('patient_id', $user->patient->id)
                                    ->where('discharge', 0) // still admitted
                                    ->exists();
                            @endphp

                            @if ($alreadyAdmitted)
                                <p>The patient is currently admitted.</p>
                            @else
                                <p>The patient is not admitted.</p>
                            @endif
                        @endif


                        {{-- Admission Date --}}
                        <input type="date" name="admission_date" class="form-control" required>
                        <input type="number" name="amount" class="form-control" required id="">

                        {{-- Ward Selection --}}
                        <select name="ward_id" id="ward-select" class="form-select" required>
                            <option value="">Select Ward</option>
                            @foreach ($wards as $ward)
                                <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                            @endforeach
                        </select>

                        {{-- Bed Selection (populated via JS) --}}
                        <select name="bed_id" id="bed-select" class="form-select" required>
                            <option value="">Select Bed</option>
                            {{-- Options will be dynamically loaded --}}
                        </select>

                        {{-- Reason for admission --}}
                        <textarea name="reason" class="form-control" rows="3" required></textarea>

                        <button type="submit" class="btn btn-primary">Admit Patient</button>
                    </form>
                </div>
            </div>
        </div>
    @endpush
    {{-- Modals (outside of table) --}}
    @foreach ($admissions as $admission)
        {{-- Edit Modal --}}
        @push('modals')
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
                                                <option value="{{ $patient->id }}"
                                                    {{ $admission->patient->id == $patient->id ? 'selected' : '' }}>
                                                    {{ $patient->user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-md-4 form-label fw-bold">Admission Date</label>
                                    <div class="col-md-8">
                                        <input type="date" name="admission_date" class="form-control"
                                            value="{{ $admission->admission_date }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-md-4 form-label fw-bold">Ward</label>
                                    <div class="col-md-8">
                                        <select name="ward_id" id="edit_ward_id" class="form-control form-select">
                                            @foreach ($wards as $ward)
                                                <option value="{{ $ward->id }}" @selected($ward->id == $admission->ward_id)>
                                                    {{ $ward->name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-md-4 form-label fw-bold">Bed</label>
                                    <div class="col-md-8">
                                        <select name="bed_id" id="edit_bed_id" class="form-select"
                                            data-selected-bed="{{ $admission->bed_id }}">
                                            <option value="{{ $admission->bed->id }}" selected>
                                                {{ $admission->bed->bed_number }}</option>
                                            {{-- Other options will be filled via AJAX if ward is changed --}}
                                        </select>

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
        @endpush

        {{-- Discharge Modal --}}
        @if (!$admission->discharge)
            @push('modals')
                <div class="modal fade" id="dischargeFormModal{{ $admission->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <form action="{{ route('discharge.store') }}" method="POST">
                                @csrf
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title">Discharge Patient</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to discharge
                                        <strong>{{ $admission->patient->user->name }}</strong>?
                                    </p>
                                    <input type="hidden" name="bed_id" value="{{ $admission->bed_id }}">
                                    <input type="hidden" name="patient_id" value="{{ $admission->patient->id }}">
                                    <input type="hidden" name="admission_id" value="{{ $admission->id }}">
                                    <div class="mb-3">
                                        <label class="form-label">Discharge Reason</label>
                                        <textarea name="discharge_reason" style="resize: none;" class="form-control" required></textarea>
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
            @endpush
        @endif
        @push('modals')
            <!-- Feedback Modal -->
            <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-3">
                        <div class="modal-header">
                            <h5 class="modal-title">Rate Your Experience</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="feedbackForm">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3 text-center">
                                    <div class="star-rating">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <input type="radio" name="rating" id="star{{ $i }}"
                                                value="{{ $i }}">
                                            <label for="star{{ $i }}">★</label>
                                        @endfor
                                    </div>
                                    <!-- এই hidden input-এ patient_id দিবে -->
                                    <input type="hidden" name="patient_id" id="patientIdInput"
                                        value="{{ session('patient_id') ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <textarea class="form-control" id="message" rows="3" placeholder="Write your feedback..." required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit Feedback</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endpush
    @endforeach
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    $(document).ready(function() {
        $("#table_data").DataTable({
            responsive: true,
            dom: '<"row mb-3"<"col-md-4"l><"col-md-4 text-center"B><"col-md-4"f>>rt<"row mt-3"<"col-md-6"i><"col-md-6"p>>',
            buttons: ['copy', 'excel', 'print'],
            columnDefs: [{
                orderable: false,
                targets: [6, 7, 8, 9]
            }],
            lengthMenu: [
                [5, 10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            language: {
                search: "Search:",
                zeroRecords: "No matching roles found",
                info: "Showing _START_ to _END_ of _TOTAL_ roles",
                infoEmpty: "No roles available",
                infoFiltered: "(filtered from _MAX_ total roles)",
                lengthMenu: "Show _MENU_ entries",
            }
        });


        // $('.dataTables_filter input[type="search"]').addClass('form-control mb-3').attr("placeholder",
        //     "Search...");
    });
</script>
{{-- <script>
$(document).ready(function () {
    var table = $('#table_data').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admissions.ajax') }}", // Your Laravel route returning JSON
        columns: [
            { data: 'patient_name', name: 'patient_name' },
            { data: 'ward', name: 'ward' },
            { data: 'bed', name: 'bed' },
            { data: 'date', name: 'date' },
            {
                data: 'status',
                name: 'status',
                render: function (data, type, row) {
                    let badgeClass = '';
                    if (data === 'Admitted') badgeClass = 'bg-success';
                    else if (data === 'Discharged') badgeClass = 'bg-secondary';
                    else badgeClass = 'bg-warning';
                    return `<span class="badge ${badgeClass}">${data}</span>`;
                }
            },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<button class="btn btn-sm btn-primary editBtn" data-id="${data}">
                                <i class="fa fa-edit"></i>
                            </button>`;
                }
            },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<button class="btn btn-sm btn-warning dischargeBtn" data-id="${data}">
                                <i class="fa fa-sign-out-alt"></i>
                            </button>`;
                }
            },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<button class="btn btn-sm btn-info paymentBtn" data-id="${data}">
                                <i class="fa fa-credit-card"></i>
                            </button>`;
                }
            },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<button class="btn btn-sm btn-dark printBtn" data-id="${data}">
                                <i class="fa fa-print"></i>
                            </button>`;
                }
            }
        ]
    });

    // Edit
    $(document).on('click', '.editBtn', function () {
        let id = $(this).data('id');
        $('#editModal').modal('show');
        // load data via AJAX
    });

    // Discharge
    $(document).on('click', '.dischargeBtn', function () {
        let id = $(this).data('id');
        if (confirm('Are you sure you want to discharge this patient?')) {
            // send AJAX request
        }
    });

    // Payment
    // $(document).on('click', '.paymentBtn', function () {
    //     let id = $(this).data('id');
    //     $('#paymentModal').modal('show');
    //     // load payment form
    // });

    // // Print
    // $(document).on('click', '.printBtn', function () {
    //     let id = $(this).data('id');
    //     window.open(`/patients/${id}/print`, '_blank');
    // });
});
</script> --}}
<script>
    $(document).ready(function() {
        $(document).on('change', '#edit_ward_id', function() {
            const wardId = $(this).val();
            const bedSelect = $('#edit_bed_id');
            const currentBedId = bedSelect.data('selected-bed'); // Get preselected bed ID

            if (wardId) {
                $.ajax({
                    url: "{{ route('get.beds.by.ward') }}",
                    type: "GET",
                    data: {
                        ward_id: wardId,
                        current_bed_id: currentBedId
                    },
                    success: function(beds) {
                        bedSelect.empty().append(
                            `<option value="">-- Select Bed --</option>`);

                        $.each(beds, function(index, bed) {
                            const isSelected = bed.id == currentBedId ? 'selected' :
                                '';
                            bedSelect.append(
                                `<option value="${bed.id}" ${isSelected}>${bed.bed_number}</option>`
                            );
                        });
                    },
                    error: function(xhr) {
                        console.error('Failed to load beds:', xhr.responseText);
                        alert('An error occurred while fetching beds. Please try again.');
                    }
                });
            } else {
                bedSelect.empty().append(`<option value="">-- Select Bed --</option>`);
            }
        });
    });
</script>
<script>
    $(document).ready(function() {

        @if (session('discharge_success'))
            // modal ওপেন করো
            $('#feedbackModal').modal('show');

            // session থেকে patient_id নিয়ে hidden input-এ বসাও
            $('#patientIdInput').val('{{ session('patient_id') }}');

            // Swal alert দেখাও
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('discharge_success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        // Star rating logic
        let rating = 0;
        $('.star').on('click', function() {
            rating = $(this).data('value');
            $('#ratingValue').val(rating);

            $('.star').removeClass('text-warning');
            $('.star').each(function() {
                if ($(this).data('value') <= rating) {
                    $(this).addClass('text-warning');
                }
            });
        });

        // Handle feedback submission
        $('#feedbackForm').on('submit', function(e) {
            e.preventDefault();

            const rating = $('input[name="rating"]:checked').val();
            const message = $('#message').val();
            const patientId = $('#patientIdInput').val(); // hidden input থেকে patient_id নাও
            console.log(patientId);

            $.post("{{ route('admin.feedback.submit') }}", {
                    _token: '{{ csrf_token() }}',
                    rating,
                    message,
                    patientId
                })
                .done(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Thank you for your feedback!',
                        confirmButtonColor: '#3085d6'
                    });
                    $('#feedbackModal').modal('hide');
                    $('#feedbackForm')[0].reset();
                })
                .fail(function(xhr) {
                    alert('Submission failed: ' + xhr.responseText);
                });
        });

    });
</script>
<script>
    $(document).ready(function() {

        $('#ward-select').on('change', function() {
            const wardId = $(this).val();
            const bedSelect = $('#bed-select');

            // Loading state
            bedSelect.html('<option value="">Loading...</option>');

            if (!wardId) {
                bedSelect.html('<option value="">Select Bed</option>');
                return;
            }

            $.ajax({
                url: "{{ route('get.beds.by.ward') }}",
                type: "GET",
                data: {
                    ward_id: wardId
                },
                success: function(response) {
                    bedSelect.empty().append('<option value="">Select Bed</option>');

                    if (Array.isArray(response) && response.length > 0) {
                        response.forEach(function(bed) {
                            bedSelect.append(
                                `<option value="${bed.id}">${bed.bed_number}</option>`
                            );
                        });
                    } else {
                        bedSelect.append('<option value="">No available beds</option>');
                    }
                },
                error: function() {
                    bedSelect.html('<option value="">Error loading beds</option>');
                }
            });
        });

    });
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    $(document).on('click', '.pay-now-btn', function() {
        const admissionId = $(this).data('admission-id');
        const amount = $(this).data('amount') * 100; // Convert to paise
        const updateUrl = "{{ route('admission.payment.update', ':id') }}".replace(':id', admissionId);


        console.log("Clicked Pay Now for Admission ID:", admissionId);
        console.log("Amount in paise:", amount);
        console.log("POST URL:", updateUrl);
        const options = {
            key: "{{ env('RAZORPAY_KEY') }}", // Razorpay public key
            amount: amount,
            currency: "INR",
            name: "Hospital Admission",
            description: "Admission Payment",

            handler: function(response) {
                console.log("✅ Razorpay Payment Success:");
                console.log("Payment ID:", response.razorpay_payment_id);

                // Send to backend
                $.ajax({
                    url: updateUrl,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        razorpay_payment_id: response.razorpay_payment_id
                    },
                    success: function(res) {
                        console.log("✅ Payment recorded in backend:", res);
                        alert('Payment successful!');
                        location.reload();
                    },
                    error: function(err) {
                        console.error("❌ Backend payment update failed:", err
                            .responseText || err);
                        alert('Payment succeeded, but updating the system failed.');
                    }
                });
            },

            prefill: {
                name: "{{ auth()->user()->name }}",
                email: "{{ auth()->user()->email }}"
            },
            theme: {
                color: "#3399cc"
            }
        };

        const rzp = new Razorpay(options);

        // Catch Razorpay failure at UI level
        rzp.on('payment.failed', function(response) {
            console.error("❌ Razorpay Payment Failed:", response.error);
            alert(
                `Payment Failed:\n` +
                `Reason: ${response.error.reason}\n` +
                `Description: ${response.error.description}\n` +
                `Step: ${response.error.step}\n` +
                `Code: ${response.error.code}`
            );
        });

        rzp.open();
    });
</script>




@stack('modals')

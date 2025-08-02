@extends('layouts.AdminLayout.app')

@section('content')
    <div class="card">
        <div class="card-header bg-primary d-flex justify-content-between">
            <h2 class="text-center fw-bold text-white"><i class="fa fa-procedures me-2"></i>Patients Management</h2>
            <div>
                <button data-bs-toggle="modal" data-bs-target="#addPatientModal" class="btn btn-success"><i
                        class="fa fa-procedures me-2"></i>+ Add Patient</button>
            </div>
            @push('modals')
                <div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog  modal-xl">
                        <div class="modal-content">
                            <div class="modal-header bg-success">
                                <h5 class="modal-title text-white" id="exampleModalLabel">Add Patient</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('patients.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    {{-- Name --}}
                                    <div class="row mb-1">
                                        <label class="col-md-4 col-form-label fw-bold">Name:</label>
                                        <div class="col-md-8">
                                            <input type="text" name="name" value="{{ old('name') }}"
                                                class="form-control">
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="row mb-1">
                                        <label class="col-md-4 col-form-label fw-bold">Email:</label>
                                        <div class="col-md-8">
                                            <input type="email" name="email" value="{{ old('email') }}"
                                                class="form-control">
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Password --}}
                                    <div class="row mb-1">
                                        <label class="col-md-4 col-form-label fw-bold">Password:</label>
                                        <div class="col-md-8">
                                            <input type="password" name="password" class="form-control">
                                            @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Confirm Password --}}
                                    <div class="row mb-1">
                                        <label class="col-md-4 col-form-label fw-bold">Confirm Password:</label>
                                        <div class="col-md-8">
                                            <input type="password" name="password_confirmation" class="form-control">
                                        </div>
                                    </div>

                                    {{-- Phone --}}
                                    <div class="row mb-1">
                                        <label class="col-md-4 col-form-label fw-bold">Phone:</label>
                                        <div class="col-md-8">
                                            <input type="text" name="phone" value="{{ old('phone') }}"
                                                class="form-control">
                                            @error('phone')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Address --}}
                                    <div class="row mb-1">
                                        <label class="col-md-4 col-form-label fw-bold">Address:</label>
                                        <div class="col-md-8">
                                            <textarea name="address" rows="3" class="form-control">{{ old('address') }}</textarea>
                                            @error('address')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- DOB --}}
                                    <div class="row mb-1">
                                        <label class="col-md-4 col-form-label fw-bold">DOB:</label>
                                        <div class="col-md-8">
                                            <input type="date" name="dob" value="{{ old('dob') }}"
                                                class="form-control">
                                            @error('dob')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Gender --}}
                                    <div class="row mb-1">
                                        <label class="col-md-4 col-form-label fw-bold">Gender:</label>
                                        <div class="col-md-8 d-flex gap-3">
                                            @php $gender = old('gender'); @endphp
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" id="male"
                                                    value="male" {{ $gender == 'male' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="male">Male</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" id="female"
                                                    value="female" {{ $gender == 'female' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="female">Female</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" id="other"
                                                    value="other" {{ $gender == 'other' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="other">Other</label>
                                            </div>
                                        </div>
                                        @error('gender')
                                            <div class="text-danger text-center mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-1">
                                        <div class="d-flex justify-content-between gap-4">
                                            <div class="d-flex gap-2">
                                                <label for="" class="form-label fw-bold">Pincode:</label>
                                                <input type="text" name="pincode" id="pincode" class="form-control">
                                            </div>
                                            <div class="d-flex gap-2">
                                                <label for="" class="form-label fw-bold">State</label>
                                                <input type="text" name="state" id="state" class="form-control">

                                            </div>

                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="d-flex justify-content-between gap-3">
                                            <div class="d-flex gap-2">
                                                <label for="" class="form-label fw-bold">Country</label>
                                                <input type="text" name="country" class="form-control" id="country">
                                            </div>
                                            <div class="d-flex gap-3">
                                                <label for="" class="form-label fw-bold">City</label>
                                                <input type="text" name="city" class="form-control" id="district">

                                            </div>



                                        </div>
                                        {{-- Post Office Name --}}
                                        <div class="row mb-1">
                                            <label class="col-md-4 col-form-label fw-bold">Post Office Name:</label>
                                            <div class="col-md-8">
                                                <input type="text" name="post_office_name" id="post_office_name"
                                                    class="form-control" readonly>
                                            </div>
                                        </div>

                                        {{-- Profile Picture --}}
                                        <div class="row mb-1">
                                            <label class="col-md-12 col-form-label fw-bold">Patient Picture:</label>
                                            <div class="col-md-8">
                                                <input type="file" name="patient_image profile_pic_input" accept="image/*"
                                                    id="profile_pic" class="form-control">
                                                <img src="" id="preview" class="d-block mx-auto mt-2 preview_img"
                                                    style="max-width: 70px;" alt="">
                                                @error('patient_image')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Submit --}}


                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary px-4">Add Patient</button>
                                            </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endpush
    </div>
    <div class="card-body">
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

        <div class="col-md-10 p-4 m-auto">
            <table class="table table-bordered table-hover table-striped  border-2" id="table_data">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Patient Name</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $index = 1; @endphp
                    @forelse ($patients as $pat)
                        <tr class="text-center">
                            <td class="h5">{{ $index++ }}</td>
                            <td class="h5">{{ $pat->user->name }}</td>
                            <td class="h5">
                                {{ \Carbon\Carbon::parse($pat->created_at)->timezone('Asia/Kolkata')->format('d-M-Y h:i A') }}
                            </td>
                            <td class="d-flex justify-content-center align-items-center gap-2">

                                <!-- View Modal Trigger -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#viewPatientModal{{ $pat->id }}">
                                    <i class="bi bi-eye">View</i>
                                </button>

                                <!-- Edit -->
                                <button class="btn btn-warning editBtn" data-bs-toggle="modal"
                                    data-bs-target="#edit_patient_modal{{ $pat->id }}">
                                    <i class="bi bi-pencil">Edit</i>
                                </button>
                                @push('modals')
                                    <!-- Modal -->
                                    <!-- Edit Patient Modal -->
                                    <!-- Edit Patient Modal -->
                                    <div class="modal fade" id="edit_patient_modal{{ $pat->id }}" tabindex="-1"
                                        aria-labelledby="edit_patient_modal_Label{{ $pat->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <form action="{{ route('patients.update', $pat->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header bg-warning">
                                                        <h5 class="modal-title" id="editPatientLabel{{ $pat->id }}"><i
                                                                class="fa fa-edit"></i> Edit Patient</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body row">
                                                        <input type="hidden" value="{{ $pat->id }}" name="id">

                                                        <div class="col-md-6">
                                                            <label class="form-label">Full Name</label>
                                                            <input type="text" class="form-control fullname"
                                                                name="name" value="{{ old('name', $pat->user->name) }}">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label">Email</label>
                                                            <input type="email"
                                                                value="{{ old('email', $pat->user->email) }}"
                                                                class="form-control" name="email">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label">Phone</label>
                                                            <input type="text" value="{{ old('phone', $pat->phone) }}"
                                                                class="form-control" name="phone">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label">DOB</label>
                                                            <input type="date" value="{{ old('dob', $pat->DOB) }}"
                                                                class="form-control" name="dob">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label">Gender</label>
                                                            <select class="form-select" name="gender">
                                                                <option value="">-- Select Gender --</option>
                                                                <option value="Male" @selected($pat->gender === 'male')>Male
                                                                </option>
                                                                <option value="Female" @selected($pat->gender === 'female')>Female
                                                                </option>
                                                            </select>

                                                        </div>
                                                        <div class="col-md-12 mb-2">
                                                            <label class="form-label">Address</label>
                                                            <textarea class="form-control" name="address" rows="2">{{ $pat->address }}</textarea>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label">Pincode</label>
                                                            <input type="text" class="form-control" name="pincode"
                                                                value="{{ old('pincode', $pat->pincode) }}">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label">Post Office</label>
                                                            <input type="text" class="form-control" name="post_office"
                                                                value="{{ old('post_office', $pat->post_office) }}">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label">City</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ old('city', $pat->city) }}" name="city">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">State</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ old('city', $pat->city) }}" name="state">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Country</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ old('country', $pat->country) }}" name="country">
                                                        </div>




                                                        <div class="col-md-12">
                                                            <label class="form-label">Profile Image</label>
                                                            <input type="file" class="form-control profile_pic_input"
                                                                name="patient_image">
                                                            <img src="{{ asset('storage/' . $pat->patient_image) }}"
                                                                class="img-thumbnail preview_img mt-2"
                                                                id="edit_patient_preview" style="max-height: 100px;">
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-warning"><i
                                                                class="fa fa-save me-1"></i>Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endpush

                                <!-- Delete -->
                                <form action="{{ route('patients.destroy', $pat->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete {{ $pat->user->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @push('modals')
                            <!-- Modal View -->
                            <div class="modal fade" id="viewPatientModal{{ $pat->id }}" tabindex="-1"
                                aria-labelledby="viewPatientModalLabel{{ $pat->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ $pat->user->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="text-center mb-3">
                                                <img src="{{ asset('storage/' . $pat->patient_image) }}"
                                                    class="rounded-circle shadow" width="180" height="180"
                                                    style="object-fit: cover;" />
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-4 text-end fw-bold">Name:</div>
                                                <div class="col-md-8">{{ $pat->user->name }}</div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-4 text-end fw-bold">Email:</div>
                                                <div class="col-md-8">{{ $pat->user->email }}</div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-4 text-end fw-bold">Phone:</div>
                                                <div class="col-md-8">{{ $pat->phone }}</div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-4 text-end fw-bold">DOB:</div>
                                                <div class="col-md-8">{{ $pat->DOB }}</div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-4 text-end fw-bold">Gender:</div>
                                                <div class="col-md-8">{{ $pat->gender }}</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4 text-end fw-bold">Pincode:</div>
                                                <div class="col-md-8">{{ $pat->pincode }}</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4 text-end fw-bold">City:</div>
                                                <div class="col-md-8">{{ $pat->city }}</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4 text-end fw-bold">State:</div>
                                                <div class="col-md-8">{{ $pat->state }}</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4 text-end fw-bold">Country:</div>
                                                <div class="col-md-8">{{ $pat->country }}</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4 text-end fw-bold">Post Office:</div>
                                                <div class="col-md-8">{{ $pat->post_office ? $pat->post_office : 'N/A' }}
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-4 text-end fw-bold">Total Appointments:</div>
                                                <div class="col-md-8">{{ $pat->appointment->count() }}</div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-4 text-end fw-bold">Appointments By:</div>
                                                <div class="col-md-8">
                                                    @php
                                                        $doctorNames = $pat->appointment
                                                            ->filter(fn($a) => $a->doctor && $a->doctor->user)
                                                            ->map(fn($a) => $a->doctor->user->name)
                                                            ->unique();
                                                    @endphp

                                                    @if ($doctorNames->isNotEmpty())
                                                        <ul class="mb-0">
                                                            @foreach ($doctorNames as $docName)
                                                                <li>{{ $docName }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        N/A
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary rounded-5"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endpush
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No Patients Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>
    </div>
@endsection


<!-- Required JS Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table_data').DataTable({
            responsive: true,
            dom: '<"d-flex justify-content-between align-items-center mb-3"lBf>rtip',
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
                zeroRecords: "No matching patients found",
                info: "Showing _START_ to _END_ of _TOTAL_ patients",
                infoEmpty: "No patients available",
                infoFiltered: "(filtered from _MAX_ total patients)",
                lengthMenu: "Show _MENU_ entries"
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.profile_pic_input').forEach(input => {
            input.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const preview = this.closest('.col-md-12').querySelector('.preview_img');
                    if (preview) {
                        preview.src = URL.createObjectURL(file);
                    }
                }
            });
        });

    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        // ===== Pincode Auto Fill =====
        function setupPincodeLogic(modal) {
            const pincodeInput = modal.querySelector("#pincode");
            const postOfficeNameInput = modal.querySelector("#post_office_name");
            const stateField = modal.querySelector("#state");
            const countryField = modal.querySelector("#country");
            const districtField = modal.querySelector("#district");
            const addressInput = modal.querySelector("#address");

            if (!pincodeInput) return;

            pincodeInput.addEventListener("change", () => {
                const pincode = pincodeInput.value.trim();
                if (!pincode) return;

                fetch(`https://api.postalpincode.in/pincode/${pincode}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data[0].Status === "Success") {
                            const postOffices = data[0].PostOffice;
                            const firstOffice = postOffices[0];

                            if (stateField) stateField.value = firstOffice.State;
                            if (countryField) countryField.value = firstOffice.Country;
                            if (districtField) districtField.value = firstOffice.District;

                            const addressText = (addressInput?.value || "").toLowerCase();

                            // Find all matches, sort by longest name
                            const matchedOffices = postOffices.filter(po =>
                                addressText.includes(po.Name.toLowerCase())
                            );

                            // Sort matches by length of post office name (longest first)
                            matchedOffices.sort((a, b) => b.Name.length - a.Name.length);

                            // Choose best match if available, else fallback to first
                            const bestMatch = matchedOffices.length ? matchedOffices[0] :
                                firstOffice;

                            postOfficeNameInput.value = bestMatch.Name;

                        } else {
                            alert("Invalid Pincode");
                        }
                    })
                    .catch(err => {
                        console.error("API error:", err);
                        alert("Something went wrong while fetching pincode info.");
                    });
            });
        }




        const addPatientModal = document.getElementById("addPatientModal");
        // const editPatientModal = document.getElementById("edit_patient_modal");

        // Apply pincode logic on modal show
        ['shown.bs.modal'].forEach(evt => {
            addPatientModal.addEventListener(evt, () => setupPincodeLogic(addPatientModal));
            //  editPatientModal.addEventListener(evt, () => setupPincodeLogic(editPatientModal));
        });

        // // ==== View Patient Modal ====
        // document.querySelectorAll(".viewBtn").forEach(btn => {
        //     btn.addEventListener("click", function() {
        //         const patient = JSON.parse(this.dataset.patient);
        //         const modal = new bootstrap.Modal(document.getElementById('viewPatientModal'));
        //         Object.keys(patient).forEach(key => {
        //             const el = document.getElementById(`view_${key}`);
        //             if (el) el.textContent = patient[key];
        //         });
        //         modal.show();
        //     });
        // });

        // // ==== Edit Patient Modal ====
        // document.querySelectorAll(".editBtn").forEach(btn => {
        //     btn.addEventListener("click", function() {
        //         const patient = JSON.parse(this.dataset.patient);
        //         const form = document.getElementById("editPatientForm");

        //         Object.keys(patient).forEach(key => {
        //             const el = form.querySelector(`[name="${key}"]`);
        //             if (el) el.value = patient[key];
        //         });

        //         document.getElementById("edit_id").value = patient.id;
        //         new bootstrap.Modal(editPatientModal).show();
        //     });
        // });

        // // ==== AJAX Submit Add Patient ====
        // document.getElementById("addPatientForm").addEventListener("submit", function(e) {
        //     e.preventDefault();
        //     const form = this;
        //     const formData = new FormData(form);

        //     fetch(form.action, {
        //             method: "POST",
        //             body: formData,
        //             headers: {
        //                 'X-CSRF-TOKEN': '{{ csrf_token() }}',
        //             },
        //         })
        //         .then(res => res.json())
        //         .then(data => {
        //             if (data.success) {
        //                 alert("Patient added successfully!");
        //                 location.reload();
        //             } else {
        //                 alert("Error adding patient.");
        //             }
        //         })
        //         .catch(err => console.error(err));
        // });

        // // ==== AJAX Submit Edit Patient ====
        // document.getElementById("editPatientForm").addEventListener("submit", function(e) {
        //     e.preventDefault();
        //     const form = this;
        //     const formData = new FormData(form);
        //     const patientId = document.getElementById("edit_id").value;

        //     fetch(`/patients/${patientId}`, {
        //             method: "POST",
        //             body: formData,
        //             headers: {
        //                 'X-CSRF-TOKEN': '{{ csrf_token() }}',
        //                 'X-Requested-With': 'XMLHttpRequest',
        //             },
        //         })
        //         .then(res => res.json())
        //         .then(data => {
        //             if (data.success) {
        //                 alert("Patient updated!");
        //                 location.reload();
        //             } else {
        //                 alert("Update failed.");
        //             }
        //         })
        //         .catch(err => console.error(err));
        // });

    });
</script>
<script>
    $(document).ready(function() {
        $('.editBtn').on('click', function() {
            const modal = $('#edit_patient_modal');

            // Set field values from data attributes
            // modal.find('input[name="id"]').val($(this).data('id'));
            // modal.find('input[name="name"]').val($(this).data('name'));
            // modal.find('input[name="email"]').val($(this).data('email'));
            // modal.find('input[name="phone"]').val($(this).data('phone'));
            // modal.find('input[name="dob"]').val($(this).data('dob'));
            // modal.find('select[name="gender"]').val($(this).data('gender'));
            // modal.find('textarea[name="address"]').val($(this).data('address'));
            // modal.find('input[name="pincode"]').val($(this).data('pincode'));
            // modal.find('input[name="post_office"]').val($(this).data('post_office'));
            // modal.find('input[name="city"]').val($(this).data('city'));
            // modal.find('input[name="state"]').val($(this).data('state'));
            // modal.find('input[name="country"]').val($(this).data('country'));
            // modal.find('.preview_img').attr('src', $(this).data('image'));

            // Input field references
            const pincodeInput = modal.find('input[name="pincode"]');
            const postOfficeInput = modal.find('input[name="post_office"]');
            const stateInput = modal.find('input[name="state"]');
            const countryInput = modal.find('input[name="country"]');
            const cityInput = modal.find('input[name="city"]');
            const addressInput = modal.find('textarea[name="address"]');

            // Pincode change event
            pincodeInput.off('change').on('change', function() {
                const pincode = $(this).val();

                if (!pincode || pincode.length !== 6) {
                    alert("Please enter a valid 6-digit pincode");
                    return;
                }

                fetch(`https://api.postalpincode.in/pincode/${pincode}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data[0].Status === "Success") {
                            const postOffices = data[0].PostOffice;
                            const firstOffice = postOffices[0];

                            // Set state, country, and city
                            stateInput.val(firstOffice.State);
                            countryInput.val(firstOffice.Country);
                            cityInput.val(firstOffice.District);

                            // Address er moddhe jodi kono word Post Office name er sathe mile, seti use korbe
                            const addressText = (addressInput.val() || "").toLowerCase();

                            let matchedOffice = postOffices.find(po =>
                                addressText.includes(po.Name.toLowerCase())
                            );

                            // Jodi kono match na pai, tahole first Office set korbe
                            if (!matchedOffice) {
                                matchedOffice = firstOffice;
                            }

                            // Set post office name
                            postOfficeInput.val(matchedOffice.Name);
                        } else {
                            alert("Invalid Pincode");
                        }
                    })
                    .catch(err => {
                        console.error("API error:", err);
                        alert("Something went wrong while fetching post office data.");
                    });
            });
        });
    });
</script>
<script>
  $(document).ready(function () {
    $("#profile_pic").on("change", function () {
        const file = this.files[0]; // get the first selected file
        console.log(file);
        if (file) {
            const preview = $("#preview");
            const fileUrl = URL.createObjectURL(file);

            preview.attr("src", fileUrl);
        }
    });
});

</script>

@stack('modals')

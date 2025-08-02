@push('modals')


<div class="modal fade" id="addBedModal" tabindex="-1" aria-labelledby="addBedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border border-dark">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addBedModalLabel"><i class="fa fa-bed me-2"></i> Add New Bed</h5>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{route('hospital.management.bed.store')}}" method="POST">
                @csrf
                <div class="modal-body">

                    {{-- Bed Number --}}
                    <div class="mb-3">
                        <label for="number" class="form-label">Bed Number <span class="text-danger">*</span></label>
                        <input type="text" name="bed_number" class="form-control" placeholder="Enter bed number" required>
                        @error('bed_number') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Ward Selection --}}
                    <div class="mb-3">
                        <label for="ward_id" class="form-label">Select Ward <span class="text-danger">*</span></label>
                        <select name="ward_id" class="form-select" required>
                            <option value="">-- Select Ward --</option>
                            @foreach($wards as $ward)
                                <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                            @endforeach
                        </select>
                        @error('ward_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="available">Available</option>
                            <option value="occupied">Occupied</option>
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
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
                         <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>

                    </div>

                        </div>
                        @endpush

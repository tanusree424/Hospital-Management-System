@push('modals')


<div class="modal fade" id="editBedModal{{ $bed->id }}" tabindex="-1" aria-labelledby="editBedModalLabel{{ $bed->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border border-primary">
            <form action="{{ route('hospital.management.bed.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editBedModalLabel{{ $bed->id }}">
                        <i class="fa fa-edit me-2"></i>Edit Bed - {{ $bed->bed_number }}
                    </h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" name="id" value="{{$bed->id}}">
                        <label for="bedNumber{{ $bed->id }}" class="form-label">Bed Number</label>
                        <input type="text" class="form-control border-dark" id="bedNumber{{ $bed->id }}" name="bed_number" value="{{ old('bed_number', $bed->bed_number) }}" required>
                        @error('number')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="wardSelect{{ $bed->id }}" class="form-label">Ward</label>
                        <select name="ward_id" id="wardSelect{{ $bed->id }}" class="form-select border-dark" required>
                            <option value="">-- Select Ward --</option>
                            @foreach($wards as $ward)
                                <option value="{{ $ward->id }}" {{ $bed->ward_id == $ward->id ? 'selected' : '' }}>
                                    {{ $ward->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('ward_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="statusSelect{{ $bed->id }}" class="form-label">Status</label>
                        <select name="status" id="statusSelect{{ $bed->id }}" class="form-select border-dark" required>
                            <option value="available" {{ $bed->status == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="occupied" {{ $bed->status == 'occupied' ? 'selected' : '' }}>Occupied</option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description{{ $bed->id }}" class="form-label">Description</label>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times me-1"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

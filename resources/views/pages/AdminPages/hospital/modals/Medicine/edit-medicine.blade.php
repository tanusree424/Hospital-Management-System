@push('modals')


<!-- Edit Medicine Modal -->
<div class="modal fade" id="editMedicineModal{{ $medicine->id }}" tabindex="-1" aria-labelledby="editMedicineModalLabel{{ $medicine->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('hospital.management.medicine.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $medicine->id }}">

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="editMedicineModalLabel{{ $medicine->id }}">
                        ✏️ Edit Medicine
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">Medicine Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $medicine->name }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="type" class="form-label fw-semibold">Category / Type</label>
                        <input type="text" name="type" class="form-control" value="{{ $medicine->category }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="stock" class="form-label fw-semibold">Stock</label>
                        <input type="number" name="stock" class="form-control" value="{{ $medicine->stock }}" required min="0">
                    </div>

                    <div class="col-md-6">
                        <label for="manufacturer" class="form-label fw-semibold">Manufacturer</label>
                        <input type="text" name="manufacturer" class="form-control" value="{{ $medicine->manufacturer }}">
                    </div>

                    <div class="col-md-6">
                        <label for="dosage" class="form-label fw-semibold">Dosage (mg/ml)</label>
                        <input type="number" name="dosage" class="form-control" value="{{ $medicine->dosage }}">
                    </div>

                    <div class="col-md-6">
                        <label for="expiry_date" class="form-label fw-semibold">Expiry Date</label>
                        <input type="date" name="expiry_date" class="form-control" value="{{ $medicine->expiry_date }}">
                    </div>

                    <div class="col-md-12">
                        <label for="description" class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ $medicine->description }}</textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        💾 Update
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        ❌ Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

@push('modals')


<div class="modal fade" id="addMedicineModal" tabindex="-1" aria-labelledby="addMedicineModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="addMedicineModalLabel">➕ Add Medicine</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('hospital.management.medicine.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="name" class="form-label">Medicine Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="name" required>
            </div>

            <div class="col-md-6">
              <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="category" required>
            </div>

            <div class="col-md-6">
              <label for="stock" class="form-label">Stock Quantity <span class="text-danger">*</span></label>
              <input type="number" class="form-control" name="stock" required min="0">
            </div>

            <div class="col-md-6">
              <label for="manufacturer" class="form-label">Manufacturer</label>
              <input type="text" class="form-control" name="manufacturer">
            </div>

            <div class="col-md-6">
              <label for="dosage" class="form-label">Dosage (mg)</label>
              <input type="number" class="form-control" name="dosage" min="0">
            </div>

            <div class="col-md-6">
              <label for="expiry_date" class="form-label">Expiry Date</label>
              <input type="date" class="form-control" name="expiry_date">
            </div>

            <div class="col-12">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" name="description" rows="3"></textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> Save
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endpush

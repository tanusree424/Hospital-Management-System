@push('modals')


<div class="modal fade" id="viewMedicineModal{{ $medicine->id }}" tabindex="-1" aria-labelledby="viewMedicineModalLabel{{ $medicine->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-dark">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="viewMedicineModalLabel{{ $medicine->id }}">Medicine Details - {{ $medicine->name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row mb-3">
          <label class="col-md-4 fw-bold">Medicine Name:</label>
          <div class="col-md-8">{{ $medicine->name }}</div>
        </div>

        <div class="row mb-3">
          <label class="col-md-4 fw-bold">Type:</label>
          <div class="col-md-8">{{ $medicine->type }}</div>
        </div>

        <div class="row mb-3">
          <label class="col-md-4 fw-bold">Stock:</label>
          <div class="col-md-8">{{ $medicine->stock }}</div>
        </div>

        <div class="row mb-3">
          <label class="col-md-4 fw-bold">Dosage:</label>
          <div class="col-md-8">{{ $medicine->dosage }}</div>
        </div>

        <div class="row mb-3">
          <label class="col-md-4 fw-bold">Description:</label>
          <div class="col-md-8">{{ $medicine->description ?? 'N/A' }}</div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endpush

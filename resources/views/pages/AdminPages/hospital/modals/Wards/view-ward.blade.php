@push('modals')


<div class="modal fade" id="viewWardModal{{ $ward->id }}" tabindex="-1" aria-labelledby="viewWardModalLabel{{ $ward->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="viewWardModalLabel{{ $ward->id }}">Ward Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Name:</strong> {{ $ward->name }}</p>
        <p><strong>Capacity:</strong> {{ $ward->capacity }}</p>
        <p><strong>Description:</strong> {{ $ward->description ?? 'N/A' }}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endpush

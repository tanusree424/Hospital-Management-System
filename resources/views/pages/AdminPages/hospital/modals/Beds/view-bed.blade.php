@push('modals')


<div class="modal fade" id="viewBedModal{{ $bed->id }}" tabindex="-1" aria-labelledby="viewBedModalLabel{{ $bed->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border border-dark">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewBedModalLabel{{ $bed->id }}">
                    <i class="fa fa-bed me-2"></i> Bed Details - {{ $bed->number }}
                </h5>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Bed Number:</strong> {{ $bed->number }}
                    </li>
                    <li class="list-group-item">
                        <strong>Ward:</strong> {{ $bed->ward->name ?? 'N/A' }}
                    </li>
                    <li class="list-group-item">
                        <strong>Status:</strong>
                        <span class="badge bg-{{ $bed->status === 'available' ? 'success' : 'danger' }}">
                            {{ ucfirst($bed->status) }}
                        </span>
                    </li>
                    <li class="list-group-item">
                        <strong>Description:</strong><br>
                        {{ $bed->description ?? 'No additional information.' }}
                    </li>
                </ul>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fa fa-times me-1"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>
@endpush

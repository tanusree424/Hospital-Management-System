@push('modals')


<div class="modal fade" id="createWardModal" tabindex="-1" aria-labelledby="createWardModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="createWardModalLabel">Add New Ward</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('hospital.management.ward.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="wardName" class="form-label">Ward Name</label>
            <input type="text" name="name" class="form-control" id="wardName" placeholder="Enter ward name" value="{{ old('name') }}" required>
            @error('name')
              <span class="text-danger small">{{ $message }}</span>
            @enderror
          </div>

          <div class="mb-3">
            <label for="wardCapacity" class="form-label">Capacity</label>
            <input type="number" name="capacity" class="form-control" id="wardCapacity" placeholder="Enter capacity" value="{{ old('capacity') }}" required>
            @error('capacity')
              <span class="text-danger small">{{ $message }}</span>
            @enderror
          </div>

          <div class="mb-3">
            <label for="wardDescription" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="wardDescription" rows="3" placeholder="Optional description">{{ old('description') }}</textarea>
            @error('description')
              <span class="text-danger small">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success btn-sm">Create</button>
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endpush

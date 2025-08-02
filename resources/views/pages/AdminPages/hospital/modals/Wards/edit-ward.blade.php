@push('modals')


<div class="modal fade" id="editWardModal{{ $ward->id }}" tabindex="-1" aria-labelledby="editWardModalLabel{{ $ward->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="editWardModalLabel{{ $ward->id }}">Edit Ward</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('hospital.management.ward.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <input type="hidden" name="id" value="{{$ward->id}}">
          <div class="mb-3">
            <label for="name{{ $ward->id }}" class="form-label">Ward Name</label>
            <input type="text" name="name" class="form-control" id="name{{ $ward->id }}" value="{{ old('name', $ward->name) }}" required>
            @error('name')
              <span class="text-danger small">{{ $message }}</span>
            @enderror
          </div>

          <div class="mb-3">
            <label for="capacity{{ $ward->id }}" class="form-label">Capacity</label>
            <input type="number" name="capacity" class="form-control" id="capacity{{ $ward->id }}" value="{{ old('capacity', $ward->capacity) }}" required>
            @error('capacity')
              <span class="text-danger small">{{ $message }}</span>
            @enderror
          </div>

          <div class="mb-3">
            <label for="description{{ $ward->id }}" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="description{{ $ward->id }}" rows="3">{{ old('description', $ward->description) }}</textarea>
            @error('description')
              <span class="text-danger small">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success btn-sm">Update</button>
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endpush

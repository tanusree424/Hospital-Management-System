@extends('layouts.AdminLayout.app')

@section('content')
<div class="col-md-8 m-auto">
    <h3 class="text-center">Edit Role & Update Permissions</h3>
    <form action="{{ route('role.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label"><strong>Role Name</strong></label>
            <input type="text" name="name" class="form-control" value="{{ $role->name }}">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label><strong>Assign Permissions</strong></label>
            <div class="row">
                @foreach ($permissions as $permission)
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="form-check-input"
                                id="perm{{ $permission->id }}"
                                {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm{{ $permission->id }}">{{ $permission->name }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Update Role</button>
    </form>
</div>
@endsection

@extends('layouts.AdminLayout.app')
@section('content')
<div class="d-flex justify-content-center align-items-center h-100 vh-100">
    <div class="col-md-4 col-lg-6 col-sm-2 col">
    <div class="card">
        <div class="card-header"  style="background-color:rgb(136, 231, 231) ;">
            <h4 class="text-center p-2 fw-bold">Edit Permission - {{$permission->name}}</h4>
        </div>
        <div class="card-body">
            <form action="{{route('permission.update', $permission->id)}}" method="POST">
                @csrf
                @method('PUT')
            <div class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <label for="" class="form-label"><strong class="fs-5">Permission name :</strong></label>
                    </div>

                    <div class="col-md-8">
                        <input type="text" value="{{$permission->name}}" placeholder="Enter Permission Name Here..." name="name" class="form-control border-1 border-dark rounded-0">
                    </div>
                </div>
            </div>
             @error('name')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
              <div class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <label for="" class="form-label"><strong class="fs-5">Permission Slug :</strong></label>
                    </div>

                    <div class="col-md-8">
                        <input type="text" value="{{$permission->permission_slug}}" placeholder="Enter Permission Slug Here..." name="permission_slug" class="form-control border-1 border-dark rounded-0">
                    </div>
                </div>
            </div>
             @error('permission_slug')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
            <div class="mb-3">
                <button class="btn btn-perm" type="submit">Update Permisson</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

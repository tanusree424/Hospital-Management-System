@extends('layouts.AdminLayout.app')
@section('content')
<div class="d-flex justify-content-center align-items-center vh-100 h-100">
<div class="col-md-6 m-auto">
    <div class="card">
        <div class="card-header" style="background-color: rgb(128, 233, 233)">
            <h4 class="text-center" >Add User</h4>
        </div>
        <div class="card-body">
            <form action="{{route('user.store')}}" method="POST">
                @csrf
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                    <label for="" class="form-label fw-bold"><strong class="h6 fw-bold" >Name:</strong></label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="name" autocomplete="off" aria-autocomplete="off" placeholder="Enter User Name.... " class="form-control">
                    </div>

                    </div>
                       @error('name')
                    <div class="text-danger text-center">{{$message}}</div>
                @enderror
                </div>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                    <label for="" class="form-label fw-bold"><strong class="h6 fw-bold" >Email:</strong></label>
                    </div>
                    <div class="col-md-8">
                        <input type="email" name="email" placeholder="Enter User Email.... " class="form-control">
                    </div>
                      @error('email')
                    <div class="text-danger text-center">{{$message}}</div>
                @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                    <label for="" class="form-label fw-bold"><strong class="h6 fw-bold" >Password:</strong></label>
                    </div>
                    <div class="col-md-8">
                        <input type="password" name="password" placeholder="Enter User Password.... " class="form-control">
                    </div>

                    </div>
                      @error('password')
                    <div class="text-danger text-center">{{$message}}</div>
                @enderror
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                    <label for="" class="form-label fw-bold"><strong class=" h6 fw-bold" >Confrim Password:</strong></label>
                    </div>
                    <div class="col-md-8">
                        <input type="password" name="password_confirmation" autocomplete="off" aria-autocomplete="off" placeholder="Confrim Your Password.... " class="form-control">
                    </div>

                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                    <label for="" class="form-label h6 fw-bold"><strong>Roles</strong></label>
                    </div>
                    <div class="col-md-8">
                       @foreach ($roles as $role)
    <div class="form-check form-check-inline">
        <input class="form-check-input " type="radio" name="role" value="{{ $role->name }}" id="role_{{ $role->id }}">
        <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
    </div>
@endforeach
@error('role')
    <div class="text-danger text-center">{{ $message }}</div>
@enderror

                    </div>
                    </div>
                </div>
                <div class="mb-3">
                    <button class="btn btn-perm">Insert User</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

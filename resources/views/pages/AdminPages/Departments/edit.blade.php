@extends('layouts.AdminLayout.app')

@section('content')
<div class="d-flex justify-content-center align-items-center h-100 vh-100">
    <div class="col-md-7 m-auto">
    <div class="card shadow">
        <div class="card-header" style="background-color:rgb(100, 222, 222)">
            <h4 class="text-center">Edit Department - {{$department->name}}</h4>
        </div>
        <div class="card-body">
            <form action="{{route('departments.update', $department->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="" class="form-label">Department Name:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" value="{{$department->name}}" name="department_name" placeholder="Enter Department Nae Here..." class="form-control">
                        </div>
                    </div>
                    @error('department_name')
                        <p class="text-center text-danger">{{$message}}</p>
                    @enderror
                </div>
                 <div class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="" class="form-label">Department Description:</label>
                        </div>
                        <div class="col-md-8">
                           <textarea name="description" placeholder="Enter Description for Department" class="form-control"  id="description" cols="30" rows="5">{{$department->description}}</textarea>
                        </div>
                    </div>
                    @error('description')
                        <p class="text-center text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary btn-perm">Update Department</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

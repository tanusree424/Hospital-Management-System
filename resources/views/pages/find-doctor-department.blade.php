@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2>Search Results</h2>
    @if($doctors->count())
        <div class="row">
            @foreach($doctors as $doctor)
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <img src="{{ asset('storage/' . $doctor->profile_picture) }}" class="card-img-top" alt="Doctor Image">
                        <div class="card-body">
                            <h5>{{ $doctor->user->name }}</h5>
                            <p>{{ $doctor->qualifications }}</p>
                            <small>Department: {{ $doctor->department->name }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No doctors found for your search.</p>
    @endif
</div>
@endsection

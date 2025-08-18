@extends('layouts.app')

@section('content')
<div class="container mt-5">

    {{-- Blog Content --}}
    <div class="card shadow-lg border-0 mb-4">
        <div class="card-body">
            <h2 class="card-title fw-bold text-primary">{{ $blogs->title ?? 'No Title' }}</h2>

            <img src="{{asset('storage/'. $blogs->image)}}" width="300" height="300" alt="{{$blogs->title}}">
            <p class="text-muted">{{ $blogs->created_at->format('F j, Y') }}</p>
            <hr>
            <p class="fs-5">{{ $blogs->description ?? 'No Content Available' }}</p>
        </div>
    </div>

    {{-- Comments Section --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h4 class="mb-4">💬 Comments</h4>

            @forelse($comments as $comment)
                <div class="d-flex align-items-start mb-3 p-3 rounded bg-light">
                    {{-- User Avatar --}}
                    <div class="me-3">
                        @if ($comment->user?->hasRole('Doctor'))
                            <img src="{{ asset('storage/' . $comment->user->doctor->profile_picture) }}"
                                class="rounded-circle border shadow-sm" width="60" height="60"
                                style="object-fit: cover" alt="">
                        @elseif ($comment->user?->hasRole('Patient'))
                            <img src="{{ asset('storage/' . $comment->user->patient->patient_image) }}"
                                class="rounded-circle border shadow-sm" width="60" height="60"
                                style="object-fit: cover" alt="">
                        @else
                            <img src="{{ asset('custome Assets/img/user.png') }}"
                                class="rounded-circle border shadow-sm" width="60" height="60"
                                style="object-fit: cover" alt="">
                        @endif
                    </div>

                    {{-- Comment Content --}}
                    <div>
                        <h6 class="fw-bold mb-1">{{ $comment->user->name ?? $comment->name ?? 'Guest User' }}</h6>
                        <p class="mb-1">{{ $comment->content }}</p>
                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">😔 No comments yet. Be the first to comment!</p>
            @endforelse
        </div>
    </div>

    {{-- Add Comment Form --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="mb-3">✍️ Leave a Comment</h5>

            <form action="{{ route('comments.store', $blogs->id) }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                <div class="mb-3">
                    <textarea name="content" class="form-control" rows="4" placeholder="Write your comment..." required></textarea>
                </div>

                @guest
                    <div class="mb-3">
                        <input type="text" name="guest_name" class="form-control mb-2"
                            placeholder="Your Name (optional)">
                        <input type="email" name="guest_email" class="form-control"
                            placeholder="Your Email (optional)">
                    </div>
                @endguest

                <button type="submit" class="btn btn-primary px-4">Post Comment</button>
            </form>
        </div>
    </div>

</div>
@endsection

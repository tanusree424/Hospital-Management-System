 <div class="container-fluid py-5">
            <div class="container">
                <div class="text-center mx-auto mb-5" style="max-width: 500px;">
                    <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Blog Post</h5>
                    <h1 class="display-4">Our Latest Medical Blog Posts</h1>
                </div>
                <div class="row g-5">
                    @foreach ($blogs as $blog)
                        <div class="col-xl-4 col-lg-6">
                            <div class="bg-light rounded overflow-hidden">
                                <img class="img-fluid w-100" src="{{asset('storage/'.$blog->image)}}" alt="">
                                <div class="p-4">
                                    <a class="h3 d-block mb-3" href="{{route('blog.slug',$blog->slug)}}">{{ $blog->title }}</a>
                                    <p class="m-0">{{ $blog->description }}</p>
                                </div>
                                <div class="d-flex justify-content-between border-top p-4">
                                    <div class="d-flex align-items-center">
                                        @if ($blog->admin && $blog->author_type === "admin")
                                            <img class="rounded-circle me-2"
                                                src="{{ asset('storage/' . $blog->admin->profile_picture) }}"
                                                width="25" height="25" alt="">
                                            <small>{{ $blog->admin->user->name }}</small>
                                        @elseif($blog->doctor && $blog->author_type === "doctor")
                                            <img class="rounded-circle me-2"
                                                src="{{ asset('storage/' . $blog->doctor->profile_picture) }}"
                                                width="25" height="25" alt="">
                                            <small>{{ $blog->doctor->user->name }}</small>
                                        @endif
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <small class="ms-3"><i
                                                class="far fa-eye text-primary me-1"></i>{{$blog->views}}</small>
                                        <small class="ms-3"><i
                                                class="far fa-comment text-primary me-1"></i>{{$blog->comments_count}}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>

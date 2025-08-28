@extends('layouts.AdminLayout.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-white"><i class="bi bi-journal"></i> Manage Blogs</h4>
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addBlogModal">
                    <i class="bi bi-plus-circle"></i> Add Blog
                </button>
            </div>
            @push('modals')
                <div class="modal fade" id="addBlogModal" tabindex="-1">
                    <div class="modal-dialog modal-xl  modal-dialog-centered">
                        <div class="modal-content ">
                            <div class="modal-header bg-success">
                                <h5 class="modal-title text-white">Add Blog</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="modal-body row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Title</label>
                                        <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                                    </div>
                                    @error('title')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="col-md-6">
                                        <label class="form-label">Slug</label>
                                        <input type="text" name="slug" value="{{ old('slug') }}" class="form-control">
                                    </div>
                                    @error('slug')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="col-md-12">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" value="{{ old('description') }}" rows="4" class="form-control"></textarea>
                                    </div>
                                    @error('description')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="col-md-12">
                                        <label class="form-label">Image</label>
                                        <input type="file" id="imageFile" name="image" class="form-control">

                                        <small>Current: <img id="img_preview" src=""
                                                class="img-fluid rounded shadow" /></small>

                                    </div>
                                    @error('image')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Insert Blog</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endpush
            <div class="card-body">
                <table id="table_data" class="table table-bordered table-striped align-middle" id="blogsTable">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>

                            <th>Title</th>


                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($blogs as $index => $blog)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>

                                <td>{{ $blog->title }}</td>

                                <td class="text-center">
                                    <!-- View Modal Trigger -->
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#viewBlogModal{{ $blog->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    @php
                                        $user = auth()->user();
                                        $role = $user->roles->pluck('name')->first();
                                    @endphp

                                    @if ($role === 'Admin' || ($blog->author_type === 'doctor' && $blog->author_id ==
                                    optional($user->doctor)->id))
                                        <!-- Edit Modal Trigger -->
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editBlogModal{{ $blog->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <!-- Delete Form -->
                                        <form action="{{ route('admin.blogs.delete', $blog->id) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                data-title="{{ $blog->title }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif






                                </td>
                            </tr>

                            <!-- View Modal -->
                            @push('modals')
                                <div class="modal fade" id="viewBlogModal{{ $blog->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-info text-white">
                                                <h5 class="modal-title">View Blog</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body row">
                                                <div class="col-md-5 text-center">
                                                    @if ($blog->image)
                                                        <img src="{{ asset('storage/' . $blog->image) }}"
                                                            class="img-fluid rounded shadow">
                                                    @else
                                                        <img src="{{ asset('images/no-image.png') }}"
                                                            class="img-fluid rounded shadow">
                                                    @endif
                                                </div>
                                                <div class="col-md-7">
                                                    <h4>{{ $blog->title }}</h4>
                                                    <p><strong>Slug:</strong> {{ $blog->slug }}</p>
                                                    <p><strong>Author:</strong>
                                                        {{ optional($blog->author)->name ?? 'Unknown' }}</p>



                                                    <p><strong>Description:</strong> {!! $blog->description !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endpush

                            <!-- Edit Modal -->
                            @push('modals')
                                <div class="modal fade" id="editBlogModal{{ $blog->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning">
                                                <h5 class="modal-title">Edit Blog</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Title</label>
                                                        <input type="text" name="title" value="{{ $blog->title }}"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Slug</label>
                                                        <input type="text" name="slug" value="{{ $blog->slug }}"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label">Description</label>
                                                        <textarea name="description" rows="4" class="form-control">{{ $blog->description }}</textarea>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label">Image</label>
                                                        <input type="file" id="imageFile" name="image"
                                                            class="form-control">
                                                        @if ($blog->image)
                                                            <small>Current: <img id="img_preview"
                                                                    src="{{ asset('storage/' . $blog->image) }}"
                                                                    class="img-fluid rounded shadow" /></small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Update</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endpush
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 for Delete Confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on("click", ".delete-btn", function(e) {
            e.preventDefault();
            let form = $(this).closest("form");
            let title = $(this).data("title");

            Swal.fire({
                title: "Are you sure?",
                text: `You are about to delete blog "${title}"`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>


    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script>
        $('#table_data').DataTable({
            responsive: true,
            dom: '<"row mb-3"<"col-md-4"l><"col-md-4 text-center"B><"col-md-4"f>>rt<"row mt-3"<"col-md-6"i><"col-md-6"p>>',
            buttons: ['copy', 'excel', 'print'],
            // columnDefs: [{
            //     orderable: false,
            //     targets: [] // Action column
            // }],
            lengthMenu: [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "All"]
            ],
            language: {
                search: "Search:",
                zeroRecords: "No matching roles found",
                info: "Showing _START_ to _END_ of _TOTAL_ roles",
                infoEmpty: "No roles available",
                infoFiltered: "(filtered from _MAX_ total roles)",
                lengthMenu: "Show _MENU_ entries"
            }
        });

        $('.dataTables_filter input[type="search"]').addClass('form-control mb-3').attr("placeholder", "Search...");
        $(document).ready(function() {
            $("#imageFile").on("change", function() {
                const file = this.files[0];
                console.log(file); // logs the File object

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Use jQuery to set the src attribute
                        $("#img_preview").attr("src", e.target.result).show();
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>

@endsection
@stack('modals')

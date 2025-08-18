@extends('layouts.AdminLayout.app')
@section('content')
    <div class="card">
        <div class="card-header bg-primary d-flex justify-content-between">
            <h3 class="text-center fw-bold text-white"><strong> <i class="fa fa-building me-2"></i> Department
                    Management</strong></h3>
            <div class="d-flex justify-content-end">
                @can('create_department')
                    <button data-bs-toggle="modal" data-bs-target="#addDepartmentModal" class="btn btn-success"> <i
                            class="fa fa-building me-2"></i>+ Add Department</button>
                @endcan

            </div>
            @push('modals')
                <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header bg-success">
                                <h5 class="modal-title text-white" id="addDepartmentModalLabel"> <i
                                        class="fa fa-building me-2"></i> Add Department Modal</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('departments.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="" class="form-label">Department Name:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="department_name"
                                                    placeholder="Enter Department Nae Here..." class="form-control">
                                            </div>
                                        </div>
                                        @error('department_name')
                                            <p class="text-center text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="" class="form-label">Department Description:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea name="description" placeholder="Enter Description for Department" class="form-control" id="description"
                                                    cols="30" rows="5"></textarea>
                                            </div>
                                        </div>
                                        @error('description')
                                            <p class="text-center text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="" class="form-label">Price</label>

                                            </div>
                                            <div class="col-md-8">
                                                <input type="number" name="price" id="" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="" class="form-label">Department Image</label>

                                            </div>
                                            <div class="col-md-8">
                                                <input type="file" name="department_image" id=""
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-perm">Insert Department</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endpush

        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert-success alert alert-dismissible fade show" role="alert ">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="col-md-12 m-auto">
                <table class="table table-bordered shadow  table-striped shadow-sm align-middle text-center"
                    id="table_data">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Department name</th>
                            <th>Created Time</th>

                            <th>Action</th>


                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @if ($departments->count() > 0)
                            @php
                                $index = 1;
                            @endphp
                            @foreach ($departments as $dept)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ $dept->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($dept->created_at)->timezone('asia/kolkata')->format('d-M-Y h:iA') }}
                                    </td>

                                    <td class="d-flex justify-content-center align-items-center gap-2">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#viewModal{{ $dept->id }}">
                                            <i class="bi bi-eye">view</i>
                                        </button>
                                        @push('modals')
                                            <div class="modal fade" id="viewModal{{ $dept->id }}" tabindex="-1"
                                                aria-labelledby="viewModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">

                                                            <h5 class="modal-title" id="viewModalLabel{{ $dept->id }}">
                                                                {{ $dept->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                               <div class="img-fluid mb-2">
                                                                <img src="{{asset('storage/'.$dept->department_image)}}" class="img-thumbnail" alt="">
                                                                </div>
                                                                <hr>
                                                            <h4>Department Name: {{ $dept->name }}</h4>
                                                            <h4>Description</h4>
                                                            <p>
                                                                {{ $dept->description }}
                                                            </p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endpush
                                        @can('edit_permission')
                                            <button data-bs-toggle="modal"
                                                data-bs-target="#editDepartmentModal{{ $dept->id }}"
                                                class="btn btn-warning"><i class="bi bi-pencil">Edit</i></button>
                                            <!-- Modal -->
                                            @push('modals')
                                                <div class="modal fade" id="editDepartmentModal{{ $dept->id }}"
                                                    tabindex="-1" aria-labelledby="editDepartmentModalLabel{{ $dept->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-warning">
                                                                <h5 class="modal-title text-white"
                                                                    id="editDepartmentModalLabel{{ $dept->id }}">
                                                                    {{ $dept->name }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('departments.update', $dept->id) }}"
                                                                    method="POST" enctype="multipart/form-data" >
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="mb-3">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for=""
                                                                                    class="form-label">Department Name:</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="text" value="{{ $dept->name }}"
                                                                                    name="department_name"
                                                                                    placeholder="Enter Department Nae Here..."
                                                                                    class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        @error('department_name')
                                                                            <p class="text-center text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for=""
                                                                                    class="form-label">Department
                                                                                    Description:</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <textarea name="description" placeholder="Enter Description for Department" class="form-control" id="description"
                                                                                    cols="30" rows="5">{{ $dept->description }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                        @error('description')
                                                                            <p class="text-center text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for=""
                                                                                    class="form-label">Department Price:</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="number" name="price"
                                                                                    placeholder="Enter prie for Department"
                                                                                    class="form-control"
                                                                                    value="{{ old('price', $dept->pricing) }}"
                                                                                    id="price" />
                                                                            </div>
                                                                        </div>
                                                                        @error('price')
                                                                            <p class="text-center text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for=""
                                                                                    class="form-label">Department Price:</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="file" name="department_image"
                                                                                    class="form-control" id="department_image" />
                                                                            </div>
                                                                        </div>
                                                                        @error('department_image')
                                                                            <p class="text-center text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                        @if (!$dept->department_image)
                                                                       <img src="{{asset('storage/'. $dept->department_image)}}" class="img-thumbnail" id="image_container" width="100px" height="100px" style="object-fit: contian" alt="">
                                                                          @else
                                                                          <img src="{{asset('storage/'. $dept->department_image)}}" class="img-thumbnail" id="image_container" width="100px" height="100px" style="object-fit: contian" alt="">
                                                                        @endif


                                                                    </div>


                                                                    <div class="mb-3">
                                                                        <button type="submit"
                                                                            class="btn btn-primary btn-perm">Update
                                                                            Department</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endpush
                                            <form action="{{ route('departments.delete', $dept->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    onclick="return confirm('Are You Sure want to delete department {{ $dept->name }} ?')"
                                                    class="btn btn-danger mt-2"><i class="bi bi-trash"></i>Delete</button>
                                            </form>
                                        @endcan

                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="4">No Department Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>


        </div>
    </div>
    </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>


<!-- And below scripts -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script>
    $(document).ready(function() {
        $('#table_data').DataTable({
            responsive: true,
            dom: '<"d-flex justify-content-between align-items-center mb-3"lBf>rtip',
            buttons: ['copy', 'excel', 'print'],
            columnDefs: [{
                orderable: false,
                targets: [2]
            }],
            lengthMenu: [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "All"]
            ],
            language: {
                search: "Search:",
                zeroRecords: "No matching patients found",
                info: "Showing _START_ to _END_ of _TOTAL_ patients",
                infoEmpty: "No patients available",
                infoFiltered: "(filtered from _MAX_ total patients)",
                lengthMenu: "Show _MENU_ entries"
            }
        });
        $('.dataTables_filter input[type="search"]').addClass('form-control mb-3').attr("placeholder",
            "Search...");
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function(){
        //alert("hello");
        const image  = document.getElementById("department_image");
       image.addEventListener("change", function(){
       if (image && image.files[0]) {
        let imageUrl = URL.createObjectURL(image.files[0]);
       // console.log(imageUrl);
       document.getElementById("image_container").src =  imageUrl;
       }
       })


    })
</script>
@stack('modals')

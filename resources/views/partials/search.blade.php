 <div class="container-fluid bg-primary my-5 py-5">
        <div class="container py-5">
            <div class="text-center mx-auto mb-5" style="max-width: 500px;">
                <h5 class="d-inline-block text-white text-uppercase border-bottom border-5">Find A Doctor</h5>
                <h1 class="display-4 mb-4">Find A Healthcare Professional</h1>
            </div>
            <form action="{{ route('find.doctor.search') }}" method="GET" class="mx-auto"
                style="width: 100%; max-width: 600px;">
                <div class="input-group">
                    <select name="department_id" class="form-select border-primary w-25" style="height: 60px;">
                        <option value="all">All Departments</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="keyword" class="form-control border-primary w-50"
                        placeholder="Keyword">
                    <button type="submit" class="btn btn-dark border-0 w-25">Search</button>
                </div>
            </form>
        </div>
    </div>

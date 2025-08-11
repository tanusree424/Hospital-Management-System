  <div class="container-fluid bg-primary my-5 py-5">
      <div class="container py-5">
          <div class="row gx-5">
              <div class="col-lg-6 mb-5 mb-lg-0">
                  <div class="mb-4">
                      <h5 class="d-inline-block text-white text-uppercase border-bottom border-5">Appointment</h5>
                      <h1 class="display-4">Make An Appointment For Your Family</h1>
                  </div>
                  <p class="text-white mb-5">Eirmod sed tempor lorem ut dolores. Aliquyam sit sadipscing kasd ipsum.
                      Dolor ea et dolore et at sea ea at dolor, justo ipsum duo rebum sea invidunt voluptua. Eos vero
                      eos vero ea et dolore eirmod et. Dolores diam duo invidunt lorem. Elitr ut dolores magna sit. Sea
                      dolore sanctus sed et. Takimata takimata sanctus sed.</p>
                  <a class="btn btn-dark rounded-pill py-3 px-5 me-3" href="">Find Doctor</a>
                  <a class="btn btn-outline-dark rounded-pill py-3 px-5" href="">Read More</a>
              </div>
              <div class="col-lg-6">
                  <div class="bg-white text-center rounded p-5">
                      <h1 class="mb-4">Book An Appointment</h1>
                     <form action="{{ route('guest.store') }}" method="POST">
    @csrf
    <div class="row g-3">
        <!-- Department -->
        <div class="col-12 col-sm-6">
            <select name="department_id" id="department_id" data-url="{{ url('/get-doctors') }}"
                class="form-select bg-light border-0" style="height: 55px;">
                <option selected>Choose Department</option>
                @foreach ($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
            @error('department_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Doctor -->
        <div class="col-12 col-sm-6">
            <select class="form-select bg-light border-0" id="doctor_id" name="doctor_id" style="height: 55px;">
                <option selected>Select Doctor</option>
                <option value="1">Doctor 1</option>
                <option value="2">Doctor 2</option>
                <option value="3">Doctor 3</option>
            </select>
            @error('doctor_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Name -->
        <div class="col-12 col-sm-6">
            <input type="text" name="name" class="form-control bg-light border-0"
                placeholder="Your Name" style="height: 55px;">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Email -->
        <div class="col-12 col-sm-6">
            <input type="email" name="email" class="form-control bg-light border-0"
                placeholder="Your Email" style="height: 55px;">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Appointment Date -->
        <div class="col-12 col-sm-6">
            <div class="input-group date" id="datetimepicker1" data-target-input="nearest" style="position: relative;">
                <input type="text" name="appointment_date"
                    class="form-control datetimepicker-input bg-light border-0"
                    placeholder="Select Date" data-target="#datetimepicker1" style="height: 55px;" />
                <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
            @error('appointment_date')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Appointment Time -->
        <div class="col-12 col-sm-6">
            <div class="input-group time" id="timepicker1" data-target-input="nearest" style="position: relative;">
                <input type="text" name="appointment_time"
                    class="form-control datetimepicker-input bg-light border-0"
                    placeholder="Select Time" data-target="#timepicker1" style="height: 55px;" />
                <div class="input-group-append" data-target="#timepicker1" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-clock"></i></div>
                </div>
            </div>
            @error('appointment_time')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Submit -->
        <div class="col-12">
            <button class="btn btn-primary w-100 py-3" type="submit">Make An Appointment</button>
        </div>
    </div>
</form>

<!-- JS Initialization -->


                  </div>
              </div>
              {{-- <form action="{{ route('guest.store') }}" method="POST">
                          @csrf

                          <div class="mb-3">
                              <label class="form-label">Choose Department</label>
                              <select name="department_id" id="department_id" class="form-select" required>
                                  <option value="">-- Select Department --</option>
                                  @foreach ($departments as $department)
                                      <option value="{{ $department->id }}">{{ $department->name }}</option>
                                  @endforeach
                              </select>
                              @error('department_id')
                                  <small class="text-danger">{{ $message }}</small>
                              @enderror
                          </div>

                          <div class="mb-3">
                              <label class="form-label">Choose Doctor</label>
                              <select name="doctor_id" id="doctor_id" class="form-select" required>
                                  <option value="">-- Select Doctor --</option>
                                  {{-- @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                @endforeach
                              </select>
                              @error('doctor_id')
                                  <small class="text-danger">{{ $message }}</small>
                              @enderror
                          </div>

                          <div class="mb-3">
                              <label class="form-label">Your Name</label>
                              <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                  required>
                              @error('name')
                                  <small class="text-danger">{{ $message }}</small>
                              @enderror
                          </div>

                          <div class="mb-3">
                              <label class="form-label">Your Email</label>
                              <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                  required>
                              @error('email')
                                  <small class="text-danger">{{ $message }}</small>
                              @enderror
                          </div>

                          <div class="mb-3">
                              <label class="form-label">Appointment Date</label>
                            <input type="date" name="appointment_date" class="form-control" value="{{ old('appointment_date') }}" required>
                              <input type="text" class="form-control bg-light border-0 datetimepicker-input"
                                  placeholder="Date" name="appointment_date" value="{{ old('appointment_date') }}"
                                  data-target="#date" data-toggle="datetimepicker" style="height: 55px;">
                              @error('appointment_date')
                                  <small class="text-danger">{{ $message }}</small>
                              @enderror
                          </div>

                          <div class="mb-3">
                              <label class="form-label">Appointment Time</label>
                              <input type="time" name="appointment_time" class="form-control"
                                  value="{{ old('appointment_time') }}" required>
                              @error('appointment_time')
                                  <small class="text-danger">{{ $message }}</small>
                              @enderror
                          </div>

                          <button type="submit" class="btn btn-primary w-100">Book Appointment</button>
                      </form> --}}
          </div>
      </div>
  </div>
  </div>
  </div>

  {{-- <script>
 $('#department_id').on('change', function() {
            var departmentId = $(this).val();
            var url = $(this).data('url');

            if (departmentId) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        department_id: departmentId
                    },
                    success: function(doctors) {
                        $('#doctor_id').empty().append(
                            '<option value="">-- Select Doctor --</option>');
                        $.each(doctors, function(index, doctor) {
                            $('#doctor_id').append('<option value="' + doctor.id +
                                '">' + doctor.user.name + '</option>');
                        });
                    },
                    error: function() {
                        console.error('Could not fetch doctors.');
                    }
                });
            } else {
                $('#doctor_id').empty().append('<option value="">-- Select Doctor --</option>');
            }
        });
</script> --}}

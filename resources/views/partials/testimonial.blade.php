 <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width: 500px;">
                <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Testimonial</h5>
                <h1 class="display-4">Patients Say About Our Services</h1>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="owl-carousel testimonial-carousel">
                        @foreach ($patients as $patient)
                            @foreach ($patient->feedback as $fb)
                                <div class="testimonial-item text-center">
                                    <div class="position-relative mb-5">
                                        <img class="img-fluid rounded-circle mx-auto"
                                            src="{{ asset('storage/' . $patient->patient_image) }}" style="object-fit:contain;" alt="">
                                        <div class="position-absolute top-100 start-50 translate-middle d-flex align-items-center justify-content-center bg-white rounded-circle"
                                            style="width: 60px; height: 60px;">
                                            <i class="fa fa-quote-left fa-2x text-primary"></i>
                                        </div>
                                    </div>
                                    <p class="fs-4 fw-normal">
                                        {{ $fb->message }}
                                    </p>

                                    <hr class="w-25 mx-auto">
                                    <h3>{{ $patient->user->name }}</h3>
                                    <h6 class="fw-normal text-primary mb-3">Profession</h6>
                                </div>
                            @endforeach
                        @endforeach



                    </div>
                </div>
            </div>
        </div>
        <!-- Testimonial End -->

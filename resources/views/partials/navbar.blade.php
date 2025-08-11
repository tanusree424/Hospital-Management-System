<!-- Navbar Start -->
    <div class="container-fluid sticky-top bg-white shadow-sm">
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0">
                <a href="index.html" class="navbar-brand">
                    <h1 class="m-0 text-uppercase text-primary"><i class="fa fa-clinic-medical me-2"></i>Medinova</h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="{{route('home')}}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                        <a href="{{route('about')}}" class="nav-item nav-link {{request()->routeIs('about') ? 'active' : ""}}">About</a>
                        <a href="{{route('services')}}" class="nav-item nav-link {{request()->routeIs('services') ?  'active' :""}}">Service</a>
                        <a href="{{route('pricing')}}" class="nav-item nav-link {{request()->routeIs('pricing') ? 'active' : ""}}">Pricing</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu m-0">
                                <a href="blog.html" class="dropdown-item">Blog Grid</a>
                                <a href="detail.html" class="dropdown-item">Blog Detail</a>
                                <a href="team.html" class="dropdown-item">The Team</a>
                                <a href="{{route('testimonial')}}" class="dropdown-item {{request()->routeIs('testimonial') ? 'active' :""}}">Testimonial</a>
                                <a href="{{route('appointment')}}" class="dropdown-item">Appointment</a>
                                <a href="search.html" class="dropdown-item">Search</a>
                            </div>
                        </div>
                        <a href="contact.html" class="nav-item nav-link">Contact</a>
                         <div class="dropdown">
  <a class="nav-item nav-link  dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
   Login
  </a>

  <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
    <li><a class="dropdown-item" href="#">Doctors</a></li>
    <li><a class="dropdown-item" href="#">Patient</a></li>
    <li><a class="dropdown-item" href="#">Staff</a></li>
     <li><a class="dropdown-item" href="{{route('admin.login')}}">Admin</a></li>
  </ul>
</div>

                       {{-- @if (Route::has('login'))
    @auth
        <a href="{{ url('/dashboard') }}" class="nav-item nav-link">Dashboard</a>
    @else
        <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>

        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="nav-item nav-link">Register</a>
        @endif
    @endauth
@endif --}}

                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->
  <!-- Hero Start -->
    {{-- <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-start">
                <div class="col-lg-8 text-center text-lg-start">
                    <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5" style="border-color: rgba(256, 256, 256, .3) !important;">Welcome To Medinova</h5>
                    <h1 class="display-1 text-white mb-md-4">Best Healthcare Solution In Your City</h1>
                    <div class="pt-2">
                        <a href="" class="btn btn-light rounded-pill py-md-3 px-md-5 mx-2">Find Doctor</a>
                        <a href="" class="btn btn-outline-light rounded-pill py-md-3 px-md-5 mx-2">Appointment</a>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!--Hero End -->

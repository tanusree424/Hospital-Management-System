{{-- @extends('layouts.app') --}}

{{-- @section('content') --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LOGIN | ADMIN</title>
   <link rel="stylesheet" href="{{asset('custome Assets/css/style.css')}}">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body class="d-flex justify-content-center align-items-center vh-100 loginPage">

    <div class="col-md-8 col-lg-6 shadow bg-white rounded-4 p-4">
        <div class="row align-items-center">
            <!-- Left image section -->
            <div class="col-md-5 text-center">
                <img src="{{ asset('custome Assets/img/Hospital Staff.png') }}" class="img-fluid" alt="Login Image" style="max-height: 200px;">
            </div>

            <!-- Login form section -->
            <div class="col-md-7">
                <h4 class="mb-4 text-center fw-bold text-primary">Admin Login</h4>

                <form method="POST" action="{{route('admin.loginpost')}}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" required autofocus>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" required>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember">
                        <label class="form-check-label">Remember Me</label>
                    </div>

                    <!-- Submit -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="custom-btn">Login</button>
                    </div>

                    <!-- Forgot password -->
                    <div class="text-center">
                        <a href="{{route('password.request')}}" class="text-decoration-none text-muted">Forgot your password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
{{-- @endsection --}}

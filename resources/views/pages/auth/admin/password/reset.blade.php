<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORGOT PASSWORD | ADMIN</title>

    <link rel="stylesheet" href="{{ asset('custome Assets/css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        body {
            background: linear-gradient(135deg, #6bb1ff, #d5e8ff);
        }

        .card-auth {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            max-width: 700px;
            width: 90%;
        }

        .form-label {
            font-weight: 600;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
        }

        .btn-custom {
            border-radius: 10px;
            padding: 10px;
            font-weight: 600;
        }

        .left-panel {
            background: url('{{ asset('custome Assets/img/Hospital Staff.png') }}') no-repeat center;
            background-size: contain;
            min-height: 100%;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="card card-auth p-0">
        <div class="row g-0">
            <!-- Left Image Panel -->
            <div class="col-md-5 d-none d-md-block left-panel"></div>

            <!-- Right Form Panel -->
            <div class="col-md-7 p-4">
                <h3 class="text-primary fw-bold mb-4 text-center">Forgot Password</h3>

                {{-- Success Alert --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Error Alert --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="text" name="token" value="{{ $token }}">
                    <div class="mb-3">
                    <input type="email" name="email" class="form-control"
                            placeholder="Enter your registerd email" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        </div>
                        <div class="mb-3">


                     <input type="password" name="password" class="form-control"
                            placeholder="Enter your password" required>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        </div>
                        <div class="mb-3">


                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                     @error('password_confirmation')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        </div>
                    <button type="submit" class="btn btn-primary btn-custom">Reset Password</button>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

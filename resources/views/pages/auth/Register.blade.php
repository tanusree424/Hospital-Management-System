<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>REGISTER | PATIENT</title>

    <link rel="stylesheet" href="{{ asset('custome Assets/css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous">

    <style>
        body {
            background: linear-gradient(135deg, #6bb1ff, #d5e8ff);
        }
        .register-card {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            width:80%;
        }
        .left-panel {
            background: url('{{ asset('custome Assets/img/Hospital Staff.png') }}') no-repeat center;
            background-size: contain;
            min-height: 100%;
        }
        .form-label {
            font-weight: 600;
        }
        .form-control, .form-select {
            border-radius: 10px;
        }
        .btn-custom {
            border-radius: 10px;
            padding: 10px;
            font-weight: 600;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center ">

    <div class="col-lg-8 col-md-10 col-sm-12 register-card bg-white">
        <div class="row g-0">

            <!-- Left Image Panel -->
            <div class="col-md-5 left-panel d-none d-md-block"></div>

            <!-- Right Form Panel -->
            <div class="col-md-7 p-4">
                <h3 class="text-primary fw-bold mb-4 text-center">Patient Registration</h3>

                {{-- Success Alert --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Error Alert --}}
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.registerpost') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">Select</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pincode</label>
                            <input type="text" name="pincode" id="pincode" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">City</label>
                            <input type="text" name="city" id="city" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">State</label>
                            <input type="text" name="state" id="state" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Post Office</label>
                           <input type="text" name="post_office" id="post_office" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" id="country" class="form-control" readonly>
                        </div>
                         <div class="col-md-12">
                            <label class="form-label">Address</label>
                           <textarea name="address" id="address" class="form-control" placeholder="Enter Address"></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Patient Image</label>
                            <input type="file" name="patient_image" class="form-control">
                        </div>
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" name="remember">
                        <label class="form-check-label">Remember Me</label>
                    </div>
                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-primary btn-custom">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap & Pincode Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        document.getElementById('pincode').addEventListener('blur', function() {
            let pincode = this.value.trim();
            if (pincode.length === 6) {
                fetch(`https://api.postalpincode.in/pincode/${pincode}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data[0].Status === "Success") {
                            let po = data[0].PostOffice[0];
                            document.getElementById('city').value = po.District;
                            document.getElementById('state').value = po.State;
                            document.getElementById('post_office').value = po.Name;
                            document.getElementById('country').value = po.Country;
                        } else {
                            alert("Invalid Pincode");
                        }
                    })
                    .catch(err => console.error(err));
            }
        });
    </script>
</body>
</html>

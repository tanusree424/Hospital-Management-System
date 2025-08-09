<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <!-- Custom CSS -->
  <style>
    html,
    body {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: 'Segoe UI', sans-serif;
    }

    /* Blurred Background Layer */
    .background-blur {
        background-image: url('/assets/img/hospital.jpg'); /* Adjust path */
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center;
        filter: blur(3px);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
    }

    /* Foreground Content Wrapper */
    .content-wrapper {
        position: relative;
        z-index: 1;
        display: flex;
        color: #48545f;
        min-height: 100vh;
        background-color: rgba(255, 255, 255, 0.1); /* Slight transparency */
    }

    .sidebar {
        width: 280px;
        background: rgba(255, 255, 255, 0.85); /* Less opaque to show background */
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }

    .sidebar a {
        color: #48545f;
        padding: 12px 25px;
        display: block;
        text-decoration: none;
        font-weight: 600;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background-color: rgb(211, 18, 211);
        color: #fff;
    }

    .main-content {
        flex-grow: 1;
        padding: 30px;
        background-color: rgba(255, 255, 255, 0.85); /* Transparent white */
        min-height: 100vh;
    }

    .btn-perm {
        background-color: rgb(127, 239, 239);
        width: 100%;
        padding: 10px 15px;
        margin-top: 15px;
        color: rgb(222, 47, 222);
        font-weight: 800;
    }

    .btn-perm:hover {
        background-color: rgb(17, 179, 179);
        color: rgb(144, 13, 144);
    }

    /* Overlay Background */
    .custom-modal-overlay {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    /* Modal Box */
    .custom-modal {
        position: relative;
        background-color: #fff;
        margin: 0 auto;
        padding: 20px;
        border-radius: 10px;
        width: 400px;
        max-width: 90%;
        top: -100px;
        opacity: 0;
        transition: all 0.4s ease;
    }

    /* Show Animation */
    .custom-modal.show {
        top: 100px;
        opacity: 1;
    }

    .close-modal {
        position: absolute;
        right: 15px;
        top: 10px;
        font-size: 24px;
        cursor: pointer;
    }

    /* Custom Modal 1 */
    .custom-modal1 {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.6);
    }

    .modal-content {
        background-color: #fff;
        margin: 100px auto;
        padding: 30px;
        border: 1px solid #888;
        width: 60%;
        border-radius: 12px;
        animation: slideFromTop 0.4s ease-out;
    }

.star-rating {
    direction: rtl;
    display: inline-flex;
}
.star-rating input[type="radio"] {
    display: none;
}
.star-rating label {
    font-size: 2rem;
    color: #ccc;
    cursor: pointer;
}
.star-rating input:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: gold;
}


    @keyframes slideFromTop {
        from {
            transform: translateY(-100px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .close-btn {
        float: right;
        font-size: 24px;
        font-weight: bold;
        color: #333;
        cursor: pointer;
        border: none;
        background: none;
    }

    .close-btn:hover {
        color: red;
    }
</style>



</head>

<body>
    <!-- Blurred Background -->
    <div class="background-blur"></div>

    <!-- Foreground Content -->
    <div class="content-wrapper">
        {{-- Sidebar --}}
        @include('partials.Admin.Sidebar')

        {{-- Main content --}}
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- SweetAlert session handling -->
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33'
            });
        @endif
    </script>
</body>

</html>

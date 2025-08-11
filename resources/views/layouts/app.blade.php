<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>MEDINOVA - Hospital</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('assets/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" />
    @yield('head')
</head>
<body>

    @include('partials.topbar')
    @include('partials.navbar')

    <main>
        @yield('content')
    </main>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('assets/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('assets/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('assets/lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/lib/tempusdominus/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
    <script src="{{asset('assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('assets/js/main.js')}}"></script>

<script>
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
</script>
@if(session('success'))
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.js"
        integrity="sha512-ZHzbWDQKpcZxIT9l5KhcnwQTidZFzwK/c7gpUUsFvGjEsxPusdUCyFxjjpc7e/Wj7vLhfMujNx7COwOmzbn+2w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    @if(session('success'))
        Toastify({
            text: "{{ session('success') }}",
            duration: 4000,
            close: true,
            gravity: "top", // top or bottom
            position: "right", // left, center, right
            backgroundColor: "#28a745",
            stopOnFocus: true,
        }).showToast();
    @endif
});
</script>

    <script>
    $(function () {
        $('#datetimepicker1').datetimepicker({
            format: 'L' // Date only
        });
        $('#timepicker1').datetimepicker({
            format: 'HH:mm' // Time only
        });
    });
</script>
@endif

</body>
</html>

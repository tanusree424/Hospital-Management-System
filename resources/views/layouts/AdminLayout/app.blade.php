<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

{{--
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script> --}}

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .sidebar {
            width: 250px;
           /* min-height: 100vh; */
            background-color:rgb(163, 246, 246);
        }
        .heading{
            color: #48545f;
            font-weight: 900;
            font: 2rem sans-serif 900 ;
        }

        .sidebar a {
            color: #48545f;
            padding: 12px 25px;
            display: block;
            text-decoration: none;
            font-weight: 600;
            font: 1em sans-serif 700;
            text-align: left;
        }

        .sidebar a:hover {
            background-color: rgb(211, 18, 211);
            color: #f8f9fa;
            font-weight: 800;
             font: 1em sans-serif 800;
             text-align: left;
        }
        .sidebar a.active{
            background-color: rgb(211, 18, 211);
            color: #f8f9fa;
            font-weight: 800;
             font: 1em sans-serif 800;
             text-align: left;
             margin: 15px 0;
        }
        .sidebar input{
            height: 60px;
            width: 100%;
        }

        .main-content {
            flex-grow: 1;
            padding: 30px;
            /* background-color: #f8f9fa; */
            min-height: 100vh;
        }
        .btn-perm{
            background-color: rgb(127, 239, 239);
            width: 100%;
            padding: 10px 15px;
            margin-top: 15px;
            border-radius: none;
            color: rgb(222, 47, 222);
            font-weight: 800;
            transition: 1ms;
        }
        .btn-perm:hover{
             background-color: rgb(17, 179, 179);
             color: rgb(144, 13, 144);

        }
    </style>
</head>
<body>
    <div class="d-flex">
        {{-- Sidebar --}}
        @include('partials.Admin.Sidebar')

        {{-- Main content --}}
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Blade file এর নিচে অথবা layouts এর নিচে -->
{{-- <script src="https://cdn.tiny.cloud/1/x9wlxq116fxill37pgqytqw5s5m66bah513d6d6ekgupjzuv/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: '#description',
    plugins: 'link image code lists table preview',
    toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview code',
    height: 300
  });
</script> --}}

</body>
</html>

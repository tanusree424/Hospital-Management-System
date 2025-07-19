<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>MEDINOVA - Hospital</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    @yield('head')
</head>
<body>

    @include('partials.topbar')
    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

</body>
</html>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard | BarberShop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Header -->
    @include('partials.header')

    <!-- Main Content -->
    <div class="pc-container">
        <div class="pc-content">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Scripts -->
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
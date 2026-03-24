<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard') | Indah Sarisalon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <base href="{{ url('/') }}/">
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
    <!-- Initialize Hamburger Toggle -->
    <script>
        function initSidebarToggle() {
            const toggle = document.getElementById('mobile-collapse'); // tombol hamburger
            const sidebar = document.querySelector('.pc-sidebar');

            if (toggle && sidebar) {
                // remove previous listener supaya tidak double
                toggle.replaceWith(toggle.cloneNode(true));
                const newToggle = document.getElementById('mobile-collapse');
                newToggle.addEventListener('click', function (e) {
                    e.preventDefault();
                    sidebar.classList.toggle('collapsed'); // toggle class collapsed
                });
            }

            // Untuk menu level yang punya submenu
            document.querySelectorAll('.pc-hasmenu > a').forEach(menu => {
                menu.onclick = (e) => {
                    e.preventDefault();
                    menu.parentElement.classList.toggle('pc-open');
                }
            });
        }

    </script>
</body>

</html>
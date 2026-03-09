<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('dashboard.user') }}" class="b-brand text-primary">
                <img src="{{ asset('assets/images/favicon.svg') }}" alt="logo" class="logo logo-lg" />
            </a>
        </div>

        <div class="navbar-content">
            <ul class="pc-navbar">

                <li class="pc-item pc-caption">
                    <label>Menu Utama</label>
                    <i class="ti ti-dashboard"></i>
                </li>

                <li class="pc-item">
                    <a href="{{ route('dashboard.user') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a class="pc-link">
                        <span class="pc-micon"><i class="ti ti-scissors"></i></span>
                        <span class="pc-mtext">Service</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a class="pc-link">
                        <span class="pc-micon"><i class="ti ti-calendar-event"></i></span>
                        <span class="pc-mtext">Booking</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a class="pc-link">
                        <span class="pc-micon"><i class="ti ti-message-star"></i></span>
                        <span class="pc-mtext">Testimoni</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>
<header class="pc-header">
    <div class="header-wrapper"><!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <li class="pc-h-item header-mobile-collapse">
                    <a href="#" class="pc-head-link head-link-secondary ms-0" id="sidebar-hide">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link head-link-secondary ms-0" id="mobile-collapse">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="dropdown pc-h-item d-inline-flex d-md-none">
                    <a class="pc-head-link head-link-secondary dropdown-toggle arrow-none m-0" data-bs-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ti ti-search"></i>
                    </a>
                    <div class="dropdown-menu pc-h-dropdown drp-search">
                        <form class="px-3">
                            <div class="mb-0 d-flex align-items-center">
                                <i data-feather="search"></i>
                                <input type="search" class="form-control border-0 shadow-none"
                                    placeholder="Search here. . ." />
                            </div>
                        </form>
                    </div>
                </li>
                <li class="pc-h-item d-none d-md-inline-flex">
                    <form class="header-search">
                        <i data-feather="search" class="icon-search"></i>
                        <input type="search" class="form-control" placeholder="Search here. . ." />
                        <button class="btn btn-light-secondary btn-search"><i
                                class="ti ti-adjustments-horizontal"></i></button>
                    </form>
                </li>
            </ul>
        </div>
        <!-- [Mobile Media Block end] -->
        <div class="ms-auto">
            <ul class="list-unstyled">

                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link head-link-primary dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : '/assets/images/user/avatar-2.jpg' }}"
                            alt="user-image" class="user-avtar" />
                        <span>
                            <i class="ti ti-settings"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header">
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0">
                                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : '/assets/images/user/avatar-2.jpg' }}"
                                        alt="user-image" class="user-avtar rounded-circle" style="width: 45px; height: 45px; object-fit: cover;" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    @php
                                        $hour = date('H');
                                        if ($hour >= 5 && $hour < 11) {
                                            $greeting = 'Selamat Pagi';
                                        } elseif ($hour >= 11 && $hour < 15) {
                                            $greeting = 'Selamat Siang';
                                        } elseif ($hour >= 15 && $hour < 18) {
                                            $greeting = 'Selamat Sore';
                                        } else {
                                            $greeting = 'Selamat Malam';
                                        }
                                    @endphp
                                    <h5 class="mb-0">{{ $greeting }},</h5>
                                    <p class="mb-0 fw-bold">{{ Auth::user()->name }}</p>
                                    <small class="text-muted">{{ ucfirst(Auth::user()->role ?? 'User') }}</small>
                                </div>
                            </div>
                            <hr />
                            <div class="profile-notification-scroll position-relative" style="max-height: calc(100vh - 280px)">
                                <a href="{{ route('profile') }}" class="dropdown-item">
                                    <i class="ti ti-user"></i>
                                    <span>My Profile</span>
                                </a>
                                <a href="{{ route('auth') }}" class="dropdown-item">
                                    <i class="ti ti-logout"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
<!-- [ Header ] end -->
@extends ('layout.dashboard')
@section('title', 'Dashboard')

<!-- [Favicon] icon -->
<link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />
<!-- [Google Font] Family -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap"
    id="main-font-link" />
<!-- [phosphor Icons] -->
<link rel="stylesheet" href="{{ asset('assets/fonts/phosphor/duotone/style.css') }}" />
<!-- [Tabler Icons] -->
<link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
<!-- [Feather Icons] -->
<link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" />
<!-- [Font Awesome Icons] -->
<link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" />
<!-- [Material Icons] -->
<link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}" />
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" />
<link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}" />

@section('content')
    <div class="pc-container">
        <div class="pc-content" id="main-content">
            <div class="row">

                <!-- ================= PROFIL USER ================= -->
                <div class="col-xl-4 col-md-6">
                    <div class="card overflow-hidden">
                        <div class="card-body text-center">

                            <div class="mb-3">
                                <div class="avtar avtar-xl bg-light-primary">
                                    <i class="ti ti-user text-primary f-24"></i>
                                </div>
                            </div>

                            <h5 class="mb-1">{{ auth()->user()->name }}</h5>

                            <p class="mb-1">
                                <span class="text-muted">@</span>{{ auth()->user()->username }}
                            </p>

                            <p class="text-muted mb-2">{{ auth()->user()->email }}</p>

                            <span class="badge bg-primary mb-3">
                                {{ auth()->user()->role }}
                            </span>

                            <hr>

                            <div class="text-start">
                                <div class="mb-2">
                                    <small class="text-muted">Nama Lengkap</small><br>
                                    <strong>{{ auth()->user()->name }}</strong>
                                </div>

                                <div class="mb-2">
                                    <small class="text-muted">Username</small><br>
                                    <strong>{{ auth()->user()->username }}</strong>
                                </div>

                                <div class="mb-2">
                                    <small class="text-muted">Email</small><br>
                                    <strong>{{ auth()->user()->email }}</strong>
                                </div>

                                <div class="mb-2">
                                    <small class="text-muted">Role</small><br>
                                    <span class="badge bg-success">
                                        {{ auth()->user()->role }}
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- ================= END PROFIL ================= -->


                <!-- CARD LAIN (TETAP) -->
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-secondary-dark dashnum-card text-white overflow-hidden">
                        <span class="round small"></span>
                        <span class="round big"></span>
                        <div class="card-body">
                            <span class="text-white d-block f-34 f-w-500 my-2">
                                10
                                <i class="ti ti-arrow-up-right-circle opacity-50"></i>
                            </span>
                            <p class="mb-0 opacity-50">Total Pelanggan</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card bg-primary-dark dashnum-card text-white overflow-hidden">
                        <span class="round small"></span>
                        <span class="round big"></span>
                        <div class="card-body">
                            <span class="text-white d-block f-34 f-w-500 my-2">
                                Rp.100.000
                            </span>
                            <p class="mb-0 opacity-50">Total Pengeluaran</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card bg-primary-dark dashnum-card text-white overflow-hidden">
                        <span class="round small"></span>
                        <span class="round big"></span>
                        <div class="card-body">
                            <span class="text-white d-block f-34 f-w-500 my-2">
                                Rp.100.000
                            </span>
                            <p class="mb-0 opacity-50">Total Pemasukan</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- JS (TIDAK DIUBAH) -->
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

    <script>
        layout_change('light');
        font_change('Roboto');
        change_box_container('false');
        layout_caption_change('true');
        layout_rtl_change('false');
        preset_change('preset-1');
    </script>

    <script src="/assets/js/plugins/apexcharts.min.js"></script>
    <script src="/assets/js/pages/dashboard-default.js"></script>
@endsection
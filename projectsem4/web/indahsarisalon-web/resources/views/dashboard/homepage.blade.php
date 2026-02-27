@extends ('layout.dashboard')
@section('title', 'Dashboard')
<!-- [Favicon] icon -->
<link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />
<!-- [Google Font] Family -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap"
    id="main-font-link" />
<!-- [phosphor Icons] https://phosphoricons.com/ -->
<link rel="stylesheet" href="{{ asset('assets/fonts/phosphor/duotone/style.css') }}" />
<!-- [Tabler Icons] https://tablericons.com -->
<link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
<!-- [Feather Icons] https://feathericons.com -->
<link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" />
<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
<link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" />
<!-- [Material Icons] https://fonts.google.com/icons -->
<link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}" />
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" />
<link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}" />

@section('content')
    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content" id="main-content">
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- [ sample-page ] start -->
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-secondary-dark dashnum-card text-white overflow-hidden">
                        <span class="round small"></span>
                        <span class="round big"></span>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="avtar avtar-lg">
                                        <i class="text-white ti ti-credit-card"></i>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="btn-group">
                                        <a href="#" class="avtar avtar-s bg-secondary text-white dropdown-toggle arrow-none"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><button class="dropdown-item">Import Card</button></li>
                                            <li><button class="dropdown-item">Export</button></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
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
                            <div class="row">
                                <div class="col">
                                    <div class="avtar avtar-lg">
                                        <i class="text-white ti ti-credit-card"></i>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <ul class="nav nav-pills justify-content-end mb-0" id="chart-tab-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link text-white active" id="chart-tab-home-tab"
                                                data-bs-toggle="pill" data-bs-target="#chart-tab-home" role="tab"
                                                aria-controls="chart-tab-home" aria-selected="true">
                                                Month
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link text-white" id="chart-tab-profile-tab"
                                                data-bs-toggle="pill" data-bs-target="#chart-tab-profile" role="tab"
                                                aria-controls="chart-tab-profile" aria-selected="false">
                                                Year
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content" id="chart-tab-tabContent">
                                <div class="tab-pane show active" id="chart-tab-home" role="tabpanel"
                                    aria-labelledby="chart-tab-home-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-6">
                                            <span class="text-white d-block f-34 f-w-500 my-2">
                                                Rp.100.000
                                                <i class="ti ti-arrow-up-right-circle opacity-50"></i>
                                            </span>
                                            <p class="mb-0 opacity-50">Total Pemasukan</p>
                                        </div>
                                        <div class="col-6">
                                            <div id="tab-chart-1"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="chart-tab-profile" role="tabpanel"
                                    aria-labelledby="chart-tab-profile-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-6">
                                            <span class="text-white d-block f-34 f-w-500 my-2">
                                                $291
                                                <i class="ti ti-arrow-down-right-circle opacity-50"></i>
                                            </span>
                                            <p class="mb-0 opacity-50">C/W Last Year</p>
                                        </div>
                                        <div class="col-6">
                                            <div id="tab-chart-2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-12">
                    <div class="card bg-primary-dark dashnum-card dashnum-card-small text-white overflow-hidden">
                        <span class="round bg-primary small"></span>
                        <span class="round bg-primary big"></span>
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="avtar avtar-lg">
                                    <i class="text-white ti ti-credit-card"></i>
                                </div>
                                <div class="ms-2">
                                    <h4 class="text-white mb-1">Rp.300.000</h4>
                                    <p class="mb-0 opacity-75 text-sm">Total Pemasukan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card dashnum-card dashnum-card-small overflow-hidden">
                        <span class="round bg-warning small"></span>
                        <span class="round bg-warning big"></span>
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="avtar avtar-lg bg-light-warning">
                                    <i class="text-warning ti ti-credit-card"></i>
                                </div>
                                <div class="ms-2">
                                    <h4 class="mb-1">$203k</h4>
                                    <p class="mb-0 opacity-75 text-sm">Total Income</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3 align-items-center">
                                <div class="col">
                                    <small class="text-muted">Profit</small>
                                    <h3>Rp.200.000</h3>
                                </div>
                                <div class="col-auto">
                                    <select class="form-select p-r-35">
                                        <option>Today</option>
                                        <option selected>This Month</option>
                                        <option>This Year</option>
                                    </select>
                                </div>
                            </div>
                            <div id="growthchart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
    </div>
    <!-- [ Main Content ] end -->
    <!-- Required Js -->
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/icon/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

    <script>
        layout_change('light');
    </script>
    <script>
        font_change('Roboto');
    </script>
    <script>
        change_box_container('false');
    </script>
    <script>
        layout_caption_change('true');
    </script>
    <script>
        layout_rtl_change('false');
    </script>
    <script>
        preset_change('preset-1');
    </script>
    <!-- [Page Specific JS] start -->
    <!-- Apex Chart -->
    <script src="/assets/js/plugins/apexcharts.min.js"></script>
    <script src="/assets/js/pages/dashboard-default.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            document.querySelectorAll(".pc-link").forEach(link => {

                link.addEventListener("click", function (e) {

                    let url = this.getAttribute("href");

                    if (!url || url === "#" || url.startsWith("http")) return;

                    e.preventDefault();

                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(res => res.text())
                        .then(data => {
                            document.querySelector("#main-content").innerHTML = data;
                            window.history.pushState({}, "", url);
                        });

                });

            });

        });
    </script>
    <!-- [Page Specific JS] end -->
@endsection
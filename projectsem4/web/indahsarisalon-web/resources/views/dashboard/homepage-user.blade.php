@extends('layout.dashboard-user')
@section('title', 'Dashboard')

<!-- [Favicon] icon -->
<link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />

<!-- [Google Font] Family -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap"
    id="main-font-link" />

<!-- [Phosphor, Tabler, Feather, Font Awesome, Material] -->
<link rel="stylesheet" href="{{ asset('assets/fonts/phosphor/duotone/style.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}" />

<!-- [Template CSS Files] -->
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" />
<link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}" />

@section('content')
    <div class="pc-container">
        <div class="pc-content" id="main-content">

            <!-- ===== Recent Booking & Promo ===== -->
            <div class="row mt-4">

                <!-- Booking Terbaru -->
                <div class="col-xl-12 col-md-12 mb-3 px-0">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5>Booking Terbaru</h5>
                        </div>
                        <div class="card-body">
                            @php
                                $bookings = [
                                    ['service' => 'Haircut', 'date' => '2026-03-05'],
                                    ['service' => 'Facial', 'date' => '2026-03-07'],
                                    ['service' => 'Spa', 'date' => '2026-03-10'],
                                    ['service' => 'Creambath', 'date' => '2026-03-12'],
                                    ['service' => 'Manicure', 'date' => '2026-03-15'],
                                ];
                            @endphp

                            <div class="booking-scroll d-flex overflow-auto gap-3">
                                @foreach($bookings as $b)
                                    <div class="card text-white bg-primary p-3"
                                        style="min-width: 280px; cursor: pointer; transition: transform 0.2s;">
                                        <h6>{{ $b['service'] }}</h6>
                                        <p class="mb-0 text-sm">{{ $b['date'] }}</p>
                                        <p class="mt-2 mb-0 text-sm">Klik untuk booking ulang</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Promo Aktif di bawah Booking -->
                <div class="col-xl-12 col-md-12 mb-3 px-0">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5>Promo Aktif</h5>
                        </div>
                        <div class="card-body">
                            @php
                                $promos = [
                                    ['title' => 'Diskon Facial 20%', 'valid_until' => '2026-03-15'],
                                    ['title' => 'Buy 1 Get 1 Creambath', 'valid_until' => '2026-03-12'],
                                ];
                            @endphp
                            @if(count($promos) > 0)
                                <ul class="list-group">
                                    @foreach($promos as $promo)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $promo['title'] }}
                                            <span class="badge bg-primary rounded-pill">Sampai: {{ $promo['valid_until'] }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>Tidak ada promo aktif saat ini.</p>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            <!-- ===== End Recent Booking & Promo ===== -->

        </div>
    </div>

    <!-- ===== Custom Style Booking Scroll & Card ===== -->
    <style>
        .px-1 {
            padding-left: 4px !important;
            padding-right: 4px !important;
        }

        .booking-scroll {
            padding-bottom: 10px;
            scroll-behavior: smooth;
        }

        .booking-scroll::-webkit-scrollbar {
            height: 6px;
        }

        .booking-scroll::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }

        .booking-scroll .card:hover {
            transform: scale(1.05);
        }

        .booking-card {
            min-height: 400px;
            max-height: 400px;
        }
    </style>

    <!-- ===== JS Dependencies ===== -->
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/icon/custom-font.js') }}"></script>
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

        document.addEventListener("DOMContentLoaded", function () {
            const toggleBtn = document.querySelector('#sidebar-toggle-btn'); // tombol sidebar
            const container = document.querySelector('.pc-container');

            // toggle sidebar class
            toggleBtn.addEventListener('click', () => {
                container.classList.toggle('sidebar-open');
            });

            // AJAX page load
            document.querySelectorAll(".pc-link").forEach(link => {
                link.addEventListener("click", function (e) {
                    let url = this.getAttribute("href");
                    if (!url || url === "#" || url.startsWith("http")) return;
                    e.preventDefault();
                    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(res => res.text())
                        .then(data => {
                            document.querySelector("#main-content").innerHTML = data;
                            window.history.pushState({}, "", url);
                        });
                });
            });
        });
    </script>
@endsection
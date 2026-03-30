@extends('layout.dashboard')

@section('title', 'Ringkasan Booking')

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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Ringkasan Booking</h4>
                    <a href="{{ route('booking.index') }}" class="btn btn-secondary btn-sm">Kembali ke Daftar Treatment</a>
                </div>
                <div class="card-body">
                    <h5>Treatment</h5>
                    <p>
                        <strong>{{ $treatment->name }}</strong> <br>
                        @foreach($treatment->details as $detail)
                            - {{ $detail->name }}: {{ $detail->duration }} menit, Rp {{ number_format($detail->price, 0) }} <br>
                        @endforeach
                    </p>

                    <h5>Stylist</h5>
                    <p>{{ $stylist->name }}</p>

                    <h5>Waktu Reservasi</h5>
                    <p>{{ \Carbon\Carbon::parse($reservation_datetime)->format('d M Y H:i') }}</p>

                    <h5>Total Biaya</h5>
                    <p>Rp {{ number_format($total_price, 0) }}</p>

                    <form action="{{ route('booking.confirm') }}" method="POST" id="bookingForm">
                        @csrf
                        <input type="hidden" name="treatment_id" value="{{ $treatment->id }}">
                        <input type="hidden" name="stylist_id" value="{{ $stylist->id }}">
                        <input type="hidden" name="reservation_datetime" value="{{ $reservation_datetime }}">
                        <input type="hidden" name="total_price" value="{{ $total_price }}">

                        <button type="submit" class="btn btn-success" id="confirmBtn">Konfirmasi & Bayar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Required JS -->
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Inisialisasi layout & font
        layout_change('light');
        font_change('Roboto');
        change_box_container('false');
        layout_caption_change('true');
        layout_rtl_change('false');
        preset_change('preset-1');
    </script>

    <script>
        $(document).ready(function () {
            // Konfirmasi sebelum submit booking
            $('#bookingForm').on('submit', function (e) {
                e.preventDefault();
                if (confirm('Apakah Anda yakin ingin melakukan konfirmasi booking ini?')) {
                    this.submit();
                }
            });
        });
    </script>
@endsection
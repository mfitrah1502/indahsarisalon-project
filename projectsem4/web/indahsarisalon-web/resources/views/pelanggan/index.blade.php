@extends('layout.dashboard')

@section('title', 'Manajemen Pelanggan')
<link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap"
    id="main-font-link" />
<link rel="stylesheet" href="{{ asset('assets/fonts/phosphor/duotone/style.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" />
<link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}" />
<style>
    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .popup-box {
        background: #fff;
        padding: 25px;
        border-radius: 8px;
        width: 500px;
        max-height: 80vh;
        overflow: auto;
        position: relative;
    }

    .popup-close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 22px;
        cursor: pointer;
    }
</style>

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Daftar Pelanggan</h4>
                    <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">Tambah Pelanggan</a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success m-3">{{ session('success') }}
                    </div>
                @endif

                <div class="card-body">
                    <div class="mb-3">
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari pelanggan..."
                            value="{{ request('search') }}">
                    </div>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pelanggans as $index => $pelanggan)
                                <tr class="pelanggan-row" data-name="{{ $pelanggan->name }}"
                                    data-username="{{ $pelanggan->username }}" data-email="{{ $pelanggan->email }}"
                                    data-status="{{ $pelanggan->status }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pelanggan->name }}</td>
                                    <td>{{ $pelanggan->username }}</td>
                                    <td>{{ $pelanggan->email }}</td>
                                    <td>{{ ucfirst($pelanggan->status) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info view-detail">Lihat</button>
                                        <a href="{{ route('pelanggan.edit', $pelanggan->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('pelanggan.destroy', $pelanggan->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Hapus pelanggan ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada pelanggan ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Popup detail pelanggan -->
    <div id="detailPopup" class="popup-overlay" style="display:none;">
        <div class="popup-box">
            <span class="popup-close">&times;</span>
            <h4 id="popupName"></h4>
            <p><b>Username:</b> <span id="popupUsername"></span></p>
            <p><b>Email:</b> <span id="popupEmail"></span></p>
            <p><b>Status:</b> <span id="popupStatus"></span></p>
        </div>
    </div>

    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src=" {{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src=" {{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        layout_change('light');
        font_change('Roboto');
        change_box_container('false');
        layout_caption_change('true');
        layout_rtl_change('false');
        preset_change('preset-1');

        // search AJAX
        $('#searchInput').on('keyup', function () {
            let query = $(this).val();
            $.ajax({
                url: " {{ route('pelanggan.index') }}", type: "GET", data: { search: query }, success: function (data) { let tbody = $(data).find('tbody').html(); $('tbody').html(tbody); }
            });
        }); // popup detail pelanggan
        $(document).on('click', '.view-detail', function () {
            let row = $(this).closest('tr');
            $('#popupName').text(row.data('name')); $('#popupUsername').text(row.data('username'));
            $('#popupEmail').text(row.data('email')); $('#popupStatus').text(row.data('status')); $('#detailPopup').fadeIn();
        }); $('.popup-close').click(function () { $('#detailPopup').fadeOut(); }); $('#detailPopup').click(function (e) {
            if
                (e.target.id === 'detailPopup') $(this).fadeOut();
        }); </script>
@endsection
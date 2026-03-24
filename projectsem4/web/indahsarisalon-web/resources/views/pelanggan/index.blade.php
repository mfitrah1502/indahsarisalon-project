@extends('layout.dashboard')

@section('title', 'Manajemen Pelanggan')
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
                    <h4>Daftar Pelanggan</h4>
                </div>

                @if(session('success'))
                    <div class="alert alert-success m-3">
                        {{ session('success') }}
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
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($pelanggans as $pelanggan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pelanggan->name }}</td>
                                    <td>{{ $pelanggan->username }}</td>
                                    <td>{{ $pelanggan->email }}</td>

                                    <td>
                                        <form action="{{ route('pelanggan.destroy', $pelanggan->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- Required Js -->
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {

            $('#searchInput').on('keyup', function () {

                let query = $(this).val();

                $.ajax({
                    url: "{{ route('pelanggan.index') }}",
                    type: 'GET',
                    data: { search: query },
                    success: function (data) {

                        let tbody = $(data).find('tbody').html();
                        $('tbody').html(tbody);

                    }
                });

            });

        });
    </script>

@endsection
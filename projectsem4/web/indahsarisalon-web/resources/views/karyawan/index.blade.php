@extends('layout.dashboard')

@section('title', 'Manajemen Karyawan')
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
                    <h4>Daftar Karyawan</h4>
                    <a href="{{ route('karyawan.create') }}" class="btn btn-primary">Tambah Karyawan</a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success m-3">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card-body">
                    <div class="mb-3">
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari karyawan..."
                            value="{{ request('search') }}">
                    </div>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($karyawans as $karyawan)
                                {{-- hanya tampilkan admin --}}
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><a href="#" class="lihat-absensi" data-id="{{ $karyawan->id }}">
                                            {{ $karyawan->name }}
                                        </a></td>
                                    <td>{{ $karyawan->username }}</td>
                                    <td>{{ $karyawan->email }}</td>
                                    <td>{{ $karyawan->phone ?? '-' }}</td>
                                    <td>{{ ucfirst($karyawan->role) }}</td>
                                    <td>{{ ucfirst($karyawan->status) }}</td>

                                    <td>
                                        <a href="{{ route('karyawan.edit', $karyawan->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('karyawan.destroy', $karyawan->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menghapus karyawan ini?')">Hapus</button>
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

    <!-- Modal Absensi -->
    <div class="modal fade" id="absensiModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Riwayat Absensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="absensiTable"></tbody>
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
                    url: "{{ route('karyawan.index') }}", // route yang sama
                    type: 'GET',
                    data: { search: query },
                    success: function (data) {
                        let tbody = $(data).find('tbody').html();
                        $('tbody').html(tbody);
                    }
                });
            });
        });
        //popup presensi
        $(document).on('click', '.lihat-absensi', function (e) {
            e.preventDefault();

            let userId = $(this).data('id');

            $.ajax({
                url: "/karyawan/" + userId + "/absensi",
                type: "GET",
                success: function (data) {
                    let rows = '';

                    if (data.length === 0) {
                        rows = `<tr><td colspan="4" class="text-center">Belum ada data absensi</td></tr>`;
                    } else {
                        data.forEach(function (item) {
                            rows += `<tr>
                                                                    <td>${item.tanggal}</td>
                                                                    <td>${item.jam_masuk ?? '-'}</td>
                                                                    <td>${item.jam_keluar ?? '-'}</td>
                                                                    <td>${item.status ?? '-'}</td>
                                                                </tr>`;
                        });
                    }

                    $('#absensiTable').html(rows);

                    var modal = new bootstrap.Modal(document.getElementById('absensiModal'));
                    modal.show();
                },
                error: function (err) {
                    console.log('AJAX Error:', err);
                }
            });
        });
    </script>
@endsection
@extends('layout.dashboard')

@section('title', 'Produk')
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Produk</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produks as $produk)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $produk->nama }}</td>
                                    <td>{{ $produk->harga }}</td>
                                    <td>{{ $produk->stok }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
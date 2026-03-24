@extends('layout.dashboard')

@section('title', 'Manajemen Treatment')
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
                    <h4>Daftar Treatment</h4>
                    <a href="{{ route('treatment.create') }}" class="btn btn-primary">Tambah Treatment</a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success m-3">{{ session('success') }}</div>
                @endif

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <select id="filterCategory" class="form-control">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}" {{ request('category') == $category->name ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select id="sortBy" class="form-control">
                                <option value="">Sort By</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z
                                </option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Z-A
                                </option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga
                                    Terendah → Tertinggi</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga
                                    Tertinggi → Terendah</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari treatment..."
                                value="{{ request('search') }}">
                        </div>
                    </div>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Promo</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($treatments as $index => $treatment)
                                <tr class="treatment-row" data-name="{{ $treatment->name }}"
                                    data-category="{{ $treatment->category ? $treatment->category->name : 'Empty'}}"
                                    data-promo="{{ $treatment->is_promo ? $treatment->promo_type . ' ' . $treatment->promo_value : 'Tidak ada' }}"
                                    data-details='@json($treatment->details)'
                                    data-image="{{ $treatment->image ?? ''}}">

                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $treatment->name }}</td>
                                    <td>{{ $treatment->category ? $treatment->category->name : 'Empty' }}</td>

                                    <td>
                                        Rp {{ number_format($treatment->details->min('price') ?? 0, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        {{ $treatment->is_promo ? $treatment->promo_type . ' ' . $treatment->promo_value : '-' }}
                                    </td>

                                    <td>
                                        <button class="btn btn-sm btn-info view-detail">Lihat</button>

                                        <a href="{{ route('treatment.edit', $treatment->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>

                                        <form action="{{ route('treatment.destroy', $treatment->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Hapus treatment ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6" style="text-align:center;">
                                        Tidak ada data yang ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div id="detailPopup" class="popup-overlay" style="display:none;">
                        <div class="popup-box">
                            <span class="popup-close">&times;</span>

                            <h4 id="popupName"></h4>
                             @if(isset($treatment) && $treatment->image)
            <img id="popupImage" 
                 class="img-fluid mb-2" 
                 style="max-width: 200px; height: auto;" 
                 alt="{{ "Gambar" }}">
        @endif
                            <p><b>Kategori:</b> <span id="popupCategory"></span></p>
                            <p><b>Promo:</b> <span id="popupPromo"></span></p>

                            <hr>

                            <h5>Detail Treatment</h5>
                            <ul id="popupDetails"></ul>
                        </div>
                    </div>
                    {{ $treatments->links() }}

                    <!-- Modal Detail Treatment -->
                    <div class="modal fade" id="treatmentDetailModal" tabindex="-1" aria-labelledby="treatmentDetailLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="treatmentDetailLabel">Detail Treatment</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Nama:</strong> <span id="modalName"></span></p>
                                    <p><strong>Kategori:</strong> <span id="modalCategory"></span></p>
                                    <p><strong>Promo:</strong> <span id="modalPromo"></span></p>
                                    <hr>
                                    <h6>Detail</h6>
                                    <ul id="modalDetails" class="list-group"></ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        layout_change('light');
        font_change('Roboto');
        change_box_container('false');
        layout_caption_change('true');
        layout_rtl_change('false');
        preset_change('preset-1');

        // AJAX filter/sort/search
        function applyFilterSortSearch() {
            let category = $('#filterCategory').val();
            let sort = $('#sortBy').val();
            let search = $('#searchInput').val();

            $.ajax({
                url: "{{ route('treatment.filter') }}",
                type: "GET",
                data: { category: category, sort: sort, search: search },
                success: function (response) {
                    $('table tbody').html(response);
                }
            });
        }

        $('#filterCategory, #sortBy').change(applyFilterSortSearch);
        $('#searchInput').on('keyup', function (e) {
            if (e.keyCode === 13) applyFilterSortSearch();
        });

        // Modal detail treatment (delegated event)
        $(document).on('click', '.view-detail', function () {

            let row = $(this).closest('tr');

            let details = row.data('details');
            

            $('#popupName').text(row.data('name'));
            $('#popupCategory').text(row.data('category'));
            $('#popupPromo').text(row.data('promo'));
            let image = row.data('image');

if (image) {
    $('#popupImage').attr('src', 'https://YOUR-PROJECT.supabase.co/storage/v1/object/public/treatments/' + image);
} else {
    $('#popupImage').attr('src', '/assets/images/no-image.jpg');
}

            let html = '';

            details.forEach(function (d) {
                html += `
                                <li>
                                    <b>${d.name}</b><br>
                                    Durasi : ${d.duration} menit<br>
                                    Harga : Rp${d.price}<br>
                                    ${d.description ?? ''}
                                </li>`;
            });

            $('#popupDetails').html(html);

            $('#detailPopup').fadeIn();
        });

        $('.popup-close').click(function () {
            $('#detailPopup').fadeOut();
        });
        $('#detailPopup').click(function (e) {
            if (e.target.id === 'detailPopup') {
                $(this).fadeOut();
            }
        });
    </script>
@endsection
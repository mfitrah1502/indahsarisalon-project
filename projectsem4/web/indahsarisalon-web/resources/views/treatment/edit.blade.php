@extends('layout.dashboard')

@section('title', 'Edit Treatment')
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

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Treatment</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('treatment.update', $treatment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label>Nama Treatment</label>
                            <input type="text" name="name" class="form-control" value="{{ $treatment->name }}" required>
                        </div>
                        <label>Kategori</label>
                        <select name="category_id" class="form-control">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ isset($treatment) && $treatment->category_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>

                        <label>Atau Tambah Kategori Baru</label>
                        <input type="text" name="category" class="form-control" placeholder="Masukkan kategori baru">

                        <div class="mb-3">
                            <label>Promo Treatment</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_promo" name="is_promo" value="1" {{ $treatment->is_promo ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_promo">Aktifkan Promo</label>
                            </div>
                        </div>

                        <div class="mb-3" id="promo_fields" style="display: {{ $treatment->is_promo ? 'block' : 'none' }};">
                            <label>Jenis Potongan</label>
                            <select name="promo_type" class="form-control">
                                <option value="percent" {{ $treatment->promo_type == 'percent' ? 'selected' : '' }}>Persen (%)
                                </option>
                                <option value="fixed" {{ $treatment->promo_type == 'fixed' ? 'selected' : '' }}>Nominal
                                </option>
                            </select>
                            <label>Nilai Potongan</label>
                            <input type="number" name="promo_value" class="form-control" placeholder="Masukkan potongan"
                                value="{{ $treatment->promo_value }}">
                        </div>

                        <hr>
                        <h5>Detail Treatment</h5>
                        <div id="details_wrapper">
                            @foreach($treatment->details as $index => $detail)
                                <div class="detail_item mb-3">
                                    <input type="text" name="details[{{ $index }}][name]" class="form-control mb-1"
                                        placeholder="Nama Detail" value="{{ $detail->name }}" required>
                                    <input type="number" name="details[{{ $index }}][duration]" class="form-control mb-1"
                                        placeholder="Durasi (menit)" value="{{ $detail->duration }}" required>
                                    <input type="number" name="details[{{ $index }}][price]" class="form-control mb-1"
                                        placeholder="Harga" value="{{ $detail->price }}" required>
                                    <textarea name="details[{{ $index }}][description]" class="form-control"
                                        placeholder="Deskripsi">{{ $detail->description }}</textarea>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add_detail" class="btn btn-secondary mb-3">Tambah Detail</button>

                        <button type="submit" class="btn btn-primary">Update Treatment</button>
                    </form>
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

        $('#is_promo').change(function () {
            if ($(this).is(':checked')) {
                $('#promo_fields').show();
            } else {
                $('#promo_fields').hide();
            }
        });

        let detail_index = {{ $treatment->details->count() }};
        $('#add_detail').click(function () {
            let html = `<div class="detail_item mb-3">
                                                <input type="text" name="details[${detail_index}][name]" class="form-control mb-1" placeholder="Nama Detail" required>
                                                <input type="number" name="details[${detail_index}][duration]" class="form-control mb-1" placeholder="Durasi (menit)" required>
                                                <input type="number" name="details[${detail_index}][price]" class="form-control mb-1" placeholder="Harga" required>
                                                <textarea name="details[${detail_index}][description]" class="form-control" placeholder="Deskripsi"></textarea>
                                            </div>`;
            $('#details_wrapper').append(html);
            detail_index++;
        });
    </script>
@endsection
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{
    public function index()
    {
        // $produks = collect([
        //     (object)[
        //         'id' => 1,
        //         'nama' => 'CreamBath Refresh',
        //         'harga' => 15000,
        //         'stok' => 10
        //     ],
        //     (object)[
        //         'id' => 2,
        //         'nama' => 'Conditioner Premium',
        //         'harga' => 25000,
        //         'stok' => 5
        //     ],
        //     (object)[
        //         'id' => 3,
        //         'nama' => 'Hair Mask Premium',
        //         'harga' => 48000,
        //         'stok' => 8
        //     ],
        // ]);
        $produks = Produk::all(); // ambil semua data dari tabel 'produks'

        return view('produk.index', compact('produks'));
    }
}
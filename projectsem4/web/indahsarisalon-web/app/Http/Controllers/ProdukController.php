<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = collect([
            (object)[
                'id' => 1,
                'nama' => 'Shampoo Herbal',
                'harga' => 25000,
                'stok' => 10
            ],
            (object)[
                'id' => 2,
                'nama' => 'Conditioner Smooth',
                'harga' => 30000,
                'stok' => 5
            ],
            (object)[
                'id' => 3,
                'nama' => 'Hair Mask',
                'harga' => 40000,
                'stok' => 8
            ],
        ]);

        return view('produk.index', compact('produks'));
    }
}
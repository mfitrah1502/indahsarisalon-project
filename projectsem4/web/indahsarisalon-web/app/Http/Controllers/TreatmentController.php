<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Treatment; // Model utama treatment
use App\Models\TreatmentDetail; // Detail treatment
use App\Models\Category; // Opsional jika kategori dibuat terpisah
use Illuminate\Support\Facades\DB;

class TreatmentController extends Controller
{
    // Menampilkan daftar treatment dengan filter, search, dan sort
    public function index(Request $request)
    {
        $query = Treatment::with('details'); // eager load detail

        // Filter kategori
        if($request->category) {
            $query->where('category', $request->category);
        }

        // Search nama
        if($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        // Sort
        if($request->sort) {
            switch($request->sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'price_asc':
                    $query->withMin('details', 'price')->orderBy('details_min_price', 'asc');
                    break;
                case 'price_desc':
                    $query->withMin('details', 'price')->orderBy('details_min_price', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $treatments = $query->paginate(10);

        // Jika kategori disimpan sebagai array di controller
        $categories = Treatment::pluck('category')->unique();
        $treatments->transform(function($treatment) {
    $treatment->details_for_modal = $treatment->details->map(function($d){
        return [
            'name' => $d->name,
            'duration' => $d->duration,
            'price' => $d->price,
            'description' => $d->description
        ];
    });
    return $treatment;
});

        return view('treatment.index', compact('treatments', 'categories'));
    }

    // Menampilkan form tambah treatment
    public function create()
    {
        $categories = Category::all();
        return view('treatment.create', compact('categories'));
    }

    // Menyimpan treatment baru
    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string',   // wajib ada input category di form
        'details.*.name' => 'required|string',
        'details.*.duration' => 'required|integer',
        'details.*.price' => 'required|numeric',
        'promo_type' => 'nullable|string',
        'promo_value' => 'nullable|numeric',
    ]);

    // Simpan treatment
    $treatment = new Treatment();
    $treatment->name = $request->name;
    $treatment->category = $request->category ?? 'Uncategorized';
    $treatment->is_promo = $request->has('is_promo') ? 1 : 0;
    $treatment->promo_type = $request->promo_type;
    $treatment->promo_value = $request->promo_value;
    $treatment->save();

    // Simpan detail treatment
    foreach ($request->details as $detail) {
        $treatment->details()->create([
            'name' => $detail['name'],
            'duration' => $detail['duration'],
            'price' => $detail['price'],
            'description' => $detail['description'] ?? null,
        ]);

    }

    return redirect()->route('treatment.index')->with('success','Treatment berhasil ditambahkan');
}

    // Menampilkan form edit
    public function edit(Treatment $treatment)
    {
        $categories = Category::all();
        return view('treatment.edit', compact('treatment','categories'));
    }

    // Update treatment
    public function update(Request $request, Treatment $treatment)
    {
        // Update treatment utama
        $treatment->name = $request->name;
        $treatment->category = $request->category ?? 'Uncategorized';
        $treatment->is_promo = $request->has('is_promo') ? 1 : 0;
        $treatment->promo_type = $request->promo_type;
        $treatment->promo_value = $request->promo_value;
        $treatment->save();

        // Hapus detail lama
        $treatment->details()->delete();

        // Simpan detail baru
        foreach ($request->details as $detail) {
            $treatment->details()->create([
                'name' => $detail['name'],
                'duration' => $detail['duration'],
                'price' => $detail['price'],
                'description' => $detail['description'] ?? null,
            ]);
        }

        // Redirect ke index dengan pesan sukses
        return redirect()->route('treatment.index')
                         ->with('success', 'Treatment berhasil diperbarui!');
    }

    // Hapus treatment
    public function destroy(Treatment $treatment)
    {
        $treatment->delete();
        return redirect()->route('treatment.index')->with('success','Treatment berhasil dihapus');
    }
    // app/Http/Controllers/TreatmentController.php

public function filter(Request $request)
{
    $query = Treatment::with('details');

    if ($request->category) {
        $query->where('category', $request->category);
    }

    if ($request->search) {
        $query->where('name', 'like', "%{$request->search}%");
    }

    if ($request->sort) {
        switch ($request->sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price_asc':
                $query->withMin('details', 'price')->orderBy('details_min_price', 'asc');
                break;
            case 'price_desc':
                $query->withMin('details', 'price')->orderBy('details_min_price', 'desc');
                break;
        }
    } else {
        $query->orderBy('created_at', 'desc');
    }

    $treatments = $query->get(); // note: jangan paginate karena kita load via AJAX

    return view('treatment.table', compact('treatments'));}
}
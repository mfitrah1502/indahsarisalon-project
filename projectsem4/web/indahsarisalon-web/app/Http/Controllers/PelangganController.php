<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'pelanggan');

        // fitur search
        if($request->has('search') && $request->search != ''){
            $query->where(function($q) use ($request){
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('username', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $pelanggans = $query->get();

        return view('pelanggan.index', compact('pelanggans'));
    }

    public function show($id)
    {
        $pelanggan = User::where('role','pelanggan')->findOrFail($id);

        return view('pelanggan.show', compact('pelanggan'));
    }

    public function destroy(User $pelanggan)
    {
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')
            ->with('success','Pelanggan berhasil dihapus');
    }
}
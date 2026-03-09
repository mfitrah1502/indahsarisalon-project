<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {

        $query = User::whereIn('role', ['admin', 'kasir']); // ambil admin & kasir


        // Jika ada pencarian
        if($request->has('search') && $request->search != ''){
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('username', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $karyawans = $query->get();

        return view('karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        return view('karyawan.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|unique:users',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6',
        'role' => 'required|in:admin,kasir', 
    ]);

    User::create([
        'name' => $request->name,
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,       // simpan role dari form
        'status' => $request->status ?? 'aktif',
    ]);

    return redirect()->route('karyawan.index')->with('success','Karyawan berhasil ditambahkan');
}

    public function edit(User $karyawan)
    {
        return view('karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, User $karyawan)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|unique:users,username,'.$karyawan->id,
        'email' => 'required|email|unique:users,email,'.$karyawan->id,
        'role' => 'required|in:admin,kasir', // validasi role
    ]);

    $karyawan->update([
        'name' => $request->name,
        'username' => $request->username,
        'email' => $request->email,
        'role' => $request->role,       // update role
        'status' => $request->status ?? 'aktif',
    ]);

    return redirect()->route('karyawan.index')->with('success','Karyawan berhasil diupdate');
}

    public function destroy(User $karyawan)
    {
        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success','Karyawan berhasil dihapus');
    }
    public function absensi($id)
{
    $karyawan = User::findOrFail($id);
    $absensi = $karyawan->absensi()->orderBy('tanggal', 'desc')->get(); // ambil absensi

    return response()->json($absensi); // wajib pakai JSON agar AJAX bisa menampilkan modal
}
}
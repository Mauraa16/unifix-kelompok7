<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PetugasController extends Controller
{
    /**
     * Menampilkan daftar semua petugas.
     */
    public function index()
    {
        $petugas = User::where('role', 'petugas')->latest()->paginate(10);
        return view('admin.petugas.index', compact('petugas'));
    }

    /**
     * Menampilkan form tambah petugas.
     */
    public function create()
    {
        return view('admin.petugas.create');
    }

    /**
     * Menyimpan petugas baru (role di-force 'petugas').
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'petugas', // <-- PERUBAHAN: Role di-set otomatis
        ]);

        return redirect()->route('petugas.index')
                         ->with('success', 'Akun petugas berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit petugas.
     */
    public function edit(User $petuga) // Nama parameter: petuga
    {
        // Pastikan kita hanya mengedit petugas
        if ($petuga->role !== 'petugas') {
            return redirect()->route('petugas.index')->with('error', 'User ini bukan petugas.');
        }
        return view('admin.petugas.edit', compact('petuga'));
    }

    /**
     * Update data petugas (role tidak bisa diubah).
     */
    public function update(Request $request, User $petuga)
    {
        // Pastikan kita hanya mengupdate petugas
        if ($petuga->role !== 'petugas') {
            return redirect()->route('petugas.index')->with('error', 'User ini bukan petugas.');
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.',email,'.$petuga->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()], // Password boleh kosong
        ]);

        $petuga->name = $request->name;
        $petuga->email = $request->email;

        if ($request->filled('password')) {
            $petuga->password = Hash::make($request->password);
        }

        $petuga->save();

        return redirect()->route('petugas.index')
                         ->with('success', 'Akun petugas berhasil diperbarui.');
    }

    /**
     * Hapus petugas.
     */
    public function destroy(User $petuga)
    {
        // Pastikan kita hanya menghapus petugas
        if ($petuga->role !== 'petugas') {
            return redirect()->route('petugas.index')->with('error', 'User ini bukan petugas.');
        }

        $petuga->delete();
        
        return redirect()->route('petugas.index')
                         ->with('success', 'Akun petugas berhasil dihapus.');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class MahasiswaController extends Controller
{
    /**
     * Menampilkan daftar mahasiswa.
     */
    public function index()
    {
        // Ambil data HANYA mahasiswa, urutkan dari terbaru, 10 data per halaman
        $mahasiswa = User::where('role', 'mahasiswa')
                         ->latest()
                         ->paginate(10);

        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    /**
     * Menampilkan form tambah mahasiswa.
     */
    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    /**
     * Menyimpan mahasiswa baru ke database.
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
            'role' => 'mahasiswa', // Otomatis set sebagai mahasiswa
        ]);

        return redirect()->route('mahasiswa.index')
                         ->with('success', 'Akun mahasiswa berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit mahasiswa.
     */
    public function edit(User $mahasiswa)
    {
        // Pastikan kita hanya mengedit mahasiswa
        if ($mahasiswa->role !== 'mahasiswa') {
            return redirect()->route('mahasiswa.index')->with('error', 'User bukan mahasiswa.');
        }
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    /**
     * Update data mahasiswa di database.
     */
    public function update(Request $request, User $mahasiswa)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Cek email unik, tapi abaikan jika email itu miliknya sendiri
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.',email,'.$mahasiswa->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()], // Password boleh kosong
        ]);

        // Update data
        $mahasiswa->name = $request->name;
        $mahasiswa->email = $request->email;

        // Cek jika admin mengisi password baru
        if ($request->filled('password')) {
            $mahasiswa->password = Hash::make($request->password);
        }

        $mahasiswa->save();

        return redirect()->route('mahasiswa.index')
                         ->with('success', 'Akun mahasiswa berhasil diperbarui.');
    }

    /**
     * Hapus mahasiswa dari database.
     */
    public function destroy(User $mahasiswa)
    {
        // Pastikan kita hanya menghapus mahasiswa
        if ($mahasiswa->role !== 'mahasiswa') {
            return redirect()->route('mahasiswa.index')->with('error', 'User bukan mahasiswa.');
        }

        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')
                         ->with('success', 'Akun mahasiswa berhasil dihapus.');
    }
}
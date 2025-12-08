<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class MahasiswaController extends Controller
{
    public function index(Request $request) 
    {
        $search = $request->input('search');

        $query = User::where('role', 'mahasiswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $mahasiswa = $query->latest()->paginate(10);

        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        return view('admin.mahasiswa.create');
    }

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
            'role' => 'mahasiswa', 
        ]); 

        return redirect()->route('mahasiswa.index')
                         ->with('success', 'Akun mahasiswa berhasil ditambahkan.');
    }

    public function edit(User $mahasiswa)
    {
        if ($mahasiswa->role !== 'mahasiswa') {
            return redirect()->route('mahasiswa.index')->with('error', 'User bukan mahasiswa.');
        }
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, User $mahasiswa)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.',email,'.$mahasiswa->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()], 
        ]);

        $mahasiswa->name = $request->name;
        $mahasiswa->email = $request->email;

        if ($request->filled('password')) {
            $mahasiswa->password = Hash::make($request->password);
        }

        $mahasiswa->save();

        return redirect()->route('mahasiswa.index')
                         ->with('success', 'Akun mahasiswa berhasil diperbarui.');
    }

    public function destroy(User $mahasiswa)
    {
        if ($mahasiswa->role !== 'mahasiswa') {
            return redirect()->route('mahasiswa.index')->with('error', 'User bukan mahasiswa.');
        }

        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')
                         ->with('success', 'Akun mahasiswa berhasil dihapus.');
    }
}
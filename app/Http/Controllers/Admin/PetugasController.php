<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PetugasController extends Controller
{
    public function index(Request $request)
{
    $search = $request->query('search');
    $query = User::where('role', 'petugas'); 
    if ($search) {
        $search_lower = strtolower($search);
        $query->where(function ($q) use ($search_lower) {
            $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search_lower . '%'])
              ->orWhereRaw('LOWER(email) LIKE ?', ['%' . $search_lower . '%']);
        });
    }
    $petugas = $query->latest()->paginate(10);
    return view('admin.petugas.index', compact('petugas'));
}
    
    public function create()
    {
        return view('admin.petugas.create');
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
            'role' => 'petugas', 
        ]);

        return redirect()->route('petugas.index')
                            ->with('success', 'Akun petugas berhasil ditambahkan.');
    }

    public function edit(User $petuga)
    {

        if ($petuga->role !== 'petugas') {
            return redirect()->route('petugas.index')->with('error', 'User ini bukan petugas.');
        }
        return view('admin.petugas.edit', compact('petuga'));
    }

    public function update(Request $request, User $petuga)
    {

        if ($petuga->role !== 'petugas') {
            return redirect()->route('petugas.index')->with('error', 'User ini bukan petugas.');
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.',email,'.$petuga->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()], 
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

    public function destroy(User $petuga)
    {
        if ($petuga->role !== 'petugas') {
            return redirect()->route('petugas.index')->with('error', 'User ini bukan petugas.');
        }

        $petuga->delete();
        
        return redirect()->route('petugas.index')
                            ->with('success', 'Akun petugas berhasil dihapus.');
    }
}
<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Exception;
use App\Models\Laporan;
use App\Models\Komentar;
use Illuminate\Validation\ValidationException; 

class ProfilPetugasController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:petugas']);
    }

    public function show()
    {
        $user = Auth::user();

        $totalLaporanDitangani = Laporan::whereHas('komentar', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();

        $totalKomentar = Komentar::where('user_id', $user->id)->count();

        return view('petugas.profil.index', compact('user', 'totalLaporanDitangani', 'totalKomentar'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }


    public function updatePhoto(Request $request) 
    {
        $user = Auth::user();

        $request->validate([
            'profile_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'], // Tambah webp untuk jaga-jaga
        ], [
            'profile_photo.max' => 'Ukuran foto profil maksimal 2MB.',
            'profile_photo.mimes' => 'Format gambar yang didukung adalah JPEG, PNG, JPG, GIF, atau WEBP.',
            'profile_photo.required' => 'Mohon pilih file gambar untuk diunggah.',
        ]);

        try {
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            
            $user->foto_profil = $path;
            $user->save();

            return redirect()->back()->with('success', 'Foto profil berhasil diunggah!');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } 
        catch (Exception $e) {
            \Log::error("Gagal upload foto profil petugas (ID: {$user->id}): " . $e->getMessage());
            return redirect()->back()->withErrors(['profile_photo' => 'Gagal mengunggah foto. Silakan coba lagi.'])->withInput();
        }
    }

    public function deletePhoto()
    {
        $user = Auth::user();

        if (!$user->foto_profil) {
            return response()->json(['error' => 'Anda tidak memiliki foto profil untuk dihapus.'], 400);
        }

        try {
            $oldFilePath = $user->foto_profil;
            if (Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
            }

            $user->foto_profil = null;
            $user->save();

            return redirect()->back()->with('success', 'Foto profil berhasil dihapus.');

        } catch (Exception $e) {
            \Log::error("Gagal menghapus foto profil petugas (ID: {$user->id}): " . $e->getMessage());

            return redirect()->back()->with('error', 'Gagal menghapus foto. Silakan coba lagi.');
        }
    }
}
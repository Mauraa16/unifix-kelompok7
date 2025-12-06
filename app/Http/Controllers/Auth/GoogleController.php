<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    // 1. Arahkan user ke halaman login Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Handle callback (data balikan) dari Google
    public function handleGoogleCallback()
    {
        try {
            // Ambil data user dari Google
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah user sudah ada berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if ($user) {
                // Jika user sudah ada, update google_id jika belum ada (untuk merging akun)
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                }
                
                // Login user tersebut
                Auth::login($user);
                
                // Redirect sesuai role (mirip logika di LoginController/HomeController)
                return $this->redirectUser($user);
            
            } else {
                // Jika user belum ada, buat user baru
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'role' => 'mahasiswa', // Default role saat daftar via Google
                    'password' => bcrypt(Str::random(16)), // Password acak aman
                    'email_verified_at' => now(), // Otomatis verifikasi email karena dari Google
                ]);

                Auth::login($newUser);
                
                return $this->redirectUser($newUser);
            }

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login dengan Google.');
        }
    }

    // Helper untuk redirect setelah login
    protected function redirectUser($user)
    {
        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role == 'petugas') {
            return redirect()->route('petugas.dashboard.index');
        } else {
            return redirect()->route('mahasiswa.beranda');
        }
    }
}
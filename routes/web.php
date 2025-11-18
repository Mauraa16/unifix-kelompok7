<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// Import Controller agar tidak error
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\PetugasController; // <-- PERBAIKAN 1: Tambahkan ini
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root ke login
Route::redirect('/', '/login');

// Routes Auth bawaan Laravel
Auth::routes();

// ====================================================================
// RUTE UTAMA (PENJAGA GERBANG)
// ====================================================================
// Ini akan mengecek role dan melempar user ke dashboard yang sesuai
Route::get('/home', [HomeController::class, 'index'])->name('home');


// ====================================================================
// RUTE KHUSUS MAHASISWA
// ====================================================================
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->group(function () {
    
    // Beranda Mahasiswa (Memanggil fungsi mahasiswaBeranda di HomeController)
    Route::get('/beranda', [HomeController::class, 'mahasiswaBeranda'])->name('mahasiswa.beranda');
    
    // CRUD Laporan
    Route::resource('laporan', LaporanController::class);
});


// ====================================================================
// RUTE KHUSUS PETUGAS
// ====================================================================
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->group(function () {
    
    // Dashboard Petugas (Memanggil fungsi petugasDashboard di HomeController)
    Route::get('/dashboard', [HomeController::class, 'petugasDashboard'])->name('petugas.dashboard');
});


// ====================================================================
// RUTE KHUSUS ADMIN
// ====================================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    
    // Dashboard Admin (PENTING: Panggil via Controller agar data statistik muncul)
    Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');
    
    // CRUD Kelola Mahasiswa 
    Route::resource('mahasiswa', MahasiswaController::class);

    // PERBAIKAN 2: Tambahkan rute resource untuk Petugas
    Route::resource('petugas', PetugasController::class);
});


// ====================================================================
// RUTE LAINNYA
// ====================================================================
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');
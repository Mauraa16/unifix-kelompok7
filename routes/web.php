<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- IMPORT SEMUA CONTROLLER ---
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LaporanController; // Untuk Mahasiswa
use App\Http\Controllers\Admin\MahasiswaController; // Untuk Admin
use App\Http\Controllers\Admin\PetugasController; // Untuk Admin
use App\Http\Controllers\Admin\KelolaLaporanController; // Untuk Admin & Petugas

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
Route::get('/home', [HomeController::class, 'index'])->name('home');


// ====================================================================
// RUTE KHUSUS MAHASISWA (role:mahasiswa)
// ====================================================================
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->group(function () {
    
    // Beranda Mahasiswa
    Route::get('/beranda', [HomeController::class, 'mahasiswaBeranda'])->name('mahasiswa.beranda');
    
    // CRUD Laporan (Laporan saya sendiri)
    Route::resource('laporan', LaporanController::class);
});



// ====================================================================
// RUTE KHUSUS PETUGAS (role:petugas)
// ====================================================================
Route::middleware(['auth', 'role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

    /* ===========================
       DASHBOARD PETUGAS
    ============================ */
    Route::get('/dashboard', [HomeController::class, 'petugasDashboard'])
        ->name('dashboard.index'); 
    // view: petugas/dashboard/index.blade.php


    /* ===========================
       LAPORAN
    ============================ */
    Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('laporan.index'); 
    // view: petugas/laporan/index.blade.php

    Route::get('/laporan/{laporan}', [LaporanController::class, 'show'])
        ->whereNumber('laporan')
        ->name('laporan.show');
    // view: petugas/laporan/show.blade.php

    Route::put('/laporan/{laporan}/status', [LaporanController::class, 'updateStatus'])
        ->whereNumber('laporan')
        ->name('laporan.updateStatus');

    Route::post('/laporan/{laporan}/komentar', [LaporanController::class, 'storeKomentar'])
        ->whereNumber('laporan')
        ->name('laporan.storeKomentar');


    /* ===========================
       FILTER STATUS
    ============================ */
    Route::get('/laporan/status/belum-diproses', [LaporanController::class, 'filterBelumDiproses'])
        ->name('laporan.belum');

    Route::get('/laporan/status/diproses', [LaporanController::class, 'filterDiproses'])
        ->name('laporan.proses');

    Route::get('/laporan/status/selesai', [LaporanController::class, 'filterSelesai'])
        ->name('laporan.selesai');


    /* ===========================
       RIWAYAT PETUGAS
    ============================ */
    Route::get('/riwayat', [LaporanController::class, 'riwayat'])
        ->name('riwayat');
    // view: petugas/riwayat/index.blade.php


    /* ===========================
       PROFIL PETUGAS
    ============================ */
    Route::get('/profil', [ProfilPetugasController::class, 'show'])
        ->name('profil');
    // view: petugas/profil/index.blade.php

    Route::put('/profil/update', [ProfilPetugasController::class, 'update'])
        ->name('profil.update');
});



// ====================================================================
// RUTE KHUSUS ADMIN (role:admin)
// ====================================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');
    
    // CRUD Kelola Akun Mahasiswa
    Route::resource('mahasiswa', MahasiswaController::class);
    
    // CRUD Kelola Akun Petugas
    Route::resource('petugas', PetugasController::class);

    // Fitur Kelola Laporan (Lengkap)
    Route::get('laporan', [KelolaLaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('laporan/{laporan}', [KelolaLaporanController::class, 'show'])->name('admin.laporan.show');
    Route::put('laporan/{laporan}/status', [KelolaLaporanController::class, 'updateStatus'])->name('admin.laporan.updateStatus');
    Route::post('laporan/{laporan}/komentar', [KelolaLaporanController::class, 'storeKomentar'])->name('admin.laporan.storeKomentar');
    Route::delete('laporan/{laporan}', [KelolaLaporanController::class, 'destroy'])->name('admin.laporan.destroy');

    // --- PERBAIKAN: 2 RUTE YANG HILANG DITAMBAHKAN DI SINI ---
    Route::get('laporan/{laporan}/edit', [KelolaLaporanController::class, 'edit'])->name('admin.laporan.edit');
    Route::put('laporan/{laporan}', [KelolaLaporanController::class, 'update'])->name('admin.laporan.update');
});


// ====================================================================
// RUTE LAINNYA (PUBLIK)
// ====================================================================
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');
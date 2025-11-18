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
use App\Http\Controllers\Petugas\ProfilPetugasController; //untuk petugas
use App\Http\Controllers\Petugas\PetugasLaporanController; //untuk petugas

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




Route::middleware(['auth', 'role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

        Route::get('/dashboard', [HomeController::class, 'petugasDashboard'])
            ->name('dashboard.index');

        // LAPORAN
        Route::get('/laporan', [PetugasLaporanController::class, 'index'])
            ->name('laporan.index');

        Route::get('/laporan/{laporan}', [PetugasLaporanController::class, 'show'])
            ->name('laporan.show');

        Route::put('/laporan/{laporan}/status', [PetugasLaporanController::class, 'updateStatus'])
            ->name('laporan.updateStatus');

        Route::post('/laporan/{laporan}/komentar', [PetugasLaporanController::class, 'storeKomentar'])
            ->name('laporan.storeKomentar');

        // FILTER STATUS
        Route::get('/laporan/status/belum-diproses', [PetugasLaporanController::class, 'filterBelum'])
            ->name('laporan.belum');

        Route::get('/laporan/status/diproses', [PetugasLaporanController::class, 'filterDiproses'])
            ->name('laporan.proses');

        Route::get('/laporan/status/selesai', [PetugasLaporanController::class, 'filterSelesai'])
            ->name('laporan.selesai');

        // RIWAYAT
        Route::get('/riwayat', [PetugasLaporanController::class, 'riwayat'])
            ->name('riwayat');

        // PROFIL PETUGAS
        Route::get('/profil', [ProfilPetugasController::class, 'show'])
            ->name('profil');

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
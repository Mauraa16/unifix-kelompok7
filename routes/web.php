<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController; 
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LaporanController; 
use App\Http\Controllers\Admin\MahasiswaController; 
use App\Http\Controllers\Admin\PetugasController; 
use App\Http\Controllers\Admin\KelolaLaporanController; 
use App\Http\Controllers\Petugas\ProfilPetugasController; 
use App\Http\Controllers\Petugas\PetugasLaporanController; 
use App\Http\Controllers\Admin\ProfilAdminController; 
use App\Http\Controllers\ProfilMahasiswaController;

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

    Route::get('/profil', [ProfilMahasiswaController::class, 'show'])->name('mahasiswa.profil');
    Route::put('/profil', [ProfilMahasiswaController::class, 'update'])->name('mahasiswa.profil.update');
});


// ====================================================================
// RUTE KHUSUS PETUGAS (role:petugas)
// ====================================================================
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
        Route::get('/laporan/status/belum-diproses', [PetugasLaporanController::class, 'filterBelumDiproses'])
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

    // Fitur Kelola Laporan (HANYA VIEW & KOMENTAR)
    Route::get('laporan', [KelolaLaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('laporan/{laporan}', [KelolaLaporanController::class, 'show'])->name('admin.laporan.show');
    Route::post('laporan/{laporan}/komentar', [KelolaLaporanController::class, 'storeKomentar'])->name('admin.laporan.storeKomentar');
    
    Route::get('/profil', [ProfilAdminController::class, 'show'])->name('admin.profil');
    Route::put('/profil', [ProfilAdminController::class, 'update'])->name('admin.profil.update');
    // Catatan: Route edit, update, destroy untuk laporan sudah dihapus agar admin tidak bisa mengubah data.

});


// ====================================================================
// RUTE LAINNYA (PUBLIK)
// ====================================================================
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');
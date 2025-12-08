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
use App\Http\Controllers\Auth\GoogleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');

// Verifikasi Email
Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

// ====================================================================
// RUTE MAHASISWA
// ====================================================================
Route::middleware(['auth', 'verified', 'role:mahasiswa'])->prefix('mahasiswa')->group(function () {
    Route::get('/beranda', [HomeController::class, 'mahasiswaBeranda'])->name('mahasiswa.beranda');
    Route::resource('laporan', LaporanController::class);
    Route::get('/profil', [ProfilMahasiswaController::class, 'show'])->name('mahasiswa.profil');
    Route::put('/profil', [ProfilMahasiswaController::class, 'update'])->name('mahasiswa.profil.update');
    Route::delete('/profil/foto', [ProfilMahasiswaController::class, 'deletePhoto'])->name('mahasiswa.profil.delete_photo');
    Route::post('/profil/upload-photo', [ProfilMahasiswaController::class, 'uploadPhoto'])->name('mahasiswa.profil.upload_photo');
});

// ====================================================================
// RUTE PETUGAS
// ====================================================================
Route::middleware(['auth', 'verified', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'petugasDashboard'])->name('dashboard.index');
    Route::get('/laporan', [PetugasLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{laporan}', [PetugasLaporanController::class, 'show'])->name('laporan.show');
    Route::put('/laporan/{laporan}/status', [PetugasLaporanController::class, 'updateStatus'])->name('laporan.updateStatus');
    Route::post('/laporan/{laporan}/komentar', [PetugasLaporanController::class, 'storeKomentar'])->name('laporan.storeKomentar');
    Route::get('/laporan/status/belum-diproses', [PetugasLaporanController::class, 'filterBelumDiproses'])->name('laporan.belum');
    Route::get('/laporan/status/diproses', [PetugasLaporanController::class, 'filterDiproses'])->name('laporan.proses');
    Route::get('/laporan/status/selesai', [PetugasLaporanController::class, 'filterSelesai'])->name('laporan.selesai');
    Route::get('/riwayat', [PetugasLaporanController::class, 'riwayat'])->name('riwayat');
    Route::get('/profil', [ProfilPetugasController::class, 'show'])->name('profil');
    Route::put('/profil/update', [ProfilPetugasController::class, 'update'])->name('profil.update');
});

// ====================================================================
// RUTE ADMIN
// ====================================================================
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->group(function () {
    
    Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');
    
    Route::resource('mahasiswa', MahasiswaController::class)->except(['show']);
    Route::resource('petugas', PetugasController::class)->except(['show']);

    Route::get('laporan', [KelolaLaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('laporan/{laporan}', [KelolaLaporanController::class, 'show'])->name('admin.laporan.show');
    Route::post('laporan/{laporan}/komentar', [KelolaLaporanController::class, 'storeKomentar'])->name('admin.laporan.storeKomentar');

    Route::get('/profil', [ProfilAdminController::class, 'show'])->name('admin.profil');
    Route::put('/profil', [ProfilAdminController::class, 'update'])->name('admin.profil.update');
    Route::prefix('profil')->name('admin.profil.')->group(function () {
        Route::get('/', [ProfilAdminController::class, 'show'])->name('index'); 
        Route::put('/', [ProfilAdminController::class, 'update'])->name('update'); 
        Route::post('/upload-photo', [ProfilAdminController::class, 'uploadPhoto'])->name('upload_photo');
        Route::delete('/delete-photo', [ProfilAdminController::class, 'deletePhoto'])->name('delete_photo');
    });
}); 

// ====================================================================
// RUTE PUBLIK & AUTH (Harus di luar middleware auth)
// ====================================================================

// Route Google Login
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Route Kontak
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');
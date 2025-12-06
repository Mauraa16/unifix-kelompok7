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

Route::redirect('/', '/login');

// PERBAIKAN: Aktifkan verify => true untuk memunculkan rute verifikasi email
Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

// ====================================================================
// RUTE MAHASISWA
// ====================================================================
// PERBAIKAN: Tambahkan middleware 'verified'
Route::middleware(['auth', 'verified', 'role:mahasiswa'])->prefix('mahasiswa')->group(function () {
    Route::get('/beranda', [HomeController::class, 'mahasiswaBeranda'])->name('mahasiswa.beranda');
    Route::resource('laporan', LaporanController::class);
    Route::get('/profil', [ProfilMahasiswaController::class, 'show'])->name('mahasiswa.profil');
    Route::put('/profil', [ProfilMahasiswaController::class, 'update'])->name('mahasiswa.profil.update');
});

// ====================================================================
// RUTE PETUGAS
// ====================================================================
// PERBAIKAN: Tambahkan middleware 'verified'
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
// PERBAIKAN: Tambahkan middleware 'verified'
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->group(function () {
    
    Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');
    
    Route::resource('mahasiswa', MahasiswaController::class)->except(['show']);
    Route::resource('petugas', PetugasController::class)->except(['show']);

    // Laporan
    Route::get('laporan', [KelolaLaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('laporan/{laporan}', [KelolaLaporanController::class, 'show'])->name('admin.laporan.show');
    Route::post('laporan/{laporan}/komentar', [KelolaLaporanController::class, 'storeKomentar'])->name('admin.laporan.storeKomentar');
    
    // Profil Admin
    Route::get('/profil', [ProfilAdminController::class, 'show'])->name('admin.profil');
    Route::put('/profil', [ProfilAdminController::class, 'update'])->name('admin.profil.update');
});

// Route Publik
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');
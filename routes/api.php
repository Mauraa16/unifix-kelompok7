<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User; // Import Model User
use Illuminate\Support\Facades\Validator; // Import Facade Validator

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * API Validasi Akun
 * Endpoint: POST /api/validate-account
 * Body: { "email": "user@example.com" }
 */
Route::post('/validate-account', function (Request $request) {
    // 1. Validasi Input
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
    ]);

    // Jika validasi gagal (format email salah atau kosong)
    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Input tidak valid',
            'errors' => $validator->errors()
        ], 400);
    }

    // 2. Cek ke Database
    $user = User::where('email', $request->email)->first();

    if ($user) {
        // Jika akun ditemukan
        return response()->json([
            'status' => 'success',
            'exists' => true,
            'message' => 'Akun ditemukan.',
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role, // Mengembalikan role untuk info tambahan
            ]
        ], 200);
    } else {
        // Jika akun TIDAK ditemukan
        return response()->json([
            'status' => 'success', // Status request sukses, tapi user tidak ada
            'exists' => false,
            'message' => 'Akun tidak terdaftar.'
        ], 404);
    }
});
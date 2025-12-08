<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modifikasi tabel users yang sudah ada
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom 'foto_profil' sebagai string, boleh kosong (nullable)
            // Ditempatkan setelah kolom 'role' agar terstruktur
            $table->string('foto_profil')->nullable()->after('role'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom 'foto_profil' saat rollback
            $table->dropColumn('foto_profil');
        });
    }
};
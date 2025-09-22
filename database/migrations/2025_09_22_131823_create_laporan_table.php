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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // pelapor (mahasiswa)
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('lokasi');
            $table->string('foto')->nullable(); 
            $table->enum('status', ['Belum Diproses', 'Diproses', 'Selesai'])->default('Belum Diproses');
            $table->foreignId('kategori_id')->constrained('kategori_laporan');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};

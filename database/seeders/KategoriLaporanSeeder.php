<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriLaporan;

class KategoriLaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            ['nama_kategori' => 'Kerusakan Fasilitas'],
            ['nama_kategori' => 'Kebersihan'],
            ['nama_kategori' => 'Keamanan'],
            ['nama_kategori' => 'Infrastruktur'],
            ['nama_kategori' => 'Lainnya'],
        ];

        foreach ($kategori as $item) {
            KategoriLaporan::create($item);
        }
    }
}

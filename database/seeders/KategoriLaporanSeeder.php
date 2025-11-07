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
            // Fasilitas Utama
            ['nama_kategori' => 'Listrik & Elektronik'],
            ['nama_kategori' => 'AC & Pendingin'],
            ['nama_kategori' => 'Penerangan'],
            ['nama_kategori' => 'Plumbing & Air'],
            ['nama_kategori' => 'Toilet & Kamar Mandi'],

            // Bangunan & Struktur
            ['nama_kategori' => 'Dinding & Partisi'],
            ['nama_kategori' => 'Lantai & Karpet'],
            ['nama_kategori' => 'Atap & Ceiling'],
            ['nama_kategori' => 'Pintu & Jendela'],
            ['nama_kategori' => 'Lift & Elevator'],

            // Perabotan & Equipment
            ['nama_kategori' => 'Meja & Kursi'],
            ['nama_kategori' => 'Lemari & Rak'],
            ['nama_kategori' => 'Proyektor & AV'],
            ['nama_kategori' => 'Komputer & IT'],
            ['nama_kategori' => 'Laboratorium'],

            // Kebersihan & Lingkungan
            ['nama_kategori' => 'Kebersihan Ruangan'],
            ['nama_kategori' => 'Sampah & Limbah'],
            ['nama_kategori' => 'Taman & Lanskap'],
            ['nama_kategori' => 'Parkir & Area Luar'],

            // Keamanan & Safety
            ['nama_kategori' => 'Sistem Keamanan'],
            ['nama_kategori' => 'Penerangan Darurat'],
            ['nama_kategori' => 'APAR & Fire Safety'],
            ['nama_kategori' => 'Aksesibilitas'],
            ['nama_kategori' => 'Kesehatan & Sanitasi'],

            // Lainnya
            ['nama_kategori' => 'Gangguan Suara'],
            ['nama_kategori' => 'Hama & Pest'],
            ['nama_kategori' => 'Lainnya'],
        ];

        foreach ($kategori as $item) {
            KategoriLaporan::create($item);
        }
    }
}

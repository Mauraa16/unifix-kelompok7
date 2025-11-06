<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'lokasi',
        'foto',
        'status',
        'kategori_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriLaporan::class, 'kategori_id');
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class, 'laporan_id');
    }
}

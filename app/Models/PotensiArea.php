<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PotensiArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kategori',
        'deskripsi',
        'latitude', // Tambahkan kolom latitude
        'longitude', // Tambahkan kolom longitude
        'polygon', // Pastikan kolom ini ada di database
        'foto',    // Tambahkan kolom foto
        'titik_potensi',
    ];

    protected $casts = [
        'polygon' => 'array',
        'titik_potensi' => 'array',
    ];
}

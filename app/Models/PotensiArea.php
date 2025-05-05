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
        'foto',
        'polygon',
        'titik_potensi',
    ];

    protected $casts = [
        'polygon' => 'array',
        'titik_potensi' => 'array',
    ];
}

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
        'polygon', // Pastikan kolom ini ada di database
        'foto',    // Tambahkan kolom foto
    ];
}

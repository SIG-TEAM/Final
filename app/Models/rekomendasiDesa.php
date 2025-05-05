<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekomendasiDesa extends Model
{
    use HasFactory;

    protected $table = 'rekomendasi_desas';
    
    protected $fillable = [
        'nama_titik', 
        'deskripsi', 
        'jenis_potensi',    
        'gambar'
    ];
}

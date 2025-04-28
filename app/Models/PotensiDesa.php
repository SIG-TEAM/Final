<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PotensiDesa extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nama_potensi', 
        'kategori', 
        'deskripsi', 
        'detail',    
        'gambar'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori_potensi';
    protected $fillable = [
        'nama'
    ];

    public function potensi()
    {
        return $this->hasMany(PotensiDesa::class, 'kategori_id');
    }
}

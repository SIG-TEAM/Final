<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class kategoriPotensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::create([
            'nama' => 'Pertanian',
        ]);
        Kategori::create([
            'nama' => 'Peternakan',
        ]);
        Kategori::create([
            'nama' => 'Perkebunan',
        ]);
        Kategori::create([
            'nama' => 'Industri',
        ]);
        Kategori::create([
            'nama' => 'Pariwisata',
        ]);
    }
}

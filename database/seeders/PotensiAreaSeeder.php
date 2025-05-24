<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PotensiArea;

class PotensiAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PotensiArea::insert([
            [
                'nama' => 'Kebun Teh Cileunyi',
                'kategori' => 'Pertanian',
                'deskripsi' => 'Kebun teh luas dengan pemandangan indah dan udara sejuk.',
                'latitude' => -6.93000000,
                'longitude' => 107.72000000,
                'polygon' => json_encode([]),
                'foto' => null,
                'titik_potensi' => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Wisata Air Curug Cileunyi',
                'kategori' => 'Pariwisata',
                'deskripsi' => 'Air terjun alami yang menjadi destinasi wisata favorit keluarga.',
                'latitude' => -6.93500000,
                'longitude' => 107.72500000,
                'polygon' => json_encode([]),
                'foto' => null,
                'titik_potensi' => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Sentra UMKM Kerajinan Bambu',
                'kategori' => 'UMKM',
                'deskripsi' => 'Pusat kerajinan bambu yang memproduksi berbagai produk kreatif.',
                'latitude' => -6.94000000,
                'longitude' => 107.73000000,
                'polygon' => json_encode([]),
                'foto' => null,
                'titik_potensi' => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

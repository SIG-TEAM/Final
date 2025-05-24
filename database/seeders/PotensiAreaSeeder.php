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
                'foto' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80',
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
                'foto' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80',
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
                'foto' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80',
                'titik_potensi' => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Wisata Air Terjun',
                'kategori' => 'Wisata Alam',
                'deskripsi' => 'Air terjun alami dengan pemandangan indah dan udara sejuk.',
                'latitude' => -6.123456,
                'longitude' => 107.123456,
                'polygon' => null,
                'foto' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80',
                'titik_potensi' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Sentra Kerajinan Bambu',
                'kategori' => 'Ekonomi',
                'deskripsi' => 'Pusat kerajinan bambu yang menghasilkan berbagai produk unik.',
                'latitude' => -6.654321,
                'longitude' => 107.654321,
                'polygon' => null,
                'foto' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80',
                'titik_potensi' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

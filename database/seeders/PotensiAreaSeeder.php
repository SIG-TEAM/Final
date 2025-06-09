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
                'nama' => 'Kebun Teh Rancabali',
                'kategori' => 'Pertanian, Pariwisata',
                'deskripsi' => 'Hamparan perkebunan teh hijau yang membentang luas di perbukitan Ciwidey. Menawarkan pemandangan yang asri, udara sejuk, dan spot foto instagramable.',
                'latitude' => -7.129035,
                'longitude' => 107.382092,
                'polygon' => json_encode([]),
                'foto' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80',
                'titik_potensi' => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Pusat Peternakan Sapi Perah Ciwidey',
                'kategori' => 'Pertanian, Sumber Daya Alam',
                'deskripsi' => 'Sentra peternakan sapi perah yang berkontribusi besar pada produksi susu segar di Jawa Barat. Menunjukkan potensi SDM lokal dalam sektor peternakan.',
                'latitude' => -7.160000, // Koordinat perkiraan area peternakan
                'longitude' => 107.380000,
                'polygon' => json_encode([]),
                'foto' => 'https://images.unsplash.com/photo-1577907575646-993d5885c33a?auto=format&fit=crop&w=400&q=80',
                'titik_potensi' => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Perkebunan Strawberry Ciwidey',
                'kategori' => 'Pertanian, Pariwisata',
                'deskripsi' => 'Berbagai perkebunan strawberry yang tersebar di Ciwidey, menawarkan pengalaman memetik strawberry langsung dari pohonnya dan menikmati produk olahan strawberry.',
                'latitude' => -7.170000, // Koordinat perkiraan area perkebunan
                'longitude' => 107.390000,
                'polygon' => json_encode([]),
                'foto' => 'https://images.unsplash.com/photo-1588619623631-f18e9508544e?auto=format&fit=crop&w=400&q=80',
                'titik_potensi' => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'UMKM Kerajinan Bambu & Kayu Ciwidey',
                'kategori' => 'UMKM, Budaya',
                'deskripsi' => 'Berbagai usaha mikro, kecil, dan menengah (UMKM) yang berfokus pada kerajinan tangan dari bambu dan kayu, menunjukkan kreativitas dan keahlian SDM lokal.',
                'latitude' => -7.1125216883383375,
                'longitude' => 107.45712592438777,
                'polygon' => json_encode([]),
                'foto' => 'https://images.unsplash.com/photo-1582236577717-380d3674b971?auto=format&fit=crop&w=400&q=80',
                'titik_potensi' => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

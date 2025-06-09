<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Kategori;
use App\Models\PotensiDesa;
use App\Models\PotensiArea;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MapViewTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test viewing map with all potensi points
     *
     * @return void
     */
    public function testViewMapWithPotensiPoints()
    {
        // Create a category
        $kategori = Kategori::create([
            'nama' => 'Pertanian'
        ]);

        // Create some potensi desa points
        PotensiDesa::create([
            'kategori_id' => $kategori->id,
            'nama' => 'Sawah Padi',
            'deskripsi' => 'Sawah padi organik',
            'latitude' => -6.914744,
            'longitude' => 107.609810,
            'status' => 'verified'
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Peta Potensi')
                    ->waitFor('div.leaflet-container', 10) // Wait for map to load
                    ->assertPresent('div.leaflet-marker-icon'); // Check if markers are displayed
        });
    }

    /**
     * Test filtering potensi by category
     *
     * @return void
     */
    public function testFilterByCategory()
    {
        // Create multiple categories
        $kategori1 = Kategori::create(['nama' => 'Pertanian']);
        $kategori2 = Kategori::create(['nama' => 'Pariwisata']);
        
        // Create potensi desa in different categories
        PotensiDesa::create([
            'kategori_id' => $kategori1->id,
            'nama' => 'Sawah Padi',
            'deskripsi' => 'Sawah padi organik',
            'latitude' => -6.914744,
            'longitude' => 107.609810,
            'status' => 'verified'
        ]);

        PotensiDesa::create([
            'kategori_id' => $kategori2->id,
            'nama' => 'Wisata Air Terjun',
            'deskripsi' => 'Air terjun alami',
            'latitude' => -6.915744,
            'longitude' => 107.619810,
            'status' => 'verified'
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->waitFor('div.leaflet-container', 10) // Wait for map to load
                    ->assertPresent('div.leaflet-marker-icon')
                    
                    // Select just the Pertanian category (adjust based on your UI)
                    ->click('.category-filter') // Open category filter dropdown
                    ->check('input[value="Pertanian"]') // Check just Pertanian category
                    ->press('Terapkan Filter') // Apply the filter
                    
                    // Assert map updated with filtered markers
                    ->waitFor('div.leaflet-container', 10)
                    ->assertPresent('div.leaflet-marker-icon');
        });
    }

    /**
     * Test viewing potensi areas on map
     *
     * @return void
     */
    public function testViewPotensiAreas()
    {
        // Create a category
        $kategori = Kategori::create([
            'nama' => 'Perkebunan'
        ]);

        // Create potensi area (simplified - actual geo area would be more complex)
        PotensiArea::create([
            'kategori_id' => $kategori->id,
            'nama' => 'Area Perkebunan Teh',
            'deskripsi' => 'Perkebunan teh luas',
            'geojson' => '{"type":"Polygon","coordinates":[[[107.6,6.9],[107.7,6.9],[107.7,6.8],[107.6,6.8],[107.6,6.9]]]}',
            'status' => 'verified'
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->waitFor('div.leaflet-container', 10) // Wait for map to load
                    ->assertPresent('path.leaflet-interactive'); // Check polygon is rendered
        });
    }

    /**
     * Test toggling between point and area views
     *
     * @return void
     */
    public function testTogglePointAndAreaViews()
    {
        // Create categories
        $kategori = Kategori::create(['nama' => 'Pertanian']);
        
        // Create potensi desa and area
        PotensiDesa::create([
            'kategori_id' => $kategori->id,
            'nama' => 'Sawah Padi',
            'deskripsi' => 'Sawah padi organik',
            'latitude' => -6.914744,
            'longitude' => 107.609810,
            'status' => 'verified'
        ]);

        PotensiArea::create([
            'kategori_id' => $kategori->id,
            'nama' => 'Area Pertanian',
            'deskripsi' => 'Area pertanian luas',
            'geojson' => '{"type":"Polygon","coordinates":[[[107.6,6.9],[107.7,6.9],[107.7,6.8],[107.6,6.8],[107.6,6.9]]]}',
            'status' => 'verified'
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->waitFor('div.leaflet-container', 10) // Wait for map to load
                    
                    // Check initial state has markers
                    ->assertPresent('div.leaflet-marker-icon')
                    
                    // Toggle to show only areas (adjust selectors to your UI)
                    ->click('#show-areas-only')
                    ->waitUntilMissing('div.leaflet-marker-icon')
                    ->assertPresent('path.leaflet-interactive')
                    
                    // Toggle to show only points
                    ->click('#show-points-only')
                    ->assertPresent('div.leaflet-marker-icon')
                    ->waitUntilMissing('path.leaflet-interactive');
        });
    }
}

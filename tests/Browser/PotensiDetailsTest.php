<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Kategori;
use App\Models\PotensiDesa;
use App\Models\PotensiArea;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PotensiDetailsTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    protected $kategori;
    protected $potensiDesa;
    protected $potensiArea;

    /**
     * Setup test data
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a category
        $this->kategori = Kategori::create(['nama' => 'Pertanian']);
          // Create a potensi point
        $this->potensiDesa = PotensiDesa::create([
            'kategori' => $this->kategori->nama,
            'nama_potensi' => 'Sawah Padi Organik',
            'deskripsi' => 'Sawah padi dengan teknik organik',
            'detail' => 'Detail tentang sawah padi organik',
            'latitude' => -6.914744,
            'longitude' => 107.609810,
            'gambar' => null,
            'is_approved' => true
        ]);
        
        // Create a potensi area
        $this->potensiArea = PotensiArea::create([
            'kategori_id' => $this->kategori->id,
            'nama' => 'Kawasan Pertanian Terpadu',
            'deskripsi' => 'Kawasan pertanian modern dengan teknik irigasi terpadu',
            'alamat' => 'Desa Sukamaju',
            'kontak' => '08198765432',
            'geojson' => '{"type":"Polygon","coordinates":[[[107.6,6.9],[107.7,6.9],[107.7,6.8],[107.6,6.8],[107.6,6.9]]]}',
            'status' => 'verified'
        ]);
    }

    /**
     * Test viewing potensi point details
     *
     * @return void
     */
    public function testViewPotensiPointDetails()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->waitFor('div.leaflet-container', 10) // Wait for map to load
                    ->click('div.leaflet-marker-icon') // Click on a map marker
                    ->waitFor('.potensi-detail-popup') // Wait for the popup
                    ->assertSee('Sawah Padi Organik')
                    ->assertSee('Sawah padi dengan teknik organik')
                    
                    // Click on the detailed view button
                    ->click('.view-details-btn')
                    ->waitForRoute('potensi-desa.detail', ['id' => $this->potensiDesa->id])
                    
                    // Assert all details are visible
                    ->assertSee('Sawah Padi Organik')
                    ->assertSee('Sawah padi dengan teknik organik')
                    ->assertSee('Pertanian')
                    ->assertSee('Jl. Persawahan No. 10')
                    ->assertSee('08123456789');
        });
    }

    /**
     * Test viewing potensi area details
     *
     * @return void
     */
    public function testViewPotensiAreaDetails()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->waitFor('div.leaflet-container', 10) // Wait for map to load
                    ->click('path.leaflet-interactive') // Click on an area polygon
                    ->waitFor('.potensi-detail-popup') // Wait for the popup
                    ->assertSee('Kawasan Pertanian Terpadu')
                    
                    // Click on the detailed view button
                    ->click('.view-details-btn')
                    ->waitForRoute('potensi-area.detail', ['id' => $this->potensiArea->id])
                    
                    // Assert all details are visible
                    ->assertSee('Kawasan Pertanian Terpadu')
                    ->assertSee('Kawasan pertanian modern dengan teknik irigasi terpadu')
                    ->assertSee('Pertanian')
                    ->assertSee('Desa Sukamaju')
                    ->assertSee('08198765432');
        });
    }

    /**
     * Test sharing potensi details
     *
     * @return void
     */
    public function testSharePotensiDetails()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('potensi-desa.detail', ['id' => $this->potensiDesa->id]))
                    // Click share button (adjust selector based on your UI)
                    ->click('.share-button')
                    ->waitFor('.share-options')
                    // Assert share options are available
                    ->assertSee('Facebook')
                    ->assertSee('Twitter')
                    ->assertSee('WhatsApp');
        });
    }

    /**
     * Test filtering related potensi points
     *
     * @return void
     */
    public function testRelatedPotensiPoints()
    {
        // Create another potensi in the same category
        $relatedPotensi = PotensiDesa::create([
            'kategori_id' => $this->kategori->id,
            'nama' => 'Sawah Padi Modern',
            'deskripsi' => 'Sawah padi dengan teknologi modern',
            'latitude' => -6.924744,
            'longitude' => 107.619810,
            'status' => 'verified'
        ]);

        $this->browse(function (Browser $browser) use ($relatedPotensi) {
            $browser->visit(route('potensi-desa.detail', ['id' => $this->potensiDesa->id]))
                    // Scroll down to related section
                    ->scrollTo('.related-potensi')
                    // Assert that related potensi is shown
                    ->assertSee('Potensi Terkait')
                    ->assertSee('Sawah Padi Modern');
        });
    }
}

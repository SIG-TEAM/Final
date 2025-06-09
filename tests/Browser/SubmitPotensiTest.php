<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Kategori;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubmitPotensiTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    protected $user;
    
    /**
     * Setup test data
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Create categories
        Kategori::create(['nama' => 'Pertanian']);
        Kategori::create(['nama' => 'Pariwisata']);
        Kategori::create(['nama' => 'Peternakan']);
        
        // Create a penduduk user
        $this->user = User::factory()->create([
            'role' => 'penduduk',
            'email' => 'penduduk@example.com',
            'password' => bcrypt('password')
        ]);
    }
    
    /**
     * Test submitting a new potensi point
     *
     * @return void
     */
    public function testSubmitPotensiPoint()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/tambah-potensi')
                    ->assertSee('Tambah Potensi Desa')
                    
                    // Select Point type
                    ->select('type', 'point')
                    
                    // Fill the form
                    ->type('nama', 'Sawah Organik Penduduk')
                    ->select('kategori_id', '1') // Select Pertanian category
                    ->type('deskripsi', 'Ini adalah sawah organik milik saya')
                    ->type('alamat', 'Jl. Maju Bersama No. 5')
                    ->type('kontak', '081234567890')
                    
                    // Add latitude and longitude (simulating map click)
                    ->type('latitude', '-6.914744')
                    ->type('longitude', '107.609810')
                    
                    // Upload photo (simulated with a test file)
                    ->attach('photo', __DIR__.'/../../public/img/test-image.jpg')
                    
                    // Submit the form
                    ->press('Simpan')
                    ->waitForText('Potensi berhasil ditambahkan')
                    
                    // Check if the potensi is in the pending list
                    ->visit('/potensi-saya')
                    ->assertSee('Sawah Organik Penduduk')
                    ->assertSee('Menunggu Verifikasi');
        });
    }
    
    /**
     * Test submitting a new potensi area
     *
     * @return void
     */
    public function testSubmitPotensiArea()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/tambah-potensi')
                    ->assertSee('Tambah Potensi Desa')
                    
                    // Select Area type
                    ->select('type', 'area')
                    
                    // Fill the form
                    ->type('nama', 'Kawasan Perkebunan Warga')
                    ->select('kategori_id', '1') // Select Pertanian category
                    ->type('deskripsi', 'Kawasan perkebunan warga desa')
                    ->type('alamat', 'Desa Sukamaju')
                    ->type('kontak', '081234567890')
                    
                    // Add GeoJSON data (simulated - in reality would be drawn on map)
                    ->type('geojson', '{"type":"Polygon","coordinates":[[[107.6,6.9],[107.7,6.9],[107.7,6.8],[107.6,6.8],[107.6,6.9]]]}')
                    
                    // Upload photo
                    ->attach('photo', __DIR__.'/../../public/img/test-image.jpg')
                    
                    // Submit the form
                    ->press('Simpan')
                    ->waitForText('Potensi berhasil ditambahkan')
                    
                    // Check if the potensi is in the pending list
                    ->visit('/potensi-saya')
                    ->assertSee('Kawasan Perkebunan Warga')
                    ->assertSee('Menunggu Verifikasi');
        });
    }
    
    /**
     * Test validation when submitting potensi
     *
     * @return void
     */
    public function testPotensiFormValidation()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/tambah-potensi')
                    
                    // Submit empty form
                    ->press('Simpan')
                    
                    // Check validation messages
                    ->assertSee('Nama potensi harus diisi')
                    ->assertSee('Kategori harus dipilih')
                    ->assertSee('Deskripsi harus diisi')
                    
                    // Select point type
                    ->select('type', 'point')
                    ->assertSee('Lokasi harus ditentukan')
                    
                    // Select area type
                    ->select('type', 'area')
                    ->assertSee('Area harus digambar pada peta');
        });
    }
    
    /**
     * Test viewing pending submissions
     *
     * @return void
     */
    public function testViewPendingSubmissions()
    {
        $this->browse(function (Browser $browser) {
            // Create a pending potensi first
            $browser->loginAs($this->user)
                    ->visit('/tambah-potensi')
                    ->select('type', 'point')
                    ->type('nama', 'Test Potensi Pending')
                    ->select('kategori_id', '1')
                    ->type('deskripsi', 'Ini adalah potensi test')
                    ->type('alamat', 'Test Address')
                    ->type('kontak', '08123456789')
                    ->type('latitude', '-6.914744')
                    ->type('longitude', '107.609810')
                    ->attach('photo', __DIR__.'/../../public/img/test-image.jpg')
                    ->press('Simpan')
                    ->waitForText('Potensi berhasil ditambahkan');
            
            // Check potensi-saya page
            $browser->visit('/potensi-saya')
                    ->assertSee('Test Potensi Pending')
                    ->assertSee('Menunggu Verifikasi');
            
            // Check edit function
            $browser->click('.edit-potensi-btn') // Adjust selector based on your UI
                    ->assertSee('Edit Potensi')
                    ->assertInputValue('nama', 'Test Potensi Pending');
            
            // Edit the potensi
            $browser->type('nama', 'Test Potensi Updated')
                    ->press('Simpan')
                    ->waitForText('Potensi berhasil diperbarui')
                    ->assertSee('Test Potensi Updated');
        });
    }
}

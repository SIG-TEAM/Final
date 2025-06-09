<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Kategori;
use App\Models\PotensiDesa;
use App\Models\PotensiArea;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    protected $admin;
    
    /**
     * Setup test data
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Create an admin user
        $this->admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
        
        // Create some initial categories
        Kategori::create(['nama' => 'Pertanian']);
        Kategori::create(['nama' => 'Pariwisata']);        // Create some potensi data
        $kategori = Kategori::first();
        
        // Create verified and pending potensi data
        for ($i = 0; $i < 3; $i++) {
            PotensiDesa::create([
                'nama_potensi' => "Potensi Verified $i",
                'kategori' => $kategori->nama,
                'deskripsi' => "Potensi description $i",
                'detail' => "Detail potensi $i",
                'latitude' => -6.914744 + ($i * 0.01),
                'longitude' => 107.609810 + ($i * 0.01),
                'is_approved' => true
            ]);
        }
        
        for ($i = 0; $i < 2; $i++) {
            PotensiDesa::create([
                'nama_potensi' => "Potensi Pending $i",
                'kategori' => $kategori->nama,
                'deskripsi' => "Potensi description $i",
                'detail' => "Detail potensi pending $i",
                'latitude' => -6.924744 + ($i * 0.01),
                'longitude' => 107.619810 + ($i * 0.01),
                'is_approved' => false
            ]);
        }
          // Create an area
        PotensiArea::create([
            'nama' => 'Area Test',
            'kategori' => $kategori->nama,
            'deskripsi' => 'Area description',
            'polygon' => '{"type":"Polygon","coordinates":[[[107.6,6.9],[107.7,6.9],[107.7,6.8],[107.6,6.8],[107.6,6.9]]]}',
            'latitude' => -6.914744,
            'longitude' => 107.609810,
            'alamat' => 'Test Address',
            'status' => 'verified',
            'is_approved' => true
        ]);
    }
    
    /**
     * Test admin can add categories
     *
     * @return void
     */
    public function testAddCategory()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit('/kategori')
                    ->assertSee('Daftar Kategori')
                    ->assertSee('Pertanian')
                    ->assertSee('Pariwisata')
                    
                    // Add new category
                    ->click('.btn-add-category') // Adjust selector based on your UI
                    ->waitForRoute('kategori.create')
                    ->assertSee('Tambah Kategori')
                    
                    // Fill form and submit
                    ->type('nama', 'Industri Kreatif')
                    ->press('Simpan')
                    
                    // Verify success and category appears in list
                    ->waitForText('Kategori berhasil ditambahkan')
                    ->assertSee('Industri Kreatif');
        });
    }
    
    /**
     * Test admin can edit categories
     *
     * @return void
     */
    public function testEditCategory()
    {
        $kategori = Kategori::first();
        
        $this->browse(function (Browser $browser) use ($kategori) {
            $browser->loginAs($this->admin)
                    ->visit('/kategori')
                    ->assertSee('Daftar Kategori')
                    
                    // Click edit on the first category
                    ->click("a[href$='/kategori/{$kategori->id}/edit']")
                    ->waitForRoute('kategori.edit', ['id' => $kategori->id])
                    
                    // Edit the category name
                    ->type('nama', 'Pertanian Organik')
                    ->press('Simpan')
                    
                    // Verify update success
                    ->waitForText('Kategori berhasil diperbarui')
                    ->assertSee('Pertanian Organik');
        });
    }
    
    /**
     * Test admin can delete categories
     *
     * @return void
     */
    public function testDeleteCategory()
    {
        $kategori = Kategori::where('nama', 'Pariwisata')->first();
        
        $this->browse(function (Browser $browser) use ($kategori) {
            $browser->loginAs($this->admin)
                    ->visit('/kategori')
                    ->assertSee('Daftar Kategori')
                    
                    // Click delete button
                    ->click("#delete-kategori-{$kategori->id}") // Adjust selector based on your UI
                    
                    // Confirm deletion in popup
                    ->whenAvailable('.confirmation-modal', function ($modal) {
                        $modal->press('Hapus');
                    })
                    
                    // Verify deletion success
                    ->waitForText('Kategori berhasil dihapus')
                    ->assertDontSee('Pariwisata');
        });
    }
    
    /**
     * Test admin dashboard statistics
     *
     * @return void
     */
    public function testDashboardStatistics()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit('/admin/dashboard')
                    ->assertSee('Dashboard')
                    
                    // Check statistics panels are visible
                    ->assertPresent('.stats-panel')
                    
                    // Check data counts are correct
                    ->assertSeeIn('.total-potensi', '6') // 5 points + 1 area
                    ->assertSeeIn('.verified-potensi', '4') // 3 points + 1 area
                    ->assertSeeIn('.pending-potensi', '2')
                    ->assertSeeIn('.categories-count', '2');
                    
            // Check charts are displayed
            $browser->assertPresent('.chart-container');
        });
    }
    
    /**
     * Test catalog generation
     *
     * @return void
     */
    public function testGenerateCatalog()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit('/admin/katalog')
                    ->assertSee('Katalog Potensi Desa')
                    
                    // Check filter options
                    ->assertPresent('select[name=kategori_filter]')
                    ->assertPresent('button[type=submit]')
                    
                    // Check all potensi are listed
                    ->assertSee('Potensi Verified 0')
                    ->assertSee('Potensi Verified 1')
                    ->assertSee('Potensi Verified 2')
                    ->assertSee('Area Test')
                    
                    // Generate PDF
                    ->click('.generate-pdf')
                    
                    // Wait for PDF to be generated
                    ->waitForText('Katalog berhasil digenerate')
                    
                    // Check download button is available
                    ->assertPresent('.download-pdf');
        });
    }
}

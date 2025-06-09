<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Kategori;
use App\Models\PotensiDesa;
use App\Models\PotensiArea;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PengurusTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    protected $pengurus;
    protected $penduduk;
    protected $pendingUser;
    protected $kategori;
    protected $potensiPending;
    protected $areaPending;
    
    /**
     * Setup test data
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a pengurus user
        $this->pengurus = User::factory()->create([
            'name' => 'Pengurus User',
            'email' => 'pengurus@example.com',
            'password' => bcrypt('password'),
            'role' => 'pengurus'
        ]);
        // Create a penduduk user
        $this->penduduk = User::factory()->create([
            'name' => 'Penduduk User',
            'email' => 'penduduk@example.com',
            'password' => bcrypt('password'),
            'role' => 'penduduk'
        ]);
        
        // Create a pending user registration
        $this->pendingUser = User::factory()->create([
            'name' => 'Pending User',
            'email' => 'pending@example.com',
            'password' => bcrypt('password'),
            'role' => 'penduduk',
            'email_verified_at' => null,
            'status_permintaan' => 'pending'
        ]);
        
        // Create some categories
        $this->kategori = Kategori::create(['nama' => 'Pertanian']);
          // Create pending potensi data
        $this->potensiPending = PotensiDesa::create([            'nama_potensi' => 'Potensi Pending',
            'kategori' => $this->kategori->nama,
            'deskripsi' => 'Potensi yang belum diverifikasi',
            'detail' => 'Detail potensi yang belum diverifikasi',
            'gambar' => null,
            'is_approved' => false,
            'latitude' => -6.914744,
            'longitude' => 107.609810,
            'user_id' => $this->penduduk->id
        ]);
          $this->areaPending = PotensiArea::create([
            'nama' => 'Area Pending',
            'kategori' => $this->kategori->nama,
            'deskripsi' => 'Area yang belum diverifikasi',
            'polygon' => '{"type":"Polygon","coordinates":[[[107.6,6.9],[107.7,6.9],[107.7,6.8],[107.6,6.8],[107.6,6.9]]]}',
            'status' => 'pending',
            'latitude' => -6.914744,
            'longitude' => 107.609810,
            'alamat' => 'Test Address',
            'foto' => null,
            'is_approved' => null, // Use null to match the scopePending function
            'user_id' => $this->penduduk->id
        ]);
    }
    
    /**
     * Test pengurus can verify potensi points
     *
     * @return void
     */
    public function testVerifyPotensiPoint()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->pengurus)
                    ->visit('/verifikasi-potensi')
                    ->assertSee('Verifikasi Potensi')
                    ->assertSee('Potensi Pending')
                    
                    // Click on the potensi to view details
                    ->click("a[href$='/potensi-desa/{$this->potensiPending->id}/detail']")
                    ->waitForRoute('potensi-desa.detail', ['id' => $this->potensiPending->id])
                    ->assertSee('Potensi Pending')
                    ->assertSee('Menunggu Verifikasi')
                    
                    // Click verify button
                    ->click('.verify-potensi')
                    
                    // Confirm verification in modal
                    ->whenAvailable('.confirmation-modal', function($modal) {
                        $modal->press('Verifikasi');
                    })
                    
                    // Check verification success message
                    ->waitForText('Potensi berhasil diverifikasi')
                    ->assertSee('Terverifikasi');
                    
            // Check that potensi now shows up on the main map
            $browser->visit('/')
                    ->waitFor('div.leaflet-container', 10)
                    ->click('div.leaflet-marker-icon')
                    ->waitFor('.potensi-detail-popup')
                    ->assertSee('Potensi Pending');
        });
    }
    
    /**
     * Test pengurus can verify potensi areas
     *
     * @return void
     */
    public function testVerifyPotensiArea()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->pengurus)
                    ->visit('/verifikasi-potensi')
                    ->assertSee('Verifikasi Potensi')
                    ->assertSee('Area Pending')
                    
                    // Click on the area to view details
                    ->click("a[href$='/potensi-area/{$this->areaPending->id}/detail']")
                    ->waitForRoute('potensi-area.detail', ['id' => $this->areaPending->id])
                    ->assertSee('Area Pending')
                    ->assertSee('Menunggu Verifikasi')
                    
                    // Click verify button
                    ->click('.verify-potensi')
                    
                    // Confirm verification in modal
                    ->whenAvailable('.confirmation-modal', function($modal) {
                        $modal->press('Verifikasi');
                    })
                    
                    // Check verification success message
                    ->waitForText('Potensi area berhasil diverifikasi')
                    ->assertSee('Terverifikasi');
                    
            // Check that area now shows up on the main map
            $browser->visit('/')
                    ->waitFor('div.leaflet-container', 10)
                    ->click('path.leaflet-interactive')
                    ->waitFor('.potensi-detail-popup')
                    ->assertSee('Area Pending');
        });
    }
    
    /**
     * Test pengurus can reject potensi
     *
     * @return void
     */
    public function testRejectPotensi()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->pengurus)
                    ->visit('/verifikasi-potensi')
                    ->assertSee('Verifikasi Potensi')
                    ->assertSee('Potensi Pending')
                    
                    // Click on the potensi to view details
                    ->click("a[href$='/potensi-desa/{$this->potensiPending->id}/detail']")
                    ->waitForRoute('potensi-desa.detail', ['id' => $this->potensiPending->id])
                    
                    // Click reject button
                    ->click('.reject-potensi')
                    
                    // Add rejection reason in modal
                    ->whenAvailable('.rejection-modal', function($modal) {
                        $modal->type('rejection_reason', 'Data tidak lengkap')
                            ->press('Tolak');
                    })
                    
                    // Check rejection success message
                    ->waitForText('Potensi berhasil ditolak')
                    ->assertSee('Ditolak');
                    
            // Check that rejected potensi doesn't show on the map
            $browser->visit('/')
                    ->waitFor('div.leaflet-container', 10)
                    ->assertMissing('div.leaflet-marker-icon'); // No markers if all are rejected
        });
    }
    
    /**
     * Test pengurus can manage user registrations
     *
     * @return void
     */
    public function testManageUserRegistrations()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->pengurus)
                    ->visit('/verifikasi-pengguna')
                    ->assertSee('Verifikasi Pengguna')
                    ->assertSee('Pending User')
                    
                    // Approve user
                    ->click("#approve-user-{$this->pendingUser->id}")
                    
                    // Confirm approval
                    ->whenAvailable('.confirmation-modal', function($modal) {
                        $modal->press('Setujui');
                    })
                    
                    // Check approval success
                    ->waitForText('Pengguna berhasil disetujui')
                    ->assertDontSee('Pending User'); // User no longer in pending list
                    
            // Check approved user can login
            $browser->logout()
                    ->visit('/login')
                    ->type('email', 'pending@example.com')
                    ->type('password', 'password')
                    ->press('Log in')
                    ->assertPathIs('/'); // Should be redirected to home
        });
    }
    
    /**
     * Test pengurus can reject user registrations
     *
     * @return void
     */
    public function testRejectUserRegistration()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->pengurus)
                    ->visit('/verifikasi-pengguna')
                    ->assertSee('Verifikasi Pengguna')
                    ->assertSee('Pending User')
                    
                    // Reject user
                    ->click("#reject-user-{$this->pendingUser->id}")
                    
                    // Add rejection reason
                    ->whenAvailable('.rejection-modal', function($modal) {
                        $modal->type('rejection_reason', 'Informasi tidak valid')
                            ->press('Tolak');
                    })
                    
                    // Check rejection success
                    ->waitForText('Pengguna berhasil ditolak')
                    ->assertDontSee('Pending User'); // User no longer in pending list
                    
            // Check rejected user cannot login
            $browser->logout()
                    ->visit('/login')
                    ->type('email', 'pending@example.com')
                    ->type('password', 'password')
                    ->press('Log in')
                    ->assertSee('These credentials do not match our records.');
        });
    }
}

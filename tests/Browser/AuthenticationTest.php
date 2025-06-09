<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthenticationTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test user registration.
     *
     * @return void
     */
    public function testUserRegistration()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'Test User')
                    ->type('email', 'test@example.com')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('Register')
                    ->assertPathIs('/');
        });
    }

    /**
     * Test user login.
     *
     * @return void
     */
    public function testUserLogin()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'test@example.com')
                    ->type('password', 'password')
                    ->press('Log in')
                    ->assertPathIs('/');
        });
    }

    /**
     * Test user logout.
     *
     * @return void
     */
    public function testUserLogout()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/')
                    ->click('#user-dropdown') // Adjust this selector based on your actual UI
                    ->clickLink('Log Out')
                    ->assertGuest();
        });
    }

    /**
     * Test different user roles have appropriate access.
     *
     * @return void
     */
    public function testUserRoles()
    {
        // Create users with different roles
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);

        $pengurus = User::factory()->create([
            'role' => 'pengurus',
            'email' => 'pengurus@test.com',
            'password' => bcrypt('password'),
        ]);

        $penduduk = User::factory()->create([
            'role' => 'penduduk',
            'email' => 'penduduk@test.com',
            'password' => bcrypt('password'),
        ]);

        // Test admin access
        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                    ->visit('/admin/dashboard')
                    ->assertSee('Dashboard')
                    ->assertPathIs('/admin/dashboard');
        });

        // Test pengurus access
        $this->browse(function (Browser $browser) use ($pengurus) {
            $browser->loginAs($pengurus)
                    ->visit('/verifikasi-potensi')
                    ->assertSee('Verifikasi')
                    ->assertPathIs('/verifikasi-potensi');
        });

        // Test penduduk access
        $this->browse(function (Browser $browser) use ($penduduk) {
            $browser->loginAs($penduduk)
                    ->visit('/tambah-potensi')
                    ->assertSee('Tambah Potensi')
                    ->assertPathIs('/tambah-potensi');
        });
    }
}

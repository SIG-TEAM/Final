<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class usersseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            // First check if admin exists
            if (User::where('email', 'admin@admin.com')->exists()) {
                $this->command->info('Admin user already exists.');
                return;
            }

            $user = User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);

            if ($user) {
                $this->command->info('Admin user created successfully.');
                $this->command->info('Email: admin@admin.com');
                $this->command->info('Password: password');
            } else {
                throw new \Exception('Failed to create user record');
            }
            
        } catch (\Exception $e) {
            $this->command->error('Error creating admin user: ' . $e->getMessage());
            $this->command->error('Full error: ' . $e->getTraceAsString());
        }
    }
}

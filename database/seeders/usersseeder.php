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
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Penduduk',
                'email' => 'penduduk@mail.com',
                'password' => Hash::make('password'),
                'role' => 'penduduk',
            ],
            [
                'name' => 'Pengurus',
                'email' => 'pengurus@mail.com',
                'password' => Hash::make('password'),
                'role' => 'pengurus',
            ],
            [
                'name' => 'Pengguna',
                'email' => 'pengguna@mail.com',
                'password' => Hash::make('password'),
                'role' => 'pengguna',
            ],
        ];

        foreach ($users as $userData) {
            // Check if user with this email already exists
            if (!User::where('email', $userData['email'])->exists()) {
                User::create($userData);
            } else {
                $this->command->info("User with email {$userData['email']} already exists, skipping...");
            }
        }
    }
}

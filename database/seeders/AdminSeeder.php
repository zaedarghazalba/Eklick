<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'poli_spesialisasi' => null,
            ],
            [
                'name' => 'Admin Klinik',
                'email' => 'admin@klinik.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'poli_spesialisasi' => null,
            ],
        ];

        foreach ($admins as $admin) {
            User::updateOrCreate(
                ['email' => $admin['email']],
                $admin
            );
        }

        $this->command->info('   ✓ Created 2 admin accounts');
    }
}

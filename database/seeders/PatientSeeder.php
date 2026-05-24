<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $patients = [
            ['name' => 'Andi Prasetyo', 'email' => 'andi.prasetyo@gmail.com'],
            ['name' => 'Budi Santoso', 'email' => 'budi.santoso@gmail.com'],
            ['name' => 'Citra Dewi', 'email' => 'citra.dewi@gmail.com'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi.lestari@gmail.com'],
            ['name' => 'Eko Wijaya', 'email' => 'eko.wijaya@gmail.com'],
            ['name' => 'Fitri Handayani', 'email' => 'fitri.handayani@gmail.com'],
            ['name' => 'Gunawan Santoso', 'email' => 'gunawan.santoso@gmail.com'],
            ['name' => 'Heni Kusuma', 'email' => 'heni.kusuma@gmail.com'],
            ['name' => 'Irfan Hakim', 'email' => 'irfan.hakim@gmail.com'],
            ['name' => 'Julia Rahmawati', 'email' => 'julia.rahmawati@gmail.com'],
            ['name' => 'Kurniawan Adi', 'email' => 'kurniawan.adi@gmail.com'],
            ['name' => 'Lestari Wulandari', 'email' => 'lestari.wulandari@gmail.com'],
            ['name' => 'Muhammad Rizki', 'email' => 'm.rizki@gmail.com'],
            ['name' => 'Nuraini Wijaya', 'email' => 'nuraini.wijaya@gmail.com'],
            ['name' => 'Olivia Andini', 'email' => 'olivia.andini@gmail.com'],
        ];

        foreach ($patients as $patient) {
            User::updateOrCreate(
                ['email' => $patient['email']],
                [
                    'name' => $patient['name'],
                    'email' => $patient['email'],
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'google_id' => null,
                    'poli_spesialisasi' => null,
                ]
            );
        }

        $this->command->info('   ✓ Created ' . count($patients) . ' patient accounts');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DokterSeeder extends Seeder
{
    public function run(): void
    {
        $dokters = [
            [
                'name' => 'Dr. Ahmad Santoso, Sp.PD',
                'email' => 'dr.ahmad@klinik.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
                'poli_spesialisasi' => 'Umum',
            ],
            [
                'name' => 'Dr. Siti Nurhaliza, Sp.M',
                'email' => 'dr.siti@klinik.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
                'poli_spesialisasi' => 'Mata',
            ],
            [
                'name' => 'Dr. Budi Hartono, Sp.THT',
                'email' => 'dr.budi@klinik.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
                'poli_spesialisasi' => 'THT',
            ],
            [
                'name' => 'Dr. Rina Wijaya, Sp.A',
                'email' => 'dr.rina@klinik.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
                'poli_spesialisasi' => 'Balita',
            ],
            [
                'name' => 'Dr. Dian Pertiwi, Sp.KK',
                'email' => 'dr.dian@klinik.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
                'poli_spesialisasi' => 'Kulit',
            ],
            [
                'name' => 'Dr. Hadi Susanto, Sp.S',
                'email' => 'dr.hadi@klinik.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
                'poli_spesialisasi' => 'Syaraf',
            ],
        ];

        foreach ($dokters as $dokter) {
            User::updateOrCreate(
                ['email' => $dokter['email']],
                $dokter
            );
        }

        $this->command->info('   ✓ Created 6 dokter accounts (Umum, Mata, THT, Balita, Kulit, Syaraf)');
    }
}

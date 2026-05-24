<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Antrians;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('');
        $this->command->info('╔══════════════════════════════════════════════════════════╗');
        $this->command->info('║          SEEDING DATABASE - KLINIK PUI                 ║');
        $this->command->info('╚══════════════════════════════════════════════════════════╝');
        $this->command->info('');

        // Step 1: Wipe all data
        $this->command->info('🗑  Wiping existing data...');
        Antrians::onlyTrashed()->forceDelete();
        Antrians::truncate();
        User::where('role', '!=', 'admin')->orWhere('email', '!=', 'admin@example.com')->delete();
        $this->command->info('   ✓ All data cleared');
        $this->command->info('');

        // Step 2: Seed Admin
        $this->command->info('👤 Seeding Admin accounts...');
        $this->call(AdminSeeder::class);
        $this->command->info('');

        // Step 3: Seed Dokter
        $this->command->info('🩺 Seeding Dokter accounts...');
        $this->call(DokterSeeder::class);
        $this->command->info('');

        // Step 4: Seed Patients
        $this->command->info('🧑‍🤝‍🧑 Seeding Patient accounts...');
        $this->call(PatientSeeder::class);
        $this->command->info('');

        // Step 5: Seed Antrian
        $this->command->info('📋 Seeding Antrian with medical records...');
        $this->call(AntrianSeeder::class);
        $this->command->info('');

        // Summary
        $this->command->info('╔══════════════════════════════════════════════════════════╗');
        $this->command->info('║              SEEDING COMPLETED SUCCESSFULLY              ║');
        $this->command->info('╚══════════════════════════════════════════════════════════╝');
        $this->command->info('');
        $this->command->info('📊 Database Summary:');
        $this->command->info('   • ' . User::where('role', 'admin')->count() . ' Admin accounts');
        $this->command->info('   • ' . User::where('role', 'dokter')->count() . ' Dokter accounts (6 poli)');
        $this->command->info('   • ' . User::where('role', 'user')->count() . ' Patient accounts');
        $this->command->info('   • ' . Antrians::count() . ' Antrian records');
        $this->command->info('');
        $this->command->info('🔐 Login Credentials:');
        $this->command->info('');
        $this->command->info('   ┌─────────────────────────────────────────────────────────┐');
        $this->command->info('   │  ADMIN                                                  │');
        $this->command->info('   │  Email: admin@example.com                               │');
        $this->command->info('   │  Pass:  password                                        │');
        $this->command->info('   ├─────────────────────────────────────────────────────────┤');
        $this->command->info('   │  DOKTER                                                 │');
        $this->command->info('   │  dr.ahmad@klinik.com  (Poli Umum)      → password123    │');
        $this->command->info('   │  dr.siti@klinik.com   (Poli Mata)      → password123    │');
        $this->command->info('   │  dr.budi@klinik.com   (Poli THT)       → password123    │');
        $this->command->info('   │  dr.rina@klinik.com   (Poli Balita)    → password123    │');
        $this->command->info('   │  dr.dian@klinik.com   (Poli Kulit)     → password123    │');
        $this->command->info('   │  dr.hadi@klinik.com   (Poli Syaraf)    → password123    │');
        $this->command->info('   ├─────────────────────────────────────────────────────────┤');
        $this->command->info('   │  PASIEN                                                 │');
        $this->command->info('   │  andi.prasetyo@gmail.com → password123                  │');
        $this->command->info('   │  (All patients use password: password123)               │');
        $this->command->info('   └─────────────────────────────────────────────────────────┘');
        $this->command->info('');
    }
}

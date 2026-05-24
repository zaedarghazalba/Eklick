<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Antrians;
use App\Models\User;
use Carbon\Carbon;

class AntrianSeeder extends Seeder
{
    public function run(): void
    {
        $patients = User::where('role', 'user')->get();
        $dokters = User::where('role', 'dokter')->get();

        if ($patients->isEmpty()) {
            $this->command->warn('⚠ Tidak ada pasien. Jalankan PatientSeeder terlebih dahulu!');
            return;
        }

        $polis = ['Umum', 'Mata', 'THT', 'Balita', 'Kulit', 'Syaraf'];
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $twoDaysAgo = Carbon::today()->subDays(2);

        $pekerjaans = ['Pegawai Swasta', 'PNS', 'Wiraswasta', 'Mahasiswa', 'Pelajar', 'Ibu Rumah Tangga', 'Petani', 'Pedagang'];

        $diagnosaData = [
            'Umum' => [
                'diagnosa' => 'Influenza (J11.1)',
                'keluhan_utama' => 'Demam, pilek, dan batuk sejak 3 hari yang lalu',
                'riwayat_penyakit' => 'Tidak ada riwayat penyakit kronis',
                'pemeriksaan_fisik' => 'Tampak sakit ringan, kesadaran compos mentis, tenggorokan merah',
                'resep_obat' => "R/ Paracetamol tab 500mg No. XV\nS 3 dd 1 tab (sesudah makan)\nR/ CTM tab 4mg No. X\nS 3 dd 1 tab (sesudah makan)\nR/ Vitamin C tab 50mg No. X\nS 1 dd 1 tab (sesudah makan)",
                'tindakan_medis' => 'Pemeriksaan fisik umum, edukasi istirahat dan minum air putih yang cukup',
                'anjuran' => 'Istirahat 3 hari, minum air putih minimal 8 gelas/hari, kontrol jika demam tidak turun',
                'catatan_dokter' => 'Pasien dalam kondisi baik, disarankan istirahat cukup',
            ],
            'Mata' => [
                'diagnosa' => 'Konjungtivitis Akut (H10.9)',
                'keluhan_utama' => 'Mata merah, gatal, dan berair sejak 2 hari yang lalu',
                'riwayat_penyakit' => 'Tidak ada riwayat alergi',
                'pemeriksaan_fisik' => 'Konjungtiva hiperemis, sekret serosa, visus OD 6/6, OS 6/6',
                'resep_obat' => "R/ Chloramphenicol eye drops 0.5%\nS 4 dd 1 gtt OU\nR/ Artificial tears eye drops\nS 3 dd 1 gtt OU",
                'tindakan_medis' => 'Pemeriksaan visus, pemeriksaan slit lamp',
                'anjuran' => 'Jangan menggosok mata, gunakan kacamata hitam saat keluar rumah, kontrol 3 hari lagi',
                'catatan_dokter' => 'Konjungtivitis bakterial ringan, prognosis baik',
            ],
            'THT' => [
                'diagnosa' => 'Faringitis Akut (J02.9)',
                'keluhan_utama' => 'Sakit tenggorokan, sulit menelan, dan demam sejak 2 hari',
                'riwayat_penyakit' => 'Sering mengalami sakit tenggorokan',
                'pemeriksaan_fisik' => 'Tenggorokan hiperemis, tonsil T1-T1, tidak ada eksudat, telinga normal',
                'resep_obat' => "R/ Amoxicillin cap 500mg No. XV\nS 3 dd 1 cap (sesudah makan)\nR/ Paracetamol tab 500mg No. X\nS 3 dd 1 tab (jika demam)\nR/ Obat kumur Benzydamine\nS 3 dd kumur",
                'tindakan_medis' => 'Pemeriksaan THT lengkap, usap tenggorokan',
                'anjuran' => 'Hindari makanan pedas dan dingin, minum air hangat, kontrol jika tidak membaik dalam 3 hari',
                'catatan_dokter' => 'Faringitis akut bakterial, perlu antibiotik',
            ],
            'Balita' => [
                'diagnosa' => 'ISPA pada Anak (J06.9)',
                'keluhan_utama' => 'Batuk pilek pada anak, demam ringan sejak 2 hari',
                'riwayat_penyakit' => 'Imunisasi lengkap sesuai usia',
                'pemeriksaan_fisik' => 'Kesadaran compos, RR 28x/menit, nadi 110x/menit, suhu 37.8°C, paru vesikuler',
                'resep_obat' => "R/ Paracetamol syrup 60mg/5ml\nS 3 dd 5ml (jika demam)\nR/ Ambroxol syrup 15mg/5ml\nS 3 dd 2.5ml\nR/ Vitamin D3 drops\nS 1 dd 1 tetes",
                'tindakan_medis' => 'Pemeriksaan fisik anak, pengukuran berat dan tinggi badan',
                'anjuran' => 'Berikan ASI/minum yang cukup, kompres hangat jika demam, kontrol 2 hari lagi',
                'catatan_dokter' => 'ISPA ringan, prognosis baik, orang tua diedukasi tanda bahaya',
            ],
            'Kulit' => [
                'diagnosa' => 'Dermatitis Kontak Alergika (L23.9)',
                'keluhan_utama' => 'Gatal-gatal dan kemerahan pada lengan sejak 1 minggu',
                'riwayat_penyakit' => 'Riwayat alergi debu',
                'pemeriksaan_fisik' => 'Lesi eritema dengan papul pada lengan kanan dan kiri, tidak ada eksudat',
                'resep_obat' => "R/ Hydrocortisone cream 1%\nS 2 dd aplikasikan tipis pada lesi\nR/ Cetirizine tab 10mg No. X\nS 1 dd 1 tab (malam hari)\nR/ Calamine lotion\nS 2 dd aplikasikan pada area gatal",
                'tindakan_medis' => 'Pemeriksaan dermatologis, patch test disarankan',
                'anjuran' => 'Hindari kontak dengan alergen, jangan menggaruk, gunakan pakaian longgar',
                'catatan_dokter' => 'Dermatitis kontak alergika ringan, perlu identifikasi alergen',
            ],
            'Syaraf' => [
                'diagnosa' => 'Cephalgia Tension-Type (G44.0)',
                'keluhan_utama' => 'Sakit kepala seperti diikat sejak 3 hari, terutama di bagian belakang kepala',
                'riwayat_penyakit' => 'Sering stres karena pekerjaan, kurang tidur',
                'pemeriksaan_fisik' => 'Kesadaran compos, TD 130/85, nadi 80x/menit, tidak ada defisit neurologis, reflex fisiologis +/+, reflex patologis -/-',
                'resep_obat' => "R/ Amitriptyline tab 25mg No. X\nS 1 dd 1 tab (malam hari)\nR/ Paracetamol tab 500mg No. XV\nS 3 dd 1 tab (jika sakit kepala)\nR/ Vitamin B Complex No. X\nS 1 dd 1 tab (sesudah makan)",
                'tindakan_medis' => 'Pemeriksaan neurologis lengkap, evaluasi tekanan darah',
                'anjuran' => 'Kelola stres, tidur cukup 7-8 jam, olahraga ringan, kontrol 1 minggu lagi',
                'catatan_dokter' => 'Tension headache, perlu manajemen stres dan pola tidur yang baik',
            ],
        ];

        $totalCreated = 0;

        foreach ($polis as $poli) {
            $dokter = $dokters->firstWhere('poli_spesialisasi', $poli);
            $diagnosa = $diagnosaData[$poli] ?? $diagnosaData['Umum'];
            $noAntrian = 1;

            // Today's antrian - 5 per poli
            for ($i = 0; $i < 5; $i++) {
                $jk = $i % 2 === 0 ? 'Laki-laki' : 'Perempuan';
                $nama = $this->getRandomName($jk, $i);
                $noAntrianFormatted = str_pad($noAntrian, 3, '0', STR_PAD_LEFT);

                if ($i < 2) {
                    $status = 'selesai';
                } elseif ($i === 2) {
                    $status = 'dipanggil';
                } else {
                    $status = 'menunggu';
                }

                $patient = $patients->random();

                Antrians::create([
                    'poli' => $poli,
                    'tanggal_daftar' => $today,
                    'nama' => $nama,
                    'no_ktp' => $this->generateKTP(),
                    'alamat' => $this->generateAddress(),
                    'jenis_kelamin' => $jk,
                    'no_hp' => $this->generatePhone(),
                    'tgl_lahir' => Carbon::now()->subYears(rand(1, 70))->subDays(rand(0, 365)),
                    'pekerjaan' => $pekerjaans[array_rand($pekerjaans)],
                    'rekam_medis' => null,
                    'user_id' => $patient->id,
                    'dokter_id' => $dokter?->id,
                    'no_antrian' => $noAntrianFormatted,
                    'status' => $status,
                    'skipped' => false,
                    'dipanggil_at' => $status === 'dipanggil' ? now() : null,
                    'diagnosa' => $status === 'selesai' ? $diagnosa['diagnosa'] : null,
                    'keluhan_utama' => $status === 'selesai' ? $diagnosa['keluhan_utama'] : null,
                    'riwayat_penyakit' => $status === 'selesai' ? $diagnosa['riwayat_penyakit'] : null,
                    'pemeriksaan_fisik' => $status === 'selesai' ? $diagnosa['pemeriksaan_fisik'] : null,
                    'resep_obat' => $status === 'selesai' ? $diagnosa['resep_obat'] : null,
                    'tindakan_medis' => $status === 'selesai' ? $diagnosa['tindakan_medis'] : null,
                    'anjuran' => $status === 'selesai' ? $diagnosa['anjuran'] : null,
                    'catatan_dokter' => $status === 'selesai' ? $diagnosa['catatan_dokter'] : null,
                    'tekanan_darah' => $status === 'selesai' ? rand(110, 140) . '/' . rand(70, 90) . ' mmHg' : null,
                    'suhu_tubuh' => $status === 'selesai' ? (36 + rand(0, 20) / 10) . '°C' : null,
                    'nadi' => $status === 'selesai' ? rand(60, 100) . ' x/menit' : null,
                    'tinggi_badan' => $status === 'selesai' ? rand(150, 180) : null,
                    'berat_badan' => $status === 'selesai' ? rand(45, 90) : null,
                    'tanggal_periksa' => $status === 'selesai' ? now() : null,
                    'nama_dokter' => $dokter?->name,
                    'dokter_poli' => $poli,
                ]);

                $totalCreated++;
                $noAntrian++;
            }

            $this->command->info("   ✓ Poli {$poli}: 5 antrian hari ini (2 selesai, 1 dipanggil, 2 menunggu)");
        }

        // Yesterday's completed antrian (for archive)
        foreach ($polis as $poli) {
            $dokter = $dokters->firstWhere('poli_spesialisasi', $poli);
            $diagnosa = $diagnosaData[$poli] ?? $diagnosaData['Umum'];

            for ($i = 0; $i < 3; $i++) {
                $jk = $i % 2 === 0 ? 'Laki-laki' : 'Perempuan';
                $nama = $this->getRandomName($jk, $i + 10);
                $noAntrianFormatted = str_pad($i + 1, 3, '0', STR_PAD_LEFT);
                $patient = $patients->random();

                Antrians::create([
                    'poli' => $poli,
                    'tanggal_daftar' => $yesterday,
                    'nama' => $nama,
                    'no_ktp' => $this->generateKTP(),
                    'alamat' => $this->generateAddress(),
                    'jenis_kelamin' => $jk,
                    'no_hp' => $this->generatePhone(),
                    'tgl_lahir' => Carbon::now()->subYears(rand(1, 70))->subDays(rand(0, 365)),
                    'pekerjaan' => $pekerjaans[array_rand($pekerjaans)],
                    'rekam_medis' => null,
                    'user_id' => $patient->id,
                    'dokter_id' => $dokter?->id,
                    'no_antrian' => $noAntrianFormatted,
                    'status' => 'selesai',
                    'skipped' => false,
                    'dipanggil_at' => $yesterday->addHours(rand(8, 14)),
                    'diagnosa' => $diagnosa['diagnosa'],
                    'keluhan_utama' => $diagnosa['keluhan_utama'],
                    'riwayat_penyakit' => $diagnosa['riwayat_penyakit'],
                    'pemeriksaan_fisik' => $diagnosa['pemeriksaan_fisik'],
                    'resep_obat' => $diagnosa['resep_obat'],
                    'tindakan_medis' => $diagnosa['tindakan_medis'],
                    'anjuran' => $diagnosa['anjuran'],
                    'catatan_dokter' => $diagnosa['catatan_dokter'],
                    'tekanan_darah' => rand(110, 140) . '/' . rand(70, 90) . ' mmHg',
                    'suhu_tubuh' => (36 + rand(0, 20) / 10) . '°C',
                    'nadi' => rand(60, 100) . ' x/menit',
                    'tinggi_badan' => rand(150, 180),
                    'berat_badan' => rand(45, 90),
                    'tanggal_periksa' => $yesterday->addHours(rand(8, 14)),
                    'nama_dokter' => $dokter?->name,
                    'dokter_poli' => $poli,
                ]);

                $totalCreated++;
            }

            $this->command->info("   ✓ Poli {$poli}: 3 antrian kemarin (selesai - arsip)");
        }

        // 2 days ago - some skipped
        foreach (['Umum', 'Mata', 'THT'] as $poli) {
            for ($i = 0; $i < 2; $i++) {
                $jk = $i % 2 === 0 ? 'Laki-laki' : 'Perempuan';
                $nama = $this->getRandomName($jk, $i + 20);
                $noAntrianFormatted = str_pad($i + 1, 3, '0', STR_PAD_LEFT);
                $patient = $patients->random();

                Antrians::create([
                    'poli' => $poli,
                    'tanggal_daftar' => $twoDaysAgo,
                    'nama' => $nama,
                    'no_ktp' => $this->generateKTP(),
                    'alamat' => $this->generateAddress(),
                    'jenis_kelamin' => $jk,
                    'no_hp' => $this->generatePhone(),
                    'tgl_lahir' => Carbon::now()->subYears(rand(1, 70))->subDays(rand(0, 365)),
                    'pekerjaan' => $pekerjaans[array_rand($pekerjaans)],
                    'rekam_medis' => null,
                    'user_id' => $patient->id,
                    'no_antrian' => $noAntrianFormatted,
                    'status' => 'selesai',
                    'skipped' => true,
                    'dipanggil_at' => null,
                    'diagnosa' => null,
                    'resep_obat' => null,
                    'catatan_dokter' => 'Pasien tidak hadir (skip)',
                    'tanggal_periksa' => $twoDaysAgo->addHours(rand(8, 14)),
                    'nama_dokter' => null,
                    'dokter_poli' => $poli,
                ]);

                $totalCreated++;
            }

            $this->command->info("   ✓ Poli {$poli}: 2 antrian 2 hari lalu (skip - arsip)");
        }

        $this->command->info('');
        $this->command->info("   Total: {$totalCreated} antrian created");
    }

    private function getRandomName($jk, $seed)
    {
        $namaLaki = ['Ahmad Fauzi', 'Bambang Sutrisno', 'Chandra Wijaya', 'Dedi Kurniawan', 'Eko Prasetyo', 'Fajar Rahman', 'Gunawan Santoso', 'Hadi Purnomo', 'Irfan Hakim', 'Joko Susilo', 'Kurniawan Adi', 'Lukman Hakim', 'Muhammad Rizki', 'Nur Hidayat', 'Oki Pratama'];
        $namaPerempuan = ['Ani Lestari', 'Bunga Citra', 'Citra Dewi', 'Diah Ayu', 'Eka Putri', 'Fitri Handayani', 'Gita Savitri', 'Heni Kusuma', 'Ika Permata', 'Julia Rahmawati', 'Kartika Sari', 'Lestari Wulandari', 'Maya Sari', 'Nuraini Wijaya', 'Olivia Andini'];

        $names = $jk === 'Laki-laki' ? $namaLaki : $namaPerempuan;
        return $names[$seed % count($names)];
    }

    private function generateKTP()
    {
        return '32' . str_pad(rand(1000000000000, 9999999999999), 14, '0', STR_PAD_LEFT);
    }

    private function generateAddress()
    {
        $streets = ['Jl. Merdeka', 'Jl. Sudirman', 'Jl. Gatot Subroto', 'Jl. Ahmad Yani', 'Jl. Diponegoro', 'Jl. Kartini', 'Jl. Pahlawan', 'Jl. Mawar', 'Jl. Melati', 'Jl. Kenanga'];
        return $streets[array_rand($streets)] . ' No. ' . rand(1, 999) . ', Jakarta';
    }

    private function generatePhone()
    {
        return '08' . rand(10, 99) . rand(10000000, 99999999);
    }
}

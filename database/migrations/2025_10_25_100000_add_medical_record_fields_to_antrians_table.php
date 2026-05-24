<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('antrians', function (Blueprint $table) {
            // Vital Signs
            $table->string('tekanan_darah')->nullable()->after('catatan_dokter');
            $table->string('suhu_tubuh')->nullable()->after('tekanan_darah');
            $table->string('nadi')->nullable()->after('suhu_tubuh');
            $table->string('tinggi_badan')->nullable()->after('nadi');
            $table->string('berat_badan')->nullable()->after('tinggi_badan');

            // Examination Results
            $table->text('keluhan_utama')->nullable()->after('berat_badan');
            $table->text('riwayat_penyakit')->nullable()->after('keluhan_utama');
            $table->text('pemeriksaan_fisik')->nullable()->after('riwayat_penyakit');
            $table->text('hasil_lab')->nullable()->after('pemeriksaan_fisik');

            // Medical Images/Files (JSON array untuk multiple files)
            $table->text('foto_pemeriksaan')->nullable()->after('hasil_lab'); // Store as JSON
            $table->text('foto_rontgen')->nullable()->after('foto_pemeriksaan'); // Store as JSON
            $table->text('file_pendukung')->nullable()->after('foto_rontgen'); // Store as JSON

            // Treatment
            $table->text('tindakan_medis')->nullable()->after('file_pendukung');
            $table->text('anjuran')->nullable()->after('tindakan_medis');

            // Doctor info
            $table->string('nama_dokter')->nullable()->after('anjuran');
            $table->string('dokter_poli')->nullable()->after('nama_dokter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antrians', function (Blueprint $table) {
            $table->dropColumn([
                'tekanan_darah',
                'suhu_tubuh',
                'nadi',
                'tinggi_badan',
                'berat_badan',
                'keluhan_utama',
                'riwayat_penyakit',
                'pemeriksaan_fisik',
                'hasil_lab',
                'foto_pemeriksaan',
                'foto_rontgen',
                'file_pendukung',
                'tindakan_medis',
                'anjuran',
                'nama_dokter',
                'dokter_poli'
            ]);
        });
    }
};

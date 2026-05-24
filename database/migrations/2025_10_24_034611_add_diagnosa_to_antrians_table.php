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
            $table->text('diagnosa')->nullable(); // Diagnosa dari dokter
            $table->text('catatan_dokter')->nullable(); // Catatan tambahan dari dokter
            $table->text('resep_obat')->nullable(); // Resep obat dari dokter
            $table->timestamp('tanggal_periksa')->nullable(); // Tanggal pemeriksaan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antrians', function (Blueprint $table) {
            $table->dropColumn(['diagnosa', 'catatan_dokter', 'resep_obat', 'tanggal_periksa']);
        });
    }
};

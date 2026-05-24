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
            // Add composite index for frequently queried columns (poli + tanggal_daftar)
            // Used in: filtering, queue number generation, dashboard statistics
            $table->index(['poli', 'tanggal_daftar'], 'idx_poli_tanggal');

            // Add index for status column (used in filtering completed/pending queues)
            $table->index('status');

            // Add index for no_ktp (for patient search)
            $table->index('no_ktp');

            // Add index for user_id (already has foreign key, but explicit index helps)
            // This improves performance when querying user's appointments
            $table->index('user_id');

            // Add index for tanggal_daftar alone (used in date range queries)
            $table->index('tanggal_daftar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antrians', function (Blueprint $table) {
            // Drop indexes in reverse order
            $table->dropIndex('idx_poli_tanggal');
            $table->dropIndex(['status']);
            $table->dropIndex(['no_ktp']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['tanggal_daftar']);
        });
    }
};

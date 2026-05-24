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
            $table->string('status')->default('menunggu'); // menunggu, dipanggil, selesai
            $table->boolean('skipped')->default(false); // apakah antrian di-skip
            $table->timestamp('dipanggil_at')->nullable(); // waktu dipanggil
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antrians', function (Blueprint $table) {
            $table->dropColumn(['status', 'skipped', 'dipanggil_at']);
        });
    }
};

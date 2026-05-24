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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['user', 'dokter', 'admin'])->default('user')->after('password');
            $table->string('poli_spesialisasi')->nullable()->after('role')->comment('Poli untuk dokter: Umum, Mata, THT, Ibu Dan Anak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'poli_spesialisasi']);
        });
    }
};

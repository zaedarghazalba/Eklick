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
            // Add dokter_id foreign key to track which doctor handled this patient
            // This replaces the string-based nama_dokter approach
            $table->unsignedBigInteger('dokter_id')->nullable()->after('user_id');

            // Add foreign key constraint with RESTRICT to prevent deleting doctors with patients
            $table->foreign('dokter_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict') // Prevent deleting doctor if they have antrians
                  ->onUpdate('cascade'); // Update if doctor ID changes

            // Add index for faster queries on dokter_id
            $table->index('dokter_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antrians', function (Blueprint $table) {
            // Drop foreign key first, then column
            $table->dropForeign(['dokter_id']);
            $table->dropIndex(['dokter_id']);
            $table->dropColumn('dokter_id');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update any invalid status values to 'menunggu'
        DB::table('antrians')
            ->whereNotIn('status', ['menunggu', 'dipanggil', 'selesai', 'skip'])
            ->update(['status' => 'menunggu']);

        // ENUM constraint only works on MySQL, SQLite doesn't support it
        // For testing with SQLite, we skip ENUM conversion
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            // MySQL: Use ENUM for strict validation
            DB::statement("ALTER TABLE antrians MODIFY status ENUM('menunggu', 'dipanggil', 'selesai', 'skip') NOT NULL DEFAULT 'menunggu'");
            DB::statement("ALTER TABLE antrians MODIFY poli ENUM('Umum', 'Mata', 'THT', 'Balita', 'Kulit', 'Syaraf', 'Ibu Dan Anak') NOT NULL");
        } else {
            // SQLite/Other: Keep as VARCHAR (for testing)
            // Validation will be done at application level
            // Note: SQLite doesn't support ENUM or ALTER COLUMN MODIFY
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            // MySQL: Revert back to VARCHAR
            DB::statement("ALTER TABLE antrians MODIFY status VARCHAR(255) NOT NULL DEFAULT 'menunggu'");
            DB::statement("ALTER TABLE antrians MODIFY poli VARCHAR(255) NOT NULL");
        } else {
            // SQLite/Other: No changes needed (was already VARCHAR)
        }
    }
};

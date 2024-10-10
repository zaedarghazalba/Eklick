<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('antrian', function (Blueprint $table) {
            $table->id();
            $table->string('poli');
            $table->string('nama');
            $table->string('no_ktp');
            $table->string('alamat');
            $table->string('jenis_kelamin');
            $table->string('no_hp');
            $table->date('tgl_lahir');
            $table->string('pekerjaan');
            // Tambahkan kolom user_id untuk menyimpan user ID yang sedang login
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrians');
    }
};

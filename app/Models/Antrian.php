<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'poli','tanggal_daftar', 'nama', 'no_ktp', 'alamat', 'jenis_kelamin', 'no_hp', 'tgl_lahir', 'pekerjaan', 'user_id','Rekam_medis'
    ];
}

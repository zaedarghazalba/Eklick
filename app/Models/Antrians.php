<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Database\Factories\AntriansFactory;

class Antrians extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'poli',
        'tanggal_daftar',
        'nama',
        'no_ktp',
        'alamat',
        'jenis_kelamin',
        'no_hp',
        'tgl_lahir',
        'pekerjaan',
        'rekam_medis',
        'user_id',
        'dokter_id', // NEW: Foreign key to users table (for dokter)
        'no_antrian',
        'status',
        'skipped',
        'dipanggil_at',
        'diagnosa',
        'catatan_dokter',
        'resep_obat',
        'tanggal_periksa',
        // Vital Signs
        'tekanan_darah',
        'suhu_tubuh',
        'nadi',
        'tinggi_badan',
        'berat_badan',
        // Examination
        'keluhan_utama',
        'riwayat_penyakit',
        'pemeriksaan_fisik',
        'hasil_lab',
        // Medical Files
        'foto_pemeriksaan',
        'foto_rontgen',
        'file_pendukung',
        // Treatment
        'tindakan_medis',
        'anjuran',
        // Doctor Info (kept for backward compatibility, but dokter_id is preferred)
        'nama_dokter',
        'dokter_poli'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'skipped' => 'boolean',
        'dipanggil_at' => 'datetime',
        'tanggal_periksa' => 'datetime',
    ];

    /**
     * Get the user (patient) that owns the antrian.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the dokter that handled this antrian.
     */
    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'google_id',
        'name',
        'email',
        'password',
        'role',
        'poli_spesialisasi',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'role' => \App\Enums\UserRole::class,
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Check if user is a doctor.
     *
     * @return bool
     */
    public function isDokter(): bool
    {
        return $this->role === 'dokter';
    }

    /**
     * Check if user is an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a regular user.
     *
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Get doctor's poli.
     *
     * @return string|null
     */
    public function getPoli(): ?string
    {
        return $this->poli_spesialisasi;
    }

    /**
     * Get all antrians (appointments) for this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function antrians()
    {
        return $this->hasMany(Antrians::class);
    }

    /**
     * Get antrians where this user is the doctor (for dokter role).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function antriansSebagaiDokter()
    {
        return $this->hasMany(Antrians::class, 'dokter_id');
    }
}

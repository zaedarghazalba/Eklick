<?php

namespace App\Enums;

class AntrianStatus
{
    public const MENUNGGU = 'menunggu';
    public const DIPANGGIL = 'dipanggil';
    public const SELESAI = 'selesai';

    /**
     * Get all available statuses
     *
     * @return array
     */
    public static function all(): array
    {
        return [
            self::MENUNGGU,
            self::DIPANGGIL,
            self::SELESAI,
        ];
    }

    /**
     * Check if status is valid
     *
     * @param string $status
     * @return bool
     */
    public static function isValid(string $status): bool
    {
        return in_array($status, self::all());
    }

    /**
     * Get status labels
     *
     * @return array
     */
    public static function labels(): array
    {
        return [
            self::MENUNGGU => 'Menunggu',
            self::DIPANGGIL => 'Dipanggil',
            self::SELESAI => 'Selesai',
        ];
    }

    /**
     * Get status badges
     *
     * @return array
     */
    public static function badges(): array
    {
        return [
            self::MENUNGGU => 'warning',
            self::DIPANGGIL => 'info',
            self::SELESAI => 'success',
        ];
    }
}

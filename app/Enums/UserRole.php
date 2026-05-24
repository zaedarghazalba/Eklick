<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case DOKTER = 'dokter';
    case USER = 'user';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrator',
            self::DOKTER => 'Dokter',
            self::USER => 'Pasien',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Models\Antrians;
use App\Enums\UserRole;
use App\Enums\AntrianStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardService
{
    private const CACHE_TTL_MINUTES = 5;
    private const CACHE_PREFIX = 'dashboard:';

    public function getStatistics(): array
    {
        return [
            'totalUsers' => $this->getTotalUsers(),
            'totalDokter' => $this->getTotalDokter(),
            'totalAntrian' => $this->getTotalAntrian(),
            'antrianHariIni' => $this->getAntrianHariIni(),
            'antrianSelesaiHariIni' => $this->getAntrianSelesaiHariIni(),
            'antrianMenungguHariIni' => $this->getAntrianMenungguHariIni(),
            'antrianDipanggilHariIni' => $this->getAntrianDipanggilHariIni(),
            'antrianMenunggu' => $this->getAntrianByStatus(AntrianStatus::MENUNGGU),
            'antrianDipanggil' => $this->getAntrianByStatus(AntrianStatus::DIPANGGIL),
            'antrianSelesai' => $this->getAntrianByStatus(AntrianStatus::SELESAI),
            'antrianPerPoli' => $this->getAntrianPerPoli(),
            'antrianPerPoliHariIni' => $this->getAntrianPerPoliHariIni(),
            'recentAntrian' => $this->getRecentAntrian(),
            'recentUsers' => $this->getRecentUsers(),
        ];
    }

    public function getTotalUsers(): int
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'total_users',
            self::CACHE_TTL_MINUTES * 60,
            fn () => User::where('role', UserRole::USER)->count()
        );
    }

    public function getTotalDokter(): int
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'total_dokter',
            self::CACHE_TTL_MINUTES * 60,
            fn () => User::where('role', UserRole::DOKTER)->count()
        );
    }

    public function getTotalAntrian(): int
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'total_antrian',
            self::CACHE_TTL_MINUTES * 60,
            fn () => Antrians::count()
        );
    }

    public function getAntrianHariIni(): int
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'antrian_today',
            60,
            fn () => Antrians::whereDate('tanggal_daftar', today())->count()
        );
    }

    public function getAntrianSelesaiHariIni(): int
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'antrian_selesai_today',
            60,
            fn () => Antrians::whereDate('tanggal_daftar', today())
                ->where('status', AntrianStatus::SELESAI)
                ->count()
        );
    }

    public function getAntrianMenungguHariIni(): int
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'antrian_menunggu_today',
            60,
            fn () => Antrians::whereDate('tanggal_daftar', today())
                ->where('status', AntrianStatus::MENUNGGU)
                ->count()
        );
    }

    public function getAntrianDipanggilHariIni(): int
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'antrian_dipanggil_today',
            60,
            fn () => Antrians::whereDate('tanggal_daftar', today())
                ->where('status', AntrianStatus::DIPANGGIL)
                ->count()
        );
    }

    public function getAntrianByStatus(string $status): int
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'antrian_status_' . $status,
            self::CACHE_TTL_MINUTES * 60,
            fn () => Antrians::where('status', $status)->count()
        );
    }

    public function getAntrianPerPoli(): array
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'antrian_per_poli',
            self::CACHE_TTL_MINUTES * 60,
            fn () => Antrians::select('poli', DB::raw('count(*) as total'))
                ->groupBy('poli')
                ->get()
                ->toArray()
        );
    }

    public function getAntrianPerPoliHariIni(): array
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'antrian_per_poli_today',
            60,
            fn () => Antrians::select('poli', DB::raw('count(*) as total'))
                ->whereDate('tanggal_daftar', today())
                ->groupBy('poli')
                ->get()
                ->toArray()
        );
    }

    public function getRecentAntrian(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return Antrians::with('user')
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    public function getRecentUsers(int $limit = 5): \Illuminate\Database\Eloquent\Collection
    {
        return User::where('role', UserRole::USER)
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    public function invalidateCache(): void
    {
        Cache::flush();
    }

    public function invalidateTodayCache(): void
    {
        Cache::forget(self::CACHE_PREFIX . 'antrian_today');
        Cache::forget(self::CACHE_PREFIX . 'antrian_selesai_today');
        Cache::forget(self::CACHE_PREFIX . 'antrian_menunggu_today');
        Cache::forget(self::CACHE_PREFIX . 'antrian_dipanggil_today');
        Cache::forget(self::CACHE_PREFIX . 'antrian_per_poli_today');
    }
}
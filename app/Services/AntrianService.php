<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Antrians;
use App\Enums\AntrianStatus;
use App\Jobs\SendAntrianDipanggilNotification;
use App\Jobs\SendAntrianSelesaiNotification;
use Illuminate\Support\Facades\Log;

class AntrianService
{
    public function __construct(
        private readonly DashboardService $dashboardService
    ) {}

    public function panggilAntrian(int $id): Antrians
    {
        $antrian = Antrians::with('user')->findOrFail($id);

        if ($antrian->status === AntrianStatus::SELESAI) {
            throw new \Exception('Antrian sudah selesai!');
        }

        $antrian->update([
            'status' => AntrianStatus::DIPANGGIL,
            'dipanggil_at' => now(),
            'skipped' => false,
        ]);

        Log::info("Antrian {$antrian->no_antrian} dipanggil", ['antrian_id' => $id]);

        $this->dispatchNotification($antrian, 'dipanggil');
        $this->dashboardService->invalidateTodayCache();

        return $antrian->fresh();
    }

    public function skipAntrian(int $id): Antrians
    {
        $antrian = Antrians::findOrFail($id);

        if ($antrian->status === AntrianStatus::SELESAI) {
            throw new \Exception('Antrian sudah selesai!');
        }

        $antrian->update([
            'skipped' => true,
            'status' => AntrianStatus::MENUNGGU,
        ]);

        Log::info("Antrian {$antrian->no_antrian} di-skip", ['antrian_id' => $id]);
        $this->dashboardService->invalidateTodayCache();

        return $antrian->fresh();
    }

    public function selesaiAntrian(int $id): Antrians
    {
        $antrian = Antrians::with('user')->findOrFail($id);

        $antrian->update([
            'status' => AntrianStatus::SELESAI,
            'tanggal_periksa' => now(),
        ]);

        Log::info("Antrian {$antrian->no_antrian} selesai", ['antrian_id' => $id]);

        $this->dispatchNotification($antrian, 'selesai');
        $this->dashboardService->invalidateTodayCache();

        return $antrian->fresh();
    }

    public function resetAntrian(int $id): Antrians
    {
        $antrian = Antrians::findOrFail($id);

        $antrian->update([
            'status' => AntrianStatus::MENUNGGU,
            'skipped' => false,
            'dipanggil_at' => null,
        ]);

        Log::info("Antrian {$antrian->no_antrian} direset", ['antrian_id' => $id]);
        $this->dashboardService->invalidateTodayCache();

        return $antrian->fresh();
    }

    private function dispatchNotification(Antrians $antrian, string $type): void
    {
        if (!$antrian->user_id) {
            Log::info("Tidak ada user untuk antrian {$antrian->no_antrian}, notifikasi dilewati");
            return;
        }

        if ($type === 'dipanggil') {
            SendAntrianDipanggilNotification::dispatch($antrian->id, $antrian->user_id);
        } elseif ($type === 'selesai') {
            SendAntrianSelesaiNotification::dispatch($antrian->id, $antrian->user_id);
        }
    }
}
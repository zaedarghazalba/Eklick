<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Antrians;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

final class CleanupOldAntrians implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 1;
    public int $timeout = 300;

    public function __construct(
        public readonly int $daysToKeep = 90
    ) {
        $this->onQueue('maintenance');
    }

    public function handle(): void
    {
        $cutoffDate = now()->subDays($this->daysToKeep);

        $oldAntrians = Antrians::onlyTrashed()
            ->where('deleted_at', '<', $cutoffDate)
            ->get();

        $count = $oldAntrians->count();

        foreach ($oldAntrians as $antrian) {
            try {
                if ($antrian->rekam_medis && Storage::exists($antrian->rekam_medis)) {
                    Storage::delete($antrian->rekam_medis);
                }

                $antrian->forceDelete();
            } catch (\Exception $e) {
                Log::error('Failed to cleanup antrian', [
                    'antrian_id' => $antrian->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        Log::info('CleanupOldAntrians completed', [
            'deleted_count' => $count,
            'cutoff_date' => $cutoffDate->toDateTimeString(),
        ]);
    }

    public function failed(\Throwable $e): void
    {
        Log::error('CleanupOldAntrians failed', [
            'days_to_keep' => $this->daysToKeep,
            'error' => $e->getMessage(),
        ]);
    }

    public function tags(): array
    {
        return ['maintenance', 'cleanup', 'antrians'];
    }
}
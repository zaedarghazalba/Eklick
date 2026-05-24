<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Antrians;
use App\Models\User;
use App\Notifications\AntrianSelesai;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

final class SendAntrianSelesaiNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 60;
    public int $maxExceptions = 3;

    public function __construct(
        public readonly int $antrianId,
        public readonly int $userId
    ) {
        $this->onQueue('notifications');
    }

    public function handle(): void
    {
        $antrian = Antrians::with('user')->find($this->antrianId);
        $user = User::find($this->userId);

        if (!$antrian || !$user || !$user->email) {
            Log::warning('AntrianSelesaiNotification skipped: missing data', [
                'antrian_id' => $this->antrianId,
                'user_id' => $this->userId,
            ]);
            return;
        }

        try {
            Notification::send($user, new AntrianSelesai($antrian));

            Log::info('AntrianSelesaiNotification sent', [
                'antrian_id' => $this->antrianId,
                'user_id' => $this->userId,
            ]);
        } catch (\Exception $e) {
            Log::error('AntrianSelesaiNotification failed', [
                'antrian_id' => $this->antrianId,
                'user_id' => $this->userId,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function failed(\Throwable $e): void
    {
        Log::error('SendAntrianSelesaiNotification permanently failed', [
            'antrian_id' => $this->antrianId,
            'user_id' => $this->userId,
            'error' => $e->getMessage(),
        ]);
    }

    public function tags(): array
    {
        return ['antrian', 'notification', 'selesai', 'antrian:' . $this->antrianId];
    }
}
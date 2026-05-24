<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Antrians;
use App\Jobs\SendAntrianDipanggilNotification;
use App\Jobs\SendAntrianSelesaiNotification;
use App\Services\AuditService;
use App\Enums\AntrianStatus;

class AntrianObserver
{
    public function __construct(
        private readonly AuditService $auditService
    ) {}

    public function created(Antrians $antrian): void
    {
        $this->auditService->logCreate($antrian);
    }

    public function updating(Antrians $antrian): void
    {
        $originalStatus = $antrian->getOriginal('status');
        $newStatus = $antrian->status;

        if ($originalStatus !== $newStatus) {
            $this->handleStatusChange($antrian, $originalStatus, $newStatus);
        }

        $this->auditService->logUpdate(
            $antrian,
            $antrian->getOriginal(),
            $antrian->getAttributes()
        );
    }

    public function deleted(Antrians $antrian): void
    {
        $this->auditService->logDelete($antrian, $antrian->getOriginal());
    }

    private function handleStatusChange(
        Antrians $antrian,
        ?string $originalStatus,
        string $newStatus
    ): void {
        if ($newStatus === AntrianStatus::DIPANGGIL && $antrian->user_id) {
            SendAntrianDipanggilNotification::dispatch(
                $antrian->id,
                $antrian->user_id
            );
        }

        if ($newStatus === AntrianStatus::SELESAI && $antrian->user_id) {
            SendAntrianSelesaiNotification::dispatch(
                $antrian->id,
                $antrian->user_id
            );
        }
    }
}
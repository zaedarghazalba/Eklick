<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\User;
use App\Services\AuditService;

class UserObserver
{
    public function __construct(
        private readonly AuditService $auditService
    ) {}

    public function created(User $user): void
    {
        $this->auditService->logCreate($user);
    }

    public function updating(User $user): void
    {
        $this->auditService->logUpdate(
            $user,
            $user->getOriginal(),
            $user->getAttributes()
        );
    }

    public function deleted(User $user): void
    {
        $this->auditService->logDelete($user, $user->getOriginal());
    }
}
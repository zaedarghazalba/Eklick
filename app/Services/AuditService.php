<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditService
{
    public function log(
        string $action,
        ?Model $model = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): AuditLog {
        $request = app(Request::class);

        return AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model?->getKey(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }

    public function logCreate(Model $model): AuditLog
    {
        return $this->log(
            AuditLog::ACTION_CREATE,
            $model,
            null,
            $model->getAttributes()
        );
    }

    public function logUpdate(Model $model, array $oldValues, array $newValues): AuditLog
    {
        return $this->log(
            AuditLog::ACTION_UPDATE,
            $model,
            $oldValues,
            $newValues
        );
    }

    public function logDelete(Model $model, array $oldValues): AuditLog
    {
        return $this->log(
            AuditLog::ACTION_DELETE,
            $model,
            $oldValues,
            null
        );
    }

    public function logLogin(string $email, bool $success = true): AuditLog
    {
        $action = $success ? AuditLog::ACTION_LOGIN : 'login_failed';

        return AuditLog::create([
            'action' => $action,
            'old_values' => ['email' => $email],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function logLogout(): AuditLog
    {
        return AuditLog::create([
            'user_id' => Auth::id(),
            'action' => AuditLog::ACTION_LOGOUT,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
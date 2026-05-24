<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Antrians;
use App\Models\User;
use App\Models\AuditLog;
use App\Observers\AntrianObserver;
use App\Observers\UserObserver;
use App\Services\AuditService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AuditService::class, function ($app) {
            return new AuditService();
        });
    }

    public function boot(): void
    {
        Antrians::observe(AntrianObserver::class);
        User::observe(UserObserver::class);
    }
}
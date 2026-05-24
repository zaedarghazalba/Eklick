<?php

use App\Jobs\CleanupOldAntrians;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'jwt.auth' => \App\Http\Middleware\JwtAuthenticate::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule): void {
        $schedule->job(new CleanupOldAntrians(90))
            ->weeklyOn(1, '02:00')
            ->withoutOverlapping()
            ->onOneServer();

        $schedule->command('cache:prune-stale-tags')
            ->hourly();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

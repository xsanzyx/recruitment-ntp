<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Jalankan pengecekan status user di setiap request web
        $middleware->web(append: [
            \App\Http\Middleware\CheckUserStatus::class,
        ]);

        // Daftarkan alias middleware untuk proteksi route berdasarkan role
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'hr' => \App\Http\Middleware\HRMiddleware::class,
            'kandidat' => \App\Http\Middleware\CandidateMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

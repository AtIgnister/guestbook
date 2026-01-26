<?php

use App\Http\Middleware\BanCheck;
use App\Http\Middleware\UserBanCheck;
use App\Http\Middleware\ValidateAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'BanCheck' => BanCheck::class,
            'UserBanCheck' => UserBanCheck::class,
            'ValidateAdmin' =>ValidateAdmin::class,
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
    $middleware->trustProxies(
        at: [
            '127.0.0.1',
            '::1',
        ],
        headers: Request::HEADER_X_FORWARDED_FOR
            | Request::HEADER_X_FORWARDED_HOST
            | Request::HEADER_X_FORWARDED_PORT
            | Request::HEADER_X_FORWARDED_PROTO
    );
})
->withExceptions(function (Exceptions $exceptions): void {
    //
})->create();

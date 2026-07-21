<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'หน้าเว็บหมดอายุ กรุณารีเฟรชหน้าเว็บแล้วลองใหม่อีกครั้ง'], 419);
            }
            return redirect()->back()->withInput($request->except('_token', 'password'))->with('error', 'หน้าเว็บหรือเซสชันของคุณหมดอายุแล้ว กรุณากดลองใหม่อีกครั้งครับ');
        });
    })->create();

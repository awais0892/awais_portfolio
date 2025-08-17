<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware groups.
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware aliases.
     *
     * In Laravel 12 the property name is $middlewareAliases. Older apps may
     * still use $routeMiddleware which won't be read by the framework; map
     * middleware aliases here so they are properly registered.
     */
    protected $middlewareAliases = [
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];

    /**
     * Backwards compatibility: some parts of the framework or cached containers
     * may still look for $routeMiddleware. Keep a copy so both names work.
     */
    protected $routeMiddleware = [
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];
}

<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
        // Keep CSP relaxed initially; can be tightened with nonces if needed
        $csp = "default-src 'self'; "
             . "img-src 'self' data: https:; "
             . "style-src 'self' 'unsafe-inline' https:; "
             . "script-src 'self' 'unsafe-inline' 'unsafe-eval' https:; "
             . "font-src 'self' https: data:; "
             . "connect-src 'self' https:";
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}

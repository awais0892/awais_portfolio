<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Require an authenticated user for admin routes
        if (! $request->user()) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}

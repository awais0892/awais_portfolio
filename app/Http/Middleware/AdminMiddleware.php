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
        // Simple admin guard; replace with proper auth later.
        if (! session('is_admin')) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}

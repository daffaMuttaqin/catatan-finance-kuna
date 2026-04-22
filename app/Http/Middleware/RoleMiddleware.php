<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    // public function handle($request, Closure $next, ...$roles)
    // {
    //     if (!in_array(auth()->user()->role, $roles)) {
    //         abort(403);
    //     }

    //     return $next($request);
    // }

    // Gunakan untuk menghindari Trying to get property 'role' of null
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}

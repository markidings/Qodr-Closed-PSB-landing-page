<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$allowedRoles)
    {
        $userRole = auth()->user()->role;

        if (in_array($userRole, $allowedRoles)) {
            return $next($request);
        }

        return redirect()->route('home');
    }
}

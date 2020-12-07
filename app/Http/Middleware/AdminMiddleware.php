<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Models\Role;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->hasRole(Role::ROLE_ADMIN)) {
                return $next($request);
            }
        }

        return redirect()->route('login');
    }
}

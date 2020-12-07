<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Models\Role;
use App\Models\User;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param string $name
     * @return mixed
     */
    public function handle($request, Closure $next, $name)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $isFail = false;

        if ($name == Role::ROLE_ADMIN) {
            if (! $user->hasRole($name)) $isFail = true;
        } elseif ($name == Role::ROLE_PUSKESMAS) {
            // TODO
        }

        // TODO: abort page
        if ($isFail) {
            dd('abort 403');
        }

        return $next($request);
    }
}

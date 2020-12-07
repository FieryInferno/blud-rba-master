<?php

namespace App\Http\Middleware;

use Closure;

class ApiWhitelistIP
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
        $remoteAddress = $request->ip();
        
        /*$whitelist = [
            "103.135.14.191",
	    "127.0.0.1",
	    "103.135.14.177",
	    "103.135.14.1"
    	];

        if(!in_array($remoteAddress, $whitelist)) {
            return response()->json([
                'message' => 'Anda tidak diizinkan untuk mengakses hal ini.',
                'data' => null
            ], 400);
	}*/

        $request->headers->set('Accept', 'application/json');
        
        return $next($request);
    }
}

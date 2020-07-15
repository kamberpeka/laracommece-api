<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthorityRoles
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string[] ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if(in_array(auth()->user()->role, $roles))
            return $next($request);

        return abort(403);
    }
}

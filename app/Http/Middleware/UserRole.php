<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $role_at)
    {
        if ((str_contains($request->route()->uri, '/user/permission') && Auth::user()->id != 1) == true)
            return redirect(route('403'));
        else if (!hasAccess(Auth::user()->internal_role_id, $role, $role_at))
            return redirect(route('403'));
        return $next($request);
    }
}

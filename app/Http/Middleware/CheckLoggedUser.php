<?php

namespace App\Http\Middleware;

use Closure;

class CheckLoggedUser
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
        if(!auth()->user()) {
            return redirect('auth/unauthorized');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Cookie;

use Closure;

class CheckGroup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $Admin, $PM)
    {
        if($request->user() === null)
        {
            return response("Insufficient permission!", 401);
        }

        if($request->user()->hasGroup($Admin) || $request->user()->hasGroup($PM))
        {
            return $next($request);
        }

        return response("Insufficient permission!", 401);
    }
}

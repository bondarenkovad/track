<?php

namespace App\Http\Middleware;

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
    public function handle($request, Closure $next, $group)
    {
        if($request->user() === null)
        {
            return response("Insufficient permission!", 401);
        }

        if($request->user()->hasGroup($group))
        {

            return $next($request);
        }

        return response("Insufficient permission!", 401);
    }
}

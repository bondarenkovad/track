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
    public function handle($request, Closure $next, $Admin)
    {
        if($request->user() === null)
        {
            session()->flash('danger', 'Only with Administrator permissions!');
            return back();
        }

        if($request->user()->hasGroup($Admin))
        {
            return $next($request);
        }

        session()->flash('danger', 'Only with Administrator permissions!');
        return back();
    }
}

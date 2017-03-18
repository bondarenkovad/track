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
    public function handle($request, Closure $next, $group)
    {
//        echo $group;
        return $next($request);
//        if($request->user() === null)
//        {
//            return response("Insufficient permission!", 401);
//        }
//
//
////        $group = 'Administrator';
//
//        if($request->user()->hasGroup($group))
//        {
//
//
//        }
////        dd($request->route());
////            return $request->route();
////        return $this->addCookieToResponse($request, $next($request));
//        return response("Insufficient permission!", 401);

    }

    protected function addCookieToResponse($request, $response)
    {
        $response->headers->setCookie(
            new Cookie('XSRF-TOKEN', $request->session()->token(), time() + 60 * 120, '/', null, false, false)
        );
        return $response;
    }

}

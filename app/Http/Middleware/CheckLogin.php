<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckLogin
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
        if (
                (
                    !$request->is('login') && 
                    !$request->is('logout') && 
                    !$request->is('password/forgot') && 
                    !$request->is('password/emailReset') && 
                    !$request->is('password/resetPassword') &&
                    !$request->is('password/reset')
                ) 
                && Auth::guest() 
            ) {
                if($request->ajax()){
                    return abort('403');
                }
           return redirect("/login?next=".$request->url());
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class MainAdminLogin
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
        if(!$request->session()->exists('admin'))
        {
            return redirect('/main-admin')->with('error','Please Log In First');
        }
        return $next($request);
    }
}

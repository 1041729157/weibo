<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null){
        if (Auth::guard($guard)->check()) {
            // return redirect(RouteServiceProvider::HOME);
            session()->flash('danger', '您已登录，无需再次操作。');
        

            // $fallback = route('home');
            // return redirect()->intended($fallback);

            // return redirect()->back();

            return redirect('/');
        }
        //return $next($request);时，相当与把请求传入接下来的逻辑中。同时，中间件也可以返回重定向，不运行之前的逻辑
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check() && auth()->user()->is_employee == 1){
            return redirect()->route('production.home');
        }
        if(Auth::guard($guard)->check() && auth()->user()->is_employee == 0){
            return redirect()->route('sale.home');
        }
        if(Auth::guard($guard)->check() && auth()->user()->is_employee == 2){
            return redirect()->route('admin.home');
        }
        
        return $next($request);
    }
}

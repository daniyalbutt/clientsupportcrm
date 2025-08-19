<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsSale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->is_employee == 0){
            return $next($request);
        }

        return redirect()->back()->with("error","You don't have emplyee rights.");
    
    }
}

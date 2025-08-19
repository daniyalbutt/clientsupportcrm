<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsClient
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
        if(auth()->user()->is_employee == 3){
            return $next($request);
        }
   
        return redirect()->back()->with("error","You don't have admin access.");
    }
}

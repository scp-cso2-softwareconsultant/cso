<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Providers\RouteServiceProvider;

class AccessAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role_permission=null, $crud_guard=null) 
    {
       
        if( Auth::user()->role_permission( Auth::id(), $role_permission,$crud_guard) )
            return $next($request);
    }
}

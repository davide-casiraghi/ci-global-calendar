<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        
        $user = \Auth::user();
        
        if(($user->isAdmin()||$user->isSuperAdmin()) == 1){
            return $next($request);
        }
        
        return redirect('/')->with('message','You have not admin access');
        
    }
}

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

        // If user is not logged
        if (! $user) {
            return redirect('/')->with('message', 'You have not admin access');
        }

        // If user is logged and admin/superadmin
        if (($user->isAdmin() || $user->isSuperAdmin()) == 1) {
            return $next($request);
        }

        // Return to homepage if user il logged but not admin
        return redirect('/')->with('message', 'You have not admin access');
    }
}

<?php
/*
    CORS middleware (Cross-Origin Resource Sharing)
    https://laravel-nepal.com/cross-origin-resource-sharing-cors-laravel-5/
    
    Implemented to allow access to the calendar from the regional websites iframe
*/


namespace App\Http\Middleware;

use Closure;

class Cors
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
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-XSRF-TOKEN, X-Requested-With');
    }
}

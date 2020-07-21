<?php

namespace Acacha\AdminLTETemplateLaravel\Http\Middleware;

use Closure;
use Illuminate\Foundation\Auth\User;

/**
 * Class GuestUser
 * @package Acacha\User\Http\Middleware
 */
class GuestUser
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
        view()->share('signedIn', auth()->check());
        view()->share('user', auth()->user() ?: new User);
        
        return $next($request);
    }
}
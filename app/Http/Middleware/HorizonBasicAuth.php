<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;

class HorizonBasicAuth extends AuthenticateWithBasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null, $field = null)
    {
        return $this->auth->guard()->onceBasic()? :$next($request);
    }
}

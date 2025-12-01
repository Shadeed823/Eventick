<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return  redirect()->route('login');
        }
    }
}

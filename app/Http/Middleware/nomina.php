<?php

namespace App\Http\Middleware;

use Closure;

class nomina
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
        if (auth()->check()) {
            if (auth()->user()->type != 1 || auth()->user()->type != 2) {
                return redirect()->to('/dashboard');
            }
        } else {
            return redirect()->to('/');
        }
        return $next($request);
    }
}

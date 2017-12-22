<?php

namespace App\Http\Middleware;

use Closure;

class supervisor
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
            if (auth()->user()->type == 3) {
                return redirect()->to('/dashboard');
            }
        } else {
            return redirect()->to('/');
        }
        return $next($request);
    }
}

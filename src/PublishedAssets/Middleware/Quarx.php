<?php

namespace App\Http\Middleware;

use Closure;
use Gate;

class Quarx
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Gate::allows('quicksite')) {
            return $next($request);
        }

        return response('Unauthorized.', 401);
    }
}

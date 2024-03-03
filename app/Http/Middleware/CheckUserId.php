<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserId
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role_id == 1) {
            return $next($request);
        }

        return response()->json(['status' => false, 'error' => 'Unauthorized'], 401);
    }
}

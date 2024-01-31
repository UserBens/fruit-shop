<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(auth()->check() && auth()->user()->role == User::ROLE_ADMIN) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}

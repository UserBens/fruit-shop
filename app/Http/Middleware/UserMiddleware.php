<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(auth()->check() && auth()->user()->role == User::ROLE_USER) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
        
    }
}

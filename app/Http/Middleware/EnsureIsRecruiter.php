<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureIsRecruiter
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'recruiter') {
            return $next($request);
        }

        return redirect('/')->with('error', 'You do not have access to this section.');
    }
}

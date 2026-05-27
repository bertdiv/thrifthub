<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        if (auth()->user()->is_blocked) {
    Auth::logout();
    return redirect('/login')->withErrors([
        'email' => 'Your account has been blocked by admin.'
    ]);
}

        return $next($request);
    }
}
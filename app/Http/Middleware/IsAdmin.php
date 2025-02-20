<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the authenticated user is an admin
        if (auth()->user() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // If not an admin, redirect to home with an error message
        return redirect('/')->with('error', 'Access Denied: Admins Only.');
    }
}

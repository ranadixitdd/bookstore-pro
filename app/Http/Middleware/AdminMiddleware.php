<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated and is an admin
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            // Redirect to home or show an error
            return redirect('/')->with('error', 'You do not have admin access.');
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Check if the request is an API request
        if ($request->is('api/*')) {
            // For API requests, return 401 response
            abort(401, 'Unauthenticated.');
        }

        // For web requests, redirect to the login page
        return route('login');
    }
}

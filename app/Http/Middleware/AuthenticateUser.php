<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Symfony\Component\HttpFoundation\Response;

class AuthenticateUser
{

    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            $notification = array(
                'message' => 'You must login to access this page',
                'alert-type' => 'error'
            );
            // Redirect to user login if not authenticated
            return redirect()->route('user.login')->with($notification);
        }

        return $next($request);
    }
}

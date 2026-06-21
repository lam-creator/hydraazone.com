<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Authenticate
{

    public function handle(Request $request, Closure $next): Response
    {

		if ($request->routeIs('admin.*')) {
            if (Auth::guard('admin')->check()) {
                return $next($request);
            }
        }

        // abort(401);
        $notification = array(
            'message' => 'You must login to access this page',
            'alert-type' => 'error'
        );
        return Redirect()->route('admin.login')->with($notification);

    }
}

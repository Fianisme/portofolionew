<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login')
                ->with('error', 'Please login to access admin panel.');
        }

        return $next($request);
    }
}

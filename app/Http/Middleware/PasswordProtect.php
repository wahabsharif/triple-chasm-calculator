<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PasswordProtect
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->get('password_authenticated', false)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Password required', 401);
            }
            // For normal web requests, show the password modal view
            return response()->view('password');
        }
        return $next($request);
    }
}

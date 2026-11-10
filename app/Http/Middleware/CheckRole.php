<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
    if (!$request->user()) {
        return redirect()->route('login');
    }

    if (!in_array($request->user()->role, $roles, true)) {
        abort(403, 'You are not authorised to access this page.');
    }

    return $next($request);
    }
}

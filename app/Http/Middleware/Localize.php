<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

final class Localize
{
    public function handle(Request $request, Closure $next)
    {
        if ($locale = $request->header('x-locale')) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}

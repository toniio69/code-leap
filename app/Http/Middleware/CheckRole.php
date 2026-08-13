<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (! auth()->check() || ! in_array($request->user()->role, $roles)) {
            abort(403, 'Unauthorized action.'); // [cite: 43]
        }

        return $next($request);
    }
}

$this->authorize('create', Course::class);

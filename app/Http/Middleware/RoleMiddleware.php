<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if ($request->user()) {
            if ($request->user()->hasAnyRole($roles)) {
                return $next($request);
            }

            throw UnauthorizedException::forRoles($roles);
        }

        return redirect('/');
    }
}

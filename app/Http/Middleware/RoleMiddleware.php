<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $roles  Comma- or pipe-separated role names
     */
    public function handle(Request $request, Closure $next, string $roles = null)
    {
        $user = $request->user();

        if (! $user) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('usersLogin');
        }

        $allowed = array_filter(array_map('trim', preg_split('/[|,]/', $roles ?? '')));

        if (empty($allowed)) {
            abort(403, 'Forbidden');
        }

        // Resolve role name: prefer helper if present, fallback to user_role string
        try {
            $userRole = method_exists($user, 'getRoleName') ? $user->getRoleName() : ($user->user_role ?? null);
        } catch (\Throwable $e) {
            $userRole = $user->user_role ?? null;
        }

        if (! $userRole || ! in_array($userRole, $allowed, true)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden.'], 403);
            }
            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\SystemSettingsModel\ManageRolesModel;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
    * @param  string[]|null  $roles  Comma- or pipe-separated role names or multiple params
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (! $user) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('usersLogin');
        }

        // Populate route and panel variables for logging later.
        $routeName = $request->route() ? $request->route()->getName() : null;
        $panel = $request->query('panel') ?? $request->input('panel') ?? null;
        // Normalize middleware role parameters: support both a single string
        // like "admin,officer" and multiple parameters like "admin","officer".
        $rolesParam = null;
        if (! empty($roles)) {
            $rolesParam = implode(',', array_map('strval', $roles));
        }

        // Allow users flagged as platform admins to bypass role checks only
        // when the middleware explicitly allows the 'admin' role.
        try {
                if (! empty($user->is_admin) && (int) $user->is_admin === 1) {
                    if (is_string($rolesParam) && preg_match('/\b(admin|administrator)\b/i', $rolesParam)) {
                        try {
                            Log::info('RoleMiddleware: allowed by is_admin bypass', [
                                'user_id' => $user->id ?? null,
                                'user_role_raw' => $user->user_role ?? null,
                                'roles_param' => $rolesParam,
                                'route' => $request->route() ? $request->route()->getName() : null,
                                'reason' => 'is_admin_bypass',
                            ]);
                        } catch (\Throwable $e) {
                            // ignore logging failures
                        }

                        return $next($request);
                    }
                }
        } catch (\Throwable $e) {
            // ignore and continue with normal role resolution
        }

        $allowedRaw = array_filter(array_map('trim', preg_split('/[|,]/', $rolesParam ?? '')));

        if (empty($allowedRaw)) {
            try {
                Log::warning('RoleMiddleware: denied because no allowed roles specified', [
                    'user_id' => $user->id ?? null,
                    'roles_param' => $rolesParam,
                    'route' => $routeName ?? null,
                    'panel' => $panel ?? null,
                ]);
            } catch (\Throwable $e) {
                // ignore logging failures
            }

            abort(403, 'Forbidden');
        }

        // Load alias map from config (simple, extensible)
        $aliases = config('roles.aliases', []);

        // Split allowed items into numeric ids and names/aliases
        $allowedIds = [];
        $allowedNames = [];
        foreach ($allowedRaw as $roleItem) {
            if ($roleItem === '') {
                continue;
            }

            if (ctype_digit((string) $roleItem)) {
                $allowedIds[] = (int) $roleItem;
                continue;
            }

            $key = strtolower(preg_replace('/[^a-z0-9]/', '', $roleItem));
            if (isset($aliases[$key])) {
                $allowedNames[] = $aliases[$key];
                continue;
            }

            // Try to canonicalize a provided name from DB
            $roleModel = ManageRolesModel::whereRaw('LOWER(name) = ?', [strtolower($roleItem)])->first();
            if ($roleModel) {
                $allowedNames[] = $roleModel->name;
                continue;
            }

            $allowedNames[] = $roleItem;
        }

        $allowedIds = array_unique($allowedIds);
        $allowedNames = array_unique($allowedNames);

        // Resolve user's role id (prefer numeric FK stored on users.user_role)
        $userRoleId = null;
        try {
            if (isset($user->user_role) && is_numeric($user->user_role)) {
                $userRoleId = (int) $user->user_role;
            } elseif (isset($user->role) && $user->role) {
                $userRoleId = $user->role->id ?? null;
            }
        } catch (\Throwable $e) {
            $userRoleId = null;
        }

        // If allowed contains numeric ids, check them first
        if (! empty($allowedIds) && $userRoleId !== null) {
            if (in_array($userRoleId, $allowedIds, true)) {
                        try {
                            Log::info('RoleMiddleware: allowed by id match', [
                                'user_id' => $user->id ?? null,
                                'user_role_id' => $userRoleId,
                                'allowed_ids' => $allowedIds,
                                'route' => $routeName ?? null,
                                'panel' => $panel ?? null,
                                'reason' => 'id_match',
                            ]);
                } catch (\Throwable $e) {
                    // ignore logging failures
                }

                return $next($request);
            }
        }

        // Resolve user's role name for name-based checks
        try {
            $userRoleName = method_exists($user, 'getRoleName') ? $user->getRoleName() : ($user->user_role ?? null);
        } catch (\Throwable $e) {
            $userRoleName = $user->user_role ?? null;
        }

        // If the user role is an id but we don't have a name yet, try to fetch it
        if (empty($userRoleName) && $userRoleId !== null) {
            $r = ManageRolesModel::find($userRoleId);
            $userRoleName = $r->name ?? null;
        }

        // Case-insensitive comparison between user role name and allowed names
        foreach ($allowedNames as $allowedName) {
            if (is_string($allowedName) && $userRoleName && strcasecmp($allowedName, $userRoleName) === 0) {
                    try {
                        Log::info('RoleMiddleware: allowed by name match', [
                            'user_id' => $user->id ?? null,
                            'user_role_name' => $userRoleName,
                            'allowed_name' => $allowedName,
                            'allowed_names' => $allowedNames,
                            'route' => $routeName ?? null,
                            'panel' => $panel ?? null,
                            'reason' => 'name_match',
                        ]);
                    } catch (\Throwable $e) {
                        // ignore logging failures
                    }

                return $next($request);
            }
        }

        try {
            Log::warning('RoleMiddleware: denied — no matching role', [
                'user_id' => $user->id ?? null,
                'user_role_id' => $userRoleId ?? null,
                'user_role_name' => $userRoleName ?? null,
                'allowed_ids' => $allowedIds,
                'allowed_names' => $allowedNames,
                'roles_param' => $rolesParam,
                'route' => $routeName ?? null,
                'panel' => $panel ?? null,
                'reason' => 'no_match',
            ]);
        } catch (\Throwable $e) {
            // ignore logging failures
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }
        abort(403, 'Forbidden');

        return $next($request);
    }
}

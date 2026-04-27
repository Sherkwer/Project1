<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemSettingsModel\ManageRolesModel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('role', function ($roles) {
            if (! Auth::check()) {
                return false;
            }
            return Auth::user()->hasAnyRole($roles);
        });



        // Helper to resolve a user's canonical role name
        $resolveRoleName = function ($user) {
            if (! $user) {
                return null;
            }

            try {
                if (method_exists($user, 'getRoleName')) {
                    return $user->getRoleName();
                } elseif (isset($user->user_role) && is_numeric($user->user_role)) {
                    $r = ManageRolesModel::query()->find((int) $user->user_role);
                    return $r->name ?? null;
                } elseif (isset($user->role) && $user->role) {
                    return $user->role->name ?? null;
                }
            } catch (\Throwable $e) {
                return null;
            }

            return null;
        };

        // Gate: hide for Super Administrator only
        $hideIfSuperAdmin = function ($user) use ($resolveRoleName) {
            if (! $user) {
                return false;
            }

            try {
                $roleName = $resolveRoleName($user);
                if ($roleName && strcasecmp($roleName, 'Super Administrator') === 0) {
                    return false; // hide for Super Administrator
                }
            } catch (\Throwable $e) {
                return true; // fail-open on error
            }

            return true;
        };

        // Gate: hide for Officer only
        $hideIfOfficer = function ($user) use ($resolveRoleName) {
            if (! $user) {
                return false;
            }

            try {
                $roleName = $resolveRoleName($user);
                if ($roleName && strcasecmp($roleName, 'Officer') === 0) {
                    return false; // hide for Officer
                }
            } catch (\Throwable $e) {
                return true; // fail-open on error
            }

            return true;
        };

        // Gates hidden only from Super Administrators
        foreach ([
            'view-dashboard',
            'view-students-menu',
            'view-events',
            'view-violation',
            'view-fees',
            'view-announcements',
                'view-attendance',
                'view-payments',
                'view-reports',
        ] as $gate) {
            Gate::define($gate, $hideIfSuperAdmin);
        }

        // Gates hidden from Officers
        foreach ([
            'view-dashboard',
            'view-students-menu',
            'view-events',
            'view-violation',
            'view-fees',
            'view-announcements',
        ] as $gate) {
            Gate::define($gate, $hideIfOfficer);
        }
    }
}

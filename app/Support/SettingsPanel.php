<?php

namespace App\Support;

use Illuminate\Http\Request;

/**
 * Whitelist + redirects for System Settings multi-panel UI (?panel=ManageCampusPanel).
 */
class SettingsPanel
{
    public const DEFAULT = 'ManageMyAccountPanel';

    /** @var list<string> */
    public const ALLOWED = [
        'ManageMyAccountPanel',
        'ManageDataPanel',
        'ManageCampusPanel',
        'ManageCollegePanel',
        'ManageOrganizationPanel',
        'ManageProgramsPanel',
        'ManageRolesPanel',
        'ManageUsersAccountsPanel',
        'ManageSemesterPanel',
        'FeesPanel',
        'notificationPanel',
        'activityPanel',
    ];

    public static function resolve(?string $panel): string
    {
        if ($panel !== null && $panel !== '' && in_array($panel, self::ALLOWED, true)) {
            return $panel;
        }

        return self::DEFAULT;
    }

    /**
     * Redirect to Settings with the same panel the user was on (from hidden input `settings_panel`).
     */
    public static function redirectWith(Request $request, array $with = []): \Illuminate\Http\RedirectResponse
    {
        $panel = self::resolve($request->input('settings_panel'));

        return redirect()
            ->route('SystemSettings_pagination', ['panel' => $panel])
            ->with($with);
    }

    /**
     * Use after Settings POST actions: stay on the same panel if `settings_panel` was posted, else normal back().
     */
    public static function backOrSettings(Request $request, array $with = []): \Illuminate\Http\RedirectResponse
    {
        if ($request->filled('settings_panel')) {
            return self::redirectWith($request, $with);
        }

        return back()->with($with);
    }
}

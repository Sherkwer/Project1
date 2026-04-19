<?php

namespace App\Support;

use Illuminate\Http\Request;

/**
 * Whitelist + redirects for System Settings multi-panel UI (?panel=ManageCampusPanel).
 */
class FeesTab
{
    public const DEFAULT = 'vert-tabs-fees';

    /** @var list<string> */
    public const ALLOWED = [
        'vert-tabs-fees',
        'vert-tabs-fees-types',
    ];

    public static function resolve(?string $tabs): string
    {
        if ($tabs !== null && $tabs !== '' && in_array($tabs, self::ALLOWED, true)) {
            return $tabs;
        }

        return self::DEFAULT;
    }

    /**
     * Redirect to Settings with the same panel the user was on (from hidden input `Fees_tabs`).
     */
    public static function redirectWith(Request $request, array $with = []): \Illuminate\Http\RedirectResponse
    {
        $tabs = self::resolve($request->input('fees_tabs'));

        return redirect()
            ->route('Fees_pagination', ['tabs' => $tabs])
            ->with($with);
    }

    /**
     * Use after Settings POST actions: stay on the same panel if `settings_panel` was posted, else normal back().
     */
    public static function backOrSettings(Request $request, array $with = []): \Illuminate\Http\RedirectResponse
    {
        if ($request->filled('fees_tabs')) {
            return self::redirectWith($request, $with);
        }

        return back()->with($with);
    }
}

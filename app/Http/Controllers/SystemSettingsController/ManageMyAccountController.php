<?php

namespace App\Http\Controllers\SystemSettingsController;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SystemSettingsModel\ManageCampusModel;
use App\Models\SystemSettingsModel\ManageCollegeModel;
use App\Models\SystemSettingsModel\ManageOrganizationModel;
use App\Models\SystemSettingsModel\ManageRolesModel;
use App\Support\SettingsPanel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class ManageMyAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Update profile (name fields + email + dropdowns). Keeps user on Settings > My Account panel.
     */
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'fname' => 'nullable|string|max:191',
            'mname' => 'nullable|string|max:191',
            'lname' => 'nullable|string|max:191',
            'email' => 'required|email|max:191|unique:users,email,' . $user->id,
            'area_id' => 'nullable|integer|exists:areas,id',
            'college_id' => 'nullable|integer|exists:db_colleges,id',
            'organization_id' => 'nullable|integer|exists:tbl_organizations,id',
            'role_id' => 'nullable|integer|exists:tbl_roles,id',
        ]);

        $fname = trim((string) ($validated['fname'] ?? ''));
        $mname = trim((string) ($validated['mname'] ?? ''));
        $lname = trim((string) ($validated['lname'] ?? ''));

        $user->fname = $fname !== '' ? $fname : $user->fname;
        $user->mname = $mname !== '' ? $mname : $user->mname;
        $user->lname = $lname !== '' ? $lname : $user->lname;

        $parts = array_filter([$user->fname, $user->mname, $user->lname], fn ($p) => $p !== null && $p !== '');
        $user->fullname = trim(implode(' ', $parts)) ?: ($user->fullname ?? $user->email);

        $user->email = $validated['email'];

        // Update dropdown fields - map to actual table columns
        // Frontend sends area_id, college_id but table has area_code, college columns
        if ($validated['area_id'] && Schema::hasColumn($user->getTable(), 'area_code')) {
            $area = ManageCampusModel::find($validated['area_id']);
            if ($area) {
                $user->area_code = $area->area_code;
            }
        }

        if ($validated['college_id']) {
            if (Schema::hasColumn($user->getTable(), 'department_id')) {
                $user->department_id = $validated['college_id'];
            } elseif (Schema::hasColumn($user->getTable(), 'college')) {
                $user->college = $validated['college_id'];
            }
        }

        if ($validated['organization_id']) {
            if (Schema::hasColumn($user->getTable(), 'organization_id')) {
                $user->organization_id = $validated['organization_id'];
            }
        }

        if ($validated['role_id']) {
            if (Schema::hasColumn($user->getTable(), 'user_role')) {
                $user->user_role = $validated['role_id'];
            }
        }

        $user->save();

        return SettingsPanel::backOrSettings($request, ['success' => 'Profile updated successfully.']);
    }

    /**
     * Change password: current password + new password + explicit acknowledgements.
     * (MFA / email OTP can be layered here later — see comment below.)
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'password_change_ack' => ['accepted'],
        ], [
            'password_change_ack.accepted' => 'You must confirm that you want to change your password.',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->getAuthPassword())) {
            throw ValidationException::withMessages([
                'current_password' => ['Current password is incorrect.'],
            ]);
        }

        $user->password = $request->password;
        if (Schema::hasColumn($user->getTable(), 'password_reset_at')) {
            $user->password_reset_at = now();
        }
        $user->save();

        return SettingsPanel::backOrSettings($request, [
            'success' => 'Password updated successfully. If you are signed in elsewhere, sign in again there.',
        ]);
    }

    /**
     * Account termination — requires exact phrase, email match, password, and checkbox.
     * Optional: send email OTP / 2FA before this route (not implemented here).
     */
    public function terminateAccount(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'terminate_phrase' => ['required', 'string', 'in:TERMINATE MY ACCOUNT'],
            'terminate_email' => ['required', 'email', 'in:' . $user->email],
            'terminate_password' => ['required'],
            'terminate_final_ack' => ['accepted'],
        ], [
            'terminate_phrase.in' => 'You must type the phrase exactly: TERMINATE MY ACCOUNT',
            'terminate_email.in' => 'Email must match your account email exactly.',
            'terminate_final_ack.accepted' => 'You must acknowledge that this action cannot be undone.',
        ]);

        if (!Hash::check($request->terminate_password, $user->getAuthPassword())) {
            return SettingsPanel::backOrSettings($request, [
                'error' => 'Incorrect password. Your account was not changed.',
            ]);
        }

        $table = $user->getTable();
        if (Schema::hasColumn($table, 'deleted_at')) {
            $user->deleted_at = now();
            if (Schema::hasColumn($table, 'deactivation_reason')) {
                $user->deactivation_reason = 'Self-service termination from Settings';
            }
            $user->save();
        } else {
            $user->delete();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with(
            'success',
            'Your account has been deactivated. Contact an administrator if you need access restored.'
        );
    }

    /**
     * Legacy JSON endpoint — kept for compatibility; prefer updateProfile.
     */
    public function store_myaccount(Request $request)
    {
        $myaccount = new User();
        $myaccount->id = $request->s_id;
        $myaccount->fname = $request->s_fname;
        $myaccount->mname = $request->s_mname;
        $myaccount->lname = $request->s_lname;
        $myaccount->fullname = $request->s_fullname;
        $myaccount->department_id = $request->s_department_id;
        $myaccount->user_role = $request->s_user_role;
        $myaccount->save();

        return response()->json($myaccount);
    }
}

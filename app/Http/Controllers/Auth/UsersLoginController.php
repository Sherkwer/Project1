<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;

class UsersLoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm(Request $request)
    {
        $roleKey = $request->query('role');
        $dd = $request->all();
        $roles = [
            'super_admin' => 'Super Administrator',
            'admin' => 'Administrator',
            'officer' => 'Officer',
            'student' => 'Student',
        ];
        $loginRole = $roles[$roleKey] ?? null;
        return view('auth.usersLogin', compact('loginRole'));
    }

    /**
     * Handle user login
     */
    public function userslogin(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->route('usersLogin', ['role' => $request->role])->withErrors($validator)->withInput();
        }

        // Attempt to login
        $credentials = $request->only('email', 'password');
        $requestedRoleKey = $request->input('role') ?? null;
        $requestedCanonical = null;
        if ($requestedRoleKey) {
            $normalized = strtolower(preg_replace('/[^a-z0-9]/', '', (string) $requestedRoleKey));
            $aliases = config('roles.aliases', []);
            if (isset($aliases[$normalized])) {
                $requestedCanonical = $aliases[$normalized];
            } else {
                // try direct lookup in DB (case-insensitive)
                try {
                    $r = \App\Models\SystemSettingsModel\ManageRolesModel::whereRaw('LOWER(name) = ?', [strtolower($requestedRoleKey)])->first();
                    if ($r) {
                        $requestedCanonical = $r->name;
                    }
                } catch (\Throwable $e) {
                    // ignore DB resolution errors and proceed without canonical name
                }
            }
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (! empty($requestedCanonical)) {
                if (! $user->hasRole($requestedCanonical)) {
                    Auth::logout();
                    return redirect()->route('usersLogin', ['role' => $requestedRoleKey])
                        ->with('error', "Only {$requestedCanonical} accounts can sign in here.")
                        ->withInput();
                }
            }

            $request->session()->regenerate();
            return redirect()->intended('home');
        }

        // Login failed
        return redirect()->route('usersLogin', ['role' => $request->role])->with('error', 'Invalid email or password')->withInput();
    }

    /**
     * Send OTP code to user's email for password reset.
     */
     public function sendPasswordOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'We could not find an account with that email address.',
            ], 404);
        }

        $code = rand(100000, 999999);

        // reuse verification fields for password reset OTP
        $user->verification_code = $code;
        $user->verification_created_at = now();
        $user->is_requested_vrc = 1;
        $user->save();

        Mail::raw("Your password reset OTP code is: {$code}", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Password Reset OTP Code');
        });

        return response()->json([
            'success' => true,
            'message' => 'An OTP has been sent to your email address.',
        ]);
    }

    
    /**
     * Reset password using OTP code sent to email.
     */
    public function resetPasswordWithOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::whereRaw('LOWER(email) = ?', [strtolower($request->email)])->first();

        if (! $user || ! $user->verification_code) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.'])->withInput();
        }

        $createdAt = $user->verification_created_at
            ? Carbon::parse($user->verification_created_at)
            : null;

        $isExpired = ! $createdAt || $createdAt->lt(now()->subMinutes(10));

        if ($user->verification_code !== $request->otp || $isExpired) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.'])->withInput();
        }

        // password is automatically hashed by the model cast
        $user->password = $request->password;
        $user->verification_code = null;
        $user->verification_created_at = null;
        $user->is_requested_vrc = 0;
        $user->password_reset_at = now();
        $user->save();

        return redirect()->route('usersLogin')->with('success', 'Your password has been updated. You can now log in.');
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/welcome');
    }
}

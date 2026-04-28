<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use App\Models\User;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Show the email verification notice.
     */
    public function show()
    {
        return view('auth.verify-email');
    }

    /**
     * Mark the authenticated user's email as verified.
     */
    public function verify(Request $request)
    {
        try {
            $user = User::findOrFail($request->route('id'));

            // Validate that the hash in the URL matches the user's email.
            if (! hash_equals(
                (string) $request->route('hash'),
                sha1($user->getEmailForVerification())
            )) {
                return redirect('/email/verify')->with('error', 'Invalid verification link. Please request a new one.');
            }

            if ($user->hasVerifiedEmail()) {
                return redirect('/home')->with('success', 'Email already verified.');
            }

            if ($user->markEmailAsVerified()) {
                event(new Verified($user));
            }

            return redirect('/home')->with('success', 'Email verified successfully!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect('/email/verify')->with('error', 'User not found. Please log in and try again.');
        } catch (\Throwable $e) {
            return redirect('/email/verify')->with('error', 'Something went wrong. Please try again later.');
        }
    }

    /**
     * Resend the email verification notification.
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect('/home')->with('success', 'Email already verified.');
        }

        try {
            $request->user()->sendEmailVerificationNotification();
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to send verification email. Please try again later.');
        }

        return back()->with('success', 'Verification link sent! Please check your inbox.');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UsersRegistrationController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.usersRegistration');
    }

    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            /* 'gender' => 'required|in:Male,Female',
            'age' => 'required|integer|min:1|max:120',
            'address' => 'required|string|max:255',*/
            'role' => 'required|in:Administrator,Staff,Student',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create new user
        $user = User::create([
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'fullname' => $request->fname . ' ' . ($request->mname ? $request->mname . ' ' : '') . $request->lname,
            'gender' => $request->gender,
            'age' => $request->age,
            'address' => $request->address,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => null, // User needs email verification
        ]);

        // Send email verification if needed
        $user->sendEmailVerificationNotification();

        // after a successful registration we want to show the login form
        // redirect the user to the named login route instead of the
        // homepage. a flash message may be shown on the login page.
        return redirect()->route('usersLogin')
                 ->with('success', 'Registration successful. Please login.');
    }
}

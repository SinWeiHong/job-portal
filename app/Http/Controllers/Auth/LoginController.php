<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display the login page.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Validate the submitted credentials
     * and authenticate the user.
     */
    public function store(
        Request $request
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Validate Login Input
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            [
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                ],

                'password' => [
                    'required',
                    'string',
                ],

                'remember' => [
                    'nullable',
                    'boolean',
                ],
            ],
            [
                'email.required' =>
                    'Please enter your email address.',

                'email.email' =>
                    'Please enter a valid email address.',

                'email.max' =>
                    'The email address must not exceed 255 characters.',

                'password.required' =>
                    'Please enter your password.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Inactive Account Check
        |--------------------------------------------------------------------------
        |
        | Only show the deactivation message when both the account and password
        | are correct. An incorrect password still receives the normal invalid
        | credentials message.
        |
        */

        $user = User::query()
            ->where(
                'email',
                $validated['email']
            )
            ->first();

        if (
            $user !== null
            && !$user->is_active
            && Hash::check(
                $validated['password'],
                $user->password
            )
        ) {
            return back()
                ->withErrors([
                    'email' =>
                        'This account has been deactivated. Please contact the administrator.',
                ])
                ->onlyInput('email');
        }

        /*
        |--------------------------------------------------------------------------
        | Authentication
        |--------------------------------------------------------------------------
        */

        $credentials = [
            'email' =>
                $validated['email'],

            'password' =>
                $validated['password'],

            'is_active' =>
                true,
        ];

        $remember = $request->boolean(
            'remember'
        );

        if (
            !Auth::attempt(
                $credentials,
                $remember
            )
        ) {
            return back()
                ->withErrors([
                    'email' =>
                        'The provided email address or password is incorrect.',
                ])
                ->onlyInput('email');
        }

        /*
        |--------------------------------------------------------------------------
        | Session Security
        |--------------------------------------------------------------------------
        */

        $request
            ->session()
            ->regenerate();

        return redirect()
            ->intended(
                route('dashboard')
            )
            ->with(
                'success',
                'You have logged in successfully.'
            );
    }

    /**
     * Log the authenticated user out securely.
     */
    public function destroy(
        Request $request
    ): RedirectResponse {
        Auth::logout();

        $request
            ->session()
            ->invalidate();

        $request
            ->session()
            ->regenerateToken();

        return redirect()
            ->route('login')
            ->with(
                'success',
                'You have logged out successfully.'
            );
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display the job seeker login page.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Validate the login details and authenticate the user.
     */
    public function store(Request $request): RedirectResponse
    {
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
                    'min:8',
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

                'password.min' =>
                    'The password must contain at least 8 characters.',
            ]
        );

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()
                ->withErrors([
                    'email' =>
                        'The provided email address or password is incorrect.',
                ])
                ->onlyInput('email');
        }

        /*
         * Regenerate the session after successful authentication.
         */
        $request->session()->regenerate();

        return redirect()
            ->intended(route('dashboard'))
            ->with(
                'success',
                'You have logged in successfully.'
            );
    }
}
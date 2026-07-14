<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     * Validate the submitted login information.
     *
     * Actual authentication will be implemented
     * in the next commit.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(
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
                'email.required' => 'Please enter your email address.',
                'email.email' => 'Please enter a valid email address.',
                'email.max' => 'The email address must not exceed 255 characters.',

                'password.required' => 'Please enter your password.',
                'password.min' => 'The password must contain at least 8 characters.',
            ]
        );

        return back()->with(
            'success',
            'The login information is valid. Authentication will be implemented in the next development stage.'
        );
    }
}
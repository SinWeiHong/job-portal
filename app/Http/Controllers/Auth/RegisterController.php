<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Display the job seeker registration page.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Validate the submitted job seeker registration information.
     *
     * The account will be saved to the database in the next commit.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'unique:users,email',
                ],

                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                ],
            ],
            [
                'name.required' => 'Please enter your full name.',
                'name.max' => 'The full name must not exceed 255 characters.',

                'email.required' => 'Please enter your email address.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email address has already been registered.',

                'password.required' => 'Please enter a password.',
                'password.min' => 'The password must contain at least 8 characters.',
                'password.confirmed' => 'The password confirmation does not match.',
            ]
        );

        /*
         * User creation will be implemented in Week 2 Commit 3.
         * This commit confirms that all submitted information is valid.
         */
        return back()->with(
            'success',
            'Registration information is valid. Account creation will be implemented in the next development stage.'
        );
    }
}
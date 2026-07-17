<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
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
     * Validate and create a new job seeker account.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
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
                    'confirmed',
                    Password::defaults(),
                ],
            ],
            [
                'name.required' =>
                    'Please enter your full name.',

                'name.max' =>
                    'The full name must not exceed 255 characters.',

                'email.required' =>
                    'Please enter your email address.',

                'email.email' =>
                    'Please enter a valid email address.',

                'email.max' =>
                    'The email address must not exceed 255 characters.',

                'email.unique' =>
                    'This email address has already been registered.',

                'password.required' =>
                    'Please enter a password.',

                'password.confirmed' =>
                    'The password confirmation does not match.',
            ]
        );

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],

            /*
             * Never store a plain-text password.
             */
            'password' => Hash::make($validated['password']),

            /*
             * Public registration creates job seeker accounts only.
             */
            'role' => 'job_seeker',
        ]);

        return redirect()
            ->route('register')
            ->with(
                'success',
                'Your job seeker account has been registered successfully.'
            );
    }
}
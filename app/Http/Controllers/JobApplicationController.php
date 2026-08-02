<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobApplicationController extends Controller
{
    /**
     * Display the job application form.
     */
    public function create(JobPost $jobPost): View
    {
        return view('applications.create', [
            'jobPost' => $jobPost,
        ]);
    }

    /**
     * Validate and store a new job application.
     */
    public function store(
        Request $request,
        JobPost $jobPost
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Authentication Check
        |--------------------------------------------------------------------------
        |
        | Saving an application requires a logged-in user's ID.
        | Job-seeker role validation will be added in Week 2 Commit 2.
        |
        */

       if (!$request->user()) {
    return back()
        ->withErrors([
            'authentication' =>
                'Please log in before applying for a job.',
        ])
        ->withInput();
}

        /*
        |--------------------------------------------------------------------------
        | Application Input Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            [
                'cover_letter' => [
                    'required',
                    'string',
                    'max:5000',
                ],
            ],
            [
                'cover_letter.required' =>
                    'Please enter your cover letter.',

                'cover_letter.string' =>
                    'The cover letter must be valid text.',

                'cover_letter.max' =>
                    'The cover letter must not exceed 5000 characters.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Save Job Application
        |--------------------------------------------------------------------------
        */

        JobApplication::create([
            'job_post_id' => $jobPost->id,
            'job_seeker_id' => $request->user()->id,
            'cover_letter' => $validated['cover_letter'],
            'status' => 'pending',
        ]);

        return redirect()
            ->route('applications.create', $jobPost)
            ->with(
                'success',
                'Your job application has been submitted successfully.'
            );
    }
}
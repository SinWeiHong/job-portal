<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobApplicationController extends Controller
{
    /**
     * Display the application form for a job posting.
     */
    public function create(JobPost $jobPost): View
    {
        return view('applications.create', [
            'jobPost' => $jobPost,
        ]);
    }

    /**
     * Handle the temporary form submission flow.
     *
     * Validation and database storage will be implemented
     * in JPW-4 Week 2 Commit 1.
     */
    public function store(
        Request $request,
        JobPost $jobPost
    ): RedirectResponse {
        return redirect()
            ->route('applications.create', $jobPost)
            ->with(
                'info',
                'The application form was submitted. Validation and database storage will be implemented in the next development commit.'
            );
    }
}
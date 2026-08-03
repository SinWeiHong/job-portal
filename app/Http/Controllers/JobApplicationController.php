<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class JobApplicationController extends Controller
{
    /**
     * Display the job application form.
     */
    public function create(
        Request $request,
        JobPost $jobPost
    ): View {
        /*
        |--------------------------------------------------------------------------
        | Authentication and Role Validation
        |--------------------------------------------------------------------------
        */

        $this->ensureJobSeeker($request);

        /*
        |--------------------------------------------------------------------------
        | Application Availability
        |--------------------------------------------------------------------------
        */

        $applicationUnavailableMessage =
            $this->getApplicationUnavailableMessage(
                $jobPost,
                $request->user()->id
            );

        return view('applications.create', [
            'jobPost' => $jobPost,
            'canApply' => $applicationUnavailableMessage === null,
            'applicationUnavailableMessage' =>
                $applicationUnavailableMessage,
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
        | Authentication and Role Validation
        |--------------------------------------------------------------------------
        */

        $this->ensureJobSeeker($request);

        /*
        |--------------------------------------------------------------------------
        | Job Status, Deadline and Duplicate Validation
        |--------------------------------------------------------------------------
        */

        $applicationUnavailableMessage =
            $this->getApplicationUnavailableMessage(
                $jobPost,
                $request->user()->id
            );

        if ($applicationUnavailableMessage !== null) {
            return back()
                ->withErrors([
                    'job' => $applicationUnavailableMessage,
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Cover Letter Validation
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
        | Save Application
        |--------------------------------------------------------------------------
        */

        JobApplication::create([
            'job_post_id' => $jobPost->id,
            'job_seeker_id' => $request->user()->id,
            'cover_letter' => trim($validated['cover_letter']),
            'status' => 'pending',
        ]);

        return redirect()
            ->route('applications.create', $jobPost)
            ->with(
                'success',
                'Your job application has been submitted successfully.'
            );
    }

    /**
     * Confirm that the current user is a logged-in job seeker.
     */
    private function ensureJobSeeker(Request $request): void
    {
        abort_unless(
            $request->user() !== null,
            401,
            'Please log in before applying for a job.'
        );

        abort_unless(
            strtolower(
                trim((string) $request->user()->role)
            ) === 'job_seeker',
            403,
            'Only job seekers can apply for jobs.'
        );
    }

    /**
     * Return the reason why the application cannot continue.
     *
     * A null value means that the job seeker can apply.
     */
    private function getApplicationUnavailableMessage(
        JobPost $jobPost,
        int $jobSeekerId
    ): ?string {
        /*
        |--------------------------------------------------------------------------
        | Job Status Check
        |--------------------------------------------------------------------------
        */

        if (
            strtolower(
                trim((string) $jobPost->status)
            ) !== 'open'
        ) {
            return 'This job posting is not open for applications.';
        }

        /*
        |--------------------------------------------------------------------------
        | Application Deadline Check
        |--------------------------------------------------------------------------
        |
        | A deadline equal to today's date is still accepted.
        |
        */

        if ($jobPost->application_deadline !== null) {
            $deadline = Carbon::parse(
                $jobPost->application_deadline
            )->startOfDay();

            if ($deadline->lt(today())) {
                return 'The application deadline for this job has passed.';
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Duplicate Application Check
        |--------------------------------------------------------------------------
        */

        $alreadyApplied = JobApplication::query()
            ->where('job_post_id', $jobPost->id)
            ->where('job_seeker_id', $jobSeekerId)
            ->exists();

        if ($alreadyApplied) {
            return 'You have already applied for this job.';
        }

        return null;
    }
}
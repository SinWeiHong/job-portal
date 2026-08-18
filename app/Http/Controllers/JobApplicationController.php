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
        $this->ensureJobSeeker($request);

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
        $this->ensureJobSeeker($request);

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

        JobApplication::create([
            'job_post_id' => $jobPost->id,
            'job_seeker_id' => $request->user()->id,
            'cover_letter' => trim(
                $validated['cover_letter']
            ),
            'status' => 'pending',
        ]);

        return redirect()
            ->route(
                'applications.create',
                $jobPost
            )
            ->with(
                'success',
                'Your job application has been submitted successfully.'
            );
    }

    /**
     * Confirm that the current user is a logged-in job seeker.
     */
    private function ensureJobSeeker(
        Request $request
    ): void {
        abort_unless(
            $request->user() !== null,
            401,
            'Please log in before applying for a job.'
        );

        abort_unless(
            strtolower(
                trim(
                    (string) $request->user()->role
                )
            ) === 'job_seeker',
            403,
            'Only job seekers can access this function.'
        );
    }

    /**
     * Return the reason why the application cannot continue.
     */
    private function getApplicationUnavailableMessage(
        JobPost $jobPost,
        int $jobSeekerId
    ): ?string {
        /*
        |--------------------------------------------------------------------------
        | Job Status
        |--------------------------------------------------------------------------
        */

        if (
            strtolower(
                trim(
                    (string) $jobPost->status
                )
            ) !== 'open'
        ) {
            return 'This job posting is not open for applications.';
        }

        /*
        |--------------------------------------------------------------------------
        | Application Deadline
        |--------------------------------------------------------------------------
        */

        if (
            $jobPost->application_deadline
            !== null
        ) {
            $deadline = Carbon::parse(
                $jobPost->application_deadline
            )->startOfDay();

            if ($deadline->lt(today())) {
                return 'The application deadline for this job has passed.';
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Duplicate Application
        |--------------------------------------------------------------------------
        */

        $alreadyApplied =
            JobApplication::query()
                ->where(
                    'job_post_id',
                    $jobPost->id
                )
                ->where(
                    'job_seeker_id',
                    $jobSeekerId
                )
                ->exists();

        if ($alreadyApplied) {
            return 'You have already applied for this job.';
        }

        return null;
    }

    /**
     * Display the logged-in job seeker's
     * submitted applications.
     *
     * JPW-5
     */
    public function index(
        Request $request
    ): View|RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Job Seeker Access
        |--------------------------------------------------------------------------
        */

        $this->ensureJobSeeker($request);

        $jobSeekerId =
            $request->user()->id;

        /*
        |--------------------------------------------------------------------------
        | Available Application Statuses
        |--------------------------------------------------------------------------
        */

        $availableStatuses =
            JobApplication::query()
                ->where(
                    'job_seeker_id',
                    $jobSeekerId
                )
                ->whereNotNull('status')
                ->pluck('status')
                ->map(
                    fn ($status) =>
                        strtolower(
                            trim(
                                (string) $status
                            )
                        )
                )
                ->filter()
                ->unique()
                ->sort()
                ->values();

        /*
        |--------------------------------------------------------------------------
        | Status Filter Validation
        |--------------------------------------------------------------------------
        */

        $rawStatus =
            $request->query('status');

        if (
            $rawStatus !== null
            && !is_string($rawStatus)
        ) {
            return redirect()
                ->route(
                    'applications.index'
                )
                ->withErrors([
                    'status' =>
                        'The application status filter is invalid.',
                ]);
        }

        $selectedStatus =
            strtolower(
                trim(
                    (string) $rawStatus
                )
            );

        if (
            $selectedStatus !== ''
            && (
                strlen(
                    $selectedStatus
                ) > 20

                || preg_match(
                    '/^[a-z0-9_-]+$/',
                    $selectedStatus
                ) !== 1

                || !$availableStatuses
                    ->contains(
                        $selectedStatus
                    )
            )
        ) {
            return redirect()
                ->route(
                    'applications.index'
                )
                ->withErrors([
                    'status' =>
                        'The selected application status is invalid.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Retrieve Applications
        |--------------------------------------------------------------------------
        */

        $applicationsQuery =
            JobApplication::query()
                ->with('jobPost')
                ->where(
                    'job_seeker_id',
                    $jobSeekerId
                );

        if (
            $selectedStatus !== ''
        ) {
            $applicationsQuery
                ->where(
                    'status',
                    $selectedStatus
                );
        }

        $applications =
            $applicationsQuery
                ->latest()
                ->get();

        $totalApplications =
            JobApplication::query()
                ->where(
                    'job_seeker_id',
                    $jobSeekerId
                )
                ->count();

        return view(
            'applications.index',
            [
                'applications' =>
                    $applications,

                'availableStatuses' =>
                    $availableStatuses,

                'selectedStatus' =>
                    $selectedStatus,

                'totalApplications' =>
                    $totalApplications,
            ]
        );
    }

    /**
     * Display applicants for an employer's
     * own job posting.
     *
     * JPW-10
     */
    public function employerApplicants(
        Request $request,
        JobPost $jobPost
    ): View|RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Employer Access
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $request->user() !== null,
            401,
            'Please log in before viewing applicants.'
        );

        abort_unless(
            strtolower(
                trim(
                    (string)
                    $request->user()->role
                )
            ) === 'employer',
            403,
            'Only employers can view applicants.'
        );

        /*
        |--------------------------------------------------------------------------
        | Job Ownership
        |--------------------------------------------------------------------------
        */

        abort_unless(
            (int) $jobPost->employer_id
                ===
            (int) $request->user()->id,
            403,
            'You can only view applicants for your own job postings.'
        );

        /*
        |--------------------------------------------------------------------------
        | Available Application Statuses
        |--------------------------------------------------------------------------
        */

        $availableStatuses =
            $jobPost
                ->applications()
                ->whereNotNull('status')
                ->pluck('status')
                ->map(
                    fn ($status) =>
                        strtolower(
                            trim(
                                (string) $status
                            )
                        )
                )
                ->filter()
                ->unique()
                ->sort()
                ->values();

        /*
        |--------------------------------------------------------------------------
        | Search Validation
        |--------------------------------------------------------------------------
        */

        $rawSearch =
            $request->query('search');

        if (
            $rawSearch !== null
            && !is_string($rawSearch)
        ) {
            return redirect()
                ->route(
                    'employer.applicants.index',
                    $jobPost
                )
                ->withErrors([
                    'search' =>
                        'The applicant search value is invalid.',
                ]);
        }

        $search = trim(
            (string) $rawSearch
        );

        if (
            strlen($search) > 100
        ) {
            return redirect()
                ->route(
                    'employer.applicants.index',
                    $jobPost
                )
                ->withErrors([
                    'search' =>
                        'The applicant search must not exceed 100 characters.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter Validation
        |--------------------------------------------------------------------------
        */

        $rawStatus =
            $request->query('status');

        if (
            $rawStatus !== null
            && !is_string($rawStatus)
        ) {
            return redirect()
                ->route(
                    'employer.applicants.index',
                    $jobPost
                )
                ->withErrors([
                    'status' =>
                        'The application status filter is invalid.',
                ]);
        }

        $selectedStatus =
            strtolower(
                trim(
                    (string) $rawStatus
                )
            );

        if (
            $selectedStatus !== ''
            && (
                strlen(
                    $selectedStatus
                ) > 20

                || preg_match(
                    '/^[a-z0-9_-]+$/',
                    $selectedStatus
                ) !== 1

                || !$availableStatuses
                    ->contains(
                        $selectedStatus
                    )
            )
        ) {
            return redirect()
                ->route(
                    'employer.applicants.index',
                    $jobPost
                )
                ->withErrors([
                    'status' =>
                        'The selected application status is invalid.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Applicant Query
        |--------------------------------------------------------------------------
        */

        $applicationsQuery =
            $jobPost
                ->applications()
                ->with('jobSeeker');

        /*
        |--------------------------------------------------------------------------
        | Search by Name or Email
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {
            $applicationsQuery
                ->whereHas(
                    'jobSeeker',
                    function ($query) use (
                        $search
                    ) {
                        $query
                            ->where(
                                'name',
                                'like',
                                '%' .
                                $search .
                                '%'
                            )
                            ->orWhere(
                                'email',
                                'like',
                                '%' .
                                $search .
                                '%'
                            );
                    }
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter by Status
        |--------------------------------------------------------------------------
        */

        if (
            $selectedStatus !== ''
        ) {
            $applicationsQuery
                ->where(
                    'status',
                    $selectedStatus
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Retrieve Applicants
        |--------------------------------------------------------------------------
        */

        $applications =
            $applicationsQuery
                ->latest()
                ->get();

        /*
        |--------------------------------------------------------------------------
        | Applicant Summary
        |--------------------------------------------------------------------------
        */

        $totalApplicants =
            $jobPost
                ->applications()
                ->count();

        $pendingApplicants =
            $jobPost
                ->applications()
                ->where(
                    'status',
                    'pending'
                )
                ->count();

        return view(
            'applications.employer-index',
            [
                'jobPost' =>
                    $jobPost,

                'applications' =>
                    $applications,

                'availableStatuses' =>
                    $availableStatuses,

                'search' =>
                    $search,

                'selectedStatus' =>
                    $selectedStatus,

                'totalApplicants' =>
                    $totalApplicants,

                'pendingApplicants' =>
                    $pendingApplicants,
            ]
        );
    }
}
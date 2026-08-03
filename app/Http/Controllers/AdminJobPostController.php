<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminJobPostController extends Controller
{
    /**
     * Display all active job postings for moderation.
     */
    public function index(Request $request): View
    {
        $this->ensureAdministrator($request);

        $jobPosts = JobPost::query()
            ->with([
                'employer:id,name,email',
            ])
            ->latest()
            ->get();

        return view('admin.job-posts.index', [
            'jobPosts' => $jobPosts,
        ]);
    }

    /**
     * Display one job posting for administrative review.
     */
    public function show(
        Request $request,
        JobPost $jobPost
    ): View {
        $this->ensureAdministrator($request);

        $jobPost->load([
            'employer:id,name,email',
        ]);

        return view('admin.job-posts.show', [
            'jobPost' => $jobPost,
        ]);
    }

    /**
     * Display the removal confirmation form.
     */
    public function remove(
        Request $request,
        JobPost $jobPost
    ): View {
        $this->ensureAdministrator($request);

        $jobPost->load([
            'employer:id,name,email',
        ]);

        return view('admin.job-posts.remove', [
            'jobPost' => $jobPost,
        ]);
    }

    /**
     * Validate the removal reason and soft delete
     * the selected job posting.
     */
    public function destroy(
        Request $request,
        JobPost $jobPost
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Administrator Authorization
        |--------------------------------------------------------------------------
        */

        $this->ensureAdministrator($request);

        /*
        |--------------------------------------------------------------------------
        | Already Removed Validation
        |--------------------------------------------------------------------------
        */

        if ($jobPost->trashed()) {
            return redirect()
                ->route('admin.job-posts.index')
                ->with(
                    'error',
                    'This job posting has already been removed.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Removal Reason Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            [
                'removal_reason' => [
                    'required',
                    'string',
                    'min:10',
                    'max:1000',
                ],
            ],
            [
                'removal_reason.required' =>
                    'Please provide a reason for removing this job posting.',

                'removal_reason.string' =>
                    'The removal reason must be valid text.',

                'removal_reason.min' =>
                    'The removal reason must contain at least 10 characters.',

                'removal_reason.max' =>
                    'The removal reason must not exceed 1000 characters.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Record Moderation Details and Soft Delete
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $request,
            $jobPost,
            $validated
        ): void {
            $jobPost->update([
                'removal_reason' =>
                    trim($validated['removal_reason']),

                'removed_by' =>
                    $request->user()->id,

                'removed_at' =>
                    now(),
            ]);

            /*
             * SoftDeletes records the deleted_at value
             * instead of permanently deleting the record.
             */
            $jobPost->delete();
        });

        return redirect()
            ->route('admin.job-posts.index')
            ->with(
                'success',
                'The job posting has been removed successfully.'
            );
    }

    /**
     * Confirm that the logged-in user is an administrator.
     */
    private function ensureAdministrator(
        Request $request
    ): void {
        $user = $request->user();

        abort_unless(
            $user !== null &&
            strtolower(
                trim((string) $user->role)
            ) === 'administrator',
            403,
            'Only administrators can manage job postings.'
        );
    }
}
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
    public function index(): View
    {
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
    public function show(JobPost $jobPost): View
    {
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
    public function remove(JobPost $jobPost): View
    {
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
             * Because JobPost uses SoftDeletes, delete()
             * records deleted_at instead of permanently
             * deleting the database record.
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
}
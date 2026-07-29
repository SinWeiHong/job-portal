<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
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
     * Display the details of one job posting
     * for administrative review.
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
}
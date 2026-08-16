<?php

namespace Tests\Feature;

use App\Models\JobApplication;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class JobApplicationIndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Job seeker can view their own submitted applications.
     */
    public function test_job_seeker_can_view_own_applications(): void
    {
        $employer = $this->createUser('employer');
        $jobSeeker = $this->createUser('job_seeker');

        $jobPost = $this->createJobPost(
            $employer,
            [
                'title' => 'Laravel Developer',
            ]
        );

        $this->createJobApplication(
            $jobPost,
            $jobSeeker,
            'pending'
        );

        $response = $this
            ->actingAs($jobSeeker)
            ->get(route('applications.index'));

        $response
            ->assertOk()
            ->assertSee('My Applications')
            ->assertSee('Laravel Developer')
            ->assertSee('Pending');
    }

    /**
     * Job seeker cannot view applications submitted by another user.
     */
    public function test_job_seeker_cannot_view_another_users_applications(): void
    {
        $employer = $this->createUser('employer');
        $jobSeeker = $this->createUser('job_seeker');
        $otherJobSeeker = $this->createUser('job_seeker');

        $ownJob = $this->createJobPost(
            $employer,
            [
                'title' => 'Frontend Developer',
            ]
        );

        $otherJob = $this->createJobPost(
            $employer,
            [
                'title' => 'Private Backend Position',
            ]
        );

        $this->createJobApplication(
            $ownJob,
            $jobSeeker,
            'pending'
        );

        $this->createJobApplication(
            $otherJob,
            $otherJobSeeker,
            'pending'
        );

        $response = $this
            ->actingAs($jobSeeker)
            ->get(route('applications.index'));

        $response
            ->assertOk()
            ->assertSee('Frontend Developer')
            ->assertDontSee('Private Backend Position');
    }

    /**
     * Employer cannot access the submitted applications page.
     */
    public function test_non_job_seeker_cannot_view_applications_page(): void
    {
        $employer = $this->createUser('employer');

        $response = $this
            ->actingAs($employer)
            ->get(route('applications.index'));

        $response->assertForbidden();
    }

    /**
     * Guest cannot access the submitted applications page.
     */
    public function test_guest_cannot_view_applications_page(): void
    {
        $response = $this->get(
            route('applications.index')
        );

        $response->assertRedirect(
            route('login')
        );
    }

    /**
     * Job seeker can filter applications according to status.
     */
    public function test_job_seeker_can_filter_applications_by_status(): void
    {
        $employer = $this->createUser('employer');
        $jobSeeker = $this->createUser('job_seeker');

        $pendingJob = $this->createJobPost(
            $employer,
            [
                'title' => 'Pending Position',
            ]
        );

        $shortlistedJob = $this->createJobPost(
            $employer,
            [
                'title' => 'Shortlisted Position',
            ]
        );

        $this->createJobApplication(
            $pendingJob,
            $jobSeeker,
            'pending'
        );

        $this->createJobApplication(
            $shortlistedJob,
            $jobSeeker,
            'shortlisted'
        );

        $response = $this
            ->actingAs($jobSeeker)
            ->get(
                route(
                    'applications.index',
                    [
                        'status' => 'shortlisted',
                    ]
                )
            );

        $response
            ->assertOk()
            ->assertSee('Shortlisted Position')
            ->assertDontSee('Pending Position');
    }

    /**
     * Invalid application status filter is rejected.
     */
    public function test_invalid_status_filter_is_rejected(): void
    {
        $jobSeeker = $this->createUser('job_seeker');

        $response = $this
            ->actingAs($jobSeeker)
            ->get(
                route(
                    'applications.index',
                    [
                        'status' => 'invalid-status',
                    ]
                )
            );

        $response
            ->assertRedirect(
                route('applications.index')
            )
            ->assertSessionHasErrors([
                'status' =>
                    'The selected application status is invalid.',
            ]);
    }

    /**
     * Deleted job posting should not break the applications page.
     */
    public function test_deleted_job_post_is_displayed_as_unavailable(): void
    {
        $employer = $this->createUser('employer');
        $jobSeeker = $this->createUser('job_seeker');

        $jobPost = $this->createJobPost(
            $employer
        );

        $this->createJobApplication(
            $jobPost,
            $jobSeeker,
            'pending'
        );

        $jobPost->delete();

        $response = $this
            ->actingAs($jobSeeker)
            ->get(route('applications.index'));

        $response
            ->assertOk()
            ->assertSee('Job Posting Unavailable')
            ->assertSee('N/A');
    }

    /**
     * Create a user for testing.
     */
    private function createUser(string $role): User
    {
        return User::create([
            'name' => ucfirst(
                str_replace(
                    '_',
                    ' ',
                    $role
                )
            ),

            'email' =>
                Str::uuid() . '@example.com',

            'password' =>
                'Password1!',

            'role' =>
                $role,
        ]);
    }

    /**
     * Create a job posting for testing.
     */
    private function createJobPost(
        User $employer,
        array $overrides = []
    ): JobPost {
        return JobPost::create(
            array_merge(
                [
                    'employer_id' =>
                        $employer->id,

                    'title' =>
                        'Software Developer',

                    'description' =>
                        'Develop and maintain web applications.',

                    'requirements' =>
                        'Basic knowledge of PHP and Laravel.',

                    'location' =>
                        'Kuala Lumpur',

                    'employment_type' =>
                        'Full-time',

                    'salary_min' =>
                        3000,

                    'salary_max' =>
                        4500,

                    'application_deadline' =>
                        now()
                            ->addDays(7)
                            ->toDateString(),

                    'status' =>
                        'open',
                ],
                $overrides
            )
        );
    }

    /**
     * Create a job application for testing.
     */
    private function createJobApplication(
        JobPost $jobPost,
        User $jobSeeker,
        string $status
    ): JobApplication {
        return JobApplication::create([
            'job_post_id' =>
                $jobPost->id,

            'job_seeker_id' =>
                $jobSeeker->id,

            'cover_letter' =>
                'I am interested in this position.',

            'status' =>
                $status,
        ]);
    }
}
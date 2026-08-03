<?php

namespace Tests\Feature;

use App\Models\JobApplication;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class JobApplicationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A job seeker can submit a valid application.
     */
    public function test_job_seeker_can_submit_application(): void
    {
        $employer = $this->createUser('employer');
        $jobSeeker = $this->createUser('job_seeker');
        $jobPost = $this->createJobPost($employer);

        $response = $this
            ->actingAs($jobSeeker)
            ->post(
                route('applications.store', $jobPost),
                [
                    'cover_letter' =>
                        'I have relevant Laravel and MySQL experience.',
                ]
            );

        $response
            ->assertRedirect(
                route('applications.create', $jobPost)
            )
            ->assertSessionHas(
                'success',
                'Your job application has been submitted successfully.'
            );

        $this->assertDatabaseHas('job_applications', [
            'job_post_id' => $jobPost->id,
            'job_seeker_id' => $jobSeeker->id,
            'status' => 'pending',
        ]);
    }

    /**
     * An employer cannot apply for a job.
     */
    public function test_non_job_seeker_cannot_apply(): void
    {
        $employer = $this->createUser('employer');
        $jobPost = $this->createJobPost($employer);

        $response = $this
            ->actingAs($employer)
            ->post(
                route('applications.store', $jobPost),
                [
                    'cover_letter' =>
                        'This application should not be accepted.',
                ]
            );

        $response->assertForbidden();

        $this->assertDatabaseCount(
            'job_applications',
            0
        );
    }

    /**
     * A job seeker cannot apply for a closed or draft job.
     */
    public function test_job_seeker_cannot_apply_for_non_open_job(): void
    {
        $employer = $this->createUser('employer');
        $jobSeeker = $this->createUser('job_seeker');

        $jobPost = $this->createJobPost(
            $employer,
            [
                'status' => 'draft',
            ]
        );

        $response = $this
            ->actingAs($jobSeeker)
            ->from(route('applications.create', $jobPost))
            ->post(
                route('applications.store', $jobPost),
                [
                    'cover_letter' =>
                        'This application should not be accepted.',
                ]
            );

        $response
            ->assertRedirect(
                route('applications.create', $jobPost)
            )
            ->assertSessionHasErrors([
                'job' =>
                    'This job posting is not open for applications.',
            ]);

        $this->assertDatabaseCount(
            'job_applications',
            0
        );
    }

    /**
     * A job seeker cannot apply after the deadline.
     */
    public function test_job_seeker_cannot_apply_after_deadline(): void
    {
        $employer = $this->createUser('employer');
        $jobSeeker = $this->createUser('job_seeker');

        $jobPost = $this->createJobPost(
            $employer,
            [
                'application_deadline' =>
                    now()->subDay()->toDateString(),
            ]
        );

        $response = $this
            ->actingAs($jobSeeker)
            ->from(route('applications.create', $jobPost))
            ->post(
                route('applications.store', $jobPost),
                [
                    'cover_letter' =>
                        'This application is after the deadline.',
                ]
            );

        $response
            ->assertRedirect(
                route('applications.create', $jobPost)
            )
            ->assertSessionHasErrors([
                'job' =>
                    'The application deadline for this job has passed.',
            ]);

        $this->assertDatabaseCount(
            'job_applications',
            0
        );
    }

    /**
     * A job seeker cannot apply for the same job twice.
     */
    public function test_duplicate_application_is_prevented(): void
    {
        $employer = $this->createUser('employer');
        $jobSeeker = $this->createUser('job_seeker');
        $jobPost = $this->createJobPost($employer);

        JobApplication::create([
            'job_post_id' => $jobPost->id,
            'job_seeker_id' => $jobSeeker->id,
            'cover_letter' =>
                'This is the original application.',
            'status' => 'pending',
        ]);

        $response = $this
            ->actingAs($jobSeeker)
            ->from(route('applications.create', $jobPost))
            ->post(
                route('applications.store', $jobPost),
                [
                    'cover_letter' =>
                        'This is a duplicate application.',
                ]
            );

        $response
            ->assertRedirect(
                route('applications.create', $jobPost)
            )
            ->assertSessionHasErrors([
                'job' =>
                    'You have already applied for this job.',
            ]);

        $this->assertDatabaseCount(
            'job_applications',
            1
        );
    }

    /**
     * The cover letter is required.
     */
    public function test_cover_letter_is_required(): void
    {
        $employer = $this->createUser('employer');
        $jobSeeker = $this->createUser('job_seeker');
        $jobPost = $this->createJobPost($employer);

        $response = $this
            ->actingAs($jobSeeker)
            ->from(route('applications.create', $jobPost))
            ->post(
                route('applications.store', $jobPost),
                [
                    'cover_letter' => '',
                ]
            );

        $response
            ->assertRedirect(
                route('applications.create', $jobPost)
            )
            ->assertSessionHasErrors([
                'cover_letter' =>
                    'Please enter your cover letter.',
            ]);

        $this->assertDatabaseCount(
            'job_applications',
            0
        );
    }

    /**
     * Create a user with the selected role.
     */
    private function createUser(string $role): User
    {
        return User::create([
            'name' => ucfirst(
                str_replace('_', ' ', $role)
            ),
            'email' =>
                Str::uuid() . '@example.com',
            'password' => 'Password1!',
            'role' => $role,
        ]);
    }

    /**
     * Create a job posting for testing.
     *
     * @param array<string, mixed> $overrides
     */
    private function createJobPost(
        User $employer,
        array $overrides = []
    ): JobPost {
        return JobPost::create(
            array_merge(
                [
                    'employer_id' => $employer->id,
                    'title' => 'Junior Software Developer',
                    'description' =>
                        'Develop and maintain web applications.',
                    'requirements' =>
                        'Basic knowledge of PHP and Laravel.',
                    'location' => 'Kuala Lumpur',
                    'employment_type' => 'Full-time',
                    'salary_min' => 3000,
                    'salary_max' => 4500,
                    'application_deadline' =>
                        now()->addDays(7)->toDateString(),
                    'status' => 'open',
                ],
                $overrides
            )
        );
    }
}
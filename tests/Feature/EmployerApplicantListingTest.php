<?php

namespace Tests\Feature;

use App\Models\JobApplication;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class EmployerApplicantListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_employer_can_view_applicants_for_own_job_posting(): void
    {
        $employer = $this->createUser('employer');

        $jobSeeker = $this->createUser(
            'job_seeker'
        );

        $jobPost = $this->createJobPost(
            $employer
        );

        $this->createJobApplication(
            $jobPost,
            $jobSeeker,
            'pending'
        );

        $response = $this
            ->actingAs($employer)
            ->get(
                route(
                    'employer.applicants.index',
                    $jobPost
                )
            );

        $response
            ->assertOk()
            ->assertSee('Applicants')
            ->assertSee($jobSeeker->name)
            ->assertSee($jobSeeker->email)
            ->assertSee('Pending');
    }

    public function test_employer_cannot_view_another_employers_job(): void
    {
        $employer = $this->createUser(
            'employer'
        );

        $otherEmployer = $this->createUser(
            'employer'
        );

        $jobPost = $this->createJobPost(
            $otherEmployer
        );

        $response = $this
            ->actingAs($employer)
            ->get(
                route(
                    'employer.applicants.index',
                    $jobPost
                )
            );

        $response->assertForbidden();
    }

    public function test_job_seeker_cannot_view_applicant_listing(): void
    {
        $employer = $this->createUser(
            'employer'
        );

        $jobSeeker = $this->createUser(
            'job_seeker'
        );

        $jobPost = $this->createJobPost(
            $employer
        );

        $response = $this
            ->actingAs($jobSeeker)
            ->get(
                route(
                    'employer.applicants.index',
                    $jobPost
                )
            );

        $response->assertForbidden();
    }

    public function test_employer_can_search_applicants(): void
    {
        $employer = $this->createUser(
            'employer'
        );

        $alice = $this->createUser(
            'job_seeker',
            [
                'name' => 'Alice Tan',
                'email' => 'alice@example.com',
            ]
        );

        $brian = $this->createUser(
            'job_seeker',
            [
                'name' => 'Brian Lee',
                'email' => 'brian@example.com',
            ]
        );

        $jobPost = $this->createJobPost(
            $employer
        );

        $this->createJobApplication(
            $jobPost,
            $alice,
            'pending'
        );

        $this->createJobApplication(
            $jobPost,
            $brian,
            'pending'
        );

        $response = $this
            ->actingAs($employer)
            ->get(
                route(
                    'employer.applicants.index',
                    [
                        'jobPost' => $jobPost,
                        'search' => 'Alice',
                    ]
                )
            );

        $response
            ->assertOk()
            ->assertSee('Alice Tan')
            ->assertDontSee('Brian Lee');
    }

    public function test_employer_can_filter_applicants_by_status(): void
    {
        $employer = $this->createUser(
            'employer'
        );

        $pendingApplicant =
            $this->createUser(
                'job_seeker'
            );

        $shortlistedApplicant =
            $this->createUser(
                'job_seeker'
            );

        $jobPost = $this->createJobPost(
            $employer
        );

        $this->createJobApplication(
            $jobPost,
            $pendingApplicant,
            'pending'
        );

        $this->createJobApplication(
            $jobPost,
            $shortlistedApplicant,
            'shortlisted'
        );

        $response = $this
            ->actingAs($employer)
            ->get(
                route(
                    'employer.applicants.index',
                    [
                        'jobPost' => $jobPost,
                        'status' => 'shortlisted',
                    ]
                )
            );

        $response
            ->assertOk()
            ->assertSee(
                $shortlistedApplicant->email
            )
            ->assertDontSee(
                $pendingApplicant->email
            );
    }

    public function test_long_search_value_is_rejected(): void
    {
        $employer = $this->createUser(
            'employer'
        );

        $jobPost = $this->createJobPost(
            $employer
        );

        $response = $this
            ->actingAs($employer)
            ->get(
                route(
                    'employer.applicants.index',
                    [
                        'jobPost' => $jobPost,

                        'search' =>
                            str_repeat(
                                'a',
                                101
                            ),
                    ]
                )
            );

        $response
            ->assertRedirect(
                route(
                    'employer.applicants.index',
                    $jobPost
                )
            )
            ->assertSessionHasErrors([
                'search' =>
                    'The applicant search must not exceed 100 characters.',
            ]);
    }

    public function test_invalid_status_filter_is_rejected(): void
    {
        $employer = $this->createUser(
            'employer'
        );

        $jobSeeker = $this->createUser(
            'job_seeker'
        );

        $jobPost = $this->createJobPost(
            $employer
        );

        $this->createJobApplication(
            $jobPost,
            $jobSeeker,
            'pending'
        );

        $response = $this
            ->actingAs($employer)
            ->get(
                route(
                    'employer.applicants.index',
                    [
                        'jobPost' =>
                            $jobPost,

                        'status' =>
                            'invalid-status',
                    ]
                )
            );

        $response
            ->assertRedirect(
                route(
                    'employer.applicants.index',
                    $jobPost
                )
            )
            ->assertSessionHasErrors([
                'status' =>
                    'The selected application status is invalid.',
            ]);
    }

    private function createUser(
        string $role,
        array $overrides = []
    ): User {
        return User::create(
            array_merge(
                [
                    'name' =>
                        ucfirst(
                            str_replace(
                                '_',
                                ' ',
                                $role
                            )
                        )
                        . ' '
                        . Str::random(5),

                    'email' =>
                        Str::uuid()
                        . '@example.com',

                    'password' =>
                        'Password1!',

                    'role' =>
                        $role,
                ],
                $overrides
            )
        );
    }

    private function createJobPost(
        User $employer
    ): JobPost {
        return JobPost::create([
            'employer_id' =>
                $employer->id,

            'title' =>
                'Laravel Developer',

            'description' =>
                'Develop and maintain Laravel applications.',

            'requirements' =>
                'Knowledge of PHP, Laravel and MySQL.',

            'location' =>
                'Kuala Lumpur',

            'employment_type' =>
                'Full-time',

            'salary_min' =>
                3000,

            'salary_max' =>
                5000,

            'application_deadline' =>
                now()
                    ->addDays(7)
                    ->toDateString(),

            'status' =>
                'open',
        ]);
    }

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
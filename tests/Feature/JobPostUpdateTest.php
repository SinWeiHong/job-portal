<?php

namespace Tests\Feature;

use App\Models\JobPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class JobPostUpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The owner can open the edit job posting page.
     */
    public function test_owner_can_open_edit_page(): void
    {
        $employer = $this->createUser('employer');
        $jobPost = $this->createJobPost($employer);

        $response = $this
            ->actingAs($employer)
            ->get(
                route('jobs.edit', $jobPost)
            );

        $response
            ->assertOk()
            ->assertSee('Edit Job Posting')
            ->assertSee($jobPost->title);
    }

    /**
     * An employer cannot open another employer's
     * edit job posting page.
     */
    public function test_employer_cannot_open_another_employers_edit_page(): void
    {
        $owner = $this->createUser('employer');
        $otherEmployer = $this->createUser('employer');

        $jobPost = $this->createJobPost($owner);

        $response = $this
            ->actingAs($otherEmployer)
            ->get(
                route('jobs.edit', $jobPost)
            );

        $response->assertForbidden();
    }

    /**
     * The owner can update their own job posting.
     */
    public function test_owner_can_update_own_job_posting(): void
    {
        $employer = $this->createUser('employer');
        $jobPost = $this->createJobPost($employer);

        $response = $this
            ->actingAs($employer)
            ->put(
                route('jobs.update', $jobPost),
                $this->validJobData([
                    'title' =>
                        'Senior Software Developer',
                    'salary_min' => 4500,
                    'salary_max' => 6500,
                ])
            );

        $response
            ->assertRedirect(
                route('jobs.edit', $jobPost)
            )
            ->assertSessionHas(
                'success',
                'The job posting has been updated successfully.'
            );

        $this->assertDatabaseHas('job_posts', [
            'id' => $jobPost->id,
            'employer_id' => $employer->id,
            'title' => 'Senior Software Developer',
            'salary_min' => 4500,
            'salary_max' => 6500,
        ]);
    }

    /**
     * An employer cannot update another employer's
     * job posting.
     */
    public function test_employer_cannot_update_another_employers_job(): void
    {
        $owner = $this->createUser('employer');
        $otherEmployer = $this->createUser('employer');

        $jobPost = $this->createJobPost($owner);

        $response = $this
            ->actingAs($otherEmployer)
            ->put(
                route('jobs.update', $jobPost),
                $this->validJobData([
                    'title' =>
                        'Unauthorised Changed Title',
                ])
            );

        $response->assertForbidden();

        $this->assertDatabaseHas('job_posts', [
            'id' => $jobPost->id,
            'employer_id' => $owner->id,
            'title' => 'Junior Software Developer',
        ]);

        $this->assertDatabaseMissing('job_posts', [
            'id' => $jobPost->id,
            'title' => 'Unauthorised Changed Title',
        ]);
    }

    /**
     * A job seeker cannot update a job posting.
     */
    public function test_non_employer_cannot_update_job_posting(): void
    {
        $employer = $this->createUser('employer');
        $jobSeeker = $this->createUser('job_seeker');

        $jobPost = $this->createJobPost($employer);

        $response = $this
            ->actingAs($jobSeeker)
            ->put(
                route('jobs.update', $jobPost),
                $this->validJobData()
            );

        $response->assertForbidden();

        $this->assertDatabaseHas('job_posts', [
            'id' => $jobPost->id,
            'title' => 'Junior Software Developer',
        ]);
    }

    /**
     * An RM0-to-RM0 salary range is rejected.
     */
    public function test_zero_to_zero_salary_range_is_rejected(): void
    {
        $employer = $this->createUser('employer');
        $jobPost = $this->createJobPost($employer);

        $response = $this
            ->actingAs($employer)
            ->from(
                route('jobs.edit', $jobPost)
            )
            ->put(
                route('jobs.update', $jobPost),
                $this->validJobData([
                    'salary_min' => 0,
                    'salary_max' => 0,
                ])
            );

        $response
            ->assertRedirect(
                route('jobs.edit', $jobPost)
            )
            ->assertSessionHasErrors([
                'salary_range' =>
                    'The salary range cannot be RM0 to RM0.',
            ]);

        $this->assertDatabaseHas('job_posts', [
            'id' => $jobPost->id,
            'salary_min' => 3000,
            'salary_max' => 4500,
        ]);
    }

    /**
     * Required job information cannot be empty.
     */
    public function test_job_title_is_required(): void
    {
        $employer = $this->createUser('employer');
        $jobPost = $this->createJobPost($employer);

        $response = $this
            ->actingAs($employer)
            ->from(
                route('jobs.edit', $jobPost)
            )
            ->put(
                route('jobs.update', $jobPost),
                $this->validJobData([
                    'title' => '',
                ])
            );

        $response
            ->assertRedirect(
                route('jobs.edit', $jobPost)
            )
            ->assertSessionHasErrors([
                'title' =>
                    'Please enter the job title.',
            ]);

        $this->assertDatabaseHas('job_posts', [
            'id' => $jobPost->id,
            'title' => 'Junior Software Developer',
        ]);
    }

    /**
     * Create a test user with the selected role.
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
     * Create a job posting owned by an employer.
     */
    private function createJobPost(
        User $employer
    ): JobPost {
        return JobPost::create([
            'employer_id' => $employer->id,
            'title' => 'Junior Software Developer',
            'description' =>
                'Develop and maintain web applications.',
            'requirements' =>
                'Basic knowledge of PHP, Laravel and MySQL.',
            'location' => 'Kuala Lumpur',
            'employment_type' => 'Full-time',
            'salary_min' => 3000,
            'salary_max' => 4500,
            'application_deadline' =>
                now()->addDays(14)->toDateString(),
            'status' => 'open',
        ]);
    }

    /**
     * Return valid job posting update data.
     *
     * @param array<string, mixed> $overrides
     *
     * @return array<string, mixed>
     */
    private function validJobData(
        array $overrides = []
    ): array {
        return array_merge(
            [
                'title' =>
                    'Junior Software Developer',
                'location' =>
                    'Kuala Lumpur',
                'employment_type' =>
                    'Full-time',
                'salary_min' => 3000,
                'salary_max' => 4500,
                'application_deadline' =>
                    now()->addDays(14)->toDateString(),
                'status' =>
                    'open',
                'description' =>
                    'Develop and maintain web applications.',
                'requirements' =>
                    'Basic knowledge of PHP, Laravel and MySQL.',
            ],
            $overrides
        );
    }
}
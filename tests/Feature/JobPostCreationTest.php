<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobPostCreationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * An authenticated employer can access
     * the create job posting page.
     */
    public function test_employer_can_access_create_job_posting_page(): void
    {
        $employer = User::factory()->create([
            'role' => 'employer',
        ]);

        $response = $this
            ->actingAs($employer)
            ->get(route('jobs.create'));

        $response->assertOk();

        $response->assertViewIs('jobs.create');
    }

    /**
     * A job seeker must not access
     * the create job posting page.
     */
    public function test_job_seeker_cannot_access_create_job_posting_page(): void
    {
        $jobSeeker = User::factory()->create([
            'role' => 'job_seeker',
        ]);

        $response = $this
            ->actingAs($jobSeeker)
            ->get(route('jobs.create'));

        $response->assertForbidden();
    }

    /**
     * An employer can create a valid job posting.
     */
    public function test_employer_can_create_job_posting(): void
    {
        $employer = User::factory()->create([
            'role' => 'employer',
        ]);

        $response = $this
            ->actingAs($employer)
            ->post(route('jobs.store'), [
                'title' => 'Junior Software Developer',
                'location' => 'Kuala Lumpur',
                'employment_type' => 'Full-time',
                'salary_min' => 3000,
                'salary_max' => 4500,
                'application_deadline' =>
                    now()->addDays(14)->toDateString(),
                'status' => 'open',
                'description' =>
                    'Develop and maintain web applications.',
                'requirements' =>
                    'Basic knowledge of PHP, Laravel and MySQL.',
            ]);

        $response->assertRedirect(route('jobs.create'));

        $response->assertSessionHas(
            'success',
            'The job posting has been created successfully.'
        );

        $this->assertDatabaseHas('job_posts', [
            'employer_id' => $employer->id,
            'title' => 'Junior Software Developer',
            'location' => 'Kuala Lumpur',
            'employment_type' => 'Full-time',
            'status' => 'open',
        ]);
    }

    /**
     * A job seeker cannot submit a new job posting.
     */
    public function test_job_seeker_cannot_create_job_posting(): void
    {
        $jobSeeker = User::factory()->create([
            'role' => 'job_seeker',
        ]);

        $response = $this
            ->actingAs($jobSeeker)
            ->post(route('jobs.store'), [
                'title' => 'Unauthorized Job Posting',
                'location' => 'Selangor',
                'employment_type' => 'Part-time',
                'salary_min' => 1500,
                'salary_max' => 2000,
                'application_deadline' =>
                    now()->addDays(7)->toDateString(),
                'status' => 'open',
                'description' =>
                    'This posting must not be created.',
                'requirements' =>
                    'No requirements.',
            ]);

        $response->assertForbidden();

        $this->assertDatabaseMissing('job_posts', [
            'title' => 'Unauthorized Job Posting',
        ]);
    }

    /**
     * Invalid job posting information must be rejected.
     */
    public function test_invalid_job_posting_is_rejected(): void
    {
        $employer = User::factory()->create([
            'role' => 'employer',
        ]);

        $response = $this
            ->actingAs($employer)
            ->from(route('jobs.create'))
            ->post(route('jobs.store'), [
                'title' => '',
                'location' => '',
                'employment_type' => '',
                'salary_min' => 5000,
                'salary_max' => 3000,
                'application_deadline' =>
                    now()->subDay()->toDateString(),
                'status' => 'open',
                'description' => '',
                'requirements' => '',
            ]);

        $response->assertRedirect(route('jobs.create'));

        $response->assertSessionHasErrors([
            'title',
            'location',
            'employment_type',
            'salary_max',
            'application_deadline',
            'description',
        ]);

        $this->assertDatabaseCount('job_posts', 0);
    }
}
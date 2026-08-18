<?php

namespace Tests\Feature;

use App\Models\JobPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminJobPostModerationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * An administrator can open the moderation list.
     */
    public function test_administrator_can_open_moderation_list(): void
    {
        $administrator = $this->createUser(
            'administrator'
        );

        $employer = $this->createUser('employer');

        $jobPost = $this->createJobPost($employer);

        $response = $this
            ->actingAs($administrator)
            ->get(
                route('admin.job-posts.index')
            );

        $response
            ->assertOk()
            ->assertSee('Job Posting Moderation')
            ->assertSee($jobPost->title);
    }

    /**
     * A non-administrator cannot open
     * the moderation list.
     */
    public function test_non_administrator_cannot_open_moderation_list(): void
    {
        $employer = $this->createUser('employer');

        $response = $this
            ->actingAs($employer)
            ->get(
                route('admin.job-posts.index')
            );

        $response->assertForbidden();
    }

    /**
     * An administrator can remove a job posting.
     */
    public function test_administrator_can_remove_job_posting(): void
    {
        $administrator = $this->createUser(
            'administrator'
        );

        $employer = $this->createUser('employer');

        $jobPost = $this->createJobPost($employer);

        $removalReason =
            'This job posting contains misleading information.';

        $response = $this
            ->actingAs($administrator)
            ->delete(
                route(
                    'admin.job-posts.destroy',
                    $jobPost
                ),
                [
                    'removal_reason' =>
                        $removalReason,
                ]
            );

        $response
            ->assertRedirect(
                route('admin.job-posts.index')
            )
            ->assertSessionHas(
                'success',
                'The job posting has been removed successfully.'
            );

        $this->assertSoftDeleted('job_posts', [
            'id' => $jobPost->id,
        ]);

        $removedJobPost = JobPost::withTrashed()
            ->findOrFail($jobPost->id);

        $this->assertSame(
            $removalReason,
            $removedJobPost->removal_reason
        );

        $this->assertSame(
            $administrator->id,
            $removedJobPost->removed_by
        );

        $this->assertNotNull(
            $removedJobPost->removed_at
        );

        $this->assertNotNull(
            $removedJobPost->deleted_at
        );
    }

    /**
     * A non-administrator cannot remove a job posting.
     */
    public function test_non_administrator_cannot_remove_job_posting(): void
    {
        $employer = $this->createUser('employer');

        $jobPost = $this->createJobPost($employer);

        $response = $this
            ->actingAs($employer)
            ->delete(
                route(
                    'admin.job-posts.destroy',
                    $jobPost
                ),
                [
                    'removal_reason' =>
                        'This removal should not be accepted.',
                ]
            );

        $response->assertForbidden();

        $this->assertDatabaseHas('job_posts', [
            'id' => $jobPost->id,
            'deleted_at' => null,
        ]);
    }

    /**
     * The removal reason is required.
     */
    public function test_removal_reason_is_required(): void
    {
        $administrator = $this->createUser(
            'administrator'
        );

        $employer = $this->createUser('employer');

        $jobPost = $this->createJobPost($employer);

        $response = $this
            ->actingAs($administrator)
            ->from(
                route(
                    'admin.job-posts.remove',
                    $jobPost
                )
            )
            ->delete(
                route(
                    'admin.job-posts.destroy',
                    $jobPost
                ),
                [
                    'removal_reason' => '',
                ]
            );

        $response
            ->assertRedirect(
                route(
                    'admin.job-posts.remove',
                    $jobPost
                )
            )
            ->assertSessionHasErrors([
                'removal_reason' =>
                    'Please provide a reason for removing this job posting.',
            ]);

        $this->assertDatabaseHas('job_posts', [
            'id' => $jobPost->id,
            'deleted_at' => null,
        ]);
    }

    /**
     * A short removal reason is rejected.
     */
    public function test_short_removal_reason_is_rejected(): void
    {
        $administrator = $this->createUser(
            'administrator'
        );

        $employer = $this->createUser('employer');

        $jobPost = $this->createJobPost($employer);

        $response = $this
            ->actingAs($administrator)
            ->from(
                route(
                    'admin.job-posts.remove',
                    $jobPost
                )
            )
            ->delete(
                route(
                    'admin.job-posts.destroy',
                    $jobPost
                ),
                [
                    'removal_reason' => 'Fake job',
                ]
            );

        $response
            ->assertRedirect(
                route(
                    'admin.job-posts.remove',
                    $jobPost
                )
            )
            ->assertSessionHasErrors([
                'removal_reason' =>
                    'The removal reason must contain at least 10 characters.',
            ]);

        $this->assertDatabaseHas('job_posts', [
            'id' => $jobPost->id,
            'deleted_at' => null,
        ]);
    }

    /**
     * An already removed posting cannot be removed again.
     */
    public function test_job_posting_cannot_be_removed_twice(): void
    {
        $administrator = $this->createUser(
            'administrator'
        );

        $employer = $this->createUser('employer');

        $jobPost = $this->createJobPost($employer);

        $jobPost->update([
            'removal_reason' =>
                'This job posting was previously removed.',
            'removed_by' =>
                $administrator->id,
            'removed_at' =>
                now(),
        ]);

        $jobPost->delete();

        $response = $this
            ->actingAs($administrator)
            ->delete(
                route(
                    'admin.job-posts.destroy',
                    $jobPost->id
                ),
                [
                    'removal_reason' =>
                        'Attempting to remove the job again.',
                ]
            );

        $response
            ->assertRedirect(
                route('admin.job-posts.index')
            )
            ->assertSessionHas(
                'error',
                'This job posting has already been removed.'
            );

        $removedJobPost = JobPost::withTrashed()
            ->findOrFail($jobPost->id);

        $this->assertSame(
            'This job posting was previously removed.',
            $removedJobPost->removal_reason
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

            'password' =>
                'Password1!',

            'role' =>
                $role,
        ]);
    }

    /**
     * Create an active job posting.
     */
    private function createJobPost(
        User $employer
    ): JobPost {
        return JobPost::create([
            'employer_id' =>
                $employer->id,

            'title' =>
                'Junior Software Developer',

            'description' =>
                'Develop and maintain web applications.',

            'requirements' =>
                'Basic knowledge of PHP, Laravel and MySQL.',

            'location' =>
                'Kuala Lumpur',

            'employment_type' =>
                'Full-time',

            'salary_min' =>
                3000,

            'salary_max' =>
                4500,

            'application_deadline' =>
                now()->addDays(14)->toDateString(),

            'status' =>
                'open',
        ]);
    }
}
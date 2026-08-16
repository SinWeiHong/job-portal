<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminUserDeactivationTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrator_can_view_user_management_page(): void
    {
        $administrator = $this->createUser(
            'administrator'
        );

        $jobSeeker = $this->createUser(
            'job_seeker'
        );

        $response = $this
            ->actingAs($administrator)
            ->get(
                route('admin.users.index')
            );

        $response
            ->assertOk()
            ->assertSee('User Management')
            ->assertSee($jobSeeker->name)
            ->assertSee($jobSeeker->email);
    }

    public function test_non_administrator_cannot_access_user_management(): void
    {
        $jobSeeker = $this->createUser(
            'job_seeker'
        );

        $response = $this
            ->actingAs($jobSeeker)
            ->get(
                route('admin.users.index')
            );

        $response->assertForbidden();
    }

    public function test_administrator_can_deactivate_active_user_account(): void
    {
        $administrator = $this->createUser(
            'administrator'
        );

        $jobSeeker = $this->createUser(
            'job_seeker'
        );

        $response = $this
            ->actingAs($administrator)
            ->patch(
                route(
                    'admin.users.deactivate',
                    $jobSeeker
                )
            );

        $response
            ->assertRedirect(
                route('admin.users.index')
            )
            ->assertSessionHas(
                'success',
                'The user account has been deactivated successfully.'
            );

        $jobSeeker->refresh();

        $this->assertFalse(
            $jobSeeker->is_active
        );

        $this->assertNotNull(
            $jobSeeker->deactivated_at
        );

        $this->assertSame(
            $administrator->id,
            $jobSeeker->deactivated_by
        );
    }

    public function test_administrator_cannot_deactivate_another_administrator(): void
    {
        $administrator = $this->createUser(
            'administrator'
        );

        $otherAdministrator =
            $this->createUser(
                'administrator'
            );

        $response = $this
            ->actingAs($administrator)
            ->patch(
                route(
                    'admin.users.deactivate',
                    $otherAdministrator
                )
            );

        $response->assertForbidden();

        $otherAdministrator->refresh();

        $this->assertTrue(
            $otherAdministrator->is_active
        );
    }

    public function test_already_inactive_account_cannot_be_deactivated_again(): void
    {
        $administrator = $this->createUser(
            'administrator'
        );

        $jobSeeker = $this->createUser(
            'job_seeker',
            [
                'is_active' => false,
                'deactivated_at' => now(),
                'deactivated_by' =>
                    $administrator->id,
            ]
        );

        $response = $this
            ->actingAs($administrator)
            ->patch(
                route(
                    'admin.users.deactivate',
                    $jobSeeker
                )
            );

        $response
            ->assertRedirect(
                route('admin.users.index')
            )
            ->assertSessionHasErrors([
                'account' =>
                    'This user account is already inactive.',
            ]);
    }

    public function test_inactive_user_cannot_log_in(): void
    {
        $jobSeeker = $this->createUser(
            'job_seeker',
            [
                'email' =>
                    'inactive@example.com',

                'password' =>
                    'Password1!',

                'is_active' =>
                    false,

                'deactivated_at' =>
                    now(),
            ]
        );

        $response = $this
            ->post(
                route('login.store'),
                [
                    'email' =>
                        'inactive@example.com',

                    'password' =>
                        'Password1!',
                ]
            );

        $response
            ->assertSessionHasErrors([
                'email' =>
                    'This account has been deactivated. Please contact the administrator.',
            ]);

        $this->assertGuest();
    }

    public function test_active_user_can_still_log_in(): void
    {
        $this->createUser(
            'job_seeker',
            [
                'email' =>
                    'active@example.com',

                'password' =>
                    'Password1!',

                'is_active' =>
                    true,
            ]
        );

        $response = $this
            ->post(
                route('login.store'),
                [
                    'email' =>
                        'active@example.com',

                    'password' =>
                        'Password1!',
                ]
            );

        $response->assertRedirect(
            route('dashboard')
        );

        $this->assertAuthenticated();
    }

    public function test_inactive_authenticated_user_is_logged_out_on_next_request(): void
    {
        $jobSeeker = $this->createUser(
            'job_seeker'
        );

        $jobSeeker->update([
            'is_active' =>
                false,

            'deactivated_at' =>
                now(),
        ]);

        $response = $this
            ->actingAs($jobSeeker)
            ->get(
                route('dashboard')
            );

        $response->assertRedirect(
            route('login')
        );

        $this->assertGuest();
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

                    'is_active' =>
                        true,
                ],
                $overrides
            )
        );
    }
}
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_seeker_can_register_with_a_strong_password(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Test Job Seeker',
            'email' => 'jobseeker@example.com',
            'password' => 'Password1!',
            'password_confirmation' => 'Password1!',
        ]);

        $response->assertRedirect(route('register'));

        $response->assertSessionHas(
            'success',
            'Your job seeker account has been registered successfully.'
        );

        $this->assertDatabaseHas('users', [
            'name' => 'Test Job Seeker',
            'email' => 'jobseeker@example.com',
            'role' => 'job_seeker',
        ]);

        $user = User::where(
            'email',
            'jobseeker@example.com'
        )->firstOrFail();

        $this->assertTrue(
            Hash::check('Password1!', $user->password)
        );
    }

    #[DataProvider('weakPasswords')]
    public function test_registration_rejects_weak_passwords(
        string $password
    ): void {
        $response = $this
            ->from(route('register'))
            ->post(route('register.store'), [
                'name' => 'Test Job Seeker',
                'email' => 'weakpassword@example.com',
                'password' => $password,
                'password_confirmation' => $password,
            ]);

        $response->assertRedirect(route('register'));

        $response->assertSessionHasErrors('password');

        $this->assertDatabaseMissing('users', [
            'email' => 'weakpassword@example.com',
        ]);
    }

    public static function weakPasswords(): array
    {
        return [
            'fewer than eight characters' => [
                'Ab1!',
            ],

            'without an uppercase letter' => [
                'password1!',
            ],

            'without a lowercase letter' => [
                'PASSWORD1!',
            ],

            'without a number' => [
                'Password!',
            ],

            'without a special character' => [
                'Password1',
            ],
        ];
    }
}
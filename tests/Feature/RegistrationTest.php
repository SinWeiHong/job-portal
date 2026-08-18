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

    public function test_full_name_is_required(): void
    {
        $response = $this
            ->from(route('register'))
            ->post(route('register.store'), [
                'name' => '',
                'email' => 'noname@example.com',
                'password' => 'Password1!',
                'password_confirmation' => 'Password1!',
            ]);

        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors('name');

        $this->assertDatabaseMissing('users', [
            'email' => 'noname@example.com',
        ]);
    }

    public function test_invalid_email_format_is_rejected(): void
    {
        $response = $this
            ->from(route('register'))
            ->post(route('register.store'), [
                'name' => 'Test Job Seeker',
                'email' => 'invalid-email',
                'password' => 'Password1!',
                'password_confirmation' => 'Password1!',
            ]);

        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors('email');

        $this->assertDatabaseMissing('users', [
            'email' => 'invalid-email',
        ]);
    }

    public function test_duplicate_email_is_rejected(): void
    {
        User::factory()->create([
            'name' => 'Existing User',
            'email' => 'existing@example.com',
        ]);

        $response = $this
            ->from(route('register'))
            ->post(route('register.store'), [
                'name' => 'New Job Seeker',
                'email' => 'existing@example.com',
                'password' => 'Password1!',
                'password_confirmation' => 'Password1!',
            ]);

        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors('email');

        $this->assertSame(
            1,
            User::where('email', 'existing@example.com')->count()
        );
    }

    public function test_password_confirmation_must_match(): void
    {
        $response = $this
            ->from(route('register'))
            ->post(route('register.store'), [
                'name' => 'Test Job Seeker',
                'email' => 'mismatch@example.com',
                'password' => 'Password1!',
                'password_confirmation' => 'DifferentPassword1!',
            ]);

        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors('password');

        $this->assertDatabaseMissing('users', [
            'email' => 'mismatch@example.com',
        ]);
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
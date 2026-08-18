<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The login page can be displayed.
     */
    public function test_login_page_can_be_displayed(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();

        $response->assertViewIs('auth.login');
    }

    /**
     * A registered user can log in
     * using valid credentials.
     */
    public function test_registered_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'jobseeker@example.com',
            'password' => Hash::make('Password1!'),
        ]);

        $response = $this
            ->from(route('login'))
            ->post(route('login.store'), [
                'email' => 'jobseeker@example.com',
                'password' => 'Password1!',
            ]);

        $response->assertRedirect(route('dashboard'));

        $response->assertSessionHas(
            'success',
            'You have logged in successfully.'
        );

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Invalid credentials must not
     * authenticate the user.
     */
    public function test_user_cannot_login_with_invalid_password(): void
    {
        User::factory()->create([
            'email' => 'jobseeker@example.com',
            'password' => Hash::make('Password1!'),
        ]);

        $response = $this
            ->from(route('login'))
            ->post(route('login.store'), [
                'email' => 'jobseeker@example.com',
                'password' => 'WrongPassword1!',
            ]);

        $response->assertRedirect(route('login'));

        $response->assertSessionHasErrors([
            'email',
        ]);

        $response->assertSessionHasErrors([
            'email' =>
                'The provided email address or password is incorrect.',
        ]);

        $this->assertGuest();
    }

/**
 * An empty email address must be rejected.
 */
public function test_empty_email_is_rejected(): void
{
    $response = $this
        ->from(route('login'))
        ->post(route('login.store'), [
            'email' => '',
            'password' => 'Password1!',
        ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHasErrors('email');

    $this->assertGuest();
}

/**
 * An invalid email format must be rejected.
 */
public function test_invalid_email_format_is_rejected(): void
{
    $response = $this
        ->from(route('login'))
        ->post(route('login.store'), [
            'email' => 'invalid-email',
            'password' => 'Password1!',
        ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHasErrors('email');

    $this->assertGuest();
}

    /**
     * An unregistered email address must not
     * authenticate the user.
     */
    public function test_unregistered_user_cannot_login(): void
    {
        $response = $this
            ->from(route('login'))
            ->post(route('login.store'), [
                'email' => 'unknown@example.com',
                'password' => 'Password1!',
            ]);

        $response->assertRedirect(route('login'));

        $response->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    /**
     * An unauthenticated visitor cannot
     * access the dashboard.
     */
    public function test_guest_cannot_access_dashboard(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));

        $this->assertGuest();
    }

    /**
     * An authenticated user can log out.
     */
    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('Password1!'),
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('logout'));

        $response->assertRedirect(route('login'));

        $response->assertSessionHas(
            'success',
            'You have logged out successfully.'
        );

        $this->assertGuest();
    }
}
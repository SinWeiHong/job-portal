<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap application services.
     */
    public function boot(): void
    {
        /*
         * Default rule for every newly created or changed password.
         *
         * Requirements:
         * - Minimum 8 characters
         * - At least one uppercase letter
         * - At least one lowercase letter
         * - At least one number
         * - At least one special character
         */
        Password::defaults(
            fn () => Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()
        );
    }
}
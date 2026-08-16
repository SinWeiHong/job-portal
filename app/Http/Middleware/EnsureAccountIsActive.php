<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountIsActive
{
    /**
     * Ensure that an authenticated user's
     * account has not been deactivated.
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Inactive Account Check
        |--------------------------------------------------------------------------
        |
        | Only an explicit false value means that the account has been
        | deactivated. This also keeps older user records and tests compatible.
        |
        */

        if (
            $user !== null
            && $user->is_active === false
        ) {
            Auth::logout();

            $request
                ->session()
                ->invalidate();

            $request
                ->session()
                ->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' =>
                        'This account has been deactivated. Please contact the administrator.',
                ]);
        }

        return $next($request);
    }
}
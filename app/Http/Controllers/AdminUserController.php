<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Display user accounts for administrator review.
     */
    public function index(
        Request $request
    ): View {
        /*
        |--------------------------------------------------------------------------
        | Administrator Authorization
        |--------------------------------------------------------------------------
        */

        $this->ensureAdministrator(
            $request
        );

        /*
        |--------------------------------------------------------------------------
        | Retrieve Manageable Accounts
        |--------------------------------------------------------------------------
        |
        | Only job seekers and employers are manageable under JPW-15.
        | Administrator accounts are intentionally excluded.
        |
        */

        $users = User::query()
            ->with('deactivatedBy')
            ->whereIn(
                'role',
                [
                    'job_seeker',
                    'employer',
                ]
            )
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Account Summary
        |--------------------------------------------------------------------------
        */

        $activeUsers = $users
            ->where(
                'is_active',
                true
            )
            ->count();

        $inactiveUsers = $users
            ->where(
                'is_active',
                false
            )
            ->count();

        return view(
            'admin.users.index',
            [
                'users' =>
                    $users,

                'activeUsers' =>
                    $activeUsers,

                'inactiveUsers' =>
                    $inactiveUsers,
            ]
        );
    }

    /**
     * Deactivate a selected user account.
     */
    public function deactivate(
        Request $request,
        User $user
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Administrator Authorization
        |--------------------------------------------------------------------------
        */

        $this->ensureAdministrator(
            $request
        );

        /*
        |--------------------------------------------------------------------------
        | Manageable Role Validation
        |--------------------------------------------------------------------------
        */

        if (
            !in_array(
                strtolower(
                    trim(
                        (string) $user->role
                    )
                ),
                [
                    'job_seeker',
                    'employer',
                ],
                true
            )
        ) {
            abort(
                403,
                'Administrator accounts cannot be deactivated.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Already Inactive Validation
        |--------------------------------------------------------------------------
        */

        if (!$user->is_active) {
            return redirect()
                ->route(
                    'admin.users.index'
                )
                ->withErrors([
                    'account' =>
                        'This user account is already inactive.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Deactivate Account
        |--------------------------------------------------------------------------
        */

        $user->update([
            'is_active' =>
                false,

            'deactivated_at' =>
                now(),

            'deactivated_by' =>
                $request->user()->id,
        ]);

        return redirect()
            ->route(
                'admin.users.index'
            )
            ->with(
                'success',
                'The user account has been deactivated successfully.'
            );
    }

    /**
     * Confirm that the logged-in user is an administrator.
     */
    private function ensureAdministrator(
        Request $request
    ): void {
        $user = $request->user();

        abort_unless(
            $user !== null
            && strtolower(
                trim(
                    (string) $user->role
                )
            ) === 'administrator',
            403,
            'Only administrators can manage user accounts.'
        );
    }
}
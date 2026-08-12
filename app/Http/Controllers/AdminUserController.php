<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Display user accounts for administrator review.
     */
    public function index(Request $request): View
    {
        /*
        |--------------------------------------------------------------------------
        | Administrator Authorization
        |--------------------------------------------------------------------------
        */

        $this->ensureAdministrator($request);

        /*
        |--------------------------------------------------------------------------
        | Retrieve User Accounts
        |--------------------------------------------------------------------------
        |
        | Administrator accounts are excluded because JPW-15 is intended
        | for administrators to manage normal platform users.
        |
        */

        $users = User::query()
            ->where(
                'role',
                '!=',
                'administrator'
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
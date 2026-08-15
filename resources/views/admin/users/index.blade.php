<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>User Management | Job Portal</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            padding: 40px 18px;
            font-family: Arial, sans-serif;
            background: #f3f6fb;
            color: #1f2937;
        }

        .page-container {
            width: 100%;
            max-width: 1150px;
            margin: 0 auto;
        }

        .top-navigation {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 28px;
            padding: 18px 24px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow:
                0 6px 20px
                rgba(0, 0, 0, 0.06);
        }

        .portal-name {
            color: #2563eb;
            font-size: 20px;
            font-weight: bold;
        }

        .navigation-actions {
            display: flex;
            gap: 10px;
        }

        .nav-link {
            padding: 10px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #374151;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
        }

        .nav-link:hover {
            background: #f9fafb;
        }

        .page-header {
            margin-bottom: 24px;
        }

        h1 {
            margin-bottom: 8px;
            font-size: 32px;
        }

        .subtitle {
            max-width: 720px;
            color: #6b7280;
            line-height: 1.6;
        }

        .alert {
            margin-bottom: 22px;
            padding: 14px 18px;
            border-radius: 10px;
            line-height: 1.5;
        }

        .alert-success {
            border: 1px solid #86efac;
            background: #f0fdf4;
            color: #166534;
        }

        .alert-error {
            border: 1px solid #fca5a5;
            background: #fef2f2;
            color: #991b1b;
        }

        .summary-grid {
            display: grid;
            grid-template-columns:
                repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .summary-card {
            padding: 22px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: #ffffff;
            box-shadow:
                0 6px 18px
                rgba(0, 0, 0, 0.04);
        }

        .summary-label {
            display: block;
            margin-bottom: 8px;
            color: #6b7280;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .summary-value {
            color: #111827;
            font-size: 30px;
            font-weight: bold;
        }

        .table-card {
            overflow: hidden;
            border-radius: 14px;
            background: #ffffff;
            box-shadow:
                0 10px 30px
                rgba(0, 0, 0, 0.08);
        }

        .table-heading {
            padding: 20px 22px;
            border-bottom:
                1px solid #e5e7eb;
        }

        .table-heading h2 {
            margin-bottom: 5px;
            font-size: 20px;
        }

        .table-heading p {
            color: #6b7280;
            font-size: 14px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 16px;
            border-bottom:
                1px solid #e5e7eb;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background: #f9fafb;
            color: #4b5563;
            font-size: 12px;
            text-transform: uppercase;
        }

        td {
            font-size: 14px;
            line-height: 1.5;
        }

        tbody tr:hover {
            background: #f9fafb;
        }

        .user-name {
            color: #111827;
            font-weight: bold;
        }

        .user-id {
            display: block;
            margin-top: 3px;
            color: #9ca3af;
            font-size: 12px;
        }

        .role-badge,
        .status-badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .role-badge {
            background: #eff6ff;
            color: #1d4ed8;
            text-transform: capitalize;
        }

        .status-active {
            background: #dcfce7;
            color: #166534;
        }

        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .deactivate-button {
            padding: 9px 13px;
            border: none;
            border-radius: 7px;
            background: #dc2626;
            color: #ffffff;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
        }

        .deactivate-button:hover {
            background: #b91c1c;
        }

        .inactive-text {
            color: #9ca3af;
            font-size: 13px;
            font-weight: 600;
        }

        .not-available {
            color: #9ca3af;
        }

        .empty-state {
            padding: 50px 24px;
            color: #6b7280;
            text-align: center;
        }

        .empty-state h2 {
            margin-bottom: 8px;
            color: #374151;
        }

        @media (max-width: 760px) {
            body {
                padding: 24px 12px;
            }

            .top-navigation {
                align-items: stretch;
                flex-direction: column;
            }

            .navigation-actions {
                flex-direction: column;
            }

            .nav-link {
                width: 100%;
                text-align: center;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <main class="page-container">

        <nav class="top-navigation">

            <div class="portal-name">
                Job Portal Website
            </div>

            <div class="navigation-actions">

                <a
                    href="{{
                        route(
                            'admin.job-posts.index'
                        )
                    }}"
                    class="nav-link"
                >
                    Job Moderation
                </a>

                <a
                    href="{{ route('dashboard') }}"
                    class="nav-link"
                >
                    Back to Dashboard
                </a>

            </div>

        </nav>

        <header class="page-header">

            <h1>User Management</h1>

            <p class="subtitle">
                Review registered user accounts
                and deactivate accounts when
                necessary to prevent misuse of
                the platform.
            </p>

        </header>

        @if (session('success'))

            <div
                class="alert alert-success"
                role="alert"
            >
                {{ session('success') }}
            </div>

        @endif

        @if ($errors->has('account'))

            <div
                class="alert alert-error"
                role="alert"
            >
                {{ $errors->first('account') }}
            </div>

        @endif

        <section class="summary-grid">

            <div class="summary-card">

                <span class="summary-label">
                    Total User Accounts
                </span>

                <div class="summary-value">
                    {{ $users->count() }}
                </div>

            </div>

            <div class="summary-card">

                <span class="summary-label">
                    Active Accounts
                </span>

                <div class="summary-value">
                    {{ $activeUsers }}
                </div>

            </div>

            <div class="summary-card">

                <span class="summary-label">
                    Inactive Accounts
                </span>

                <div class="summary-value">
                    {{ $inactiveUsers }}
                </div>

            </div>

        </section>

        <section class="table-card">

            <div class="table-heading">

                <h2>Registered Users</h2>

                <p>
                    Review job seeker and employer
                    accounts and manage their
                    account status.
                </p>

            </div>

            @if ($users->isEmpty())

                <div class="empty-state">

                    <h2>No user accounts found</h2>

                    <p>
                        There are currently no user
                        accounts available for
                        administrative review.
                    </p>

                </div>

            @else

                <div class="table-wrapper">

                    <table>

                        <thead>

                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Deactivated At</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($users as $user)

                                <tr>

                                    <td>

                                        <span class="user-name">
                                            {{ $user->name }}
                                        </span>

                                        <span class="user-id">
                                            User ID:
                                            {{ $user->id }}
                                        </span>

                                    </td>

                                    <td>
                                        {{ $user->email }}
                                    </td>

                                    <td>

                                        <span class="role-badge">

                                            {{
                                                ucwords(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        $user->role
                                                    )
                                                )
                                            }}

                                        </span>

                                    </td>

                                    <td>

                                        @if ($user->is_active)

                                            <span
                                                class="
                                                    status-badge
                                                    status-active
                                                "
                                            >
                                                Active
                                            </span>

                                        @else

                                            <span
                                                class="
                                                    status-badge
                                                    status-inactive
                                                "
                                            >
                                                Inactive
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        @if ($user->deactivated_at)

                                            {{
                                                $user
                                                    ->deactivated_at
                                                    ->format(
                                                        'd/m/Y h:i A'
                                                    )
                                            }}

                                        @else

                                            <span class="not-available">
                                                —
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        @if ($user->is_active)

                                            <form
                                                method="POST"
                                                action="{{
                                                    route(
                                                        'admin.users.deactivate',
                                                        $user
                                                    )
                                                }}"
                                                onsubmit="
                                                    return confirm(
                                                        'Are you sure you want to deactivate this user account?'
                                                    );
                                                "
                                            >

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="deactivate-button"
                                                >
                                                    Deactivate
                                                </button>

                                            </form>

                                        @else

                                            <span class="inactive-text">
                                                Already Inactive
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        </section>

    </main>

</body>
</html>
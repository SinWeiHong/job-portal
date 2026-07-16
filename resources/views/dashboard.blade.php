<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Job Seeker Dashboard | Job Portal</title>

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

        .dashboard-container {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
        }

        .portal-name {
            margin-bottom: 8px;
            color: #2563eb;
            font-size: 18px;
            font-weight: bold;
        }

        .dashboard-header {
            margin-bottom: 28px;
        }

        h1 {
            margin-bottom: 8px;
            font-size: 32px;
        }

        .subtitle {
            color: #6b7280;
            line-height: 1.5;
        }

        .alert-success {
            margin-bottom: 22px;
            padding: 13px 15px;
            border: 1px solid #86efac;
            border-radius: 8px;
            background: #f0fdf4;
            color: #166534;
            line-height: 1.5;
        }

        .profile-card {
            padding: 30px;
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .profile-card h2 {
            margin-bottom: 22px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 22px;
        }

        .profile-row {
            display: grid;
            grid-template-columns: 160px 1fr;
            gap: 20px;
            padding: 14px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .profile-row:last-child {
            border-bottom: none;
        }

        .profile-label {
            color: #6b7280;
            font-weight: 600;
        }

        .profile-value {
            overflow-wrap: anywhere;
            font-weight: 500;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 999px;
            background: #dcfce7;
            color: #166534;
            font-size: 13px;
            font-weight: bold;
        }

        .dashboard-message {
            margin-top: 24px;
            padding: 18px;
            border-radius: 10px;
            background: #eff6ff;
            color: #1e40af;
            line-height: 1.6;
        }

        @media (max-width: 600px) {
            .profile-row {
                grid-template-columns: 1fr;
                gap: 6px;
            }

            .profile-card {
                padding: 24px 20px;
            }
        }
    </style>
</head>

<body>
    <main class="dashboard-container">
        <header class="dashboard-header">
            <div class="portal-name">
                Job Portal Website
            </div>

            <h1>Job Seeker Dashboard</h1>

            <p class="subtitle">
                Welcome to your secure account dashboard.
            </p>
        </header>

        @if (session('success'))
            <div class="alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <section class="profile-card">
            <h2>Account Information</h2>

            <div class="profile-row">
                <div class="profile-label">
                    Full Name
                </div>

                <div class="profile-value">
                    {{ auth()->user()->name }}
                </div>
            </div>

            <div class="profile-row">
                <div class="profile-label">
                    Email Address
                </div>

                <div class="profile-value">
                    {{ auth()->user()->email }}
                </div>
            </div>

            <div class="profile-row">
                <div class="profile-label">
                    Account Status
                </div>

                <div class="profile-value">
                    <span class="status-badge">
                        Authenticated
                    </span>
                </div>
            </div>

            <div class="dashboard-message">
                You have successfully logged in to the Job Portal.
                Additional job searching and profile functions will
                be added in future sprints.
            </div>
        </section>
    </main>
</body>
</html>
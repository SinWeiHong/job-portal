<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Job Moderation | Job Portal</title>

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
            max-width: 1100px;
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
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
        }

        .portal-name {
            color: #2563eb;
            font-size: 20px;
            font-weight: bold;
        }

        .dashboard-link {
            padding: 10px 17px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            color: #374151;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
        }

        .dashboard-link:hover {
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
            color: #6b7280;
            line-height: 1.6;
        }

        .development-note {
            margin-bottom: 24px;
            padding: 14px 16px;
            border: 1px solid #bfdbfe;
            border-radius: 9px;
            background: #eff6ff;
            color: #1e40af;
            line-height: 1.6;
        }

        .summary-card {
            margin-bottom: 24px;
            padding: 20px 24px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        .summary-label {
            display: block;
            margin-bottom: 6px;
            color: #6b7280;
            font-size: 14px;
            font-weight: bold;
        }

        .summary-value {
            color: #111827;
            font-size: 28px;
            font-weight: bold;
        }

        .table-card {
            overflow: hidden;
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
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
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background: #f9fafb;
            color: #4b5563;
            font-size: 13px;
            text-transform: uppercase;
        }

        td {
            font-size: 14px;
            line-height: 1.5;
        }

        tbody tr:hover {
            background: #f9fafb;
        }

        .job-title {
            color: #111827;
            font-weight: bold;
        }

        .employer-email {
            display: block;
            margin-top: 3px;
            color: #6b7280;
            font-size: 12px;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            background: #dcfce7;
            color: #166534;
            font-size: 12px;
            font-weight: bold;
            text-transform: capitalize;
        }

        .status-badge.draft {
            background: #fef3c7;
            color: #92400e;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            white-space: nowrap;
        }

        .button {
            display: inline-block;
            padding: 9px 13px;
            border: none;
            border-radius: 7px;
            font-size: 13px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        .review-button {
            background: #2563eb;
            color: #ffffff;
        }

        .review-button:hover {
            background: #1d4ed8;
        }

        .remove-button {
    background: #dc2626;
    color: #ffffff;
}

.remove-button:hover {
    background: #b91c1c;
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

        @media (max-width: 700px) {
            body {
                padding: 24px 12px;
            }

            .top-navigation {
                align-items: flex-start;
                flex-direction: column;
            }

            .dashboard-link {
                width: 100%;
                text-align: center;
            }
        }

        .alert-success {
    margin-bottom: 24px;
    padding: 14px 16px;
    border: 1px solid #86efac;
    border-radius: 9px;
    background: #f0fdf4;
    color: #166534;
    line-height: 1.6;
}

    </style>
</head>

<body>
    <main class="page-container">
        <nav class="top-navigation">
            <div class="portal-name">
                Job Portal Website
            </div>

            <a
                href="{{ route('dashboard') }}"
                class="dashboard-link"
            >
                Back to Dashboard
            </a>
        </nav>

        <header class="page-header">
            <h1>Job Posting Moderation</h1>

            <p class="subtitle">
                Review active job postings and identify content that may
                be inappropriate, misleading or unreliable.
            </p>

            
        </header>

        @if (session('success'))
    <div class="alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

       

        <section class="summary-card">
            <span class="summary-label">
                Active job postings
            </span>

            <div class="summary-value">
                {{ $jobPosts->count() }}
            </div>
        </section>

        <section class="table-card">
            @if ($jobPosts->isEmpty())
                <div class="empty-state">
                    <h2>No active job postings</h2>

                    <p>
                        There are currently no job postings available
                        for administrative review.
                    </p>
                </div>
            @else
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Job</th>
                                <th>Employer</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Posted Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($jobPosts as $jobPost)
                                <tr>
                                    <td>
                                        <span class="job-title">
                                            {{ $jobPost->title }}
                                        </span>

                                        <span class="employer-email">
                                            Job ID: {{ $jobPost->id }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $jobPost->employer?->name
                                            ?? 'Employer unavailable' }}

                                        @if ($jobPost->employer?->email)
                                            <span class="employer-email">
                                                {{ $jobPost->employer->email }}
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $jobPost->location }}
                                    </td>

                                    <td>
                                        <span
                                            class="status-badge
                                                {{ $jobPost->status === 'draft'
                                                    ? 'draft'
                                                    : '' }}"
                                        >
                                            {{ $jobPost->status }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $jobPost->created_at
                                            ?->format('d M Y') }}
                                    </td>

                                    <td>
                                        <div class="action-buttons">
                                            <a
                                                href="{{ route(
                                                    'admin.job-posts.show',
                                                    $jobPost
                                                ) }}"
                                                class="button review-button"
                                            >
                                                Review
                                            </a>

                                           <a
    href="{{ route(
        'admin.job-posts.remove',
        $jobPost
    ) }}"
    class="button remove-button"
>
    Remove
</a>
                                        </div>
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
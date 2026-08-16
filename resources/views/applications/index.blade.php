<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>My Applications | Job Portal</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            padding: 36px 18px;
            font-family: Arial, sans-serif;
            background: #f3f6fb;
            color: #1f2937;
        }

        .page-container {
            width: 100%;
            max-width: 1040px;
            margin: 0 auto;
        }

        .top-navigation {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
            padding: 18px 24px;
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
        }

        .portal-name {
            color: #2563eb;
            font-size: 20px;
            font-weight: bold;
        }

        .dashboard-link {
            padding: 10px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #374151;
            font-size: 14px;
            font-weight: 600;
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
            color: #111827;
            font-size: 32px;
        }

        .subtitle {
            max-width: 650px;
            color: #6b7280;
            line-height: 1.6;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }

        .summary-card {
            padding: 22px;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            background: #ffffff;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.04);
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

        .filter-panel {
            margin-bottom: 24px;
            padding: 22px;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            background: #ffffff;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.04);
        }

        .filter-heading {
            margin-bottom: 16px;
            font-size: 18px;
        }

        .filter-form {
            display: flex;
            align-items: flex-end;
            gap: 12px;
        }

        .filter-field {
            flex: 1;
            max-width: 360px;
        }

        .filter-field label {
            display: block;
            margin-bottom: 7px;
            color: #374151;
            font-size: 14px;
            font-weight: 600;
        }

        .filter-field select {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #1f2937;
            font-size: 14px;
        }

        .button {
            display: inline-block;
            padding: 11px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        .filter-button {
            border: 1px solid #2563eb;
            background: #2563eb;
            color: #ffffff;
        }

        .filter-button:hover {
            background: #1d4ed8;
        }

        .clear-button {
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #374151;
        }

        .clear-button:hover {
            background: #f9fafb;
        }

        .alert-error {
            margin-bottom: 22px;
            padding: 14px 16px;
            border: 1px solid #fca5a5;
            border-radius: 10px;
            background: #fef2f2;
            color: #991b1b;
        }

        .results-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 16px;
        }

        .results-heading h2 {
            font-size: 21px;
        }

        .results-note {
            color: #6b7280;
            font-size: 14px;
        }

        .application-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .application-card {
            position: relative;
            overflow: hidden;
            padding: 24px;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            background: #ffffff;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        }

        .application-card::before {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: #2563eb;
            content: '';
        }

        .card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 20px;
        }

        .job-title {
            color: #111827;
            font-size: 20px;
            line-height: 1.35;
        }

        .status-badge {
            flex-shrink: 0;
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            text-transform: capitalize;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-success {
            background: #dcfce7;
            color: #166534;
        }

        .status-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-neutral {
            background: #f3f4f6;
            color: #4b5563;
        }

        .detail-list {
            display: grid;
            gap: 12px;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 135px 1fr;
            gap: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f3f4f6;
        }

        .detail-row:last-child {
            padding-bottom: 0;
            border-bottom: none;
        }

        .detail-label {
            color: #6b7280;
            font-size: 13px;
            font-weight: 600;
        }

        .detail-value {
            color: #374151;
            font-size: 14px;
            font-weight: 500;
        }

        .empty-state {
            padding: 48px 24px;
            border: 1px dashed #cbd5e1;
            border-radius: 14px;
            background: #ffffff;
            text-align: center;
        }

        .empty-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            border-radius: 50%;
            background: #eff6ff;
            color: #2563eb;
            font-size: 24px;
            font-weight: bold;
        }

        .empty-state h2 {
            margin-bottom: 8px;
        }

        .empty-state p {
            color: #6b7280;
            line-height: 1.6;
        }

        @media (max-width: 760px) {
            body {
                padding: 24px 14px;
            }

            .top-navigation,
            .filter-form,
            .results-heading {
                align-items: stretch;
                flex-direction: column;
            }

            .summary-grid,
            .application-grid {
                grid-template-columns: 1fr;
            }

            .filter-field {
                max-width: none;
            }

            .button,
            .dashboard-link {
                width: 100%;
                text-align: center;
            }

            .detail-row {
                grid-template-columns: 1fr;
                gap: 5px;
            }

            h1 {
                font-size: 28px;
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

            <a
                href="{{ route('dashboard') }}"
                class="dashboard-link"
            >
                Back to Dashboard
            </a>

        </nav>

        <header class="page-header">

            <h1>My Applications</h1>

            <p class="subtitle">
                Review the jobs you have applied for and track the
                current status of each submitted application.
            </p>

        </header>

        @if ($errors->has('status'))

            <div class="alert-error" role="alert">
                {{ $errors->first('status') }}
            </div>

        @endif

        <section class="summary-grid">

            <div class="summary-card">

                <span class="summary-label">
                    Total Applications
                </span>

                <div class="summary-value">
                    {{ $totalApplications }}
                </div>

            </div>

            <div class="summary-card">

                <span class="summary-label">
                    Currently Displayed
                </span>

                <div class="summary-value">
                    {{ $applications->count() }}
                </div>

            </div>

        </section>

        <section class="filter-panel">

            <h2 class="filter-heading">
                Filter Applications
            </h2>

            <form
                method="GET"
                action="{{ route('applications.index') }}"
                class="filter-form"
            >

                <div class="filter-field">

                    <label for="status">
                        Application Status
                    </label>

                    <select id="status" name="status">

                        <option value="">
                            All Applications
                        </option>

                        @foreach ($availableStatuses as $status)

                            <option
                                value="{{ $status }}"
                                @selected(
                                    $selectedStatus === $status
                                )
                            >
                                {{
                                    ucwords(
                                        str_replace(
                                            ['_', '-'],
                                            ' ',
                                            $status
                                        )
                                    )
                                }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <button
                    type="submit"
                    class="button filter-button"
                >
                    Apply Filter
                </button>

                @if ($selectedStatus !== '')

                    <a
                        href="{{ route('applications.index') }}"
                        class="button clear-button"
                    >
                        Clear Filter
                    </a>

                @endif

            </form>

        </section>

        <div class="results-heading">

            <h2>
                Submitted Applications
            </h2>

            @if ($selectedStatus !== '')

                <div class="results-note">

                    Showing status:

                    <strong>
                        {{
                            ucwords(
                                str_replace(
                                    ['_', '-'],
                                    ' ',
                                    $selectedStatus
                                )
                            )
                        }}
                    </strong>

                </div>

            @endif

        </div>

        @if ($applications->isEmpty())

            <section class="empty-state">

                <div class="empty-icon">
                    i
                </div>

                @if ($selectedStatus !== '')

                    <h2>No matching applications</h2>

                    <p>
                        You do not currently have applications
                        with the selected status.
                    </p>

                @else

                    <h2>No applications yet</h2>

                    <p>
                        You have not submitted any job applications yet.
                        Your applications will appear here after submission.
                    </p>

                @endif

            </section>

        @else

            <section class="application-grid">

                @foreach ($applications as $application)

                    @php
                        $status = strtolower(
                            trim(
                                (string) $application->status
                            )
                        );

                        $statusClass = match ($status) {
                            'accepted',
                            'approved',
                            'hired'
                                => 'status-success',

                            'rejected',
                            'declined'
                                => 'status-danger',

                            'reviewing',
                            'under_review',
                            'shortlisted',
                            'interview'
                                => 'status-info',

                            'pending'
                                => 'status-pending',

                            default
                                => 'status-neutral',
                        };

                        $statusLabel = ucwords(
                            str_replace(
                                ['_', '-'],
                                ' ',
                                $status
                            )
                        );
                    @endphp

                    <article class="application-card">

                        <div class="card-header">

                            <h3 class="job-title">
                                {{
                                    $application
                                        ->jobPost?->title
                                    ?? 'Job Posting Unavailable'
                                }}
                            </h3>

                            <span
                                class="
                                    status-badge
                                    {{ $statusClass }}
                                "
                            >
                                {{
                                    $statusLabel
                                    ?: 'Unknown'
                                }}
                            </span>

                        </div>

                        <div class="detail-list">

                            <div class="detail-row">

                                <div class="detail-label">
                                    Location
                                </div>

                                <div class="detail-value">
                                    {{
                                        $application
                                            ->jobPost?->location
                                        ?? 'N/A'
                                    }}
                                </div>

                            </div>

                            <div class="detail-row">

                                <div class="detail-label">
                                    Employment Type
                                </div>

                                <div class="detail-value">
                                    {{
                                        $application
                                            ->jobPost?->employment_type
                                        ?? 'N/A'
                                    }}
                                </div>

                            </div>

                            <div class="detail-row">

                                <div class="detail-label">
                                    Applied Date
                                </div>

                                <div class="detail-value">
                                    {{
                                        $application
                                            ->created_at
                                            ->format(
                                                'd/m/Y h:i A'
                                            )
                                    }}
                                </div>

                            </div>

                            <div class="detail-row">

                                <div class="detail-label">
                                    Application ID
                                </div>

                                <div class="detail-value">
                                    #{{ $application->id }}
                                </div>

                            </div>

                        </div>

                    </article>

                @endforeach

            </section>

        @endif

    </main>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Applicants | Job Portal</title>

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
            max-width: 1120px;
            margin: 0 auto;
        }

        .top-navigation {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 28px;
            padding: 18px 24px;
            border-radius: 14px;
            background: #ffffff;
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
            color: #374151;
            background: #ffffff;
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

        .page-header h1 {
            margin-bottom: 8px;
            color: #111827;
            font-size: 32px;
        }

        .subtitle {
            color: #6b7280;
            line-height: 1.6;
        }

        .job-card {
            margin-bottom: 22px;
            padding: 22px 24px;
            border: 1px solid #dbeafe;
            border-radius: 14px;
            background: #eff6ff;
        }

        .job-card h2 {
            margin-bottom: 12px;
            color: #1e3a8a;
            font-size: 21px;
        }

        .job-details {
            display: flex;
            flex-wrap: wrap;
            gap: 12px 24px;
            color: #475569;
            font-size: 14px;
        }

        .job-detail strong {
            color: #1f2937;
        }

        .alert-error {
            margin-bottom: 22px;
            padding: 14px 16px;
            border: 1px solid #fca5a5;
            border-radius: 10px;
            background: #fef2f2;
            color: #991b1b;
        }

        .alert-error ul {
            margin-left: 20px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns:
                repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 22px;
        }

        .summary-card {
            padding: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            background: #ffffff;
            box-shadow:
                0 6px 18px rgba(0, 0, 0, 0.04);
        }

        .summary-label {
            display: block;
            margin-bottom: 8px;
            color: #6b7280;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .summary-value {
            color: #111827;
            font-size: 29px;
            font-weight: bold;
        }

        .filter-panel {
            margin-bottom: 24px;
            padding: 22px;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            background: #ffffff;
            box-shadow:
                0 6px 18px rgba(0, 0, 0, 0.04);
        }

        .filter-panel h2 {
            margin-bottom: 16px;
            font-size: 18px;
        }

        .filter-form {
            display: grid;
            grid-template-columns:
                minmax(220px, 1fr)
                220px
                auto
                auto;
            gap: 12px;
            align-items: end;
        }

        .filter-field label {
            display: block;
            margin-bottom: 7px;
            color: #374151;
            font-size: 14px;
            font-weight: 600;
        }

        .filter-field input,
        .filter-field select {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #1f2937;
            font-size: 14px;
        }

        .filter-field input:focus,
        .filter-field select:focus {
            border-color: #2563eb;
            outline: none;
            box-shadow:
                0 0 0 3px
                rgba(37, 99, 235, 0.1);
        }

        .button {
            display: inline-block;
            padding: 11px 17px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }

        .primary-button {
            border: 1px solid #2563eb;
            background: #2563eb;
            color: #ffffff;
        }

        .primary-button:hover {
            background: #1d4ed8;
        }

        .secondary-button {
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #374151;
        }

        .secondary-button:hover {
            background: #f9fafb;
        }

        .results-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 16px;
        }

        .results-header h2 {
            font-size: 21px;
        }

        .results-note {
            color: #6b7280;
            font-size: 14px;
        }

        .applicant-grid {
            display: grid;
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .applicant-card {
            overflow: hidden;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            background: #ffffff;
            box-shadow:
                0 8px 24px rgba(0, 0, 0, 0.05);
        }

        .applicant-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            padding: 22px;
            border-bottom: 1px solid #f3f4f6;
        }

        .applicant-identity {
            display: flex;
            align-items: center;
            gap: 13px;
            min-width: 0;
        }

        .avatar {
            display: flex;
            flex: 0 0 44px;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: 17px;
            font-weight: bold;
        }

        .applicant-name {
            margin-bottom: 4px;
            color: #111827;
            font-size: 18px;
        }

        .applicant-email {
            color: #6b7280;
            font-size: 13px;
            overflow-wrap: anywhere;
        }

        .status-badge {
            flex-shrink: 0;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-shortlisted {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-accepted {
            background: #dcfce7;
            color: #166534;
        }

        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-default {
            background: #f3f4f6;
            color: #4b5563;
        }

        .applicant-body {
            padding: 20px 22px 22px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 16px;
            color: #4b5563;
            font-size: 14px;
        }

        .detail-label {
            color: #6b7280;
            font-weight: 600;
        }

        .cover-letter-box {
            padding: 14px;
            border-radius: 10px;
            background: #f8fafc;
        }

        .cover-letter-box h4 {
            margin-bottom: 8px;
            color: #374151;
            font-size: 13px;
        }

        .cover-letter-box p {
            color: #4b5563;
            font-size: 14px;
            line-height: 1.6;
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

        .empty-state {
            padding: 50px 24px;
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
            font-size: 22px;
            font-weight: bold;
        }

        .empty-state h3 {
            margin-bottom: 8px;
        }

        .empty-state p {
            color: #6b7280;
            line-height: 1.6;
        }

        @media (max-width: 900px) {
            .summary-grid {
                grid-template-columns: 1fr;
            }

            .filter-form {
                grid-template-columns: 1fr 1fr;
            }

            .applicant-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 620px) {
            body {
                padding: 24px 14px;
            }

            .top-navigation,
            .results-header {
                align-items: stretch;
                flex-direction: column;
            }

            .dashboard-link {
                width: 100%;
                text-align: center;
            }

            .filter-form {
                grid-template-columns: 1fr;
            }

            .applicant-header {
                flex-direction: column;
            }

            .detail-row {
                flex-direction: column;
                gap: 5px;
            }

            .page-header h1 {
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

            <h1>Applicants</h1>

            <p class="subtitle">
                Review the candidates who applied for your
                job posting. Use search and status filters
                to find applicants quickly.
            </p>

        </header>

        <section class="job-card">

            <h2>{{ $jobPost->title }}</h2>

            <div class="job-details">

                <div class="job-detail">
                    <strong>Location:</strong>
                    {{ $jobPost->location ?? 'N/A' }}
                </div>

                <div class="job-detail">
                    <strong>Employment Type:</strong>
                    {{
                        $jobPost->employment_type
                        ?? 'N/A'
                    }}
                </div>

                <div class="job-detail">
                    <strong>Job Status:</strong>
                    {{
                        ucfirst(
                            $jobPost->status
                            ?? 'N/A'
                        )
                    }}
                </div>

            </div>

        </section>

        @if ($errors->any())

            <div
                class="alert-error"
                role="alert"
            >
                <ul>
                    @foreach (
                        $errors->all()
                        as $error
                    )
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>

        @endif

        <section class="summary-grid">

            <div class="summary-card">

                <span class="summary-label">
                    Total Applicants
                </span>

                <div class="summary-value">
                    {{ $totalApplicants }}
                </div>

            </div>

            <div class="summary-card">

                <span class="summary-label">
                    Pending Review
                </span>

                <div class="summary-value">
                    {{ $pendingApplicants }}
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

            <h2>Find Applicants</h2>

            <form
                method="GET"
                action="{{
                    route(
                        'employer.applicants.index',
                        $jobPost
                    )
                }}"
                class="filter-form"
            >

                <div class="filter-field">

                    <label for="search">
                        Applicant Name or Email
                    </label>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ $search }}"
                        maxlength="100"
                        placeholder="Search by name or email"
                    >

                </div>

                <div class="filter-field">

                    <label for="status">
                        Application Status
                    </label>

                    <select
                        id="status"
                        name="status"
                    >

                        <option value="">
                            All Statuses
                        </option>

                        @foreach (
                            $availableStatuses
                            as $status
                        )

                            <option
                                value="{{ $status }}"
                                @selected(
                                    $selectedStatus
                                    === $status
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
                    class="button primary-button"
                >
                    Apply Filter
                </button>

                @if (
                    $search !== ''
                    || $selectedStatus !== ''
                )

                    <a
                        href="{{
                            route(
                                'employer.applicants.index',
                                $jobPost
                            )
                        }}"
                        class="button secondary-button"
                    >
                        Clear
                    </a>

                @endif

            </form>

        </section>

        <div class="results-header">

            <h2>Applicant List</h2>

            <div class="results-note">
                {{ $applications->count() }}
                applicant(s) found
            </div>

        </div>

        @if ($applications->isEmpty())

            <section class="empty-state">

                <div class="empty-icon">
                    i
                </div>

                @if (
                    $search !== ''
                    || $selectedStatus !== ''
                )

                    <h3>
                        No matching applicants
                    </h3>

                    <p>
                        No applicants match the current
                        search or status filter.
                        Clear the filters and try again.
                    </p>

                @else

                    <h3>
                        No applicants yet
                    </h3>

                    <p>
                        No job seekers have applied for
                        this job posting yet.
                        New applications will appear here.
                    </p>

                @endif

            </section>

        @else

            <section class="applicant-grid">

                @foreach (
                    $applications
                    as $application
                )

                    @php
                        $applicantName =
                            $application
                                ->jobSeeker?->name
                            ?? 'Applicant Unavailable';

                        $applicantEmail =
                            $application
                                ->jobSeeker?->email
                            ?? 'N/A';

                        $initial = strtoupper(
                            substr(
                                $applicantName,
                                0,
                                1
                            )
                        );

                        $status = strtolower(
                            trim(
                                (string)
                                $application->status
                            )
                        );

                        $statusClass =
                            match ($status) {
                                'pending'
                                    => 'status-pending',

                                'shortlisted',
                                'reviewing',
                                'under_review',
                                'interview'
                                    => 'status-shortlisted',

                                'accepted',
                                'approved',
                                'hired'
                                    => 'status-accepted',

                                'rejected',
                                'declined'
                                    => 'status-rejected',

                                default
                                    => 'status-default',
                            };

                        $statusLabel = ucwords(
                            str_replace(
                                ['_', '-'],
                                ' ',
                                $status
                            )
                        );
                    @endphp

                    <article class="applicant-card">

                        <div class="applicant-header">

                            <div class="applicant-identity">

                                <div class="avatar">
                                    {{ $initial }}
                                </div>

                                <div>

                                    <h3 class="applicant-name">
                                        {{ $applicantName }}
                                    </h3>

                                    <div class="applicant-email">
                                        {{ $applicantEmail }}
                                    </div>

                                </div>

                            </div>

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

                        <div class="applicant-body">

                            <div class="detail-row">

                                <span class="detail-label">
                                    Applied Date
                                </span>

                                <span>
                                    {{
                                        $application
                                            ->created_at
                                            ->format(
                                                'd/m/Y h:i A'
                                            )
                                    }}
                                </span>

                            </div>

                            <div class="detail-row">

                                <span class="detail-label">
                                    Application ID
                                </span>

                                <span>
                                    #{{ $application->id }}
                                </span>

                            </div>

                            <div class="cover-letter-box">

                                <h4>
                                    Cover Letter
                                </h4>

                                <p>{{
                                    $application
                                        ->cover_letter
                                    ?: 'No cover letter provided.'
                                }}</p>

                            </div>

                        </div>

                    </article>

                @endforeach

            </section>

        @endif

    </main>
</body>
</html>
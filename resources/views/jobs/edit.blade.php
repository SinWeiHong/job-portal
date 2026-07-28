<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Job Posting | Job Portal</title>

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
            max-width: 760px;
            margin: 0 auto;
        }

        .page-header {
            margin-bottom: 24px;
        }

        .portal-name {
            margin-bottom: 8px;
            color: #2563eb;
            font-size: 18px;
            font-weight: bold;
        }

        h1 {
            margin-bottom: 8px;
            font-size: 30px;
        }

        .subtitle {
            color: #6b7280;
            line-height: 1.5;
        }

        .job-card {
            padding: 30px;
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .job-card h2 {
            margin-bottom: 22px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 22px;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 18px;
            padding: 13px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .detail-label {
            color: #6b7280;
            font-weight: bold;
        }

        .detail-value {
            overflow-wrap: anywhere;
            line-height: 1.5;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 999px;
            background: #dbeafe;
            color: #1e40af;
            font-size: 13px;
            font-weight: bold;
            text-transform: capitalize;
        }

        .development-note {
            margin-top: 24px;
            padding: 16px;
            border: 1px solid #bfdbfe;
            border-radius: 9px;
            background: #eff6ff;
            color: #1e40af;
            line-height: 1.6;
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 24px;
        }

        .back-button {
            display: inline-block;
            padding: 11px 20px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #374151;
            font-weight: bold;
            text-decoration: none;
        }

        .back-button:hover {
            background: #f9fafb;
        }

        @media (max-width: 600px) {
            .job-card {
                padding: 24px 20px;
            }

            .detail-row {
                grid-template-columns: 1fr;
                gap: 6px;
            }
        }
    </style>
</head>

<body>
    <main class="page-container">
        <header class="page-header">
            <div class="portal-name">
                Job Portal Website
            </div>

            <h1>Edit Job Posting</h1>

            <p class="subtitle">
                Review the current job posting information before editing.
            </p>
        </header>

        <section class="job-card">
            <h2>Current Job Information</h2>

            <div class="detail-row">
                <div class="detail-label">Job ID</div>

                <div class="detail-value">
                    {{ $jobPost->id }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Job Title</div>

                <div class="detail-value">
                    {{ $jobPost->title }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Location</div>

                <div class="detail-value">
                    {{ $jobPost->location }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Employment Type</div>

                <div class="detail-value">
                    {{ $jobPost->employment_type }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Minimum Salary</div>

                <div class="detail-value">
                    @if ($jobPost->salary_min !== null)
                        RM {{ number_format((float) $jobPost->salary_min, 2) }}
                    @else
                        Not specified
                    @endif
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Maximum Salary</div>

                <div class="detail-value">
                    @if ($jobPost->salary_max !== null)
                        RM {{ number_format((float) $jobPost->salary_max, 2) }}
                    @else
                        Not specified
                    @endif
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Application Deadline</div>

                <div class="detail-value">
                    {{ $jobPost->application_deadline?->format('d M Y') }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Status</div>

                <div class="detail-value">
                    <span class="status-badge">
                        {{ $jobPost->status }}
                    </span>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Job Description</div>

                <div class="detail-value">
                    {{ $jobPost->description }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Requirements</div>

                <div class="detail-value">
                    {{ $jobPost->requirements ?: 'Not specified' }}
                </div>
            </div>

            <div class="development-note">
                The complete prefilled edit form will be implemented
                in JPW-8 Week 1 Commit 2.
            </div>

            <div class="actions">
                <a
                    href="{{ route('dashboard') }}"
                    class="back-button"
                >
                    Back to Dashboard
                </a>
            </div>
        </section>
    </main>
</body>
</html>
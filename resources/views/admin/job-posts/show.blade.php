<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Review Job Posting | Job Portal</title>

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
            max-width: 900px;
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
            line-height: 1.6;
        }

        .review-card {
            padding: 32px;
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .section-title {
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 21px;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 190px 1fr;
            gap: 20px;
            padding: 15px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .detail-label {
            color: #6b7280;
            font-weight: bold;
        }

        .detail-value {
            overflow-wrap: anywhere;
            line-height: 1.6;
            white-space: pre-line;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 999px;
            background: #dcfce7;
            color: #166534;
            font-size: 13px;
            font-weight: bold;
            text-transform: capitalize;
        }

        .development-note {
            margin-top: 24px;
            padding: 15px 16px;
            border: 1px solid #bfdbfe;
            border-radius: 9px;
            background: #eff6ff;
            color: #1e40af;
            line-height: 1.6;
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 24px;
            padding-top: 22px;
            border-top: 1px solid #e5e7eb;
        }

        .button {
            display: inline-block;
            padding: 11px 19px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
        }

        .back-button {
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #374151;
        }

        .back-button:hover {
            background: #f9fafb;
        }

        .remove-button {
            background: #e5e7eb;
            color: #9ca3af;
            cursor: not-allowed;
        }

        @media (max-width: 650px) {
            .review-card {
                padding: 24px 20px;
            }

            .detail-row {
                grid-template-columns: 1fr;
                gap: 6px;
            }

            .actions {
                flex-direction: column-reverse;
            }

            .button {
                width: 100%;
                text-align: center;
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

            <h1>Review Job Posting</h1>

            <p class="subtitle">
                Examine the complete job posting before taking
                moderation action.
            </p>
        </header>

        <section class="review-card">
            <h2 class="section-title">
                Job Posting Details
            </h2>

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
                <div class="detail-label">Employer</div>

                <div class="detail-value">
                    {{ $jobPost->employer?->name
                        ?? 'Employer unavailable' }}

                    @if ($jobPost->employer?->email)
                        <br>
                        {{ $jobPost->employer->email }}
                    @endif
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
                <div class="detail-label">Salary Range</div>

                <div class="detail-value">
                    @if (
                        $jobPost->salary_min !== null
                        && $jobPost->salary_max !== null
                    )
                        RM {{ number_format(
                            (float) $jobPost->salary_min,
                            2
                        ) }}
                        –
                        RM {{ number_format(
                            (float) $jobPost->salary_max,
                            2
                        ) }}
                    @else
                        Not specified
                    @endif
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Deadline</div>

                <div class="detail-value">
                    {{ $jobPost->application_deadline
                        ?->format('d M Y') }}
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
                <div class="detail-label">Description</div>

                <div class="detail-value">
                    {{ $jobPost->description }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Requirements</div>

                <div class="detail-value">
                    {{ $jobPost->requirements
                        ?: 'No requirements provided.' }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Posted Date</div>

                <div class="detail-value">
                    {{ $jobPost->created_at?->format(
                        'd M Y, h:i A'
                    ) }}
                </div>
            </div>

            <div class="development-note">
                The removal reason form and soft-delete operation
                will be implemented in JPW-13 Week 2 Commit 1.
            </div>

            <div class="actions">
                <a
                    href="{{ route('admin.job-posts.index') }}"
                    class="button back-button"
                >
                    Back to Moderation List
                </a>

                <button
                    type="button"
                    class="button remove-button"
                    disabled
                >
                    Remove Job Posting
                </button>
            </div>
        </section>
    </main>
</body>
</html>
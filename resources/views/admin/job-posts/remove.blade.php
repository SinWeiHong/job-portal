<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Remove Job Posting | Job Portal</title>

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
            max-width: 820px;
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

        .removal-card {
            padding: 32px;
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .warning-box {
            margin-bottom: 24px;
            padding: 16px;
            border: 1px solid #fca5a5;
            border-radius: 9px;
            background: #fef2f2;
            color: #991b1b;
            line-height: 1.6;
        }

        .warning-box strong {
            display: block;
            margin-bottom: 4px;
        }

        .section-title {
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 21px;
        }

        .job-summary {
            margin-bottom: 26px;
            padding: 18px;
            border: 1px solid #e5e7eb;
            border-radius: 9px;
            background: #f9fafb;
        }

        .summary-row {
            display: grid;
            grid-template-columns: 170px 1fr;
            gap: 18px;
            padding: 10px 0;
        }

        .summary-label {
            color: #6b7280;
            font-weight: bold;
        }

        .summary-value {
            overflow-wrap: anywhere;
            line-height: 1.5;
        }

        .error-summary {
            margin-bottom: 20px;
            padding: 14px 16px;
            border: 1px solid #fca5a5;
            border-radius: 8px;
            background: #fef2f2;
            color: #991b1b;
            line-height: 1.5;
        }

        .error-summary ul {
            margin-top: 8px;
            padding-left: 22px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .required {
            color: #dc2626;
        }

        textarea {
            width: 100%;
            min-height: 170px;
            padding: 13px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-family: Arial, sans-serif;
            font-size: 15px;
            line-height: 1.5;
            resize: vertical;
            outline: none;
        }

        textarea:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
        }

        .input-error {
            border-color: #dc2626;
        }

        .error-message {
            display: block;
            margin-top: 7px;
            color: #dc2626;
            font-size: 13px;
            line-height: 1.5;
        }

        .field-help {
            display: block;
            margin-top: 7px;
            color: #6b7280;
            font-size: 13px;
            line-height: 1.5;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            padding-top: 22px;
            border-top: 1px solid #e5e7eb;
        }

        .button {
            display: inline-block;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        .cancel-button {
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #374151;
        }

        .cancel-button:hover {
            background: #f9fafb;
        }

        .remove-button {
            background: #dc2626;
            color: #ffffff;
        }

        .remove-button:hover {
            background: #b91c1c;
        }

        @media (max-width: 650px) {
            .removal-card {
                padding: 24px 20px;
            }

            .summary-row {
                grid-template-columns: 1fr;
                gap: 5px;
            }

            .form-actions {
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

            <h1>Remove Job Posting</h1>

            <p class="subtitle">
                Provide a clear reason before removing this job posting
                from the platform.
            </p>
        </header>

        <section class="removal-card">
            <div class="warning-box">
                <strong>
                    Are you sure you want to remove this job posting?
                </strong>

                The posting will be hidden from users but retained in
                the database as a moderation record.
            </div>

            <h2 class="section-title">
                Job Posting Information
            </h2>

            <div class="job-summary">
                <div class="summary-row">
                    <div class="summary-label">
                        Job ID
                    </div>

                    <div class="summary-value">
                        {{ $jobPost->id }}
                    </div>
                </div>

                <div class="summary-row">
                    <div class="summary-label">
                        Job Title
                    </div>

                    <div class="summary-value">
                        {{ $jobPost->title }}
                    </div>
                </div>

                <div class="summary-row">
                    <div class="summary-label">
                        Employer
                    </div>

                    <div class="summary-value">
                        {{ $jobPost->employer?->name
                            ?? 'Employer unavailable' }}

                        @if ($jobPost->employer?->email)
                            <br>
                            {{ $jobPost->employer->email }}
                        @endif
                    </div>
                </div>

                <div class="summary-row">
                    <div class="summary-label">
                        Location
                    </div>

                    <div class="summary-value">
                        {{ $jobPost->location }}
                    </div>
                </div>

                <div class="summary-row">
                    <div class="summary-label">
                        Status
                    </div>

                    <div class="summary-value">
                        {{ ucfirst($jobPost->status) }}
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="error-summary" role="alert">
                    <strong>
                        Please correct the following information:
                    </strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route(
                    'admin.job-posts.destroy',
                    $jobPost
                ) }}"
                novalidate
            >
                @csrf
                @method('DELETE')

                <div class="form-group">
                    <label for="removal_reason">
                        Removal Reason
                        <span class="required">*</span>
                    </label>

                    <textarea
                        id="removal_reason"
                        name="removal_reason"
                        minlength="10"
                        maxlength="1000"
                        placeholder="Explain why this job posting is inappropriate, misleading or unreliable."
                        class="@error('removal_reason') input-error @enderror"
                        required
                    >{{ old('removal_reason') }}</textarea>

                    @error('removal_reason')
                        <span class="error-message">
                            {{ $message }}
                        </span>
                    @enderror

                    <span class="field-help">
                        Enter between 10 and 1000 characters.
                    </span>
                </div>

                <div class="form-actions">
                    <a
                        href="{{ route(
                            'admin.job-posts.show',
                            $jobPost
                        ) }}"
                        class="button cancel-button"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="button remove-button"
                    >
                        Confirm Removal
                    </button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
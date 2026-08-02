<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Apply for Job | Job Portal</title>

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
            line-height: 1.5;
        }

        .job-card,
        .application-card {
            margin-bottom: 24px;
            padding: 30px;
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

        .job-title {
            margin-bottom: 18px;
            color: #111827;
            font-size: 24px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .detail-item {
            padding: 14px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #f9fafb;
        }

        .detail-label {
            display: block;
            margin-bottom: 5px;
            color: #6b7280;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .detail-value {
            color: #1f2937;
            font-weight: 600;
            line-height: 1.5;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 999px;
            background: #dcfce7;
            color: #166534;
            font-size: 13px;
            font-weight: bold;
            text-transform: capitalize;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        textarea {
            width: 100%;
            min-height: 190px;
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
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
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
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .button {
            display: inline-block;
            padding: 12px 21px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
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

        .submit-button {
            background: #2563eb;
            color: #ffffff;
        }

        .submit-button:hover {
            background: #1d4ed8;
        }

        .closed-message {
            padding: 16px;
            border: 1px solid #fca5a5;
            border-radius: 8px;
            background: #fef2f2;
            color: #991b1b;
            line-height: 1.5;
        }

        @media (max-width: 650px) {
            body {
                padding: 24px 14px;
            }

            .job-card,
            .application-card {
                padding: 24px 20px;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .button {
                width: 100%;
                text-align: center;
            }
        }

        .alert-success {
    margin-bottom: 20px;
    padding: 13px 15px;
    border: 1px solid #86efac;
    border-radius: 8px;
    background: #f0fdf4;
    color: #166534;
    line-height: 1.5;
}

.error-summary {
    margin-bottom: 20px;
    padding: 13px 15px;
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

.input-error {
    border-color: #dc2626;
}

.input-error:focus {
    border-color: #dc2626;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
}

.error-message {
    display: block;
    margin-top: 7px;
    color: #dc2626;
    font-size: 13px;
    line-height: 1.5;
}
    </style>
</head>

<body>
    <main class="page-container">
        <header class="page-header">
            <div class="portal-name">
                Job Portal Website
            </div>

            <h1>Apply for a Job</h1>

            <p class="subtitle">
                Review the job information and submit your application
                to the employer.
            </p>
        </header>

        <section class="job-card">
            <h2 class="section-title">
                Job Information
            </h2>

            <h3 class="job-title">
                {{ $jobPost->title }}
            </h3>

            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">
                        Location
                    </span>

                    <div class="detail-value">
                        {{ $jobPost->location }}
                    </div>
                </div>

                <div class="detail-item">
                    <span class="detail-label">
                        Employment Type
                    </span>

                    <div class="detail-value">
                        {{ $jobPost->employment_type }}
                    </div>
                </div>

                <div class="detail-item">
                    <span class="detail-label">
                        Salary Range
                    </span>

                    <div class="detail-value">
                        @if (
                            $jobPost->salary_min !== null
                            && $jobPost->salary_max !== null
                        )
                            RM {{ number_format((float) $jobPost->salary_min, 2) }}
                            –
                            RM {{ number_format((float) $jobPost->salary_max, 2) }}
                        @elseif ($jobPost->salary_min !== null)
                            From RM
                            {{ number_format((float) $jobPost->salary_min, 2) }}
                        @elseif ($jobPost->salary_max !== null)
                            Up to RM
                            {{ number_format((float) $jobPost->salary_max, 2) }}
                        @else
                            Not specified
                        @endif
                    </div>
                </div>

                <div class="detail-item">
                    <span class="detail-label">
                        Application Deadline
                    </span>

                    <div class="detail-value">
                        {{ $jobPost->application_deadline?->format('d M Y') }}
                    </div>
                </div>

                <div class="detail-item">
                    <span class="detail-label">
                        Posting Status
                    </span>

                    <div class="detail-value">
                        <span class="status-badge">
                            {{ $jobPost->status }}
                        </span>
                    </div>
                </div>

                <div class="detail-item">
                    <span class="detail-label">
                        Employer
                    </span>

                    <div class="detail-value">
                        {{ $jobPost->employer?->name ?? 'Employer not available' }}
                    </div>
                </div>
            </div>
        </section>

        <section class="application-card">
            <h2 class="section-title">
                Application Form
            </h2>

            @if (session('success'))
    <div class="alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

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

            @if (
                strtolower((string) $jobPost->status) === 'open'
            )
                <form
                    method="POST"
                    action="{{ route('applications.store', $jobPost) }}"
                >
                    @csrf

                    <div class="form-group">
                        <label for="cover_letter">
                            Cover Letter
                        </label>

                        <textarea
    id="cover_letter"
    name="cover_letter"
    maxlength="5000"
    placeholder="Introduce yourself and explain why you are suitable for this job."
    class="@error('cover_letter') input-error @enderror"
    required
>{{ old('cover_letter') }}</textarea>

@error('cover_letter')
    <span class="error-message">
        {{ $message }}
    </span>
@enderror

                        <span class="field-help">
                            You may include your relevant skills, experience
                            and reasons for applying. Maximum 5000 characters.
                        </span>
                    </div>

                    <div class="form-actions">
                        <a
                            href="{{ url('/') }}"
                            class="button cancel-button"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="button submit-button"
                        >
                            Submit Application
                        </button>
                    </div>
                </form>
            @else
                <div class="closed-message">
                    Applications are not currently available because this
                    job posting is not open.
                </div>
            @endif
        </section>
    </main>
</body>
</html>
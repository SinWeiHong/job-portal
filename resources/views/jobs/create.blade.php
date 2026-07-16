<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Create Job Posting | Job Portal</title>

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
            line-height: 1.5;
        }

        .form-card {
            padding: 32px;
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .section-title {
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 20px;
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

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: 600;
        }

        .required {
            color: #dc2626;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            font-family: Arial, sans-serif;
            font-size: 15px;
            outline: none;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
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
            margin-top: 6px;
            color: #dc2626;
            font-size: 13px;
        }

        textarea {
            min-height: 130px;
            resize: vertical;
        }

        .field-help {
            display: block;
            margin-top: 6px;
            color: #6b7280;
            font-size: 13px;
            line-height: 1.4;
        }

        .salary-fields {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 12px;
            padding-top: 22px;
            border-top: 1px solid #e5e7eb;
        }

        .button {
            display: inline-block;
            padding: 12px 22px;
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

        .create-button {
            background: #2563eb;
            color: #ffffff;
        }

        .create-button:hover {
            background: #1d4ed8;
        }

        @media (max-width: 700px) {
            .form-grid,
            .salary-fields {
                grid-template-columns: 1fr;
            }

            .form-card {
                padding: 24px 20px;
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

            <h1>Create Job Posting</h1>

            <p class="subtitle">
                Enter the necessary job information to publish a new
                employment opportunity for job seekers.
            </p>
        </header>

        <section class="form-card">
            <h2 class="section-title">
                Job Information
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

            <form
                method="POST"
                action="{{ route('jobs.store') }}"
                novalidate
            >
                @csrf

                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="title">
                            Job Title
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="{{ old('title') }}"
                            maxlength="150"
                            placeholder="Example: Junior Software Developer"
                            class="@error('title') input-error @enderror"
                            required
                        >

                        @error('title')
                            <span class="error-message">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="location">
                            Job Location
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="location"
                            name="location"
                            value="{{ old('location') }}"
                            maxlength="150"
                            placeholder="Example: Kuala Lumpur"
                            class="@error('location') input-error @enderror"
                            required
                        >

                        @error('location')
                            <span class="error-message">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="employment_type">
                            Employment Type
                            <span class="required">*</span>
                        </label>

                        <select
                            id="employment_type"
                            name="employment_type"
                            class="@error('employment_type') input-error @enderror"
                            required
                        >
                            <option value="">
                                Select employment type
                            </option>

                            <option
                                value="Full-time"
                                @selected(old('employment_type') === 'Full-time')
                            >
                                Full-time
                            </option>

                            <option
                                value="Part-time"
                                @selected(old('employment_type') === 'Part-time')
                            >
                                Part-time
                            </option>

                            <option
                                value="Contract"
                                @selected(old('employment_type') === 'Contract')
                            >
                                Contract
                            </option>

                            <option
                                value="Internship"
                                @selected(old('employment_type') === 'Internship')
                            >
                                Internship
                            </option>

                            <option
                                value="Temporary"
                                @selected(old('employment_type') === 'Temporary')
                            >
                                Temporary
                            </option>
                        </select>

                        @error('employment_type')
                            <span class="error-message">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label>
                            Monthly Salary Range (RM)
                        </label>

                        <div class="salary-fields">
                            <div>
                                <input
                                    type="number"
                                    id="salary_min"
                                    name="salary_min"
                                    value="{{ old('salary_min') }}"
                                    min="0"
                                    step="0.01"
                                    placeholder="Minimum salary"
                                    class="@error('salary_min') input-error @enderror"
                                >

                                @error('salary_min')
                                    <span class="error-message">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div>
                                <input
                                    type="number"
                                    id="salary_max"
                                    name="salary_max"
                                    value="{{ old('salary_max') }}"
                                    min="0"
                                    step="0.01"
                                    placeholder="Maximum salary"
                                    class="@error('salary_max') input-error @enderror"
                                >

                                @error('salary_max')
                                    <span class="error-message">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <span class="field-help">
                            Leave both fields empty when salary is
                            negotiable or confidential.
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="application_deadline">
                            Application Deadline
                            <span class="required">*</span>
                        </label>

                        <input
                            type="date"
                            id="application_deadline"
                            name="application_deadline"
                            value="{{ old('application_deadline') }}"
                            min="{{ now()->toDateString() }}"
                            class="@error('application_deadline') input-error @enderror"
                            required
                        >

                        @error('application_deadline')
                            <span class="error-message">
                                {{ $message }}
                            </span>
                        @enderror

                        <span class="field-help">
                            The deadline cannot be earlier than today.
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="status">
                            Posting Status
                            <span class="required">*</span>
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="@error('status') input-error @enderror"
                            required
                        >
                            <option
                                value="open"
                                @selected(old('status', 'open') === 'open')
                            >
                                Open
                            </option>

                            <option
                                value="draft"
                                @selected(old('status') === 'draft')
                            >
                                Draft
                            </option>
                        </select>

                        @error('status')
                            <span class="error-message">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="description">
                            Job Description
                            <span class="required">*</span>
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            maxlength="5000"
                            placeholder="Describe the responsibilities, duties and working conditions."
                            class="@error('description') input-error @enderror"
                            required
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <span class="error-message">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="requirements">
                            Job Requirements
                        </label>

                        <textarea
                            id="requirements"
                            name="requirements"
                            maxlength="5000"
                            placeholder="Enter the required qualifications, skills and experience."
                            class="@error('requirements') input-error @enderror"
                        >{{ old('requirements') }}</textarea>

                        @error('requirements')
                            <span class="error-message">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
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
                        class="button create-button"
                    >
                        Create Job Posting
                    </button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
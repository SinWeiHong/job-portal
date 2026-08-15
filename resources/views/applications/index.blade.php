<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Applications</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        .application-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            max-width: 700px;
        }

        .status {
            font-weight: bold;
        }

        .empty-message {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            max-width: 700px;
        }

        .filter-form {
            display: flex;
            align-items: end;
            gap: 12px;
            margin-bottom: 24px;
            max-width: 700px;
        }

        .filter-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .filter-field label {
            font-weight: bold;
        }

        .filter-field select {
            min-width: 180px;
            padding: 8px 10px;
        }

        .filter-button,
        .clear-filter {
            padding: 9px 14px;
            border: 1px solid #333;
            border-radius: 4px;
            background: #fff;
            color: #111;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .filter-button:hover,
        .clear-filter:hover {
            background: #f2f2f2;
        }

        .filter-summary {
            margin-bottom: 18px;
        }
    </style>
</head>

<body>

    <h1>My Applications</h1>

    <form
        method="GET"
        action="{{ route('applications.index') }}"
        class="filter-form"
    >
        <div class="filter-field">
            <label for="status">Application Status</label>

            <select id="status" name="status">
                <option value="">All Applications</option>

                @foreach ($availableStatuses as $status)
                    <option
                        value="{{ $status }}"
                        @selected($selectedStatus === strtolower($status))
                    >
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="filter-button">
            Filter
        </button>

        @if ($selectedStatus !== '')
            <a
                href="{{ route('applications.index') }}"
                class="clear-filter"
            >
                Clear
            </a>
        @endif
    </form>

    @if ($selectedStatus !== '')
        <p class="filter-summary">
            Showing {{ ucfirst($selectedStatus) }} applications.
        </p>
    @endif

    @if ($applications->isEmpty())

        <div class="empty-message">
            @if ($selectedStatus !== '')
                <p>
                    No {{ ucfirst($selectedStatus) }} applications found.
                </p>
            @else
                <p>You have not submitted any job applications yet.</p>
            @endif
        </div>

    @else

        @foreach ($applications as $application)

            <div class="application-card">

                <h2>
                    {{ $application->jobPost->title ?? 'Job Posting Unavailable' }}
                </h2>

                <p>
                    <strong>Location:</strong>
                    {{ $application->jobPost->location ?? 'N/A' }}
                </p>

                <p>
                    <strong>Employment Type:</strong>
                    {{ $application->jobPost->employment_type ?? 'N/A' }}
                </p>

                <p>
                    <strong>Applied Date:</strong>
                    {{ $application->created_at->format('d/m/Y') }}
                </p>

                <p class="status">
                    <strong>Status:</strong>
                    {{ ucfirst($application->status) }}
                </p>

            </div>

        @endforeach

    @endif

</body>
</html>
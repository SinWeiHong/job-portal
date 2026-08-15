<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Applicants - {{ $jobPost->title }}
    </title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        h1 {
            margin-bottom: 5px;
        }

        .job-info {
            color: #666;
            margin-bottom: 25px;
        }

        .filter-form {
            display: flex;
            gap: 12px;
            align-items: end;
            margin-bottom: 25px;
            padding: 18px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fafafa;
        }

        .filter-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .filter-field label {
            font-weight: bold;
        }

        .filter-field input,
        .filter-field select {
            min-width: 220px;
            padding: 9px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .filter-button,
        .clear-button {
            padding: 9px 14px;
            border: 1px solid #333;
            border-radius: 4px;
            background-color: white;
            color: #111;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .filter-button:hover,
        .clear-button:hover {
            background-color: #f0f0f0;
        }

        .result-summary {
            margin-bottom: 15px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f4f4f4;
        }

        .status {
            font-weight: bold;
        }

        .empty {
            padding: 20px;
            background-color: #f8f8f8;
        }

        @media (max-width: 760px) {
            .filter-form {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-field input,
            .filter-field select {
                width: 100%;
                min-width: 0;
            }
        }
    </style>
</head>

<body>

    <h1>Applicants</h1>

    <div class="job-info">
        <strong>Job Posting:</strong>
        {{ $jobPost->title }}
    </div>

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
                Search Applicant
            </label>

            <input
                type="text"
                id="search"
                name="search"
                value="{{ $search }}"
                placeholder="Name or email"
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
                    $availableStatuses as $status
                )

                    <option
                        value="{{ $status }}"
                        @selected(
                            $selectedStatus
                            === strtolower($status)
                        )
                    >
                        {{ ucfirst($status) }}
                    </option>

                @endforeach

            </select>

        </div>

        <button
            type="submit"
            class="filter-button"
        >
            Filter
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
                class="clear-button"
            >
                Clear
            </a>

        @endif

    </form>

    <div class="result-summary">
        {{ $applications->count() }}
        applicant(s) found.
    </div>

    @if ($applications->isEmpty())

        <div class="empty">

            @if (
                $search !== ''
                || $selectedStatus !== ''
            )

                No applicants match the selected
                search or status filter.

            @else

                No applicants have applied for
                this job posting yet.

            @endif

        </div>

    @else

        <table>

            <thead>
                <tr>
                    <th>Applicant</th>
                    <th>Email</th>
                    <th>Cover Letter</th>
                    <th>Status</th>
                    <th>Applied Date</th>
                </tr>
            </thead>

            <tbody>

                @foreach (
                    $applications as $application
                )

                    <tr>

                        <td>
                            {{
                                $application
                                    ->jobSeeker
                                    ->name
                                ?? 'N/A'
                            }}
                        </td>

                        <td>
                            {{
                                $application
                                    ->jobSeeker
                                    ->email
                                ?? 'N/A'
                            }}
                        </td>

                        <td>
                            {{
                                $application
                                    ->cover_letter
                                ?? 'No cover letter provided.'
                            }}
                        </td>

                        <td>
                            <span class="status">
                                {{
                                    ucfirst(
                                        $application
                                            ->status
                                    )
                                }}
                            </span>
                        </td>

                        <td>
                            {{
                                $application
                                    ->created_at
                                    ->format(
                                        'd/m/Y'
                                    )
                            }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    @endif

</body>
</html>
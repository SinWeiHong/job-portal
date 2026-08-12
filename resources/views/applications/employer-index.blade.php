<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Applicants - {{ $jobPost->title }}</title>

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
            margin-bottom: 30px;
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
    </style>
</head>

<body>

    

    <h1>Applicants</h1>

    <div class="job-info">
        <strong>Job Posting:</strong> {{ $jobPost->title }}
    </div>

    @if ($applications->isEmpty())

        <div class="empty">
            No applicants have applied for this job posting yet.
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
                @foreach ($applications as $application)
                    <tr>
                        <td>
                            {{ $application->jobSeeker->name ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $application->jobSeeker->email ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $application->cover_letter ?? 'No cover letter provided.' }}
                        </td>

                        <td>
                            <span class="status">
                                {{ ucfirst($application->status) }}
                            </span>
                        </td>

                        <td>
                            {{ $application->created_at->format('d/m/Y') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif

</body>
</html>
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
    </style>
</head>

<body>

    <h1>My Applications</h1>

    @if ($applications->isEmpty())

        <div class="empty-message">
            <p>You have not submitted any job applications yet.</p>
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
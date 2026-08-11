<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Applications</title>
</head>

<body>

    <h1>My Applications</h1>

    @if ($applications->isEmpty())
        <p>You have not submitted any job applications yet.</p>
    @else

        @foreach ($applications as $application)

            <div>
                <h2>
                    {{ $application->jobPost->title }}
                </h2>

                <p>
                    Status: {{ ucfirst($application->status) }}
                </p>

                <p>
                    Applied on:
                    {{ $application->created_at->format('d/m/Y') }}
                </p>
            </div>

            <hr>

        @endforeach

    @endif

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy</title>
    @vite("resources/css/app.css")
</head>
<body>
    <main>
        <a href="{{ route("privacy-policy.list") }}">View Revisions</a>
        <h1>Privacy Policy</h1>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            ← Back
        </a><br>
        {!! $policy->content !!}
    </main>
</body>
</html>

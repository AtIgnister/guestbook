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
        <p>This revision of the privacy policy has been manually hidden by an administrator for one of the following reasons:</p>
        <ul>
            <li>Unauthorized or malicious modification.</li>
            <li>Inclusion of sensitive information.</li>
            <li>
                Significant publishing errors, such as missing sections or factual inaccuracies,
                that were identified shortly after publication.
            </li>
        </ul>

        <p>
            If you want to access this revision, please contact an administrator and include a link to this policy
            in your request. We will then provide an unaltered copy of the policy as it existed at the time,
            except where redaction is necessary to protect platform security.
        </p>
        <br>
        <p>
            “Sensitive information” refers specifically to data that could compromise the security of the platform
            (for example, private keys or credentials).
        </p>

        @role("admin")
            <br>
            <h1>Original Policy Content (Admin Only)</h1>
            {!! $privacyPolicy->content !!}
        @endrole
    </main>
</body>
</html>

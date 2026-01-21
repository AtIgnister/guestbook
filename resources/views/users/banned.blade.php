<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your account has been suspended.</title>
    @vite("resources/css/app.css")
</head>
<body>
    <main>
        <h1>You have been banned.</h1>
        <p>Your account has been suspended for breaking our rules of conduct.</p>
        <p>You will no longer be able to create any new guestbooks or edit old ones.</p>
        <p>You can still do the following actions:</p>
        <ul>
            <li>Export your account data</li>
            <li>Edit your account information</li>
            <li>Delete your account</li>
        </ul>
        <p>You can contact me at {{ config('app.contact') }} if you feel you have been unfairly banned, or wish to request any additional information about your ban.</p>
    </main>
</body>
</html>

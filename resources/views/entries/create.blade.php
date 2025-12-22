<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Guestbook</title>
    <link rel="stylesheet" href="{{ asset('app.css') }}">
</head>
<body>
    <h1>Create a Guestbook Entry</h1>

    <!-- Guestbook form -->
    <form action="{{ route('entries.store', ['guestbook_id' => $guestbook->id]) }}" method="POST">
        @csrf
        
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div>
            <label for="comment">Comment</label>
            <textarea id="comment" name="comment" required></textarea>
        </div>

        <div>
            <label for="website">Website</label>
            <input type="url" id="website" name="website" required>
        </div>

        <div>
            <button type="submit">Create Guestbook Entry</button>
        </div>
    </form>

</body>
</html>

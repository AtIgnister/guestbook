<!-- resources/views/guestbooks/create.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Guestbook</title>
    <link rel="stylesheet" href="{{ asset('app.css') }}">
</head>
<body>
    <h1>Create a Guestbook</h1>

    <!-- Guestbook form -->
    <form action="{{ route('guestbooks.store') }}" method="POST">
        @csrf
        
        <div>
            <label for="name">Guestbook Name</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div>
            <label for="style">Styles</label>
            <textarea id="style" name="style"></textarea>
        </div>

        <div>
            <button type="submit">Create Guestbook</button>
        </div>
    </form>

</body>
</html>

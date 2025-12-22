<!-- resources/views/guestbooks/create.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit {{ $guestbook->name }}</title>
    <link rel="stylesheet" href="{{ asset('app.css') }}">
</head>
<body>
    <h1>Edit {{ $guestbook->name }}</h1>

    <!-- Guestbook form -->
    <form action="{{ route('guestbooks.update', $guestbook) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div>
            <label for="name">Guestbook Name</label>
            <input type="text" id="name" name="name" value="{{ $guestbook->name }}" required>
        </div>

        <div>
            <label for="style">Styles</label>
            <textarea id="style" name="style">{{ $guestbook->style }}</textarea>
        </div>

        <div>
            <button type="submit">Save Guestbook</button>
            <a href="{{ route('guestbooks.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

</body>
</html>

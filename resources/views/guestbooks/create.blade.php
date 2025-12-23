<!-- resources/views/guestbooks/create.blade.php -->
@extends('components.layouts.layout')
@section("content")
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
@endsection
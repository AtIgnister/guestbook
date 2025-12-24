@extends('components.layouts.layout')
@section("content")
    <h1>Create a Guestbook Entry</h1>

    <!-- Guestbook form -->
    <form action="{{ route('entries.store', ['guestbook_id' => $guestbook->id]) }}" method="POST">
        @csrf
        
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>
        </div>
        <br>

        <div>
            <label for="comment">Comment</label>
            <textarea id="comment" name="comment" required></textarea>
            <br>
            {{ /* TODO: make this configurable */ "" }}
            <sub>(Limit of 20.000 characters per message, which is roughly twice the length of <a href="https://kami.bearblog.dev/why-comment-sections-suck-rei-want-to-comment-on-your-blog-post/">this blogpost</a>)</sub>
        </div>
        <br>
        <div>
            <label for="website">Website</label>
            <input type="url" id="website" name="website" required>
        </div>
        <br>

        <div>
            <button type="submit">Create Guestbook Entry</button>
        </div>
    </form>
@endsection

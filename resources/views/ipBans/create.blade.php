@extends('components.layouts.layout')

@section("content")
<section class="m-3">
    <h1>Do you really want to ban this user?</h1>

    <!-- Retrieve the associated GuestbookEntry -->
    @php
        // Retrieve the associated GuestbookEntry using the relationship
        $guestbookEntry = $entryIp->guestbookEntry;
    @endphp

    <p>Name: {{ $guestbookEntry->name }}</p>
    <p>Message:</p>
    <textarea>{{ $guestbookEntry->comment }}</textarea>

    <!-- Guestbook form -->
    <form
        action="{{ route('ipBans.store', $guestbookEntry) }}"
        method="POST"
    >
        @csrf
        <button type="submit">Ban User</button>
    </form>
</section>

    <!-- Display errors if any exist -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection

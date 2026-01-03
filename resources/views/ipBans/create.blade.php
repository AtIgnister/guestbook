@extends('components.layouts.layout')

@section("content")
<section class="m-3">
    <h1>Do you really want to ban this user?</h1>

    <!-- Retrieve the associated GuestbookEntry -->
    @php
        // Retrieve the associated GuestbookEntry using the relationship
        $guestbookEntry = $entry_ip->guestbookEntry;
    @endphp

    <p>Name: {{ $guestbookEntry->name }}</p>
    <p>Message:</p>
    <textarea>{{ $guestbookEntry->comment }}</textarea>

    <!-- Guestbook form -->
    <form action="{{ route("ipBans.store") }}" method="POST" class="flex-col md:w-1/2">
        @csrf
        @method("POST")
        <input type="hidden" name="guestbook_entry_ip_id" value="{{ $entry_ip->id }}">
        <input type="hidden" name="ip_hash" value="{{ $entry_ip->ip_hash }}">
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

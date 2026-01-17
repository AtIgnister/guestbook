@extends('components.layouts.layout')
@section("content")
<section class="m-3">
    <h1>Edit User</h1>

    <!-- Guestbook form -->
    <div class="flex-col md:w-3/4 space-y-2">
        @csrf
        
        <div>
            <p>Name: {{ $user->name }}</p>
            <p>Email: {{ $user->email }}</p>
            <p>Created at: {{ $user->created_at }}</p>
            <p>Banned: {{ $user->userBan()->exists() ? "Yes" : "No" }}</p>
        </div>

        <div>
            @php
                $userBan = $user->userBan;
            @endphp
            @if (!$userBan)
                <a class="block" href="{{ route('userBans.create', $user) }}">
                    Ban User
                </a>
            @else
                <a class="block" href="{{ route('userBans.delete', $userBan) }}">
                    Unban User
                </a>
            @endif
            <a class="block" href="{{ route('users.delete', compact('user')) }}">Delete</a>
        </div>
    </div>
</section>
@endsection
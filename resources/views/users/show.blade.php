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
        </div>

        <div>
            <a class="block" href="{{ route('userBans.create', compact('user')) }}">Ban User</a>
            <a class="block" href="{{ route('users.delete', compact('user')) }}">Delete</a>
        </div>
    </div>
</section>
@endsection
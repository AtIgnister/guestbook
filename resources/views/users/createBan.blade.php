<!-- resources/views/guestbooks/create.blade.php -->
@extends('components.layouts.layout')
@section("content")
    <main class="flex flex-col items-center gap-4">
        <h1 class="text-xl font-semibold mt-6">
            Do you really want to ban {{ $user->name }}?
        </h1>

        <p class="text-red-400">
            This action is permanent.
        </p>

        <form action="{{ route('userBans.store', $user) }}" method="POST" class="flex gap-3">
            @csrf
        
            <button type="submit">Ban User</button>
    
            <a
                href="{{ route('users.index') }}"
            >
                Cancel
            </a>
        </form>

        @error('deletion_confirmation')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </main>
@endsection
@extends('components.layouts.layout')
@section("content")
    <main class="flex flex-col items-center gap-4">
        <h1 class="text-xl font-semibold mt-6">
            Do you really want to unban {{ $userBan->user->name }}?
        </h1>

        <form action="{{ route('userBans.destroy', $userBan) }}" method="POST" class="flex gap-3">
            @csrf
            @method("DELETE")
        
            <button type="submit">Unban User</button>
    
            <a
                href="{{ route('users.index') }}"
            >
                Cancel
            </a>
        </form>

        @error('unban_error')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </main>
@endsection
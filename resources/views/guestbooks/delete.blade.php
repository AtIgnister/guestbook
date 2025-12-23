<!-- resources/views/guestbooks/create.blade.php -->
@extends('components.layouts.layout')
@section("content")
    <main class="flex flex-col items-center gap-4">
        <h1 class="text-xl font-semibold mt-6">
            Do you really want to delete {{ $guestbook->name }}?
        </h1>
    
        <p class="text-red-400">
            This action is permanent.
        </p>
    
        <form action="{{ route('guestbooks.destroy', $guestbook) }}" method="POST" class="flex gap-3">
            @csrf
            @method('DELETE')
    
            <button
                type="submit"
            >
                Delete Guestbook
            </button>
    
            <a
                href="{{ route('guestbooks.index') }}"
            >
                Cancel
            </a>
        </form>
    </main>
@endsection
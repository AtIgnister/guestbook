@extends('components.layouts.layout')

@section("content")
<div class="guestbook-entry my-10 border-solid border-2 rounded-xl p-2">
    <p>{{ $entry->name }} wrote...</p>

    @if ($entry->website !== null)
    <sup>Website: <a rel="ugc" target="_blank" href="{{ $entry->website }}">{{ $entry->website }}</a></sup>
    @endif
                        
    <p>{!! nl2br(e($entry->comment)) !!}</p>

    @auth
    @if (auth()->user()->ownsEntry($entry) && !$is_embed)
        <form 
            action="{{ route('entries.destroy', compact('entry')) }}"
            onsubmit="return confirm('Are you sure you want to delete this entry? This cannot be undone.')"
            method="post"
        >
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-500">Delete Entry</button>
        </form>
        @endif
    @endauth
</div>
@endsection
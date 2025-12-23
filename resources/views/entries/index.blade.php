@extends('components.layouts.layout')
@section("content")
    @if ($guestbook->style)
        <style>{!! \App\Helpers\SanitizeCSS::sanitizeCSS($guestbook->style) !!}</style>
    @endif

    @if (Auth::check())
        <a href="/guestbooks">Back to Guestbooks</a>
    @endif

    <div class="max-w-2xl mx-auto">
        @forelse ($entries as $entry)
        <div class="my-10 border-solid border-2 rounded-xl p-2">
                <p>{{ $entry->name }} wrote...</p>
                <sup>Website: <a href="{{ $entry->website }}">{{ $entry->website }}</a></sup>
                <p>{{ $entry->comment }}</p>
        </div>
        @empty
            <p class="text-gray-500">No entries yet.</p>
            <a href="/entries/{{ $guestbook->id }}/create">Be the first to leave a comment!</a>
        @endforelse

        @if ($entries && $entries->count())
            <a href="/entries/{{ $guestbook->id }}/create">Leave a comment!</a>
        @endif
    </div>
@endsection
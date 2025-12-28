@extends('components.layouts.layout')
@section("content")
    @if ($guestbook->style)
        <style>{!! \App\Helpers\SanitizeCSS::sanitizeCSS($guestbook->style) !!}</style>
    @endif

    @if (Auth::check())
        <a href="/guestbooks">Back to Guestbooks</a>
    @endif

    <div class="max-w-2xl mx-auto">
        <sub>Be reasonable, follow the <a href="/blog/tos">guestbook guidelines.</a></sub>
        @if ($entries && $entries->count())
            <div class="my-10 border-solid border-2 rounded-xl p-2">
                <a class="mt-3" href="/entries/{{ $guestbook->id }}/create">Leave a comment!</a>
            </div>
        @endif

        @forelse ($entries as $entry)
        <div class="my-10 border-solid border-2 rounded-xl p-2">
                <p>{{ $entry->name }} wrote...</p>
                @if (filter_var($entry->website, FILTER_VALIDATE_URL))
                    <sup>Website: <a href="{{ $entry->website }}">{{ $entry->website }}</a></sup>
                @endif
                <p>{{ nl2br($entry->comment) }}</p>
        </div>
        @empty
            <p class="text-gray-500">No entries yet.</p>
            <a href="/entries/{{ $guestbook->id }}/create">Be the first to leave a comment!</a>
        @endforelse
    </div>
@endsection
@extends('components.layouts.layout')

@section("hideBackToDashboard")
@endsection

@section("hideAdminBanner")
@endsection

@section("content")
    @if ($guestbook->style)
        <style>{!! \App\Helpers\SanitizeCSS::sanitizeCSS($guestbook->style) !!}</style>
    @endif

    @if (Auth::check())
        <a href="/guestbooks">Back to Guestbooks</a>
    @endif

    <div class="max-w-2xl mx-auto p-4 md:p-0">
        
        @if($guestbook->description)
            <p class="whitespace-pre-line">{{$guestbook->description}}</p>
        @endif

        <sub>Be reasonable, follow the <a href="/blog/tos">guestbook guidelines.</a></sub>

        @if ($entries && $entries->count())
            <div class="my-10 border-solid border-2 rounded-xl p-2">
                @if (!$is_embed)
                    <a class="mt-3" href="{{ route('entries.create', compact('guestbook')) }}">Leave a comment!</a>
                @else
                    <a class="mt-3" href="{{ route('embed.entries.create', compact('guestbook')) }}">Leave a comment!</a>
                @endif
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
            @if (!$is_embed)
                <a class="mt-3" href="{{ route('entries.create', compact('guestbook')) }}">Be the first to leave a comment!</a>
            @else
                <a class="mt-3" href="{{ route('embed.entries.create', compact('guestbook')) }}">Be the first to leave a comment!</a>
            @endif
        @endforelse
    </div>
@endsection
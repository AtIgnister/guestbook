@extends('components.layouts.layout')

@push('head')
<link rel="alternate" type="application/atom+xml" title="Guestbook Feed" href="{{ route("entries.feed", compact("guestbook")) }}">
@endpush

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

    <div class="comment-container max-w-2xl mx-auto p-4 md:p-0">
        
        @if($guestbook->description)
            <x-markdown class="guestbook-description ">
                {{$guestbook->description}}
            </x-markdown>
        @endif

        <sub class="guestbook-info">Be reasonable, follow the <a target="_blank" href="/blog/tos">guestbook guidelines.</a></sub><br>
        <sub class="guestbook-info">Use of this service is subject to our <a target="_blank" href="{{ route('privacy-policy.index') }}">privacy policy.</a></sub>
        <p class="mt-5">
            Want to see guestbook entries in your rss reader?
            Add <a href="{{ route('entries.feed', compact('guestbook')) }}">this url</a> to your readers feeds!
        </p>

        @if ($entries && $entries->count())
            <div class="comment-link-container my-10 border-solid border-2 rounded-xl p-2">
                @include('partials.entries.comment-cta-link', ['text' => 'Leave a comment!'])
            </div>
        @endif

        @forelse ($entries as $entry)
            @include('partials.entries.single_entry', ['entry' => $entry, 'is_embed' => $is_embed, 'is_show' => false])
        @empty
            <p class="comment-link text-gray-500">No entries yet.</p>
            @include('partials.entries.comment-cta-link', ['text' => 'Be the first to leave a comment!'])
        @endforelse
    </div>
@endsection
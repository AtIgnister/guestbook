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

    <div class="comment-container max-w-2xl mx-auto p-4 md:p-0">
        
        @if($guestbook->description)
            <p class="guestbook-description whitespace-pre-line">{{$guestbook->description}}</p>
        @endif

        <sub class="guestbook-info">Be reasonable, follow the <a href="/blog/tos">guestbook guidelines.</a></sub><br>
        <sub class="guestbook-info">Use of this service is subject to our <a href="{{ route('privacy-policy.index') }}">privacy policy.</a></sub>

        @if ($entries && $entries->count())
            <div class="comment-link-container my-10 border-solid border-2 rounded-xl p-2">
                @include('partials.entries.comment-cta-link', ['text' => 'Leave a comment!'])
            </div>
        @endif

        @forelse ($entries as $entry)
            <div class="guestbook-entry my-10 border-solid border-2 rounded-xl p-2">
                <p>{{ $entry->name }} wrote...</p>

                @if ($entry->website !== null)
                    <sup>Website: <a rel="ugc" href="{{ $entry->website }}">{{ $entry->website }}</a></sup>
                @endif
                    
                <p>{{ nl2br($entry->comment) }}</p>

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
        @empty
            <p class="comment-link text-gray-500">No entries yet.</p>
            @include('partials.entries.comment-cta-link', ['text' => 'Be the first to leave a comment!'])
        @endforelse
    </div>
@endsection
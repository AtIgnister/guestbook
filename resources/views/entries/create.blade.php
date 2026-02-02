@extends('components.layouts.layout')
@section("content")
<section class="entry-container m-3">
    @if ($guestbook->style)
        <style>{!! \App\Helpers\SanitizeCSS::sanitizeCSS($guestbook->style) !!}</style>
    @endif

    <h1>Create a Guestbook Entry</h1>

    <!-- Guestbook form -->
    <form action="{{ route('entries.store', ['guestbook' => $guestbook]) }}" method="POST" class="entry-form flex-col md:w-1/2">
        @csrf
        
        <div class="name-field">
            <label for="name">Name</label>
            <input class="md:w-1/2 w-full" value="{{ old('name') }}" type="text" id="name" name="name" required>
        </div>
        <br>
        <div class="website-field">
            <label for="website">Website</label>
            <input class="md:w-1/2 w-full" value="{{ old('website') }}" type="url" id="website" name="website">
        </div>
        <br>
        @auth
            @if (auth()->user()->ownsGuestbook($guestbook))
                <label for="posted_at">Entry Date & Time</label>
                <input
                    type="datetime-local"
                    id="posted_at"
                    name="posted_at"
                    class="form-control"
                    value="{{ old('posted_at', optional($entry->posted_at ?? now())->format('Y-m-d\TH:i')) }}"
                    required
                >
            @endif
        @endauth
        <br>
        <div class="comment-field">
            <label class="align-top" for="comment">Comment</label>
            <textarea class="md:w-3/4 w-full" id="comment" name="comment" required>{{ old('comment') }}</textarea>
            <br>
            {{ /* TODO: make this configurable */ "" }}
            <sub class="character-limit-notice w-full">(Limit of 20.000 characters per message, which is roughly twice the length of <a href="https://kami.bearblog.dev/why-comment-sections-suck-rei-want-to-comment-on-your-blog-post/">this blogpost</a>)</sub>
        </div>
       <br>

        <div class="captcha-field mb-2">
            <label for="captcha">Captcha</label>
            <div class="flex items-center gap-2">
                <span class="captcha-img">{!! captcha_img() !!}</span>
                <button type="button" onclick="refreshCaptcha()">↻</button>
            </div>
        
            <input type="hidden" name="captcha_type" id="captcha_type" value="image">
            <input
                type="text"
                id="captcha"
                name="captcha"
                class="md:w-1/2 w-full"
                placeholder="Enter the text above"
                required
            >
        
            @error('captcha')
                <div class="captcha-error text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit">Create Guestbook Entry</button>
        </div>
    </form>

    <script>
        function refreshCaptcha() {
            fetch('{{ route("captcha.refresh") }}')
                .then(response => response.json())
                .then(data => {
                    document.querySelector('span img').src = data.captcha;
                });
        }
        </script>
</section>
@endsection

@extends('components.layouts.layout')
@section("content")
<section class="entry-container m-3">
    @if ($guestbook->style)
        <style>{!! \App\Helpers\SanitizeCSS::sanitizeCSS($guestbook->style) !!}</style>
    @endif

    <h1>Create a Guestbook Entry</h1>
    <button id="captcha-switch" onclick="captchaSwitch()">Switch to Audio Captcha</button>

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
                <div id="captcha_container">
                </div>
                <button type="button" onclick="loadCaptcha()">↻</button>
            </div>
        
            <input type="hidden" name="captcha_key" id="captcha_key">
            <input type="hidden" name="captcha_type" id="captcha_type" value="{{ old('captcha_type', 'image') }}">
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
        document.addEventListener('DOMContentLoaded', () => {
            loadCaptcha()
        });

        function captchaSwitch() {
            const captchaType = document.querySelector('#captcha_type');
            const button = document.querySelector('#captcha-switch')

            if (captchaType.value === 'image') {
                button.textContent = 'Switch to Audio Captcha';
            } else {
                button.textContent = 'Switch to Image Captcha';
            }

            captchaType.value = captchaType.value === 'image' ? 'audio' : 'image';
            loadCaptcha();
        }

        function loadCaptcha() {
            const captchaType = document.querySelector('#captcha_type');
            if(captchaType.value == 'image') {
                loadCaptcha_image()
            }

            if(captchaType.value == 'audio') {
                loadCaptcha_audio()
            }
        }

        async function loadCaptcha_audio() {
            const res = await fetch('/api/audio-captcha/generate');
            const data = await res.json();
            document.querySelector('#captcha_key').value = data.token
            const captcha = `
            <audio controls>
                <source src="${data.mp3Link}" type="audio/mp3">
                Your browser does not support the audio element.
            </audio>
            `
            const captchaContent = document.querySelector('#captcha_container')
            captchaContent.innerHTML = captcha
            console.log(data)
        }

        function loadCaptcha_image() {
            fetch('{{ route("captcha.refresh") }}')
                .then(response => response.json())
                .then(data => {
                    document.querySelector('#captcha_container').innerHTML =
                        `<span class="captcha-img"><img src=${data.captcha}></img></span>`;
                    document.querySelector('#captcha_key').value = '';
                });
        }
        </script>
</section>
@endsection

@extends('components.layouts.layout')
@section("content")
<section class="m-3">
    <h1>Create a Guestbook Entry</h1>

    <!-- Guestbook form -->
    <form action="{{ route('entries.store', ['guestbook' => $guestbook]) }}" method="POST" class="flex-col md:w-1/2">
        @csrf
        
        <div>
            <label for="name">Name</label>
            <input class="md:w-1/2 w-full" value="{{ old('name') }}" type="text" id="name" name="name" required>
        </div>
        <br>
        <div>
            <label for="website">Website</label>
            <input class="md:w-1/2 w-full" value="{{ old('website') }}" type="url" id="website" name="website">
        </div>
        <br>
        <div>
            <label class="align-top" for="comment">Comment</label>
            <textarea class="md:w-3/4 w-full" id="comment" name="comment" required>{{ old('comment') }}</textarea>
            <br>
            {{ /* TODO: make this configurable */ "" }}
            <sub class="w-full">(Limit of 20.000 characters per message, which is roughly twice the length of <a href="https://kami.bearblog.dev/why-comment-sections-suck-rei-want-to-comment-on-your-blog-post/">this blogpost</a>)</sub>
        </div>
       <br>

        <div class="mb-2">
            <label for="captcha">Captcha</label>
            <div class="flex items-center gap-2">
                <span>{!! captcha_img() !!}</span>
                <button type="button" onclick="refreshCaptcha()">↻</button>
            </div>
        
            <input
                type="text"
                id="captcha"
                name="captcha"
                class="md:w-1/2 w-full"
                placeholder="Enter the text above"
                required
            >
        
            @error('captcha')
                <div class="text-red-600 text-sm">{{ $message }}</div>
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

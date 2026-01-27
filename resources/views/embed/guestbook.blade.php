@extends('components.layouts.layout')
@section("content")
<section class="m-3">
    <h1>Create a Guestbook Entry</h1>

    <form id="embedForm" class="flex-col md:w-1/2" action="{{ route('embed.entries.store', $guestbook) }}" method="POST">
        <div>
            <label for="name">Name</label>
            <input class="md:w-1/2 w-full" type="text" name="name" placeholder="Name" required>
        </div>
        <div>
            <label for="website">Website</label>
            <input class="md:w-1/2 w-full" type="url" name="website" placeholder="Website">
        </div>
        <div>
            <label class="align-top" for="comment">Comment</label>
            <textarea class="md:w-3/4 w-full" name="comment" placeholder="Comment" required></textarea>
            <br>
            {{ /* TODO: make this configurable */ "" }}
            <sub class="w-full">(Limit of 20.000 characters per message, which is roughly twice the length of <a href="https://kami.bearblog.dev/why-comment-sections-suck-rei-want-to-comment-on-your-blog-post/">this blogpost</a>)</sub>
        </div>

        <div class="mb-2">
            <img id="captchaImage" alt="captcha" style="width: 200px; height: 80px; object-fit: contain; display: block; margin-bottom: 0.5rem;">
            <label for="captcha">Captcha</label>
            <input type="text" name="captcha" placeholder="Enter captcha" required>

            <div class="flex items-center gap-2">
                <button type="button" onclick="loadCaptcha()">↻</button>
                <input type="hidden" name="key" id="captchaKey">
            </div>
        </div>

        <button type="submit">Submit</button>
    </form>

    <script>
        let captchaKey = '';

        async function loadCaptcha() {
            const res = await fetch('{{ url("/captcha/api/default") }}');
            const data = await res.json();
            captchaKey = data.key;
            document.getElementById('captchaImage').src = data.img;
            document.getElementById('captchaKey').value = captchaKey;
        }

        async function loadEntries() {
            const res = await fetch('{{ route("entries.index", $guestbook) }}', {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            const container = document.getElementById('entries');
            container.innerHTML = '';
            data.entries.forEach(entry => {
                container.innerHTML += `
                    <div class="k-comment">
                        <p class="k-name">${entry.name}</p>
                        <p class="c-comment">${entry.comment}</p>
                    </div>
                `;
            });
        }

        document.getElementById('embedForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const data = new FormData(form);

            const res = await fetch(form.action, {
                method: 'POST',
                body: data,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                redirect: 'follow'
            });

            // ✅ Captcha success → Laravel redirect
            if (res.redirected) {
                window.location.href = res.url;
                return;
            }

            // ❌ Captcha failed → JSON response
            const json = await res.json();
            alert(json.message);

            loadCaptcha(); // refresh captcha only on failure
        });

        loadCaptcha();
        loadEntries();
    </script>
</section>
@endsection
@extends('components.layouts.layout')
@section("content")
<section class="m-3">
    @if ($guestbook->style)
        <style>{!! \App\Helpers\SanitizeCSS::sanitizeCSS($guestbook->style) !!}</style>
    @endif

    <h1>Create a Guestbook Entry</h1>
    <button id="captcha-switch" onclick="captchaSwitch()">Switch to Audio Captcha</button>
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

        <div class="mb-2 captcha-container">
            
            <label for="captcha">Captcha</label>
            <div id="captcha_content"></div>
            <input type="text" name="captcha" placeholder="Enter captcha" required>
            <input type="hidden" name="captcha_type" id="captcha_type" value="image">

            <div class="flex items-center gap-2">
                <button type="button" onclick="loadCaptcha()">↻</button>
                <input type="hidden" name="key" id="captchaKey">
            </div>
        </div>

        <button type="submit">Submit</button>
    </form>

    <script>
        let captchaKey = '';

        function captchaSwitch() {
            const captchaType = document.querySelector('#captcha_type')
            const captchaSwitch = document.querySelector('#captcha-switch')
            if(captchaType.value == 'image') {
                captchaType.value = 'audio'
                captchaSwitch.innerText = 'Switch to Image Captcha'
            } else if(captchaType.value == 'audio') {
                captchaType.value = 'image'
                captchaSwitch.innerText = 'Switch to Audio Captcha'
            }

            loadCaptcha()
        }

        async function loadCaptcha() {
            const type = document.querySelector('#captcha_type').value
            if(type == 'image') {
                return loadCaptcha_image(type)
            }else if(type == 'audio') {
                return loadcaptcha_audio(type)
            }
        }

        async function loadCaptcha_image() {
            const res = await fetch('{{ url("/captcha/api/default") }}');
            const data = await res.json();
            captchaKey = data.key;

            const captchaImg = document.createElement('img')
            captchaImg.style = 'width: 200px; height: 80px; object-fit: contain; display: block; margin-bottom: 0.5rem;'
            captchaImg.id = 'captchaImage'
            captchaImg.alt = 'captcha'
            captchaImg.src = data.img

            const captchaContent = document.querySelector('#captcha_content')
            captchaContent.innerHTML = ''
            captchaContent.append(captchaImg)

            document.getElementById('captchaImage').src = data.img;
            document.getElementById('captchaKey').value = captchaKey;
        }

        async function loadcaptcha_audio() {
            const res = await fetch('/api/audio-captcha/generate');
            const data = await res.json();
            document.getElementById('captchaKey').value = data.token
            const captcha = `
            <audio controls>
                <source src="${data.mp3Link}" type="audio/mp3">
                Your browser does not support the audio element.
            </audio>
            `
            const captchaContent = document.querySelector('#captcha_content')
            captchaContent.innerHTML = captcha
            console.log(data)
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

            if (res.redirected) {
                window.location.href = res.url;
                return;
            }

            const json = await res.json();
            alert(json.message);

            loadCaptcha(); // refresh captcha only on failure
        });

        loadCaptcha();
    </script>
</section>
@endsection
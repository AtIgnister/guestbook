const script = document.currentScript;
const guestbookId = "{{ $guestbook }}";
const host = "{{ $url }}"
const submitRoute = "{{ route('embed.entries.store', $guestbook) }}"

async function getGuestbookData(guestbookId) {
    // fetch the API
    const response = await fetch(`${host}/api/${guestbookId}/json`);

    // check for HTTP errors
    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

    // parse JSON
    const data = await response.json();
    return data;
}

function loadEntries(entries) {
    const guestbookResponses = document.querySelector('#guestbooks___guestbook-messages-container')
    guestbookResponses.innerHTML = ''
    entries.forEach(entry => {
        guestbookResponses.innerHTML += `
            <p>${entry.name} wrote...</p>
            <p>${entry.comment}</p>
        `
    })
}

function renderGuestbook(data) {
    const guestbookForm = document.querySelector('#guestbooks___guestbook-form')
    guestbookForm.action = submitRoute
    loadEntries(data.entries)

    guestbookForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = e.target;
        const data = new FormData(form);
        data.append('key', getCaptchaKey())
        data.append('captcha_type', getCaptchaType())
        data.append('no_redirect', true)

        const res = await fetch(form.action, {
            method: 'POST',
            body: data,
        });

            const json = await res.json();
            alert(json.message);

            if (res.ok) {
                form.reset();
                getGuestbookData(guestbookId).then(data => {
                    const guestbookData = data.guestbooks[guestbookId]
                    renderGuestbook(guestbookData)
                })
                loadCaptcha();
                
            }
        });

        loadCaptcha()
    }

function setCaptchaType(type) {
    localStorage.setItem('k_guestbooks_captcha_type', type)
}

function getCaptchaType() {
    const type = localStorage.getItem('k_guestbooks_captcha_type')
    if(!type) {
        setCaptchaType('image')
        return 'image'
    }

    return type
}

function setCaptchaKey(key) {
    localStorage.setItem('k_guestbooks_captcha_key', key)
}

function getCaptchaKey() {
    return localStorage.getItem('k_guestbooks_captcha_key')
}

async function loadCaptcha() {
    const type = getCaptchaType()
    if(type == 'image') {
        return loadCaptcha_image(type)
    } else if(type == 'audio') {
        return loadcaptcha_audio(type)
    }
}

async function loadCaptcha_image() {
    const res = await fetch('{{ url("/captcha/api/default") }}');
    const data = await res.json();
    const captchaContainer = document.querySelector('#guestbooks___challenge-answer-container')
    captchaContainer.innerHTML = ''
    setCaptchaKey(data.key);

    const captchaImg = document.createElement('img')
    const captchaRefresh = document.createElement('button')
    const captchaField = document.createElement('input')
    captchaRefresh.innerText = '↻'

    captchaField.type = 'text'
    captchaField.name = 'captcha'
    captchaField.placeholder = 'Enter Captcha Text'

    captchaRefresh.onclick = loadCaptcha
    captchaImg.style = 'width: 200px; height: 80px; object-fit: contain; display: block; margin-bottom: 0.5rem;'
    captchaImg.id = 'captchaImage'
    captchaImg.alt = 'Captcha image containing distorted characters'
    captchaImg.src = data.img

    captchaContainer.innerHTML = '<p id="captcha-instructions">Type the characters shown in the image.</p>'
    captchaContainer.append(captchaImg)
    captchaContainer.append(captchaField)
    captchaContainer.append(captchaRefresh)
}

async function loadcaptcha_audio() {
    const res = await fetch(`${host}/api/audio-captcha/generate`);
    const data = await res.json();
    const captchaContainer = document.querySelector('#guestbooks___challenge-answer-container')
    setCaptchaKey(data.token)
    const captcha = `
        <p id="captcha-instructions">Type the characters spoken in the audio.</p>
        <audio controls aria-label="Audio captcha challenge">
        <source src="${data.mp3Link}" type="audio/mp3">
            Your browser does not support the audio element.
        </audio>
    `
    captchaContainer.innerHTML = captcha
}

getGuestbookData(guestbookId).then(data => {
    const guestbookData = data.guestbooks[guestbookId]
    
    whenReady((event) => {
        renderGuestbook(guestbookData)
    });
})

function whenReady(fn) {
    if (document.readyState !== "loading") {
        fn();
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

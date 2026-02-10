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

function renderGuestbook(data) {
    const guestbookResponses = document.querySelector('#guestbooks___guestbook-messages-container')
    const guestbookForm = document.querySelector('#guestbooks___guestbook-form')
    guestbookForm.action = submitRoute
    data.entries.forEach(entry => {
        guestbookResponses.innerHTML += `
            <p>${entry.name} wrote...</p>
            <p>${entry.comment}</p>
        `
    })
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

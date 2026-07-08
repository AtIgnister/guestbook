<script src="{{ route("api.guestbook.embedjs", $guestbook) }}"></script>
<style>
/* fake heading styles for guestbook entries*/
.h {
    font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
    line-height: 1.2;

    margin-top: 0.7em;
    margin-bottom: 0.5em;

    scroll-margin-top: 80px; /* nice for anchor links */
}

.h1 {
    font-size: 2.25rem; /* 36px */
    font-weight: 700;
    letter-spacing: -0.02em;
}

.h2 {
    font-size: 1.875rem; /* 30px */
    font-weight: 700;
    letter-spacing: -0.01em;
}

.h3 {
    font-size: 1.5rem; /* 24px */
    font-weight: 700;
}

.h4 {
    font-size: 1.25rem; /* 20px */
    font-weight: 600;
}

.h5 {
    font-size: 1.125rem; /* 18px */
    font-weight: 600;
}

.h6 {
    font-size: 1rem; /* 16px */
    font-weight: 600;
}
</style>
<!-- Guestbook Form -->
<div id="guestbooks___guestbook-form-container">
    <button class="guestbooks__captcha-switch">Switch Captcha Type</button>
    <form id="guestbooks___guestbook-form" 
        action="" 
        method="post">
        <div class="guestbooks___input-container">
            <input type="text" 
                    id="name" 
                    name="name" 
                    placeholder="name" 
                    required>
            </div>
            <input type="url" 
                id="website" 
                name="website" 
                placeholder="website (optional)">
            </div>
        </div>
        <div id="guestbooks___challenge-answer-container"></div>
        <div class="guestbooks___input-container">
            <textarea id="text" 
                name="comment" 
                placeholder="leave your message here..." 
                rows="4"
                style="width: 100%; box-sizing: border-box; resize: vertical;"
                required
            ></textarea>
            <p>Be reasonable, follow the <a target="_blank" href="{{ config('app.url') }}/blog/tos">guestbook guidelines.</a></p>
            <p>Use of this service is subject to our <a target="_blank" href="{{ config("app.url") }}/privacy-policy">privacy policy.</a></p>
        </div>
        <button type="submit">submit</button>
        <div id="guestbooks___error-message"></div>
    </form>
</div>
<!-- Attribution (optional but appreciated!) -->
<div id="guestbooks___guestbook-made-with" style="text-align: right; margin-top: 10px;">
<small>powered by <a href="{{ config("app.url") }}" target="_blank">guestbooks</a></small>
</div>
<!-- Messages Section -->
<hr>
<h3 id="guestbooks___guestbook-messages-header">messages</h3>
<div id="guestbooks___guestbook-messages-container"></div>
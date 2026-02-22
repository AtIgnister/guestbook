@if (config("app.enable_donations"))
    <div class="mt-4">
        <p>Want to help support this website? Buy me a coffee <a href="{{ config('app.donate_link') }}">here!</a></p>
    </div>
@endif

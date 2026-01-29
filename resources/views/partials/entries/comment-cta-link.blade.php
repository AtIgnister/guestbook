@if (!$is_embed)
    <a class="comment-link mt-3"
        href="{{ route('entries.create', compact('guestbook')) }}">
        {{ $text }}
    </a>
@else
    <a class="comment-link mt-3"
        href="{{ route('embed.entries.create', compact('guestbook')) }}">
            {{ $text }}
    </a>
@endif
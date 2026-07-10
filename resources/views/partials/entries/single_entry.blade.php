<div class="guestbook-entry my-10 border-solid border-2 rounded-xl p-2">
    @if ($is_show && $entry->is_reply)
        <p>This is a reply. You can view the top-level entry <a href="{{ route('entries.show', ['entry' => $entry->parent]) }}">here.</a></p>
        <br>
    @endif
    <p>{{ $entry->name }} wrote...</p>

    @if ($entry->website !== null)
        <sup>Website: <a rel="ugc" target="_blank" href="{{ $entry->website }}">{{ $entry->website }}</a></sup>
    @endif

    @php
        $options = config('markdown.commonmark_options');
        $renderer = new \App\Renderers\MDSandboxRenderer($options);
    @endphp

    {!! nl2br($entry->rendered_comment) !!}

    @auth
        @if (auth()->user()->ownsEntry($entry) && !$is_embed && !$entry->is_reply)
            <details>
                <summary class="mb-3">Reply to guestbook entry</summary>
                <form action="{{ route('reply.create', ['entry' => $entry]) }}" method="POST">
                    @csrf

                    <label class="align-top" for="comment-{{ $entry->id }}">Comment</label>

                    <textarea class="md:w-3/4 w-full" id="comment-{{ $entry->id }}" name="comment" required>{{ old('comment') }}</textarea>

                    @error('comment')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror

                    <button type="submit">Post Reply</button>
                </form>
            </details>
        @endif
    @endauth

    @auth
        @if (auth()->user()->ownsEntry($entry) && !$is_embed)
            <form action="{{ route('entries.destroy', compact('entry')) }}"
                onsubmit="return confirm('Are you sure you want to delete this entry? This cannot be undone.')"
                method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500">Delete Entry</button>
            </form>
        @endif
    @endauth

    @include('partials.entries.reply', ['entry' => $entry, 'is_embed' => $is_embed])
</div>

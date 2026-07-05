@if ($entry->replies->isNotEmpty())
    <div class="ml-8 mt-6 space-y-4 border-l-2 pl-4">
        @foreach ($entry->replies as $reply)
            <div class="guestbook-reply">
                <p><strong>{{ $reply->name }}</strong> replied...</p>

                @if ($reply->website)
                    <sup>
                        Website:
                        <a rel="ugc" target="_blank" href="{{ $reply->website }}">
                            {{ $reply->website }}
                        </a>
                    </sup>
                @endif

                @php
                    $options = config('markdown.commonmark_options');
                    $renderer = new \App\Renderers\MDSandboxRenderer($options);
                @endphp

                {!! nl2br($renderer->convertToHtml($reply->comment)) !!}

                <form 
                    action="{{ route('entries.destroy', ["entry" => $reply]) }}"
                    onsubmit="return confirm('Are you sure you want to delete this entry? This cannot be undone.')"
                    method="post"
                >
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500">Delete Entry</button>
                </form>
            </div>
        @endforeach
    </div>
@endif

@foreach ($guestbooks as $guestbook)
<div class="guestbook-data">
    <p class="guestbook-id">{{ $guestbook->id }}</p>
    <h1 class="guestbook-title">{{ $guestbook->name }}</h1>
    @if(!empty($guestbook->style))
    <style>{!! $guestbook->style !!}</style>
    @endif

    @foreach ($guestbook->entries as $entry)
    <div class="entry-data">
        <p class="entry-author-name">{{ $entry->name }}</p>
        <p class="entry-guestbook-id">{{ $entry->guestbook_id }}</p>
        <time class="entry-creation-date">{{ $entry->created_at }}</time>
        <time class="entry-update-date">{{ $entry->updated_at }}</time>
        <a class="entry-author-website" href="{{ $entry->website }}">{{ $entry->website }}</a>
        <div class="entry-comment">{!! $entry->comment !!}</div>
    </div>
    @endforeach
</div>
@endforeach

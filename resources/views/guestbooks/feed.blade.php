<?=
    /* Using an echo tag here so the `<? ... ?>` won't get parsed as short tags */
    '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<feed xmlns="http://www.w3.org/2005/Atom">
<title>{{ $guestbook->name }} Entries</title>
<link rel="self" href="{{ route('entries.feed', compact('guestbook')) }}"/>
<link href="{{ route('entries.index', compact('guestbook')) }}"/>
<updated>{{ $updated }}</updated>
<author>
<name>{{ $guestbook->user->name }}</name>
</author>
<id>{{ route('entries.index', compact('guestbook')) }}</id>
@foreach ($guestbook->entries as $entry)
<entry>
    <title>{{ $entry->name }} says...</title>
    <link href="{{ route('entries.show', compact('entry')) }}"/>
    <id>{{ route('entries.show', compact('entry')) }}</id>
    <updated>{{ $entry->updated_at->toAtomString() }}</updated>
    <summary>{{ $entry->comment }}</summary>
</entry>
@endforeach
</feed>
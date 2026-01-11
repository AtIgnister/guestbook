@extends('components.layouts.layout')
@section("content")
    <div class="ml-5">
        <h1>Revisions</h1>
        <ol reversed>
        @foreach ($policies as $privacyPolicy)
            <li><a href="{{ route("privacy-policy.show", compact('privacyPolicy')) }}">{{ $privacyPolicy->published_at }}</a></li>
        @endforeach
        </ol>
    </div>

@endsection
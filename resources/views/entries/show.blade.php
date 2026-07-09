@extends('components.layouts.layout')

@section("content")
@include('partials.entries.single_entry', ['entry' => $entry, 'is_embed' => $is_embed, 'is_show' => true])
@endsection
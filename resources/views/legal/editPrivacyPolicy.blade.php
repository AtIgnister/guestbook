<!-- resources/views/guestbooks/create.blade.php -->
@extends('components.layouts.layout')
@section("content")
<section class="m-3">
    <h1>Edit Policy Draft</h1>

    <!-- Guestbook form -->
    <form action="{{ route('privacy-policy.update', $privacyPolicy) }}" method="POST" class="flex-col md:w-3/4 space-y-2">
        @csrf
        @method("PUT")
        <div class="md:flex flex-wrap">
            <label class="w-1/4 max-w-40" for="description">Policy Content</label>
            <textarea class="md:flex-1 w-full h-90" type="text" id="content" name="content">{{ old('content', $privacyPolicy->content) }}</textarea>
        </div>

        <div class="md:flex flex-wrap">
            <label class="w-1/4 max-w-40" for="style">Change Summary</label>
            <textarea class="md:flex-1 w-full h-50" id="change_summary" name="change_summary">{{ old('change_summary', $privacyPolicy->change_summary) }}</textarea>
        </div>

        <div>
            <button type="submit">Save</button>
        </div>
    </form>
</section>
@endsection
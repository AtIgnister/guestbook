<!-- resources/views/guestbooks/create.blade.php -->
@extends('components.layouts.layout')
@section("content")
<section class="m-3">
    <h1>Create a Policy Draft</h1>

    <!-- Guestbook form -->
    <form action="{{ route('privacy-policy.store') }}" method="POST" class="flex-col md:w-3/4 space-y-2">
        @csrf
        <div class="md:flex flex-wrap">
            <label class="w-1/4 max-w-40" for="description">Policy Content</label>
            <textarea class="md:flex-1 w-full h-90" type="text" id="content" name="content">{{ old("content") }}</textarea>
        </div>

        <div class="md:flex flex-wrap">
            <label class="w-1/4 max-w-40" for="style">Change Summary</label>
            <textarea class="md:flex-1 w-full h-50" id="change_summary" name="change_summary">{{ old("change_summary") }}</textarea>
        </div>

        <div class="md:flex items-center gap-2">
            <input
                type="checkbox"
                id="requires_approval"
                name="requires_approval"
                value="1"
            >
            <label for="requires_approval">
                Publish draft right after creation
            </label>
        </div>

        <div>
            <button type="submit">Create Policy Draft</button>
        </div>
    </form>
</section>
@endsection
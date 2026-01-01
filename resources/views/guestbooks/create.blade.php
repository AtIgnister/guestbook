<!-- resources/views/guestbooks/create.blade.php -->
@extends('components.layouts.layout')
@section("content")
<section class="m-3">
    <h1>Create a Guestbook</h1>

    <!-- Guestbook form -->
    <form action="{{ route('guestbooks.store') }}" method="POST" class="flex-col md:w-3/4 space-y-2">
        @csrf
        
        <div class="md:flex flex-wrap">
            <label class="w-1/4 max-w-40" for="name">Guestbook Name</label>
            <input class="md:flex-1 w-full md:max-w-1/3" value="{{ old("name") }}" type="text" id="name" name="name" required>
        </div>

        <div class="md:flex flex-wrap">
            <label class="w-1/4 max-w-40" for="description">Guestbook Description</label>
            <textarea class="md:flex-1 w-full h-25" type="text" id="description" name="description">{{ old("description") }}</textarea>
        </div>

        <div class="md:flex flex-wrap">
            <label class="w-1/4 max-w-40" for="style">Styles</label>
            <textarea class="md:flex-1 w-full h-50" id="style" name="style">{{ old("style") }}</textarea>
        </div>

        <div class="md:flex items-center gap-2">
            <input
                type="checkbox"
                id="requires_approval"
                name="requires_approval"
                value="1"
                {{ old('requires_approval', $guestbook->requires_approval ?? false) ? 'checked' : '' }}
            >
            <label for="requires_approval">
                Require manual approval for new entries
            </label>
        </div>

        <div>
            <button type="submit">Create Guestbook</button>
        </div>
    </form>
</section>
@endsection
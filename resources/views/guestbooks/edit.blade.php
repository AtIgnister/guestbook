@extends('components.layouts.layout')
@section("content")
    <main class="flex flex-col items-center gap-4">
        <h1>Edit {{ $guestbook->name }}</h1>

        <!-- Guestbook form -->
        <form action="{{ route('guestbooks.update', $guestbook) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-2">
                <label for="name">Guestbook Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $guestbook->name) }}" required>
            </div>

            <div class="mb-2">
                <label for="description">Guestbook Description</label>
                <textarea  type="text" id="description" name="description">{{ old('description', $guestbook->description) }}</textarea>
            </div>
    
            <div class="mb-2">
                <label for="style">Styles</label>
                <textarea id="style" name="style">{{ old('style', $guestbook->style) }}</textarea>
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
                <button type="submit">Save Guestbook</button>
                <a href="{{ route('guestbooks.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </main>
@endsection
@extends('components.layouts.layout')
@section("content")
    <main class="md:flex flex-col items-center gap-4 p-4 md:p-0" >
        <h1>Edit {{ $guestbook->name }}</h1>

        <!-- Guestbook form -->
        <form action="{{ route('guestbooks.update', $guestbook) }}" method="POST" class="flex-col space-y-4 md:w-130">
            @csrf
            @method('PUT')
            
            <div class="flex flex-wrap space-x-4 space-y-2 md:space-y-0">
                <label for="name" class="w-full md:w-fit">Guestbook Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $guestbook->name) }}" class="flex-1" required>
            </div>

            <div class="flex flex-wrap space-y-2">
                <label for="description" class="w-full">Guestbook Description</label>
                <textarea  type="text" id="description" name="description" class="flex-1 h-15">{{ old('description', $guestbook->description) }}</textarea>
            </div>
    
            <div class="flex flex-wrap 2">
                <label for="style" class="w-full">Styles</label>
                <textarea id="style" name="style" class="flex-1 h-60 block">{{ old('style', $guestbook->style) }}</textarea>
            </div>

            <p class="text-sm">
                Please don't use CSS to hide the links to the privacy policy or commenting guidelines.
            </p>

            <div class="md:flex items-center gap-2">

                <label for="requires_approval">Require manual approval for new entries</label>
                <input
                    type="checkbox"
                    id="requires_approval"
                    name="requires_approval"
                    value="1"
                    {{ old('requires_approval', $guestbook->requires_approval ?? false) ? 'checked' : '' }}
                >
            </div>

            <div class="flex flex-wrap space-y-2">
                <label for="embed-code" class="w-full">
                    embed-code
                </label>
                <input type="text" class="flex-1 h-15" readonly name="embed-code" 
                    value="{{ '<iframe src="' . config('app.url') . '/embed/guestbook/' . $guestbook->id . '" width="100%" height="500px" frameborder="0"></iframe>' }}">
            </div>
    
            <div class="flex space-x-4 justify-between md:justify-start">
                <button type="submit">Save Guestbook</button>
                <a href="{{ route('guestbooks.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </main>
@endsection
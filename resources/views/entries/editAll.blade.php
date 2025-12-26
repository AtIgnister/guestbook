@extends('components.layouts.layout')
@section("content")
    <a href="{{ route("dashboard") }}">Back to Dashboard</a>
    @if(session('success'))
        <div class="max-w-2xl mx-auto mt-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <main class="max-w-2xl mx-auto p-4">
        <!-- Header -->
        <h1 class="text-3xl md:text-4xl font-bold text-center my-6">
            View Entries
        </h1>

        <!-- Table -->
        <div class="">
            <table class="border shadow-sm rounded-lg">
                <thead>
                    <tr>
                    <th class="px-4 py-2 text-left">Guestbook</th>
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-left">Website</th>
                        <th class="px-4 py-2 text-left">Comment</th>
                        <th class="px-4 py-2 text-left">Date</th>
                        <th class="px-4 py-2 text-left">Delete</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($entries as $entry)
                    <tr>
                        <td class="px-4 py-2">
                            <a href="{{ route('guestbooks.edit', $entry->guestbook->id) }}">
                                {{ $entry->guestbook->name }}
                            </a>
                        </td>
                        <td class="px-4 py-2">{{ $entry->name }}</td>
                        @if ($entry->website)
                            <td><a href="{{ $entry->website }}">{{ $entry->website }}</a></td>
                        @else
                            <td>-</td>
                        @endif
                        <td class="px-4 py-2">
                            <div class="max-h-50 overflow-y-scroll">
                                {{ $entry->comment }}
                            </div>
                        </td>
                        <td><time>{{ $entry->created_at }}</time></td>
                        <td class="pl-4">
                            <form method="POST" action="{{ route('entries.destroy', $entry) }}">
                                @csrf
                                @method('DELETE')
                            
                                <button type="submit" class="text-red-600 hover:underline">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500">No entries yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
@endsection
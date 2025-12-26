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
        <div class="overflow-x-auto">
            <table class="min-w-full border  shadow-sm rounded-lg">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-left">Comment</th>
                        <th class="px-4 py-2 text-left">Date</th>
                        <th class="px-4 py-2 text-left">Delete</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($entries as $entry)
                        <tr>
                            <td class="px-4 py-2">{{ $entry->name }}</td>
                            <td class="px-4 py-2">{{ $entry->coment }}</td>
                            <td><time>{{ $entry->created_at }}</time></td>
                            <td><a>Delete</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                No entries yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Add New Button -->
        @if ($guestbooks && $guestbooks->count())
            <div class="flex justify-end mt-4">
                <a href="/guestbooks/create" class="px-4 py-2">
                    Add new!
                </a>
            </div>
        @endif
    </main>
@endsection
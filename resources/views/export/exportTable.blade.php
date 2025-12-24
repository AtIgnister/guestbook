@extends('components.layouts.layout')
@section("title")
Export Guestbooks
@endsection
@section("content")
    <a href="{{ route("dashboard") }}">Back to Dashboard</a>
    <main class="max-w-2xl mx-auto p-4">
        <!-- Header -->
        <h1 class="text-3xl md:text-4xl font-bold text-center my-6">
            Export Guestbooks
        </h1>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full border  shadow-sm rounded-lg">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-left">Export as JSON</th>
                        <th class="px-4 py-2 text-left">Export as CSV</th>
                        <th class="px-4 py-2 text-left">Export as HTML</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($guestbooks as $guestbook)
                        <tr>
                            <td class="px-4 py-2">{{ $guestbook->name }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route("export.json", compact("guestbook")) }}" class="hover:underline">Download</a> /
                                <a href="{{ route("export.json.raw", compact("guestbook")) }}" class="hover:underline">View Raw File</a>
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route("export.csv", compact("guestbook")) }}" class="hover:underline">Download</a>
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route("export.html", compact("guestbook")) }}" class="hover:underline">Download</a> /
                                <a href="{{ route("export.html.raw", compact("guestbook")) }}" class="hover:underline">View Raw File</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                No guestbooks yet.
                                <a href="{{ route("guestbooks.create") }}" class="text-blue-600 hover:underline">Go ahead and make one!</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
@endsection
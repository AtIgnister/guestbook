<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guestbooks</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('app.css') }}">
</head>
<body class="min-h-screen">

    @if(session('success'))
        <div class="max-w-2xl mx-auto mt-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route("dashboard") }}">Back to Dashboard</a>
    <main class="max-w-2xl mx-auto p-4">
        <!-- Header -->
        <h1 class="text-3xl md:text-4xl font-bold text-center my-6">
            Guestbooks
        </h1>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full border  shadow-sm rounded-lg">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-left">Entries</th>
                        <th class="px-4 py-2 text-left">Edit</th>
                        <th class="px-4 py-2 text-left">Delete</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($guestbooks as $guestbook)
                        <tr>
                            <td class="px-4 py-2">{{ $guestbook->name }}</td>
                            <td class="px-4 py-2">
                                <a href="/entries/{{ $guestbook->id }}" class="text-blue-600 hover:underline">Entries</a>
                            </td>
                            <td class="px-4 py-2">
                                <a href="/guestbooks/{{ $guestbook->id }}/edit" class="text-green-600 hover:underline">Edit</a>
                            </td>
                            <td class="px-4 py-2">
                                <a href="/guestbook/{{ $guestbook->id }}/delete" class="text-red-600 hover:underline">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                No guestbooks yet.
                                <a href="/guestbooks/create" class="text-blue-600 hover:underline">Go ahead and make one!</a>
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

</body>
</html>

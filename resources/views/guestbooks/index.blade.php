@extends('components.layouts.layout')
@section("content")
    @if(session('success'))
        <div class="max-w-2xl mx-auto mt-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <main class="max-w-2xl mx-auto p-4">
        <!-- Header -->
        <h1 class="text-3xl md:text-4xl font-bold text-center my-6">
            Guestbooks
        </h1>
        @if (auth()->user()->hasRole('admin'))
            <form class="mb-2" method="POST" action="{{ route('ipBans.clearGlobal') }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to clear all global IP bans?')">Clear All Global IP Bans</button>
            </form>
        @endif

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="overflow-x-auto min-w-full border  shadow-sm rounded-lg">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Name</th>
                        @role("admin")
                            <th class="px-4 py-2 text-left">User</th>
                        @endrole
                        <th class="px-4 py-2 text-left">Entries</th>
                        <th class="px-4 py-2 text-left">Edit</th>
                        <th class="px-4 py-2 text-left">Delete</th>
                        @if (!auth()->user()->hasRole('admin'))
                            <th class="px-4 py-2 text-left">Clear Bans</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($guestbooks as $guestbook)
                        <tr>
                            <td class="px-4 py-2">{{ $guestbook->name }}</td>
                            @role("admin")
                                <td class="px-4 py-2">
                                    <a href="{{ route('users.show', $guestbook->user) }}">
                                        {{ $guestbook->user->name }}
                                    </a>
                                </td>
                            @endrole
                            <td class="px-4 py-2">
                                <a href="{{ route("entries.index", compact("guestbook")) }}" class="hover:underline">Entries</a>
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route("guestbooks.edit", compact("guestbook")) }}" class="hover:underline">Edit</a>
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route("guestbooks.delete", compact("guestbook")) }}" class="hover:underline">Delete</a>
                            </td>
                            @if (!auth()->user()->hasRole('admin'))
                                <td class="px-4 py-2"><form class="mb-2" method="POST" action="{{ route('guestbooks.clearBans', $guestbook) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-warning"
                                            onclick="return confirm('Are you sure you want to clear all bans for this guestbook?')">
                                        Clear All IP Bans for This Guestbook
                                    </button>
                                </form></td>
                            @endif
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
            
            {{ $guestbooks->links('pagination::simple-tailwind') }}
        </div>
        <x-search-filter />
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
@extends('components.layouts.layout')
@section("content")
    @if(session('success'))
        <div class="max-w-2xl mx-auto mt-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <main class="max-w-200 mx-auto p-4">
        <!-- Header -->
        <h1 class="text-3xl md:text-4xl font-bold text-center my-6">
            View Entries
        </h1>

        @if(auth()->user()->hasRole('admin'))
            <form class="mb-2" method="POST" action="{{ route('ipBans.clearGlobal') }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Are you sure you want to clear all global IP bans?')">
                    Clear All Global IP Bans
                </button>
            </form>
        @endif

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="border shadow-sm rounded-lg overflow-auto">
                <thead>
                    <tr>
                        <th>Approved?</th>
                        <th class="px-4 py-2 text-left">Guestbook</th>
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-left">Website</th>
                        <th class="px-4 py-2 text-left">Comment</th>
                        <th class="px-4 py-2 text-left">Date</th>
                        <th class="px-4 py-2 text-left">Delete</th>
                        <th class="px-4 py-2 text-left">Ban IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-20">
                    @forelse ($entries as $entry)
                    {{-- TODO: use color that looks less bad --}}
                        <tr class="@if (!$entry->isApproved())
                            bg-red-600
                        @endif">
                            <td class="px-4 py-2">
                                @if (!$entry->isApproved() && auth()->user()->id === $entry->guestbook->user_id)
                                    <form method="POST" action="{{ route('entries.approve', $entry) }}">
                                        @csrf
                                    
                                        <button type="submit" class="hover:underline">
                                            Approve
                                        </button>
                                    </form>
                                @else
                                    {{ $entry->getIsApprovedLabel() }}
                                @endif
                            </td>
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
                            @role("admin")
                                <td><time>{{ $entry->created_at }}</time></td>
                            @else
                                <td><time>{{ $entry->posted_at }}</time></td>
                            @endrole
                            <td class="pl-4">
                                <form method="POST" action="{{ route('entries.destroy', $entry) }}">
                                    @csrf
                                    @method('DELETE')
                                
                                    <button type="submit" class="text-red-600 hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </td>
                            <td>
                                @php($ipBan = $entry->getIpBan())

                                @if (!$ipBan)
                                    <a href="{{ route('ipBans.create', ['entry_ip' => $entry->ip]) }}">
                                        Ban IP
                                    </a>
                                @else
                                    <form method="POST" action="{{ route('ipBans.destroy', $ipBan) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Unban IP</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500">No entries yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $entries->links('pagination::simple-tailwind') }}
        </div>
        <x-search-filter />
    </main>
@endsection
@extends('components.layouts.layout')

@section("content")
<section class="m-3 space-y-6">

    <h1 class="text-2xl font-bold">Edit User</h1>

    <!-- User info -->
    <div class="flex-col md:w-3/4 space-y-2">
        <div>
            <p>Name: {{ $user->name }}</p>
            <p>Email: {{ $user->email }}</p>
            <p>Created at: {{ $user->created_at }}</p>
            <p>Banned: {{ $user->userBan ? 'Yes' : 'No' }}</p>
        </div>

        <!-- Actions -->
        <div class="space-y-1">
            @if (!$user->userBan)
                <a class="block w-fit" href="{{ route('userBans.create', $user) }}">
                    Ban User
                </a>
            @else
                <a class="block w-fit" href="{{ route('userBans.delete', $user->userBan) }}">
                    Unban User
                </a>
            @endif

            <a class="block w-fit" href="{{ route('users.delete', $user) }}">
                Delete
            </a>
        </div>
    </div>

    <!-- Guestbooks list -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-4">
            Guestbooks by {{ $user->name }}
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border shadow-sm rounded-lg">
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
                            <td class="px-4 py-2">
                                {{ $guestbook->name }}
                            </td>

                            <td class="px-4 py-2">
                                <a href="{{ route('entries.index', $guestbook) }}" class="hover:underline">
                                    Entries
                                </a>
                            </td>

                            <td class="px-4 py-2">
                                <a href="{{ route('guestbooks.edit', $guestbook) }}" class="hover:underline">
                                    Edit
                                </a>
                            </td>

                            <td class="px-4 py-2">
                                <a href="{{ route('guestbooks.delete', $guestbook) }}" class="hover:underline">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                This user has no guestbooks.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $guestbooks->links('pagination::simple-tailwind') }}
        </div>
    </div>

</section>
@endsection

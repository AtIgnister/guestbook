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
            Users
        </h1>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="overflow-x-auto min-w-full border  shadow-sm rounded-lg">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Username</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Delete</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2"><a href="{{ route('user.delete', compact('user')) }}">Delete</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{ $users->links('pagination::simple-tailwind') }}
        </div>
        <x-search-filter />
    </main>
@endsection
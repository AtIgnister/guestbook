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
            Privacy Policies
        </h1>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="overflow-x-auto min-w-full border  shadow-sm rounded-lg">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Date Published</th>
                        <th class="px-4 py-2 text-left">Date Created</th>
                        <th class="px-4 py-2 text-left">Visible?</th>
                        <th class="px-4 py-2 text-left">Link</th>
                        @if ($enableDraftView)
                            <th class="px-4 py-2 text-left">Edit</th>
                            <th class="px-4 py-2 text-left">Delete</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($privacyPolicies as $privacyPolicy)
                        <tr>
                            <td class="px-4 py-2">
                                @if ($privacyPolicy->published_at)
                                    {{ $privacyPolicy->published_at }}
                                @else
                                    <form action="{{ route('privacy-policy.publish', $privacyPolicy) }}" method="POST" class="flex gap-3">
                                        @csrf
                                        @method('PATCH')
                                    
                                        <button
                                            type="submit"
                                            class="text-green-500"
                                        >
                                            Publish
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $privacyPolicy->created_at }}</td>
                            <td class="px-4 py-2">{{ $privacyPolicy->visible ? "Yes" : "No" }}</td>
                            <td class="px-4 py-2"><a href="{{ route("privacy-policy.show", compact("privacyPolicy")) }}">Link</a></td>
                            @if ($enableDraftView)
                                <td>
                                    <a href="{{ route("privacy-policy.edit", compact("privacyPolicy")) }}">Edit</a>
                                </td>
                                <td>
                                    <form action="{{ route('privacy-policy.destroy', $privacyPolicy) }}" method="POST" class="flex gap-3">
                                        @csrf
                                        @method('DELETE')
                                    
                                        <button
                                            type="submit"
                                            class="text-red-500"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                No policies yet.
                                <a href="{{ route("privacy-policy.create") }}" class="text-blue-600 hover:underline">Go ahead and make one!</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Add New Button -->
        @if ($privacyPolicies && $privacyPolicies->count())
            <div class="flex justify-end mt-4">
                <a href="{{ route("privacy-policy.create") }}" class="px-4 py-2">
                    Add new!
                </a>
            </div>
        @endif
    </main>
@endsection
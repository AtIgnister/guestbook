@extends('components.layouts.layout')

@section('content')
<div class="max-w-lg mx-auto mt-10 space-y-6" x-data="{ open: false }">
    <h1 class="text-2xl font-bold">{{ __('Delete Account') }}</h1>
    <p class="text-red-600">
        {{ __('Once your account is deleted, all of your data will be permanently removed.') }}
    </p>

    @if(session('status'))
        <div class="p-4 bg-green-100 text-green-700 rounded">
            {{ session('status') }}
        </div>
    @endif

    <!-- Delete Account Button -->
    <button 
        @click="open = true" 
        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
    >
        {{ __('Delete Account') }}
    </button>

    <!-- Modal -->
    <div
        x-show="open"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div
            class="rounded-lg max-w-md w-full p-6 bg-[#01242e]"
            @click.away="open = false"
        >
            <h2 class="text-xl font-bold mb-4">{{ __('Are you sure you want to delete your account?') }}</h2>
            <p class="mb-4 text-red-600">
                {{ __('This action cannot be undone. Please enter your password to confirm.') }}
            </p>

            <form method="POST" action="{{ route('account.destroy') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="password" class="block text-sm font-medium ">{{ __('Password') }}</label>
                    <input id="password" name="password" type="password" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" @click="open = false"
                            class="px-4 py-2  rounded ">
                        {{ __('Cancel') }}
                    </button>

                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        {{ __('Delete Account') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

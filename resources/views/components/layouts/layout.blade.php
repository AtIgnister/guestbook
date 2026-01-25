<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Guestbooks')</title>
    @vite('resources/css/app.css')
    {!! config('app.analytics_src') !!}
</head>
<body class="flex flex-col h-screen justify-between text-gray-700 dark:text-gray-300 bg-white dark:bg-[#01242e]">

    @php
        $currentRoute = request()->route()->getName();
    @endphp

    @if (! request()->routeIs('home') && ! request()->routeIs('dashboard') && !View::hasSection('hideBackToDashboard') && Auth::check() && !auth()->user()->hasRole('admin'))
        <a href="{{ route('dashboard') }}"
           class="top-2 left-2 relative mb-3 {{ auth()->user() && auth()->user()->hasRole('admin') ? 'text-black' : '' }}">
            Back to Dashboard
        </a>
    @endif

    @if (!View::hasSection('hideAdminBanner'))
        @role("admin")
            <div class=" text-black font-semibold relative">
                <p class="bg-red-600 p-2 mb-3 text-center">You are logged in as an <strong>Admin</strong></p>
                @if(!request()->routeIs('dashboard'))
                <a href="{{ route('dashboard') }}" class="ml-3">
                    Back to Dashboard
                </a> 
                @endif               
            </div>
        @endrole
    @endif

    <main class="flex-grow">
        @yield('content')
    </main>

    <x-agpl-footer></x-agpl-footer>

</body>
</html>

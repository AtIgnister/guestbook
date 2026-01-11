<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Guestbooks')</title>
    @vite('resources/css/app.css')
</head>
<body class="flex flex-col h-screen justify-between">

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
            <div class="bg-red-600 text-black px-4 py-2 text-center font-semibold relative">
                <a href="{{ route('dashboard') }}" class="absolute left-2 top-2 mb-3 text-black">
                    Back to Dashboard
                </a>
                You are logged in as an <strong>Admin</strong>
            </div>
        @endrole
    @endif

    <main class="flex-grow">
        @yield('content')
    </main>

    <x-agpl-footer></x-agpl-footer>

</body>
</html>

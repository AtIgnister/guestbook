<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Guestbooks')</title>
    @vite('resources/css/app.css')
</head>
<body @class([

    'dark' => (session('theme')==='dark'),

])>

    <livewire:theme-toggle>
    
    @php
        // Current route check
        $currentRoute = request()->route()->getName(); // assumes named routes
    @endphp

    @if (! request()->routeIs('home') && ! request()->routeIs('dashboard') && !View::hasSection('hideBackToDashboard'))
        <a href="{{ route('dashboard') }}"
        class="top-2 left-2 absolute {{ auth()->user() && auth()->user()->hasRole('admin') ? 'text-black' : '' }}">
            Back to Dashboard
        </a>
    @endif

    @if (!View::hasSection('hideAdminBanner'))
        @role("admin")
            <div class="bg-red-600 text-black px-4 py-2 text-center font-semibold">
                You are logged in as an <strong>Admin</strong>
            </div>
        @endrole
    @endif

    @yield('content')
</body>
</html>
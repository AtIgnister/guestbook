@extends("components.layouts.layout")
@section("title")
    Dashboard
@endsection
@section("content")
<main class="flex flex-col items-center gap-4">
    <h1>Dashboard</h1>
    <a class="block" href="{{ route('guestbooks.index')}}">View Guestbooks</a>
    <a class="block" href="{{ route('entries.editAll') }}">View all Entries</a>
    <a class="block">Approve Entries</a>
    <a class="block" href="{{ route('guestbooks.export.index') }}">Export Data</a>
    <a class="block" href="{{ route('profile.edit') }}">Settings</a>
    <br>
    <p>Logged in as: {{ auth()->user()->name }}</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
    
        <button type="submit" class="text-red-500">
            Logout
        </button>
    </form>
</main>
@endsection
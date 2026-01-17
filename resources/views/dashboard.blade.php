@extends("components.layouts.layout")
@section("title")
    Dashboard
@endsection
@section("content")
<main class="flex flex-col items-center gap-4">

    <!-- MESSAGES -->
    @if(session('success'))
        <p class="p-2" x-data="{show: true}" x-show="show" x-init="setTimeout(() => show = false, 30000)" x-transition>
            {!! session('success') !!}
        </p>
    @endif

     @if(session('error'))
        <p class="p-2" x-data="{show: true}" x-show="show" x-init="setTimeout(() => show = false, 30000)" x-transition>
            {!! session('error') !!}
        </p>
    @endif
   <!-- MESSAGES -->

    <h1>Dashboard</h1>
    <a class="block" href="{{ route('guestbooks.index')}}">View Guestbooks</a>
    <a class="block" href="{{ route('entries.editAll') }}">View all Entries</a>
    @role("admin")
        <a class="block" href="{{ route("privacy-policy.editAllDrafts") }}">View privacy policy drafts</a>
        <a class="block" href="{{ route("privacy-policy.editAllPublished") }}">Edit published policies</a>
    @endrole
    <a class="block" href="{{ route('guestbooks.export.index') }}">Export Data</a>
    <a class="block" href="{{ route('profile.edit') }}">Settings</a>

    @role("admin")
        <a class="block" href="{{route('admin.invite')}}">Create invite</a>
        <a class="block" href="{{ route('users.index') }}">Manage Users</a>
    @endrole
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
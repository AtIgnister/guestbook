@extends("components.layouts.layout")

@section("title")
Blog
@endsection

@section("content")

<div class="mx-auto max-w-content px-5 py-5  leading-relaxed">

    <header class="mb-6">
        <a href="{{ route('blog.index') }}">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                The Guestbook Blog
            </h1>
        </a>

        <nav class="mt-2 space-x-2">
            @auth
                <a href="{{ route('dashboard') }}">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" >
                    Login
                </a>
            @endauth

            <a href="{{ route('privacy-policy.index') }}">
                Privacy Policy
            </a>
        </nav>
    </header>

    <main class="prose dark:prose-invert max-w-none">
        {!! $content !!}
    </main>

</div>
@endsection

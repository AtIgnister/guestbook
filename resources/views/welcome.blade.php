@extends("components.layouts.layout")
@section('content')
    @if (Route::has('login'))
        <nav class="flex items-center justify-end gap-4">
            @auth
                <a
                    href="{{ url('/dashboard') }}"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm leading-normal"
                >
                    Dashboard
                </a>
            @else
                <a
                    href="{{ route('login') }}"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm leading-normal"
                >
                    Log in
                </a>

                @if (Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm leading-normal">
                        Register
                    </a>
                @endif
            @endauth
                <a href="/privacy-policy" class="text-white mr-6 text-sm">Privacy Policy</a>
        </nav>
        <main class="max-w-2xl mx-auto">
            <h1>Guestbooks</h1>
            <p>A really simple, <a href="https://bearblog.dev">bearblog inspired</a> guestbook app that will not lose your data.</p>
            <a href="mailto:kami@kamiscorner.xyz">Email me to receive an invite</a> or <a href="/login">Log in with an existing account</a>.
        </main>
    @endif
@endsection
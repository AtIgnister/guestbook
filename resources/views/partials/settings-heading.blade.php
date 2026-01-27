<div class="relative mb-6 w-full">
    <h1>{{ __('Settings') }}</h1>
    <p>{{ __('Manage your profile and account settings') }}</p>
    <a href="{{ route("dashboard") }}">Return to dashboard</a>
    {{-- This is a stupid workaround, TODO: figure out why this is the only way to get the text to show up --}}
    <style>
        /* Light mode placeholder */
        input::placeholder,
        textarea::placeholder {
            color: #71717a !important; /* zinc-500 */
            opacity: 1; /* Firefox */
        }

        input {
            color: black !important
        }

        /* Dark mode placeholder */
        .dark input::placeholder,
        .dark textarea::placeholder {
            color: #a1a1aa !important; /* zinc-400 */
        }
    </style>
</div>

<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <nav>
            <a class="block" href="{{ route('profile.edit') }}" wire:navigate>{{ __('Profile') }}</a>
            <a class="block" href="{{ route('user-password.edit') }}" wire:navigate>{{ __('Password') }}</a>
            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <a class="block" href="{{ route('two-factor.show') }}" wire:navigate>{{ __('Two-Factor Auth') }}</a>
            @endif
            <a class="block" href="{{ route('appearance.edit') }}" wire:navigate>{{ __('Appearance') }}</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
            
                <button type="submit" class="text-red-500">
                    Logout
                </button>
            </form>
        </nav>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <h1>{{ $heading ?? '' }}</h1>
        <p>{{ $subheading ?? '' }}</p>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>

<x-agpl-footer></x-agpl-footer>
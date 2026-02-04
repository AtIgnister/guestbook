<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Two Factor Authentication')" :subheading="__('Manage your 2FA settings.')">
        @php
            $secret = auth()->user()->twoFactorSecretPlain();
        @endphp

        {{-- Status messages --}}
        @if (session('status'))
            <div class="mb-6 text-sm text-green-600 font-medium">
                {{ session('status') }}
            </div>
        @endif

        <section>
            <div class="mb-4">
                <h2>Two-Factor Authentication</h2>
                <p>Add additional security to your account using two-factor authentication.</p>
            </div>

            {{-- Disabled --}}
            @if (! auth()->user()->two_factor_secret)
                <form method="POST" action="/user/two-factor-authentication">
                    @csrf
                    <flux:button
                        variant="primary"
                        type="submit"
                    >
                        Enable Two-Factor Authentication
                    </flux:button>
                </form>
            @endif

            {{-- Enabled, waiting for confirmation--}}
            @if (auth()->user()->two_factor_secret && ! auth()->user()->two_factor_confirmed_at)
                <div class="mt-6">
                    <p class="mb-4">
                        Scan the following QR code using your authenticator app,
                        then enter the generated code below.<br><br>
                        Alternatively, you can use this manual setup key: {{ $secret }}
                    </p>

                    <div class="mb-4">
                        {!! auth()->user()->twoFactorQrCodeSvg() !!}
                    </div>

                    <form method="POST" action="/user/confirmed-two-factor-authentication" class="mt-4">
                        @csrf
                        <div class="mb-3">
                            <label for="code">Authentication Code</label>
                            <input
                                id="code"
                                name="code"
                                type="text"
                                inputmode="numeric"
                                autocomplete="one-time-code"
                                required
                                class="mt-1 block w-48 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-white"
                            >
                        </div>
                        <flux:button 
                            variant="primary"
                            type="submit"
                        >
                            Confirm
                        </flux:button>
                    </form>
                </div>
            @endif

            {{-- Confirmed --}}
            @if (auth()->user()->two_factor_confirmed_at)
                <div class="mt-6">
                    <p class="mb-4">
                        Two-factor authentication is enabled. Store these recovery codes in a secure location.
                    </p>

                    {{-- Recovery Codes --}}
                    <div class="grid grid-cols-2 gap-2 font-mono text-sm rounded p-4 mb-4">
                        @foreach (auth()->user()->recoveryCodes() as $code)
                            <div>{{ $code }}</div>
                        @endforeach
                    </div>

                    <div class="flex items-center gap-3">
                        <form method="POST" action="/user/two-factor-recovery-codes">
                            @csrf
                            <flux:button
                                variant="primary"
                                type="submit"
                            >
                                Regenerate Recovery Codes
                            </flux:button>
                        </form>

                        {{-- Disable 2fa --}}
                        <form method="POST" action="/user/two-factor-authentication">
                            @csrf
                            @method('DELETE')
                            <flux:button
                                variant="primary"
                                type="submit"
                            >
                                Disable Two-Factor Authentication
                            </flux:button>
                        </form>
                    </div>
                </div>
            @endif

        </section>
    </x-settings.layout>
</section>

<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TwoFactor extends Component
{
    public bool $twoFactorEnabled = false;
    public ?string $secret = null;

    public function mount(){
        $user = Auth::user();

        // Clean up old 2FA secrets if created > 5 minutes ago
        if ($user->two_factor_secret
            && ! $user->two_factor_confirmed_at
            && $user->two_factor_updated_at
            && $user->two_factor_updated_at->lt(now()->subMinutes(5))
        ) {
            $user->forceFill([
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
            ])->save();
        }

        $this->twoFactorEnabled = (bool) $user->two_factor_confirmed_at;
        $this->secret = $user->twoFactorSecretPlain();
    }


    public function render()
    {
        return view('livewire.settings.two-factor');
    }
}

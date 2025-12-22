<?php

use App\Http\Controllers\EntriesController;
use App\Http\Controllers\GuestbookController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::resource("guestbooks", GuestbookController::class)
->middleware(['auth', 'verified']);

Route::get('/entries/{guestbook_id}', [EntriesController::class, 'index'])
->name('entries.index');

Route::get('/entries/{guestbook_id}/create', [EntriesController::class, 'create']);

Route::post('/entries/{guestbook_id}/store', [EntriesController::class, 'store'])
->name('entries.store')
->middleware(['auth', 'verified']);

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

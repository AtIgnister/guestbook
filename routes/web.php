<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\EntriesController;
use App\Http\Controllers\Export\ExportGuestbookJsonController;
use App\Http\Controllers\GuestbookController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\AccountController;

// <!-- Dash and Home Routes --!>
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');

Route::resource("guestbooks", GuestbookController::class)
->middleware(['auth']);
// <!-- Dash and Home Routes --!>


// <!-- Guestbook Routes --!>
Route::get(
    '/guestbooks/{guestbook}/delete',
    [GuestbookController::class, 'delete']
)->middleware('auth')
->can('delete,guestbook')
->name('guestbooks.delete');

Route::get('/entries/{guestbook}', [EntriesController::class, 'index'])
->name('entries.index');
Route::get('/entries/{guestbook}/create', [EntriesController::class, 'create'])
->middleware(['throttle:20,1']);

Route::view("privacy-policy", "legal.privacy")->name("legal.privacy");

Route::post('/entries/{guestbook}/store', [EntriesController::class, 'store'])
->name('entries.store')
->middleware(['auth'])
->middleware(['throttle:20,1']);
// <!-- Guestbook Routes --!>


// <!-- Guestbook Export Routes --!>
Route::middleware(['auth'])->group(function () { 
    Route::get(
        '/guestbooks/{guestbook}/export/json',
        [ExportGuestbookJsonController::class, 'export']
    );
    
    Route::get(
        '/guestbooks/{guestbook}/export/json/raw',
        [ExportGuestbookJsonController::class, 'exportRaw']
    );
})->middleware(['auth', 'can:view,guestbook', 'throttle:60,1']);
// <!-- Guestbook Export Routes --!>


// <!-- Account Routes --!>
Route::middleware(['auth'])->group(function () {
    Route::get('/account/delete', [AccountController::class, 'showDeleteForm'])->name('account.delete');
    Route::post('/account/delete', [AccountController::class, 'deleteAccount'])->name('account.destroy');
});

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
})->middleware(['throttle:30,1']);

Route::get('/register', function () {
    return redirect('/login');
})->name('register');
// <!-- Account Routes --!>


// <!-- Blog Routes --!>
Route::get('/blog/{post_name}', [BlogController::class, 'post'])->name('blog.post');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
// <!-- Blog Routes --!>
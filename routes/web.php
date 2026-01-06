<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\EntriesController;
use App\Http\Controllers\Export\ExportGuestbookCSVController;
use App\Http\Controllers\Export\ExportGuestbookHTMLController;
use App\Http\Controllers\Export\ExportGuestbookJsonController;
use App\Http\Controllers\Export\ExportGuestbookListController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\GuestbookController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\IpBanController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\AccountController;
use Laravel\Fortify\RoutePath;

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
)->middleware('auth', 'BanCheck')
->can('delete,guestbook')
->name('guestbooks.delete');

Route::get('/entries/{guestbook}', [EntriesController::class, 'index'])
->name('entries.index');
Route::get('/entries/{guestbook}/create', [EntriesController::class, 'create'])
->middleware(['throttle:20,1', 'BanCheck:guestbook']);
Route::delete('/entries/{entry}/destroy', [EntriesController::class, 'destroy'])
->middleware('auth', 'BanCheck')
->can('delete', 'entry')
->name('entries.destroy');

Route::view("privacy-policy", "legal.privacy")->name("legal.privacy");

Route::post('/entries/{guestbook}/store', [EntriesController::class, 'store'])
->name('entries.store')
->middleware(['auth', 'BanCheck:guestbook'])
->middleware(['throttle:20,1']);

Route::get('/entries/edit/all/', [EntriesController::class, 'editAll'])->name('entries.editAll')
->middleware(['auth', 'BanCheck']);

Route::post('/entries/{entry}/approve', [EntriesController::class,'approve'])
->name('entries.approve')
->middleware(['auth', 'BanCheck', 'throttle:30,1'])
->can('approve', 'entry');
// <!-- Guestbook Routes --!>

// <!-- IP Ban Routes --!>
Route::get('/ip/ban/{entry_ip}', [IpBanController::class, 'create'])
->middleware('auth', 'BanCheck')
->name('ipBans.create');

Route::post("/ip/ban/store", [IpBanController::class, 'store'])
->middleware('auth', 'BanCheck')
->name("ipBans.store");
// <!-- IP Ban Routes --!>


// <!-- Guestbook Export Routes --!>
Route::middleware(['auth'])->group(function () {
    Route::get(
        '/guestbooks/export/dashboard',
        [ExportGuestbookListController::class,'index']
    )->name("guestbooks.export.index");

    Route::get(
        '/guestbooks/{guestbook}/export/json',
        [ExportGuestbookJsonController::class, 'export']
    )->name("export.json");
    
    Route::get(
        '/guestbooks/{guestbook}/export/json/raw',
        [ExportGuestbookJsonController::class, 'exportRaw']
    )->name("export.json.raw");

    Route::get(
        '/guestbooks/{guestbook}/export/csv',
        [ExportGuestbookCSVController::class, 'export']
    )->name("export.csv");

    Route::get(
        '/guestbooks/{guestbook}/export/html',
        [ExportGuestbookHTMLController::class, 'export']
    )->name("export.html");

    Route::get(
        '/guestbooks/{guestbook}/export/html/raw',
        [ExportGuestbookHTMLController::class, 'exportRaw']
    )->name("export.html.raw");
});
// <!-- Guestbook Export Routes --!>

// <!-- Account Routes --!>
Route::middleware(['auth'])->group(function () {
    Route::get('/account/delete', [AccountController::class, 'showDeleteForm'])->name('account.delete');
    Route::delete('/account/delete', [AccountController::class, 'deleteAccount'])->name('account.destroy');
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

// <!-- Account Routes --!>

//Overwrite registration route to use signed middleware

Route::get(RoutePath::for('register', '/register'), [RegisteredUserController::class, 'create'])
    ->middleware(['guest:'.config('fortify.guard')])
    ->middleware('signed')
    ->name('register');

// <!-- Blog Routes --!>
Route::get('/blog/{post_name}', [BlogController::class, 'post'])->name('blog.post');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
// <!-- Blog Routes --!>


// <!-- Captcha --!>
Route::get('/captcha-refresh', function () {
    return response()->json(['captcha' => captcha_src()]);
})->name('captcha.refresh');
// <!-- Captcha --!>

// <!-- Admin Routes --!>
 Route::get('/admin/invite', [InviteController::class, 'show'])
    ->middleware(['auth','ValidateAdmin'])
    ->name('admin.invite');

 Route::post('/admin/invite', [InviteController::class, 'create'])
    ->middleware(['auth','ValidateAdmin'])
    ->name('admin.invite.create');

// <!-- Admin Routes --!>

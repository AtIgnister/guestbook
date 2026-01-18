<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\EntriesController;
use App\Http\Controllers\Export\ExportGuestbookCSVController;
use App\Http\Controllers\Export\ExportGuestbookHTMLController;
use App\Http\Controllers\Export\ExportGuestbookJsonController;
use App\Http\Controllers\Export\ExportGuestbookListController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\UserBanController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\GuestbookController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\IpBanController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\AccountController;
use Laravel\Fortify\RoutePath;
use App\Http\Controllers\UserController;

// <!-- Dash and Home Routes --!>
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');

Route::resource("guestbooks", GuestbookController::class)
->middleware(['auth', 'UserBanCheck']);
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

Route::middleware(['UserBanCheck'])->group(function() {
    Route::get('/entries/{guestbook}/create', [EntriesController::class, 'create'])
    ->middleware(['throttle:20,1', 'BanCheck:guestbook']);
    Route::delete('/entries/{entry}/destroy', [EntriesController::class, 'destroy'])
    ->middleware('auth', 'BanCheck')
    ->can('delete', 'entry')
    ->name('entries.destroy');
});

// <!-- Privacy Policy Routes --!>
Route::get("/privacy-policy", [PrivacyPolicyController::class, 'index'])->name("privacy-policy.index");;
Route::get("/privacy-policy/history", [PrivacyPolicyController::class, 'list'])->name("privacy-policy.list");
Route::get("/privacy-policy/history/{privacyPolicy}", [PrivacyPolicyController::class, 'show'])->name("privacy-policy.show");

Route::middleware(['UserBanCheck'])->group(function() {
    Route::get("privacy-policy/create", [PrivacyPolicyController::class, 'create'])
    ->name("privacy-policy.create")
    ->middleware(['auth','ValidateAdmin']);

    Route::get("privacy-policy/edit/{privacyPolicy}", [PrivacyPolicyController::class, 'edit'])
    ->name("privacy-policy.edit")
    ->middleware(['auth','ValidateAdmin']);

    Route::get("privacy-policy/editAll/drafts", [PrivacyPolicyController::class, 'editAllDrafts'])
    ->name("privacy-policy.editAllDrafts")
    ->middleware(['auth','ValidateAdmin']);

    Route::get("privacy-policy/editAll/published", [PrivacyPolicyController::class, 'editAllPublished'])
    ->name("privacy-policy.editAllPublished")
    ->middleware(['auth','ValidateAdmin']);

    Route::patch("privacy-policy/toggleVisibility/{privacyPolicy}", [PrivacyPolicyController::class, 'toggleVisibility'])
    ->name("privacy-policy.toggleVisibility")
    ->middleware(['auth','ValidateAdmin']);

    Route::post("/privacy-policy/store", [PrivacyPolicyController::class, 'store'])
    ->name("privacy-policy.store")
    ->middleware(['auth','ValidateAdmin']);

    Route::put("/privacy-policy/edit/{privacyPolicy}", [PrivacyPolicyController::class, 'update'])
    ->name("privacy-policy.update")
    ->middleware(['auth','ValidateAdmin']);

    Route::patch("/privacy-policy/publish/{privacyPolicy}", [PrivacyPolicyController::class, 'publish'])
    ->name("privacy-policy.publish")
    ->middleware(['auth','ValidateAdmin']);

    Route::delete("/privacy-policy/destroy/{privacyPolicy}", [PrivacyPolicyController::class, 'destroy'])
    ->name("privacy-policy.destroy")
    ->middleware(['auth','ValidateAdmin']);
});

// <!-- Privacy Policy Routes --!>

Route::middleware(['UserBanCheck'])->group(function() { 
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
});
// <!-- Guestbook Routes --!>

// <!-- IP Ban Routes --!>
Route::middleware(['UserBanCheck'])->group(function() { 
    Route::get('/ip/ban/{entry_ip}', [IpBanController::class, 'create'])
    ->middleware('auth', 'BanCheck')
    ->name('ipBans.create');

    Route::post("/ip/ban/store", [IpBanController::class, 'store'])
    ->middleware('auth', 'BanCheck')
    ->name("ipBans.store");

    Route::delete('/ip/unban/{IpBan}', [IpBanController::class, 'destroy']);
});
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

Route::get(RoutePath::for('register', '/register'), [RegisteredUserController::class, 'create'])
    ->middleware(['guest:'.config('fortify.guard')])
   # ->middleware('signed')
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

// <!-- Invite Routes --!>
Route::middleware(['auth'. 'UserBanCheck'])->group(function () {
    Route::get('/admin/invite', [InviteController::class, 'show'])
    ->middleware(['auth','ValidateAdmin'])
    ->name('admin.invite');

    Route::post('/admin/invite', [InviteController::class, 'create'])
        ->middleware(['auth','ValidateAdmin'])
        ->name('admin.invite.create');
});
// <!-- Invite Routes --!>

// <!-- User Management Routes --!>
Route::middleware(['auth', 'ValidateAdmin', 'UserBanCheck'])->group(function () { 
    Route::get("users", [UserController::class, 'index'])->name('users.index');
    Route::get("users/delete/{user}", [UserController::class, 'delete'])->name('users.delete');
    Route::delete("users/delete/{user}", [UserController::class, 'destroy'])->name('users.destroy');

    Route::get("users/show/{user}", [UserController::class, 'show'])->name('users.show');

    Route::get("users/ban/{user}", [UserBanController::class, 'create'])->name('userBans.create');
    Route::get('users/unban/{userBan}', [UserBanController::class, 'delete'])->name('userBans.delete');
    Route::delete("users/unban/{userBan}", [UserBanController::class, 'destroy'])->name('userBans.destroy');
    Route::post("users/ban/{user}", [UserBanController::class, 'store'])->name('userBans.store');
});

// <!-- User Routes --!>
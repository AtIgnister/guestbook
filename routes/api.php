<?php

use App\Http\Controllers\AudioCaptchaController;
use App\Http\Controllers\Export\ExportGuestbookJsonController;
use App\Services\AudioCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/audio-captcha/generate', function (Request $request, AudioCaptcha $audioCaptcha) {
    return $audioCaptcha->getCaptcha();
});

Route::get(
    '/audio-captcha/audio/{id}',
    [AudioCaptchaController::class, 'audio']
)->name('audio-captcha.audio')
->middleware('throttle:30,1');

Route::get(
        '/{guestbook}/json',
        [ExportGuestbookJsonController::class, 'exportRaw']
)->name("export.json")
->middleware('throttle:30,1');

// <!-- Embed Route --!>
Route::get('/embeds/{guestbook}/embed.js', function ($guestbook) {
    $url= config('app.url');

    return response()
        ->view('embed.js', compact('url', 'guestbook'))
        ->header('Content-Type', 'application/javascript')
        ->header('Cache-Control', 'public, max-age=31536000')
        ->header('Access-Control-Allow-Origin', '*');
})->middleware('throttle:30,1');
// <!-- Embed Route --!>
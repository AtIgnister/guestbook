<?php

use App\Http\Controllers\AudioCaptchaController;
use App\Services\AudioCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/audio-captcha/generate', function (Request $request, AudioCaptcha $audioCaptcha) {
    return $audioCaptcha->getCaptcha();
});

Route::get(
    '/audio-captcha/audio/{id}',
    [AudioCaptchaController::class, 'audio']
)->name('audio-captcha.audio')->middleware('signed');
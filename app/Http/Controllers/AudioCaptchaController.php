<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class AudioCaptchaController extends Controller
{
    public function audio(string $id){
        $path = "captcha/tmp/{$id}.mp3";

        if (! Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return response()->file(
            Storage::disk('public')->path($path),
            [
                'Content-Type'  => 'audio/mpeg',
                'Cache-Control' => 'no-store, no-cache, must-revalidate',
                'Pragma'        => 'no-cache',
            ]
        );
    }
}

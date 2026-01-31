<?php

namespace App\Services;

use Cache;
use Illuminate\Support\Facades\Storage;
use Str;

class AudioCaptcha
{
    // What do we need?
    // 1. User calls audio captcha/generate
    // 2. return captcha token in JSON form and link pointing to audio file
    // 3. User can submit Token + answer to api, and then we check for correctness

    public function generate(int $chars = 6): array {
        $token  = Str::uuid()->toString();
        $answer = Str::upper(Str::random($chars));

        Cache::put(
            "audio_captcha:{$token}",
            hash('sha256', $answer),
            now()->addMinutes(5)
        );

        return [
            'token'   => $token,
            'mp3Link' => route('audio-captcha.audio', ['token' => $token]),
        ];
    }

    public function validate(string $token, string $input): bool {
        $cacheKey = "audio_captcha:{$token}";
        $expected = Cache::get($cacheKey);

        if (! $expected) {
            return false;
        }

        Cache::forget($cacheKey);

        return hash_equals(
            $expected,
            hash('sha256', strtoupper($input))
        );
    }

    public function generateAudio(string $answer): string
    {
        $answer = strtolower($answer);
        $lettersPath = storage_path('app/captcha/letters');
        $tmpPath     = storage_path('app/captcha/tmp');
        $publicDisk  = Storage::disk('public');

        if (! is_dir($tmpPath)) {
            mkdir($tmpPath, 0755, true);
        }

        $id = Str::uuid()->toString();

        $listFile   = "$tmpPath/{$id}.txt";
        $silenceMp3 = "$tmpPath/silence.mp3";
        $outputMp3  = "$tmpPath/{$id}.mp3";

        if (! file_exists($silenceMp3)) {
            exec(
                "ffmpeg -f lavfi -i anullsrc=r=44100:cl=mono -t 0.3 -q:a 9 -acodec libmp3lame $silenceMp3"
            );
        }

        $lines = [];

        foreach (str_split($answer) as $char) {
            $file = "$lettersPath/{$char}.mp3";

            if (! file_exists($file)) {
                throw new \RuntimeException("Missing audio file for [$char]");
            }

            $lines[] = "file '$file'";
            $lines[] = "file '$silenceMp3'";
        }

        file_put_contents($listFile, implode("\n", $lines));

        // Concatenate
        exec(
            "ffmpeg -y -f concat -safe 0 -i $listFile -c copy $outputMp3"
        );

        // Move to public disk
        // TODO: clean these up periodically
        $publicPath = "captcha/tmp/{$id}.mp3";
        $publicDisk->put(
            $publicPath,
            file_get_contents($outputMp3)
        );

        // Cleanup temp files
        unlink($listFile);
        unlink($outputMp3);

        // Temporary URL (5 minutes)
        return $publicDisk->temporaryUrl(
            $publicPath,
            now()->addMinutes(5)
        );
    }

}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CleanupTmpFiles extends Command
{
    protected $signature = 'tmp:cleanup {--minutes=10 : Delete files older than this}';
    protected $description = 'Delete old temporary files in storage/app/public/tmp';

    public function handle(): int
    {
        $disk = Storage::disk('public');
        $path = 'captcha/tmp';
        $maxAgeMinutes = (int) $this->option('minutes');

        if (! $disk->exists($path)) {
            $this->info('No tmp directory found.');
            return self::SUCCESS;
        }

        $now = now();

        foreach ($disk->allFiles($path) as $file) {
            $lastModified = Carbon::createFromTimestamp(
                $disk->lastModified($file)
            );

            if ($lastModified->diffInMinutes($now) >= $maxAgeMinutes) {
                $disk->delete($file);
                $this->line("Deleted: {$file}");
            }
        }

        return self::SUCCESS;
    }
}

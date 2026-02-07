<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class GenerateAudio extends Command
{
    // The command signature
    protected $signature = 'gen:audio';

    // Command description
    protected $description = 'Generate audio files using gen.py';

    public function handle()
    {
        $this->info('Running gen.py...');

        // Make sure the path to gen.py is correct
        $process = new Process(['python3', base_path('gen.py')]);
        $process->setTimeout(300); // 5 minutes max

        $process->run(function ($type, $buffer) {
            echo $buffer;
        });

        if (!$process->isSuccessful()) {
            $this->error('gen.py failed!');
            return 1; // exit code 1 for failure
        }

        $this->info('Audio generation complete!');
        return 0;
    }
}

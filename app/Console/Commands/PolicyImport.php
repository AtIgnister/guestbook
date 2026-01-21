<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PrivacyPolicy;

class PolicyImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'policy:import {policy? : Name of the policy template}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports a privacy policy.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $policy = $this->argument('policy') 
            ??  'default';

        if (! view()->exists($policy)) {
            $this->error("Policy template '{$policy}' does not exist.");
            return self::FAILURE;
        }

        $content = view($policy)->render();

        PrivacyPolicy::create([
            'content' => $content,
            'change_summary' => "Imported policy: {$policy}",
        ]);

        $this->info('Policy imported successfully.');
        return self::SUCCESS;
    }
}

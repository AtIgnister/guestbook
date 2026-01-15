<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invite;

class ClearInvites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:clear-invites';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all invites older than 1 month from invites table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Calculate cutoff date (30 days ago)
        $cutoff = Carbon::now()->subMonth();

        // Delete old invites
        $count = Invite::where('created_at', '<', $cutoff)->delete();

        $this->info("Deleted $count invites older than 1 month.");

        return 0;
    }
}

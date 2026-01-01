<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GuestbookEntryIp;
use Illuminate\Support\Carbon;

class ClearGuestbookIps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'guestbook:clear-ips';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all hashed IPs older than 1 month from guestbook table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Calculate cutoff date (30 days ago)
        $cutoff = Carbon::now()->subMonth();

        // Delete old IPs
        $count = GuestbookEntryIp::where('created_at', '<', $cutoff)->delete();

        $this->info("Deleted $count hashed IP(s) older than 1 month.");

        return 0;
    }
}

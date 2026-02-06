<?php

namespace Database\Factories;

use App\Models\GuestbookEntries;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GuestbookEntryIp>
 */
class GuestbookEntryIpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(){
        return [
            'guestbook_entries_id' => GuestbookEntries::factory(),
            'ip_hash' => hash('sha256', $this->faker->ipv4()),
        ];
    }

}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\GuestbookEntryIp;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IpBan>
 */
class IpBanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'guestbook_entry_ip_id' => GuestbookEntryIp::factory(), // link to an IP
            'guestbook_id' => null, // nullable
            'is_global' => false, // default local ban
        ];
    }
}

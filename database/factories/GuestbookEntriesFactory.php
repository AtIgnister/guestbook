<?php

namespace Database\Factories;

use App\Models\Guestbook;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GuestbookEntries>
 */
class GuestbookEntriesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'guestbook_id' => Guestbook::factory(),
            'name' => $this->faker->name(),
            'comment' => $this->faker->sentence(),
            'posted_at' => now(),
        ];
    }
}

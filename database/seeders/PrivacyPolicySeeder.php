<?php

namespace Database\Seeders;

use App\Models\PrivacyPolicy;
use Illuminate\Database\Seeder;

class PrivacyPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(PrivacyPolicy::exists()) {
            return;
        }

        $content = view('default')->render();

        $policy = PrivacyPolicy::create(
            [
                "content" => $content,
                "change_summary" => "Initial Version",
            ]
        );

        $policy->publish();
    }
}

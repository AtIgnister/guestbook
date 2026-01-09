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

        $defaultPolicyFile = config_path(env("DEFAULT_PRIVACY_POLICY"));
        $content = file_get_contents($defaultPolicyFile);

        $policy = PrivacyPolicy::create(
            [
                "content" => $content,
                "change_summary" => "Initial Version",
            ]
        );

        $policy->publish();
    }
}

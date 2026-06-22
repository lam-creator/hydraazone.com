<?php

namespace Database\Seeders;

use App\Models\WebsiteSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebsiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create default website settings
        WebsiteSettings::create([
            'logo' => '',
            'company_name' => 'Hydraa Zone',
            'company_slogan' => 'hydraazone - Best Quality products at Affordable Prices',
            'phone' => '01611000000',
            'support_phone' => '01722000000',
            'email' => 'info@hydraazone.com',
            'company_address' => '25/38 Rajabari, Savar, Dhaka-1340, Bangladesh',
            'facebook_url' => 'https://www.facebook.com/hydraazone',
            'twitter_url' => 'https://x.com/',
            'youtube_url' => 'https://www.youtube.com/',
            'instagram_url' => 'https://www.instagram.com/',
            'android_app_url' => 'https://play.google.com/store/apps',
            'ios_app_url' => 'https://www.apple.com/in/app-store/',
            'copyright' => 'Copyright &copy;  Hydraa Zone 2026 All rights reserved',
            'meta_title' => 'Hydraa Zone Home',
            'meta_description' => 'Hydraa Zone',
            'meta_keywords' => 'Hydraa Zone, hydraazone, hydra a zone, hydraazone.com',
            'user_id' => '1',
        ]);

    }
}

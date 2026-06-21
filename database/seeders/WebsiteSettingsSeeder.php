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
            'company_name' => 'MA IMPORT AND SUPPLIER',
            'company_slogan' => 'MA IMPORT AND SUPPLIER - Best Quality Chinese products at Affordable Prices',
            'phone' => '01609-272855',
            'support_phone' => '01609-272855',
            'email' => 'info@maimportandsupplier.com',
            'company_address' => '25/38 Rajabari, Savar, Dhaka-1340, Bangladesh',
            'facebook_url' => 'https://www.facebook.com/maimportandsupplier',
            'twitter_url' => 'https://x.com/',
            'youtube_url' => 'https://www.youtube.com/',
            'instagram_url' => 'https://www.instagram.com/',
            'android_app_url' => 'https://play.google.com/store/apps',
            'ios_app_url' => 'https://www.apple.com/in/app-store/',
            'copyright' => 'Copyright &copy;  MA IMPORT AND SUPPLIER 2026 All rights reserved',
            'meta_title' => 'MA IMPORT AND SUPPLIER Home',
            'meta_description' => 'MA IMPORT AND SUPPLIER',
            'meta_keywords' => 'MA IMPORT AND SUPPLIER, maimportandsupplier, ma import and supplier,ma-import-and-supplier',
            'user_id' => '1',
        ]);

    }
}

<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name',       'value' => 'رحلاتي',                    'group' => 'general'],
            ['key' => 'site_tagline_ar', 'value' => 'اكتشف العالم معنا',          'group' => 'general'],
            ['key' => 'site_tagline_en', 'value' => 'Discover the World With Us', 'group' => 'general'],

            // Contact
            ['key' => 'contact_phone',      'value' => '+201000000000',            'group' => 'contact'],
            ['key' => 'contact_email',      'value' => 'info@rehlatyy.com',         'group' => 'contact'],
            ['key' => 'contact_address_ar', 'value' => 'القاهرة، مصر',             'group' => 'contact'],
            ['key' => 'contact_address_en', 'value' => 'Cairo, Egypt',             'group' => 'contact'],
            ['key' => 'whatsapp_number',    'value' => '201000000000',             'group' => 'contact'],

            // Social
            ['key' => 'facebook_url',  'value' => '', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => '', 'group' => 'social'],
            ['key' => 'tiktok_url',    'value' => '', 'group' => 'social'],
            ['key' => 'youtube_url',   'value' => '', 'group' => 'social'],
        ];

        foreach ($settings as $s) {
            Setting::firstOrCreate(['key' => $s['key']], $s);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['ar' => 'مصر',      'en' => 'Egypt',        'slug' => 'egypt',        'flag' => '🇪🇬'],
            ['ar' => 'الإمارات', 'en' => 'UAE',           'slug' => 'uae',          'flag' => '🇦🇪'],
            ['ar' => 'السعودية', 'en' => 'Saudi Arabia',  'slug' => 'saudi-arabia', 'flag' => '🇸🇦'],
            ['ar' => 'الأردن',   'en' => 'Jordan',        'slug' => 'jordan',       'flag' => '🇯🇴'],
            ['ar' => 'تركيا',    'en' => 'Turkey',        'slug' => 'turkey',       'flag' => '🇹🇷'],
            ['ar' => 'اليونان',  'en' => 'Greece',        'slug' => 'greece',       'flag' => '🇬🇷'],
            ['ar' => 'إيطاليا',  'en' => 'Italy',         'slug' => 'italy',        'flag' => '🇮🇹'],
        ];

        foreach ($countries as $data) {
            Country::firstOrCreate(
                ['slug' => $data['slug']],
                [
                    'name'      => ['ar' => $data['ar'], 'en' => $data['en']],
                    'flag'      => $data['flag'],
                    'is_active' => true,
                ]
            );
        }
    }
}

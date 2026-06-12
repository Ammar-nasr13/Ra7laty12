<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    public function run(): void
    {
        $egyptId = Country::where('slug', '=', 'egypt')->value('id');

        $destinations = [
            [
                'data' => [
                    'country_id'  => $egyptId,
                    'name'        => ['ar' => 'الغردقة', 'en' => 'Hurghada'],
                    'description' => [
                        'ar' => 'مدينة ساحلية رائعة على البحر الأحمر، مشهورة بشعابها المرجانية وشواطئها الذهبية ورياضات الغوص والسنوركل.',
                        'en' => 'A stunning coastal city on the Red Sea, famous for its coral reefs, golden beaches, and world-class diving.',
                    ],
                    'category'    => 'beach',
                    'is_featured' => true,
                    'sort_order'  => 1,
                    'meta_title'    => ['ar' => 'الغردقة — شواطئ البحر الأحمر وغوص المرجان', 'en' => 'Hurghada — Red Sea Beaches & Coral Diving'],
                    'meta_desc'     => ['ar' => 'اكتشف الغردقة، مدينة البحر الأحمر ذات الشعاب المرجانية والشواطئ الذهبية ورياضات الغوص والسنوركل العالمية.', 'en' => 'Discover Hurghada — the Red Sea city with world-famous coral reefs, golden beaches & thrilling water sports.'],
                    'meta_keywords' => ['ar' => 'الغردقة, البحر الأحمر, غوص, شعاب مرجانية, سياحة مصر, رحلاتي', 'en' => 'hurghada, red sea, diving, coral reefs, egypt beach tourism, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1566438480900-0609be27a4be?w=1200&q=80',
            ],
            [
                'data' => [
                    'country_id'  => $egyptId,
                    'name'        => ['ar' => 'شرم الشيخ', 'en' => 'Sharm El-Sheikh'],
                    'description' => [
                        'ar' => 'جنة الشعاب المرجانية والمنتجعات الفاخرة بين جبال سيناء وأزرق البحر الأحمر.',
                        'en' => 'Paradise of coral reefs and luxury resorts nestled between the Sinai mountains and the Red Sea.',
                    ],
                    'category'    => 'beach',
                    'is_featured' => true,
                    'sort_order'  => 2,
                    'meta_title'    => ['ar' => 'شرم الشيخ — جنة المرجان والمنتجعات الفاخرة', 'en' => 'Sharm El-Sheikh — Coral Reefs & Luxury Resorts'],
                    'meta_desc'     => ['ar' => 'استكشف شرم الشيخ بشعابها المرجانية الخلابة ومنتجعاتها الفاخرة بين جبال سيناء وأزرق البحر الأحمر.', 'en' => 'Explore Sharm El-Sheikh with stunning coral reefs and luxury resorts between the Sinai mountains & Red Sea.'],
                    'meta_keywords' => ['ar' => 'شرم الشيخ, سيناء, البحر الأحمر, منتجعات, شعاب مرجانية, سياحة مصر, رحلاتي', 'en' => 'sharm el sheikh, sinai, red sea, luxury resorts, coral reefs, egypt tourism, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=1200&q=80',
            ],
            [
                'data' => [
                    'country_id'  => $egyptId,
                    'name'        => ['ar' => 'الأقصر وأسوان', 'en' => 'Luxor & Aswan'],
                    'description' => [
                        'ar' => 'معابد الفراعنة ووادي الملوك الأسطوري والإبحار على النيل بين الحضارات.',
                        'en' => 'Pharaonic temples, the Valley of the Kings, and Nile cruises between ancient civilizations.',
                    ],
                    'category'    => 'heritage',
                    'is_featured' => true,
                    'sort_order'  => 3,
                    'meta_title'    => ['ar' => 'الأقصر وأسوان — كنوز الفراعنة على النيل', 'en' => 'Luxor & Aswan — Pharaonic Treasures on the Nile'],
                    'meta_desc'     => ['ar' => 'اكتشف أسرار الحضارة الفرعونية بين معابد الكرنك وأبو سمبل ووادي الملوك ورحلات النيل في الأقصر وأسوان.', 'en' => 'Uncover ancient Egypt in Luxor & Aswan — Karnak temples, Abu Simbel, Valley of the Kings & Nile cruises.'],
                    'meta_keywords' => ['ar' => 'الأقصر, أسوان, معابد فرعونية, وادي الملوك, رحلة النيل, سياحة مصر, رحلاتي', 'en' => 'luxor, aswan, pharaonic temples, valley of kings, nile cruise, egypt tourism, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1568322445389-f64ac2515020?w=1200&q=80',
            ],
            [
                'data' => [
                    'country_id'  => $egyptId,
                    'name'        => ['ar' => 'القاهرة', 'en' => 'Cairo'],
                    'description' => [
                        'ar' => 'قلب مصر النابض بين الأهرامات والمتحف المصري وأزقة الحي الإسلامي العريق.',
                        'en' => 'The beating heart of Egypt between the Pyramids, the Egyptian Museum, and the ancient Islamic Quarter.',
                    ],
                    'category'    => 'culture',
                    'is_featured' => true,
                    'sort_order'  => 4,
                    'meta_title'    => ['ar' => 'القاهرة — الأهرامات والحضارة والتاريخ', 'en' => 'Cairo — Pyramids, Civilization & History'],
                    'meta_desc'     => ['ar' => 'استكشف القاهرة بين أهرامات الجيزة والمتحف المصري والحي الإسلامي العريق في عاصمة مصر النابضة بالحياة.', 'en' => 'Explore Cairo between the Giza Pyramids, the Egyptian Museum & the ancient Islamic Quarter — Egypt\'s capital.'],
                    'meta_keywords' => ['ar' => 'القاهرة, أهرامات الجيزة, المتحف المصري, الحي الإسلامي, سياحة مصر, رحلاتي', 'en' => 'cairo, giza pyramids, egyptian museum, islamic quarter, egypt tourism, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1539768942893-daf525e2a97e?w=1200&q=80',
            ],
            [
                'data' => [
                    'country_id'  => $egyptId,
                    'name'        => ['ar' => 'مرسى مطروح', 'en' => 'Marsa Matrouh'],
                    'description' => [
                        'ar' => 'أنقى شواطئ البحر المتوسط بمياهه الفيروزية الشفافة ورماله الناصعة البياض.',
                        'en' => "The Mediterranean's purest beaches with crystal-clear turquoise waters and pristine white sands.",
                    ],
                    'category'    => 'beach',
                    'is_featured' => false,
                    'sort_order'  => 5,
                    'meta_title'    => ['ar' => 'مرسى مطروح — أنقى شواطئ البحر المتوسط', 'en' => "Marsa Matrouh — The Mediterranean's Purest Beaches"],
                    'meta_desc'     => ['ar' => 'اكتشف مرسى مطروح بمياهها الفيروزية النقية ورمالها البيضاء الناصعة على ساحل البحر المتوسط في مصر.', 'en' => 'Discover Marsa Matrouh with crystal-clear turquoise waters and pristine white sands on Egypt\'s Mediterranean coast.'],
                    'meta_keywords' => ['ar' => 'مرسى مطروح, البحر المتوسط, شواطئ بيضاء, مياه فيروزية, سياحة مصر, رحلاتي', 'en' => 'marsa matrouh, mediterranean beach, white sands, turquoise water, egypt tourism, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1200&q=80',
            ],
            [
                'data' => [
                    'country_id'  => $egyptId,
                    'name'        => ['ar' => 'سيناء', 'en' => 'Sinai'],
                    'description' => [
                        'ar' => 'جبال سيناء الشاهقة وجبل موسى المقدس وشواطئ العقبة الرائعة.',
                        'en' => 'The towering Sinai mountains, sacred Mount Moses, and the stunning Gulf of Aqaba beaches.',
                    ],
                    'category'    => 'adventure',
                    'is_featured' => false,
                    'sort_order'  => 6,
                    'meta_title'    => ['ar' => 'سيناء — الجبال المقدسة وشواطئ العقبة', 'en' => 'Sinai — Sacred Mountains & Gulf of Aqaba'],
                    'meta_desc'     => ['ar' => 'استكشف سيناء بين جبالها الشاهقة وجبل موسى المقدس وشواطئ خليج العقبة الرائعة في قلب مصر.', 'en' => 'Explore Sinai between its towering mountains, sacred Mount Moses & the stunning Gulf of Aqaba beaches.'],
                    'meta_keywords' => ['ar' => 'سيناء, جبل موسى, خليج العقبة, مغامرة, رحلة جبلية, سياحة مصر, رحلاتي', 'en' => 'sinai, mount moses, gulf of aqaba, adventure, hiking, egypt tourism, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1469041797191-50ace28483c3?w=1200&q=80',
            ],
        ];

        foreach ($destinations as $item) {
            $destination = Destination::updateOrCreate(
                ['sort_order' => $item['data']['sort_order']],
                $item['data']
            );

            if (!$destination->hasMedia('image')) {
                try {
                    $destination->addMediaFromUrl($item['image'])
                        ->toMediaCollection('image');
                } catch (\Exception) {
                    // No internet or URL unavailable — site uses CSS gradients as fallback
                }
            }
        }
    }
}

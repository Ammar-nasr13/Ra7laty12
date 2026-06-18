<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AppwriteService;
use Illuminate\Support\Facades\Hash;

class AppwriteSeedCommand extends Command
{
    protected $signature = 'appwrite:seed {--fresh : Clear existing documents before seeding}';
    protected $description = 'Seed default data (countries, destinations, trips, testimonials, settings, admins) to Appwrite';

    protected AppwriteService $appwrite;

    public function __construct(AppwriteService $appwrite)
    {
        parent::__construct();
        $this->appwrite = $appwrite;
    }

    public function handle(): int
    {
        $this->info('Starting Appwrite Database Seeder...');
        
        $dbId = $this->appwrite->getDatabaseId();
        if (empty($dbId) || $dbId === 'your_appwrite_database_id_here') {
            $this->error('Error: Please configure your APPWRITE_DATABASE_ID in the .env file first.');
            return 1;
        }

        try {
            // Optional: Clear existing data
            if ($this->option('fresh')) {
                $this->clearCollections();
            }

            // 1. Seed Settings
            $this->seedSettings();

            // 2. Seed Admins
            $this->seedAdmins();

            // 3. Seed Testimonials
            $this->seedTestimonials();

            // 4. Seed Countries (returns map of slug => appwrite_id)
            $countryMap = $this->seedCountries();

            // 5. Seed Destinations (returns map of sort_order => appwrite_id)
            $destinationMap = $this->seedDestinations($countryMap);

            // 6. Seed Trips
            $this->seedTrips($destinationMap);

            $this->info('Appwrite Database Seeding completed successfully!');
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Seeding failed: ' . $e->getMessage());
            return 1;
        }
    }

    protected function clearCollections(): void
    {
        $collections = ['settings', 'admins', 'testimonials', 'countries', 'destinations', 'trips'];
        foreach ($collections as $col) {
            $this->comment("Clearing collection: {$col}...");
            $documents = $this->appwrite->list($col);
            foreach ($documents as $doc) {
                $this->appwrite->delete($col, $doc['$id']);
            }
        }
    }

    protected function seedSettings(): void
    {
        $this->comment('Seeding Settings...');
        $settings = [
            ['key' => 'site_name',       'value' => 'رحلاتي'],
            ['key' => 'site_tagline_ar', 'value' => 'اكتشف العالم معنا'],
            ['key' => 'site_tagline_en', 'value' => 'Discover the World With Us'],
            ['key' => 'contact_phone',      'value' => '+201000000000'],
            ['key' => 'contact_email',      'value' => 'info@rehlatyy.com'],
            ['key' => 'contact_address_ar', 'value' => 'القاهرة، مصر'],
            ['key' => 'contact_address_en', 'value' => 'Cairo, Egypt'],
            ['key' => 'whatsapp_number',    'value' => '201000000000'],
            ['key' => 'facebook_url',  'value' => 'https://facebook.com'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com'],
            ['key' => 'tiktok_url',    'value' => 'https://tiktok.com'],
            ['key' => 'youtube_url',   'value' => 'https://youtube.com'],
        ];

        foreach ($settings as $s) {
            // Check if exists
            $existing = $this->appwrite->list('settings', [\Appwrite\Query::equal('key', $s['key'])]);
            if (empty($existing)) {
                $this->appwrite->create('settings', $s);
            }
        }
    }

    protected function seedAdmins(): void
    {
        $this->comment('Seeding Admin accounts...');
        $admins = [
            [
                'name' => 'المدير العام',
                'email' => 'admin@rahalaty.com',
                'password' => Hash::make('123456789'),
                'role' => 'super_admin',
            ]
        ];

        foreach ($admins as $admin) {
            $existing = $this->appwrite->list('admins', [\Appwrite\Query::equal('email', $admin['email'])]);
            if (empty($existing)) {
                $this->appwrite->create('admins', $admin);
            }
        }
    }

    protected function seedTestimonials(): void
    {
        $this->comment('Seeding Testimonials...');
        $testimonials = [
            [
                'name' => 'أحمد محمد',
                'rating' => 5,
                'comment_ar' => 'تجربة رائعة جداً! الرحلة إلى الغردقة كانت أكثر من رائعة، الفندق ممتاز والخدمة احترافية.',
                'comment_en' => 'A wonderful experience! The Hurghada trip was awesome, the hotel was excellent, and the service was professional.',
                'avatar_url' => 'https://i.pravatar.cc/200?img=11',
                'is_active' => true,
            ],
            [
                'name' => 'مي السيد',
                'rating' => 5,
                'comment_ar' => 'سافرنا كعائلة إلى الأقصر وأسوان وكانت رحلة لا تُنسى، الأطفال أحبوها جداً وشعرنا بالتاريخ المصري العريق.',
                'comment_en' => 'We traveled as a family to Luxor & Aswan; it was an unforgettable trip. The kids loved it, and we felt the deep history.',
                'avatar_url' => 'https://i.pravatar.cc/200?img=47',
                'is_active' => true,
            ],
            [
                'name' => 'كريم علي',
                'rating' => 5,
                'comment_ar' => 'حجزت رحلة تركيا وكان كل شيء مرتب بشكل احترافي من الفندق للجولات. سأحجز مرة ثانية بالتأكيد.',
                'comment_en' => 'I booked the Turkey trip. Everything was professionally arranged, from hotel to tours. Will book again!',
                'avatar_url' => 'https://i.pravatar.cc/200?img=33',
                'is_active' => true,
            ],
            [
                'name' => 'سارة حسن',
                'rating' => 4,
                'comment_ar' => 'رحلة بالي كانت حلماً أصبح حقيقة، الطبيعة الخلابة والمعابد الجميلة، شكراً رحلاتي!',
                'comment_en' => 'Bali trip was a dream come true. Gorgeous nature and beautiful temples. Thank you Rahalaty!',
                'avatar_url' => 'https://i.pravatar.cc/200?img=56',
                'is_active' => true,
            ],
            [
                'name' => 'عمر خالد',
                'rating' => 5,
                'comment_ar' => 'أفضل خدمة وأفضل أسعار، رحلة دبي كانت ممتازة وسيكون رحلاتي هو خياري دائماً للسفر.',
                'comment_en' => 'Best service and prices. The Dubai trip was excellent. Rahalaty will always be my choice for travel.',
                'avatar_url' => 'https://i.pravatar.cc/200?img=68',
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $t) {
            $existing = $this->appwrite->list('testimonials', [\Appwrite\Query::equal('name', $t['name'])]);
            if (empty($existing)) {
                $this->appwrite->create('testimonials', $t);
            }
        }
    }

    protected function seedCountries(): array
    {
        $this->comment('Seeding Countries...');
        $countries = [
            ['name_ar' => 'مصر',      'name_en' => 'Egypt',        'slug' => 'egypt',        'flag' => '🇪🇬'],
            ['name_ar' => 'الإمارات', 'name_en' => 'UAE',           'slug' => 'uae',          'flag' => '🇦🇪'],
            ['name_ar' => 'السعودية', 'name_en' => 'Saudi Arabia',  'slug' => 'saudi-arabia', 'flag' => '🇸🇦'],
            ['name_ar' => 'الأردن',   'name_en' => 'Jordan',        'slug' => 'jordan',       'flag' => '🇯🇴'],
            ['name_ar' => 'تركيا',    'name_en' => 'Turkey',        'slug' => 'turkey',       'flag' => '🇹🇷'],
            ['name_ar' => 'اليونان',  'name_en' => 'Greece',        'slug' => 'greece',       'flag' => '🇬🇷'],
            ['name_ar' => 'إيطاليا',  'name_en' => 'Italy',         'slug' => 'italy',        'flag' => '🇮🇹'],
        ];

        $map = [];
        foreach ($countries as $c) {
            $existing = $this->appwrite->list('countries', [\Appwrite\Query::equal('slug', $c['slug'])]);
            if (empty($existing)) {
                $doc = $this->appwrite->create('countries', array_merge($c, ['is_active' => true]));
                $map[$c['slug']] = $doc['$id'];
            } else {
                $map[$c['slug']] = $existing[0]['$id'];
            }
        }
        return $map;
    }

    protected function seedDestinations(array $countryMap): array
    {
        $this->comment('Seeding Destinations...');
        $egyptId = $countryMap['egypt'] ?? null;

        $destinations = [
            [
                'name_ar' => 'الغردقة', 'name_en' => 'Hurghada',
                'description_ar' => 'مدينة ساحلية رائعة على البحر الأحمر، مشهورة بشعابها المرجانية وشواطئها الذهبية ورياضات الغوص والسنوركل.',
                'description_en' => 'A stunning coastal city on the Red Sea, famous for its coral reefs, golden beaches, and world-class diving.',
                'category' => 'beach', 'is_featured' => true, 'sort_order' => 1,
                'meta_title_ar' => 'الغردقة — شواطئ البحر الأحمر وغوص المرجان', 'meta_title_en' => 'Hurghada — Red Sea Beaches & Coral Diving',
                'meta_desc_ar' => 'اكتشف الغردقة، مدينة البحر الأحمر ذات الشعاب المرجانية والشواطئ الذهبية ورياضات الغوص والسنوركل العالمية.', 'meta_desc_en' => 'Discover Hurghada — the Red Sea city with world-famous coral reefs, golden beaches & thrilling water sports.',
                'meta_keywords_ar' => 'الغردقة, البحر الأحمر, غوص, شعاب مرجانية, سياحة مصر, رحلاتي', 'meta_keywords_en' => 'hurghada, red sea, diving, coral reefs, egypt beach tourism, rahalaty',
                'image_url' => 'https://images.unsplash.com/photo-1566438480900-0609be27a4be?w=1200&q=80',
                'country_id' => $egyptId
            ],
            [
                'name_ar' => 'شرم الشيخ', 'name_en' => 'Sharm El-Sheikh',
                'description_ar' => 'جنة الشعاب المرجانية والمنتجعات الفاخرة بين جبال سيناء وأزرق البحر الأحمر.',
                'description_en' => 'Paradise of coral reefs and luxury resorts nestled between the Sinai mountains and the Red Sea.',
                'category' => 'beach', 'is_featured' => true, 'sort_order' => 2,
                'meta_title_ar' => 'شرم الشيخ — جنة المرجان والمنتجعات الفاخرة', 'meta_title_en' => 'Sharm El-Sheikh — Coral Reefs & Luxury Resorts',
                'meta_desc_ar' => 'استكشف شرم الشيخ بشعابها المرجانية الخلابة ومنتجعاتها الفاخرة بين جبال سيناء وأزرق البحر الأحمر.', 'meta_desc_en' => 'Explore Sharm El-Sheikh with stunning coral reefs and luxury resorts between the Sinai mountains & Red Sea.',
                'meta_keywords_ar' => 'شرم الشيخ, سيناء, البحر الأحمر, منتجعات, شعاب مرجانية, سياحة مصر, رحلاتي', 'meta_keywords_en' => 'sharm el sheikh, sinai, red sea, luxury resorts, coral reefs, egypt tourism, rahalaty',
                'image_url' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=1200&q=80',
                'country_id' => $egyptId
            ],
            [
                'name_ar' => 'الأقصر وأسوان', 'name_en' => 'Luxor & Aswan',
                'description_ar' => 'معابد الفراعنة ووادي الملوك الأسطوري والإبحار على النيل بين الحضارات.',
                'description_en' => 'Pharaonic temples, the Valley of the Kings, and Nile cruises between ancient civilizations.',
                'category' => 'heritage', 'is_featured' => true, 'sort_order' => 3,
                'meta_title_ar' => 'الأقصر وأسوان — كنوز الفراعنة على النيل', 'meta_title_en' => 'Luxor & Aswan — Pharaonic Treasures on the Nile',
                'meta_desc_ar' => 'اكتشف أسرار الحضارة الفرعونية بين معابد الكرنك وأبو سمبل ووادي الملوك ورحلات النيل في الأقصر وأسوان.', 'meta_desc_en' => 'Uncover ancient Egypt in Luxor & Aswan — Karnak temples, Abu Simbel, Valley of the Kings & Nile cruises.',
                'meta_keywords_ar' => 'الأقصر, أسوان, معابد فرعونية, وادي الملوك, رحلة النيل, سياحة مصر, رحلاتي', 'meta_keywords_en' => 'luxor, aswan, pharaonic temples, valley of kings, nile cruise, egypt tourism, rahalaty',
                'image_url' => 'https://images.unsplash.com/photo-1568322445389-f64ac2515020?w=1200&q=80',
                'country_id' => $egyptId
            ],
            [
                'name_ar' => 'القاهرة', 'name_en' => 'Cairo',
                'description_ar' => 'قلب مصر النابض بين الأهرامات والمتحف المصري وأزقة الحي الإسلامي العريق.',
                'description_en' => 'The beating heart of Egypt between the Pyramids, the Egyptian Museum, and the ancient Islamic Quarter.',
                'category' => 'culture', 'is_featured' => true, 'sort_order' => 4,
                'meta_title_ar' => 'القاهرة — الأهرامات والحضارة والتاريخ', 'meta_title_en' => 'Cairo — Pyramids, Civilization & History',
                'meta_desc_ar' => 'استكشف القاهرة بين أهرامات الجيزة والمتحف المصري والحي الإسلامي العريق في عاصمة مصر النابضة بالحياة.', 'meta_desc_en' => 'Explore Cairo between the Giza Pyramids, the Egyptian Museum & the ancient Islamic Quarter — Egypt\'s capital.',
                'meta_keywords_ar' => 'القاهرة, أهرامات الجيزة, المتحف المصري, الحي الإسلامي, سياحة مصر, رحلاتي', 'meta_keywords_en' => 'cairo, giza pyramids, egyptian museum, islamic quarter, egypt tourism, rahalaty',
                'image_url' => 'https://images.unsplash.com/photo-1539768942893-daf525e2a97e?w=1200&q=80',
                'country_id' => $egyptId
            ],
        ];

        $map = [];
        foreach ($destinations as $d) {
            $existing = $this->appwrite->list('destinations', [\Appwrite\Query::equal('sort_order', $d['sort_order'])]);
            if (empty($existing)) {
                $doc = $this->appwrite->create('destinations', $d);
                $map[$d['sort_order']] = $doc['$id'];
            } else {
                $map[$d['sort_order']] = $existing[0]['$id'];
            }
        }
        return $map;
    }

    protected function seedTrips(array $destMap): void
    {
        $this->comment('Seeding Trips...');
        
        $trips = [
            [
                'title_ar' => 'غردقة الساحرة', 'title_en' => 'Magical Hurghada',
                'desc_ar' => 'استمتع بشواطئ الغردقة الرائعة وغوص في أعماق البحر الأحمر، رحلة لا تُنسى بأسعار مناسبة.', 'desc_en' => 'Enjoy the stunning beaches of Hurghada and dive into the Red Sea depths — an unforgettable trip at affordable prices.',
                'highlights_ar' => ['غوص وسنوركل', 'رياضات مائية', 'رحلة صحراوية', 'كورنيش الغردقة'], 'highlights_en' => ['Diving & Snorkeling', 'Water Sports', 'Desert Safari', 'Hurghada Corniche'],
                'price' => 350.00, 'currency' => '$', 'duration' => 5,
                'category' => 'beach', 'climate' => 'beach', 'travel_type' => ['family', 'couple', 'friends'],
                'budget_tier' => 'low', 'color_from' => '#0099CC', 'color_to' => '#FF6633',
                'is_egyptian' => true, 'spots_total' => 20, 'spots_left' => 5,
                'departure_dates' => ['2026-06-20', '2026-07-10', '2026-08-05', '2026-09-01'],
                'is_active' => true, 'sort_order' => 1,
                'meta_title_ar' => 'رحلة الغردقة الساحرة — شواطئ البحر الأحمر', 'meta_title_en' => 'Magical Hurghada — Red Sea Beaches & Diving',
                'meta_desc_ar' => 'رحلة 5 أيام في الغردقة مع غوص بالشعاب المرجانية ورياضات مائية وسفاري صحراوي مثير. احجز الآن مع رحلاتي من 350$.', 'meta_desc_en' => 'Enjoy 5 days in Hurghada with coral diving, water sports & desert safari. Book now with Rahalaty from $350.',
                'meta_keywords_ar' => 'رحلة الغردقة, البحر الأحمر, غوص, شعاب مرجانية, رياضات مائية, رحلاتي, سياحة مصر', 'meta_keywords_en' => 'hurghada trip, red sea diving, snorkeling, water sports, egypt beach, rahalaty',
                'image_url' => 'https://images.unsplash.com/photo-1566438480900-0609be27a4be?w=1200&q=80',
                'destination_id' => $destMap[1] ?? null
            ],
            [
                'title_ar' => 'شرم الشيخ الأسطوري', 'title_en' => 'Legendary Sharm El-Sheikh',
                'desc_ar' => 'جنة الشعاب المرجانية وأجمل شواطئ مصر في رحلة مثيرة بين الجبال والبحر.', 'desc_en' => "Paradise of coral reefs and Egypt's most beautiful beaches in an exciting journey between mountains and sea.",
                'highlights_ar' => ['نعمة باي', 'جزيرة تيران', 'سوق شرم', 'رحلة الصحراء'], 'highlights_en' => ['Naama Bay', 'Tiran Island', 'Sharm Market', 'Desert Trip'],
                'price' => 420.00, 'currency' => '$', 'duration' => 6,
                'category' => 'beach', 'climate' => 'beach', 'travel_type' => ['couple', 'family', 'friends'],
                'budget_tier' => 'low', 'color_from' => '#00B4D8', 'color_to' => '#F77F00',
                'is_egyptian' => true, 'spots_total' => 18, 'spots_left' => 3,
                'departure_dates' => ['2026-06-25', '2026-07-15', '2026-08-10'],
                'is_active' => true, 'sort_order' => 2,
                'meta_title_ar' => 'رحلة شرم الشيخ الأسطورية — جنة المرجان', 'meta_title_en' => 'Legendary Sharm El-Sheikh — Coral Reef Paradise',
                'meta_desc_ar' => 'رحلة 6 أيام في شرم الشيخ بين نعمة باي وجزيرة تيران والشعاب المرجانية الخلابة. احجز مع رحلاتي من 420$.', 'meta_desc_en' => '6-day Sharm El-Sheikh trip exploring Naama Bay, Tiran Island & stunning coral reefs from $420 with Rahalaty.',
                'meta_keywords_ar' => 'رحلة شرم الشيخ, نعمة باي, جزيرة تيران, شعاب مرجانية, سيناء, رحلاتي', 'meta_keywords_en' => 'sharm el sheikh trip, naama bay, tiran island, coral reefs, sinai, rahalaty',
                'image_url' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=1200&q=80',
                'destination_id' => $destMap[2] ?? null
            ],
            [
                'title_ar' => 'الأقصر وأسوان — أرض الفراعنة', 'title_en' => 'Luxor & Aswan — Land of Pharaohs',
                'desc_ar' => 'رحلة في أعماق التاريخ المصري القديم بين معابد الكرنك وأبو سمبل والمتحف الفرعوني.', 'desc_en' => 'A journey into ancient Egyptian history between Karnak temples, Abu Simbel, and the Pharaonic museum.',
                'highlights_ar' => ['معبد الكرنك', 'أبو سمبل', 'وادي الملوك', 'رحلة النيل'], 'highlights_en' => ['Karnak Temple', 'Abu Simbel', 'Valley of Kings', 'Nile Cruise'],
                'price' => 500.00, 'currency' => '$', 'duration' => 7,
                'category' => 'culture', 'climate' => 'desert', 'travel_type' => ['family', 'couple', 'solo'],
                'budget_tier' => 'medium', 'color_from' => '#8B4513', 'color_to' => '#C5A028',
                'is_egyptian' => true, 'spots_total' => 15, 'spots_left' => 9,
                'departure_dates' => ['2026-07-01', '2026-07-22', '2026-09-03'],
                'is_active' => true, 'sort_order' => 3,
                'meta_title_ar' => 'رحلة الأقصر وأسوان — أرض الفراعنة', 'meta_title_en' => 'Luxor & Aswan Tour — Land of Pharaohs',
                'meta_desc_ar' => 'رحلة 7 أيام بين معابد الكرنك وأبو سمبل ووادي الملوك ورحلة النيل. احجز مع رحلاتي من 500$.', 'meta_desc_en' => '7-day journey through Karnak temples, Abu Simbel & Valley of the Kings with a Nile cruise from $500.',
                'meta_keywords_ar' => 'رحلة الأقصر, أسوان, معبد الكرنك, أبو سمبل, وادي الملوك, رحلة النيل, رحلاتي', 'meta_keywords_en' => 'luxor tour, aswan trip, karnak temple, abu simbel, valley of kings, nile cruise, rahalaty',
                'image_url' => 'https://images.unsplash.com/photo-1568322445389-f64ac2515020?w=1200&q=80',
                'destination_id' => $destMap[3] ?? null
            ],
            [
                'title_ar' => 'باريس — مدينة الأنوار', 'title_en' => 'Paris — City of Lights',
                'desc_ar' => 'استكشف عاصمة الفنون والموضة، من برج إيفل إلى متحف اللوفر في رحلة رومانسية لا مثيل لها.', 'desc_en' => 'Explore the capital of arts and fashion, from the Eiffel Tower to the Louvre in an unparalleled romantic journey.',
                'highlights_ar' => ['برج إيفل', 'متحف اللوفر', 'الشانزليزيه', 'قصر فرساي'], 'highlights_en' => ['Eiffel Tower', 'Louvre Museum', 'Champs-Élysées', 'Palace of Versailles'],
                'price' => 1500.00, 'currency' => '$', 'duration' => 7,
                'category' => 'culture', 'climate' => 'city', 'travel_type' => ['couple', 'solo'],
                'budget_tier' => 'high', 'color_from' => '#003087', 'color_to' => '#ED2939',
                'is_egyptian' => false, 'spots_total' => 20, 'spots_left' => 12,
                'departure_dates' => ['2026-07-05', '2026-08-12', '2026-09-10'],
                'is_active' => true, 'sort_order' => 4,
                'meta_title_ar' => 'رحلة باريس — مدينة الأنوار والرومانسية', 'meta_title_en' => 'Paris Trip — City of Lights & Romance',
                'meta_desc_ar' => 'استكشف برج إيفل ومتحف اللوفر والشانزليزيه في رحلة 7 أيام إلى قلب أوروبا. احجز مع رحلاتي من 1500$.', 'meta_desc_en' => 'Explore the Eiffel Tower, Louvre & Champs-Élysées in a 7-day Paris journey. Book with Rahalaty from $1500.',
                'meta_keywords_ar' => 'رحلة باريس, برج إيفل, متحف اللوفر, فرنسا, رحلة رومانسية, رحلاتي', 'meta_keywords_en' => 'paris trip, eiffel tower, louvre museum, france tourism, romantic paris, rahalaty',
                'image_url' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=1200&q=80',
                'destination_id' => null
            ],
        ];

        foreach ($trips as $t) {
            $existing = $this->appwrite->list('trips', [\Appwrite\Query::equal('sort_order', $t['sort_order'])]);
            if (empty($existing)) {
                $this->appwrite->create('trips', $t);
            }
        }
    }
}

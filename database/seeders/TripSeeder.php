<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Trip;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    public function run(): void
    {
        // Map destination sort_order → id so we can assign destination_id below
        $destMap = Destination::pluck('id', 'sort_order');

        $trips = [
            [
                'data' => [
                    'title'           => ['ar' => 'غردقة الساحرة', 'en' => 'Magical Hurghada'],
                    'desc'            => ['ar' => 'استمتع بشواطئ الغردقة الرائعة وغوص في أعماق البحر الأحمر، رحلة لا تُنسى بأسعار مناسبة.', 'en' => 'Enjoy the stunning beaches of Hurghada and dive into the Red Sea depths — an unforgettable trip at affordable prices.'],
                    'highlights'      => ['ar' => ['غوص وسنوركل', 'رياضات مائية', 'رحلة صحراوية', 'كورنيش الغردقة'], 'en' => ['Diving & Snorkeling', 'Water Sports', 'Desert Safari', 'Hurghada Corniche']],
                    'destination_id'  => $destMap[1] ?? null,
                    'price' => 350, 'currency' => '$', 'duration' => 5,
                    'category' => 'beach', 'climate' => 'beach', 'travel_type' => ['family', 'couple', 'friends'],
                    'budget_tier' => 'low', 'color_from' => '#0099CC', 'color_to' => '#FF6633',
                    'is_egyptian' => true, 'spots_total' => 20, 'spots_left' => 5,
                    'departure_dates' => ['2026-06-20', '2026-07-10', '2026-08-05', '2026-09-01'],
                    'is_active' => true, 'sort_order' => 1,
                    'meta_title'    => ['ar' => 'رحلة الغردقة الساحرة — شواطئ البحر الأحمر', 'en' => 'Magical Hurghada — Red Sea Beaches & Diving'],
                    'meta_desc'     => ['ar' => 'رحلة 5 أيام في الغردقة مع غوص بالشعاب المرجانية ورياضات مائية وسفاري صحراوي مثير. احجز الآن مع رحلاتي من 350$.', 'en' => 'Enjoy 5 days in Hurghada with coral diving, water sports & desert safari. Book now with Rahalaty from $350.'],
                    'meta_keywords' => ['ar' => 'رحلة الغردقة, البحر الأحمر, غوص, شعاب مرجانية, رياضات مائية, رحلاتي, سياحة مصر', 'en' => 'hurghada trip, red sea diving, snorkeling, water sports, egypt beach, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1566438480900-0609be27a4be?w=1200&q=80',
            ],
            [
                'data' => [
                    'title'           => ['ar' => 'شرم الشيخ الأسطوري', 'en' => 'Legendary Sharm El-Sheikh'],
                    'desc'            => ['ar' => 'جنة الشعاب المرجانية وأجمل شواطئ مصر في رحلة مثيرة بين الجبال والبحر.', 'en' => "Paradise of coral reefs and Egypt's most beautiful beaches in an exciting journey between mountains and sea."],
                    'highlights'      => ['ar' => ['نعمة باي', 'جزيرة تيران', 'سوق شرم', 'رحلة الصحراء'], 'en' => ['Naama Bay', 'Tiran Island', 'Sharm Market', 'Desert Trip']],
                    'destination_id'  => $destMap[2] ?? null,
                    'price' => 420, 'currency' => '$', 'duration' => 6,
                    'category' => 'beach', 'climate' => 'beach', 'travel_type' => ['couple', 'family', 'friends'],
                    'budget_tier' => 'low', 'color_from' => '#00B4D8', 'color_to' => '#F77F00',
                    'is_egyptian' => true, 'spots_total' => 18, 'spots_left' => 3,
                    'departure_dates' => ['2026-06-25', '2026-07-15', '2026-08-10'],
                    'is_active' => true, 'sort_order' => 2,
                    'meta_title'    => ['ar' => 'رحلة شرم الشيخ الأسطورية — جنة المرجان', 'en' => 'Legendary Sharm El-Sheikh — Coral Reef Paradise'],
                    'meta_desc'     => ['ar' => 'رحلة 6 أيام في شرم الشيخ بين نعمة باي وجزيرة تيران والشعاب المرجانية الخلابة. احجز مع رحلاتي من 420$.', 'en' => '6-day Sharm El-Sheikh trip exploring Naama Bay, Tiran Island & stunning coral reefs from $420 with Rahalaty.'],
                    'meta_keywords' => ['ar' => 'رحلة شرم الشيخ, نعمة باي, جزيرة تيران, شعاب مرجانية, سيناء, رحلاتي', 'en' => 'sharm el sheikh trip, naama bay, tiran island, coral reefs, sinai, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=1200&q=80',
            ],
            [
                'data' => [
                    'title'           => ['ar' => 'الأقصر وأسوان — أرض الفراعنة', 'en' => 'Luxor & Aswan — Land of Pharaohs'],
                    'desc'            => ['ar' => 'رحلة في أعماق التاريخ المصري القديم بين معابد الكرنك وأبو سمبل والمتحف الفرعوني.', 'en' => 'A journey into ancient Egyptian history between Karnak temples, Abu Simbel, and the Pharaonic museum.'],
                    'highlights'      => ['ar' => ['معبد الكرنك', 'أبو سمبل', 'وادي الملوك', 'رحلة النيل'], 'en' => ['Karnak Temple', 'Abu Simbel', 'Valley of Kings', 'Nile Cruise']],
                    'destination_id'  => $destMap[3] ?? null,
                    'price' => 500, 'currency' => '$', 'duration' => 7,
                    'category' => 'culture', 'climate' => 'desert', 'travel_type' => ['family', 'couple', 'solo'],
                    'budget_tier' => 'medium', 'color_from' => '#8B4513', 'color_to' => '#C5A028',
                    'is_egyptian' => true, 'spots_total' => 15, 'spots_left' => 9,
                    'departure_dates' => ['2026-07-01', '2026-07-22', '2026-09-03'],
                    'is_active' => true, 'sort_order' => 3,
                    'meta_title'    => ['ar' => 'رحلة الأقصر وأسوان — أرض الفراعنة', 'en' => 'Luxor & Aswan Tour — Land of Pharaohs'],
                    'meta_desc'     => ['ar' => 'رحلة 7 أيام بين معابد الكرنك وأبو سمبل ووادي الملوك ورحلة النيل. احجز مع رحلاتي من 500$.', 'en' => '7-day journey through Karnak temples, Abu Simbel & Valley of the Kings with a Nile cruise from $500.'],
                    'meta_keywords' => ['ar' => 'رحلة الأقصر, أسوان, معبد الكرنك, أبو سمبل, وادي الملوك, رحلة النيل, رحلاتي', 'en' => 'luxor tour, aswan trip, karnak temple, abu simbel, valley of kings, nile cruise, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1568322445389-f64ac2515020?w=1200&q=80',
            ],
            [
                'data' => [
                    'title'           => ['ar' => 'باريس — مدينة الأنوار', 'en' => 'Paris — City of Lights'],
                    'desc'            => ['ar' => 'استكشف عاصمة الفنون والموضة، من برج إيفل إلى متحف اللوفر في رحلة رومانسية لا مثيل لها.', 'en' => 'Explore the capital of arts and fashion, from the Eiffel Tower to the Louvre in an unparalleled romantic journey.'],
                    'highlights'      => ['ar' => ['برج إيفل', 'متحف اللوفر', 'الشانزليزيه', 'قصر فرساي'], 'en' => ['Eiffel Tower', 'Louvre Museum', 'Champs-Élysées', 'Palace of Versailles']],
                    'destination_id'  => null,
                    'price' => 1500, 'currency' => '$', 'duration' => 7,
                    'category' => 'culture', 'climate' => 'city', 'travel_type' => ['couple', 'solo'],
                    'budget_tier' => 'high', 'color_from' => '#003087', 'color_to' => '#ED2939',
                    'is_egyptian' => false, 'spots_total' => 20, 'spots_left' => 12,
                    'departure_dates' => ['2026-07-05', '2026-08-12', '2026-09-10'],
                    'is_active' => true, 'sort_order' => 4,
                    'meta_title'    => ['ar' => 'رحلة باريس — مدينة الأنوار والرومانسية', 'en' => 'Paris Trip — City of Lights & Romance'],
                    'meta_desc'     => ['ar' => 'استكشف برج إيفل ومتحف اللوفر والشانزليزيه في رحلة 7 أيام إلى قلب أوروبا. احجز مع رحلاتي من 1500$.', 'en' => 'Explore the Eiffel Tower, Louvre & Champs-Élysées in a 7-day Paris journey. Book with Rahalaty from $1500.'],
                    'meta_keywords' => ['ar' => 'رحلة باريس, برج إيفل, متحف اللوفر, فرنسا, رحلة رومانسية, رحلاتي', 'en' => 'paris trip, eiffel tower, louvre museum, france tourism, romantic paris, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=1200&q=80',
            ],
            [
                'data' => [
                    'title'           => ['ar' => 'روما — العاصمة الأبدية', 'en' => 'Rome — The Eternal City'],
                    'desc'            => ['ar' => 'تجول في شوارع التاريخ بين الكولوسيوم والفاتيكان وينابيع تريفي في مدينة خالدة.', 'en' => 'Walk through streets of history between the Colosseum, Vatican, and Trevi Fountain in an eternal city.'],
                    'highlights'      => ['ar' => ['الكولوسيوم', 'الفاتيكان', 'نافورة تريفي', 'البانثيون'], 'en' => ['Colosseum', 'Vatican City', 'Trevi Fountain', 'Pantheon']],
                    'destination_id'  => null,
                    'price' => 1300, 'currency' => '$', 'duration' => 6,
                    'category' => 'culture', 'climate' => 'city', 'travel_type' => ['couple', 'family', 'solo'],
                    'budget_tier' => 'high', 'color_from' => '#009246', 'color_to' => '#CE2B37',
                    'is_egyptian' => false, 'spots_total' => 16, 'spots_left' => 7,
                    'departure_dates' => ['2026-07-28', '2026-08-01', '2026-09-18'],
                    'is_active' => true, 'sort_order' => 5,
                    'meta_title'    => ['ar' => 'رحلة روما — العاصمة الأبدية', 'en' => 'Rome Trip — The Eternal City'],
                    'meta_desc'     => ['ar' => 'رحلة 6 أيام في روما بين الكولوسيوم والفاتيكان ونافورة تريفي. جولة عبر 2000 عام من التاريخ من 1300$.', 'en' => '6-day Rome trip between the Colosseum, Vatican & Trevi Fountain — walk through 2000 years of history from $1300.'],
                    'meta_keywords' => ['ar' => 'رحلة روما, الكولوسيوم, الفاتيكان, إيطاليا, نافورة تريفي, رحلاتي', 'en' => 'rome trip, colosseum, vatican city, italy tourism, trevi fountain, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=1200&q=80',
            ],
            [
                'data' => [
                    'title'           => ['ar' => 'برشلونة — مدينة الفن', 'en' => 'Barcelona — City of Art'],
                    'desc'            => ['ar' => 'من معمار غاودي الفريد إلى شواطئ لا باركيتا المذهلة، برشلونة تجمع الفن والمتعة معاً.', 'en' => "From Gaudí's unique architecture to the stunning beaches of La Barceloneta, Barcelona combines art and fun."],
                    'highlights'      => ['ar' => ['الساغرادا فاميليا', 'لاس رامبلاس', 'شاطئ برشلونة', 'الحي القوطي'], 'en' => ['Sagrada Família', 'Las Ramblas', 'Barcelona Beach', 'Gothic Quarter']],
                    'destination_id'  => null,
                    'price' => 1200, 'currency' => '$', 'duration' => 6,
                    'category' => 'adventure', 'climate' => 'beach', 'travel_type' => ['friends', 'couple', 'solo'],
                    'budget_tier' => 'high', 'color_from' => '#AA151B', 'color_to' => '#F1BF00',
                    'is_egyptian' => false, 'spots_total' => 20, 'spots_left' => 14,
                    'departure_dates' => ['2026-07-08', '2026-08-20', '2026-09-01'],
                    'is_active' => true, 'sort_order' => 6,
                    'meta_title'    => ['ar' => 'رحلة برشلونة — الفن والشواطئ وغاودي', 'en' => 'Barcelona Trip — Art, Beaches & Gaudí'],
                    'meta_desc'     => ['ar' => 'رحلة 6 أيام في برشلونة بين الساغرادا فاميليا ولاس رامبلاس وشاطئ لاباركيتا والحي القوطي من 1200$.', 'en' => '6-day Barcelona trip exploring Sagrada Família, Las Ramblas, La Barceloneta beach & Gothic Quarter from $1200.'],
                    'meta_keywords' => ['ar' => 'رحلة برشلونة, الساغرادا فاميليا, إسبانيا, شاطئ برشلونة, غاودي, رحلاتي', 'en' => 'barcelona trip, sagrada familia, spain tourism, barcelona beach, gaudi, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1583422409516-2895a77efded?w=1200&q=80',
            ],
            [
                'data' => [
                    'title'           => ['ar' => 'دبي — مدينة المستقبل', 'en' => 'Dubai — City of the Future'],
                    'desc'            => ['ar' => 'تسوق في أفخم المراكز التجارية وتزلج على الثلج بينما الصحراء تمتد خارج النافذة.', 'en' => 'Shop in the most luxurious malls and ski on snow while the desert stretches outside the window.'],
                    'highlights'      => ['ar' => ['برج خليفة', 'دبي مول', 'ميناء جميرا', 'رحلة الصحراء'], 'en' => ['Burj Khalifa', 'Dubai Mall', 'Jumeirah Port', 'Desert Safari']],
                    'destination_id'  => null,
                    'price' => 900, 'currency' => '$', 'duration' => 5,
                    'category' => 'adventure', 'climate' => 'desert', 'travel_type' => ['family', 'couple', 'friends'],
                    'budget_tier' => 'high', 'color_from' => '#00732F', 'color_to' => '#C0392B',
                    'is_egyptian' => false, 'spots_total' => 25, 'spots_left' => 2,
                    'departure_dates' => ['2026-06-22', '2026-07-18', '2026-08-25'],
                    'is_active' => true, 'sort_order' => 7,
                    'meta_title'    => ['ar' => 'رحلة دبي — الترف والمغامرة في الإمارات', 'en' => 'Dubai Trip — Luxury & Adventure in the UAE'],
                    'meta_desc'     => ['ar' => 'رحلة 5 أيام في دبي بين برج خليفة ودبي مول وسفاري الصحراء المثير. احجز مع رحلاتي من 900$.', 'en' => '5-day Dubai trip featuring Burj Khalifa, Dubai Mall & thrilling desert safari. Book with Rahalaty from $900.'],
                    'meta_keywords' => ['ar' => 'رحلة دبي, برج خليفة, دبي مول, سفاري صحراء, الإمارات, رحلاتي', 'en' => 'dubai trip, burj khalifa, dubai mall, desert safari, uae tourism, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=1200&q=80',
            ],
            [
                'data' => [
                    'title'           => ['ar' => 'إسطنبول — جسر الحضارات', 'en' => 'Istanbul — Bridge of Civilizations'],
                    'desc'            => ['ar' => 'مدينة تجمع بين شرق وغرب، بين آيا صوفيا والبسفور والبازارات الشرقية العريقة.', 'en' => 'A city that brings together East and West, between Hagia Sophia, the Bosphorus, and ancient Eastern bazaars.'],
                    'highlights'      => ['ar' => ['آيا صوفيا', 'القصر الكبير', 'البازار المسقوف', 'جسر البسفور'], 'en' => ['Hagia Sophia', 'Topkapi Palace', 'Grand Bazaar', 'Bosphorus Bridge']],
                    'destination_id'  => null,
                    'price' => 700, 'currency' => '$', 'duration' => 6,
                    'category' => 'culture', 'climate' => 'city', 'travel_type' => ['family', 'couple', 'friends', 'solo'],
                    'budget_tier' => 'medium', 'color_from' => '#E30A17', 'color_to' => '#2E4053',
                    'is_egyptian' => false, 'spots_total' => 22, 'spots_left' => 10,
                    'departure_dates' => ['2026-07-03', '2026-07-28', '2026-09-05'],
                    'is_active' => true, 'sort_order' => 8,
                    'meta_title'    => ['ar' => 'رحلة إسطنبول — جسر الشرق والغرب', 'en' => 'Istanbul Trip — Where East Meets West'],
                    'meta_desc'     => ['ar' => 'رحلة 6 أيام في إسطنبول بين آيا صوفيا والبازار الكبير وجسر البسفور الخلاب. احجز مع رحلاتي من 700$.', 'en' => '6-day Istanbul trip exploring Hagia Sophia, Grand Bazaar & the stunning Bosphorus. Book with Rahalaty from $700.'],
                    'meta_keywords' => ['ar' => 'رحلة إسطنبول, آيا صوفيا, البازار الكبير, البسفور, تركيا, رحلاتي', 'en' => 'istanbul trip, hagia sophia, grand bazaar, bosphorus, turkey tourism, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?w=1200&q=80',
            ],
            [
                'data' => [
                    'title'           => ['ar' => 'بالي — جنة الأرض', 'en' => 'Bali — Heaven on Earth'],
                    'desc'            => ['ar' => 'جزيرة الآلهة ذات المعابد والشلالات والشواطئ البركانية الخلابة وثقافة فريدة من نوعها.', 'en' => 'Island of the gods with temples, waterfalls, volcanic beaches, and a unique culture like no other.'],
                    'highlights'      => ['ar' => ['معبد أولوواتو', 'تراسات أوبود', 'شاطئ كوتا', 'كانيون أيانغ'], 'en' => ['Uluwatu Temple', 'Ubud Terraces', 'Kuta Beach', 'Ayung Canyon']],
                    'destination_id'  => null,
                    'price' => 800, 'currency' => '$', 'duration' => 10,
                    'category' => 'beach', 'climate' => 'beach', 'travel_type' => ['couple', 'friends', 'solo'],
                    'budget_tier' => 'medium', 'color_from' => '#FF6B35', 'color_to' => '#1A936F',
                    'is_egyptian' => false, 'spots_total' => 18, 'spots_left' => 6,
                    'departure_dates' => ['2026-07-12', '2026-08-09', '2026-10-11'],
                    'is_active' => true, 'sort_order' => 9,
                    'meta_title'    => ['ar' => 'رحلة بالي — جنة الأرض في إندونيسيا', 'en' => 'Bali Trip — Heaven on Earth in Indonesia'],
                    'meta_desc'     => ['ar' => 'رحلة 10 أيام في بالي بين معبد أولوواتو وتراسات أوبود وشاطئ كوتا الخلاب. احجز مع رحلاتي من 800$.', 'en' => '10-day Bali trip exploring Uluwatu Temple, Ubud rice terraces & Kuta Beach. Book with Rahalaty from $800.'],
                    'meta_keywords' => ['ar' => 'رحلة بالي, إندونيسيا, شاطئ كوتا, أوبود, معبد أولوواتو, رحلاتي', 'en' => 'bali trip, bali indonesia, kuta beach, ubud terraces, uluwatu temple, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1200&q=80',
            ],
            [
                'data' => [
                    'title'           => ['ar' => 'نيويورك — المدينة التي لا تنام', 'en' => 'New York — The City That Never Sleeps'],
                    'desc'            => ['ar' => 'تجربة المدينة الأكثر إثارة في العالم، من تايمز سكوير إلى سنترال بارك والمتحف الأمريكي.', 'en' => 'Experience the most exciting city in the world, from Times Square to Central Park and the American Museum.'],
                    'highlights'      => ['ar' => ['تايمز سكوير', 'سنترال بارك', 'تمثال الحرية', 'برودواي'], 'en' => ['Times Square', 'Central Park', 'Statue of Liberty', 'Broadway']],
                    'destination_id'  => null,
                    'price' => 2500, 'currency' => '$', 'duration' => 8,
                    'category' => 'adventure', 'climate' => 'city', 'travel_type' => ['friends', 'couple', 'solo'],
                    'budget_tier' => 'luxury', 'color_from' => '#3C3B6E', 'color_to' => '#B22234',
                    'is_egyptian' => false, 'spots_total' => 15, 'spots_left' => 8,
                    'departure_dates' => ['2026-07-20', '2026-09-01', '2026-10-05'],
                    'is_active' => true, 'sort_order' => 10,
                    'meta_title'    => ['ar' => 'رحلة نيويورك — المدينة التي لا تنام', 'en' => 'New York Trip — The City That Never Sleeps'],
                    'meta_desc'     => ['ar' => 'رحلة 8 أيام في نيويورك بين تايمز سكوير وسنترال بارك وتمثال الحرية وعروض برودواي من 2500$.', 'en' => '8-day New York trip covering Times Square, Central Park, Statue of Liberty & Broadway shows from $2500.'],
                    'meta_keywords' => ['ar' => 'رحلة نيويورك, تايمز سكوير, سنترال بارك, تمثال الحرية, أمريكا, رحلاتي', 'en' => 'new york trip, times square, central park, statue of liberty, usa tourism, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1485871981521-5b1fd3805eee?w=1200&q=80',
            ],
            [
                'data' => [
                    'title'           => ['ar' => 'المالديف — المتعة الخالصة', 'en' => 'Maldives — Pure Paradise'],
                    'desc'            => ['ar' => 'جزر المحيط الهندي الخيالية مع أكواخ فوق الماء وشعاب مرجانية بلورية وغروب شمس لا يوصف.', 'en' => 'Dreamy Indian Ocean islands with overwater bungalows, crystal coral reefs, and indescribable sunsets.'],
                    'highlights'      => ['ar' => ['كوخ فوق الماء', 'الغوص في المرجان', 'غروب المحيط', 'سبا خاص'], 'en' => ['Overwater Bungalow', 'Coral Diving', 'Ocean Sunset', 'Private Spa']],
                    'destination_id'  => null,
                    'price' => 3000, 'currency' => '$', 'duration' => 7,
                    'category' => 'beach', 'climate' => 'beach', 'travel_type' => ['couple'],
                    'budget_tier' => 'luxury', 'color_from' => '#006994', 'color_to' => '#00C9A7',
                    'is_egyptian' => false, 'spots_total' => 10, 'spots_left' => 1,
                    'departure_dates' => ['2026-08-01', '2026-09-15', '2026-11-03'],
                    'is_active' => true, 'sort_order' => 11,
                    'meta_title'    => ['ar' => 'رحلة المالديف — أكواخ فوق الماء وغروب المحيط', 'en' => 'Maldives Trip — Overwater Bungalows & Ocean Sunsets'],
                    'meta_desc'     => ['ar' => 'رحلة 7 أيام في جزر المالديف مع أكواخ فوق الماء وغوص في مرجان بلوري وغروب شمس ساحر من 3000$.', 'en' => '7-day Maldives escape with overwater bungalows, crystal coral diving & breathtaking ocean sunsets from $3000.'],
                    'meta_keywords' => ['ar' => 'رحلة المالديف, كوخ فوق الماء, غوص مرجان, جزر المحيط الهندي, رحلات فاخرة, رحلاتي', 'en' => 'maldives trip, overwater bungalow, coral diving, indian ocean islands, luxury travel, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=1200&q=80',
            ],
            [
                'data' => [
                    'title'           => ['ar' => 'طوكيو — عاصمة المستقبل', 'en' => 'Tokyo — Capital of the Future'],
                    'desc'            => ['ar' => 'مزيج مذهل بين التكنولوجيا الحديثة والتراث الياباني الأصيل في مدينة لا تشبه أي مكان آخر.', 'en' => 'An amazing blend of modern technology and authentic Japanese heritage in a city unlike anywhere else.'],
                    'highlights'      => ['ar' => ['جبل فوجي', 'شينجوكو', 'معبد سنسوجي', 'حي أكيهابارا'], 'en' => ['Mount Fuji', 'Shinjuku', 'Senso-ji Temple', 'Akihabara District']],
                    'destination_id'  => null,
                    'price' => 2200, 'currency' => '$', 'duration' => 9,
                    'category' => 'culture', 'climate' => 'city', 'travel_type' => ['solo', 'couple', 'friends'],
                    'budget_tier' => 'luxury', 'color_from' => '#BC002D', 'color_to' => '#2C3E50',
                    'is_egyptian' => false, 'spots_total' => 20, 'spots_left' => 11,
                    'departure_dates' => ['2026-08-15', '2026-09-22', '2026-10-17'],
                    'is_active' => true, 'sort_order' => 12,
                    'meta_title'    => ['ar' => 'رحلة طوكيو — حيث المستقبل يلتقي التراث', 'en' => 'Tokyo Trip — Where Future Meets Heritage'],
                    'meta_desc'     => ['ar' => 'رحلة 9 أيام في طوكيو بين جبل فوجي ومعبد سنسوجي وأحياء التكنولوجيا المذهلة. احجز مع رحلاتي من 2200$.', 'en' => '9-day Tokyo trip from Mount Fuji & Senso-ji Temple to Shinjuku & Akihabara tech district from $2200.'],
                    'meta_keywords' => ['ar' => 'رحلة طوكيو, جبل فوجي, اليابان, معبد سنسوجي, أكيهابارا, رحلاتي', 'en' => 'tokyo trip, mount fuji, japan tourism, senso-ji temple, akihabara, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=1200&q=80',
            ],
            [
                'data' => [
                    'title'           => ['ar' => 'المغرب — مملكة الألوان', 'en' => 'Morocco — Kingdom of Colors'],
                    'desc'            => ['ar' => 'من أزقة مراكش الوردية إلى صحراء الصحراء الكبرى وشاطئ أغادير المدهش، رحلة بألف لون.', 'en' => 'From the pink alleys of Marrakech to the Sahara Desert and stunning Agadir beach — a journey of a thousand colors.'],
                    'highlights'      => ['ar' => ['جامع الفنا', 'الصحراء الكبرى', 'فاس القديمة', 'شاطئ أغادير'], 'en' => ["Jemaa el-Fna", 'Sahara Desert', 'Ancient Fez', 'Agadir Beach']],
                    'destination_id'  => null,
                    'price' => 600, 'currency' => '$', 'duration' => 7,
                    'category' => 'adventure', 'climate' => 'desert', 'travel_type' => ['friends', 'family', 'solo'],
                    'budget_tier' => 'medium', 'color_from' => '#C1272D', 'color_to' => '#006233',
                    'is_egyptian' => false, 'spots_total' => 20, 'spots_left' => 15,
                    'departure_dates' => ['2026-07-24', '2026-08-22', '2026-09-19'],
                    'is_active' => true, 'sort_order' => 13,
                    'meta_title'    => ['ar' => 'رحلة المغرب — مملكة الألوان والتاريخ', 'en' => 'Morocco Trip — Kingdom of Colors & History'],
                    'meta_desc'     => ['ar' => 'رحلة 7 أيام في المغرب بين مراكش والصحراء الكبرى وفاس القديمة وشاطئ أغادير. احجز مع رحلاتي من 600$.', 'en' => '7-day Morocco trip through Marrakech, the Sahara Desert, ancient Fez & Agadir beach from $600 with Rahalaty.'],
                    'meta_keywords' => ['ar' => 'رحلة المغرب, مراكش, الصحراء الكبرى, فاس القديمة, أغادير, رحلاتي', 'en' => 'morocco trip, marrakech, sahara desert, ancient fez, agadir beach, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1539635278303-d4002c07eae3?w=1200&q=80',
            ],
            [
                'data' => [
                    'title'           => ['ar' => 'جزر اليونان — أجمل شواطئ أوروبا', 'en' => "Greek Islands — Europe's Most Beautiful Beaches"],
                    'desc'            => ['ar' => 'سانتوريني الحالمة وميكونوس الصاخبة وجزر الإيجه الخلابة في رحلة بحرية فريدة.', 'en' => 'Dreamy Santorini and vibrant Mykonos and stunning Aegean islands in a unique sea journey.'],
                    'highlights'      => ['ar' => ['سانتوريني', 'ميكونوس', 'جزيرة كريت', 'أكروبوليس أثينا'], 'en' => ['Santorini', 'Mykonos', 'Crete Island', 'Athens Acropolis']],
                    'destination_id'  => null,
                    'price' => 1100, 'currency' => '$', 'duration' => 8,
                    'category' => 'beach', 'climate' => 'beach', 'travel_type' => ['couple', 'friends'],
                    'budget_tier' => 'high', 'color_from' => '#0D5EAF', 'color_to' => '#FFFFFF',
                    'is_egyptian' => false, 'spots_total' => 16, 'spots_left' => 4,
                    'departure_dates' => ['2026-07-07', '2026-08-04', '2026-09-02'],
                    'is_active' => true, 'sort_order' => 14,
                    'meta_title'    => ['ar' => 'رحلة جزر اليونان — سانتوريني وميكونوس', 'en' => 'Greek Islands Trip — Santorini & Mykonos'],
                    'meta_desc'     => ['ar' => 'رحلة 8 أيام في جزر اليونان بين سانتوريني الحالمة وميكونوس وكريت وأكروبوليس أثينا. احجز من 1100$.', 'en' => '8-day Greek Islands journey through dreamy Santorini, vibrant Mykonos & stunning Crete from $1100.'],
                    'meta_keywords' => ['ar' => 'رحلة اليونان, سانتوريني, ميكونوس, كريت, شواطئ أوروبا, رحلاتي', 'en' => 'greek islands trip, santorini, mykonos, crete, greece tourism, europe beach, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1533105079780-92b9be482077?w=1200&q=80',
            ],
            [
                'data' => [
                    'title'           => ['ar' => 'البر السويسري — قلب الألب', 'en' => 'Switzerland — Heart of the Alps'],
                    'desc'            => ['ar' => 'تزلج على جبال الألب وتجول في قرى الشوكولاتة وبحيرة جنيف الرائعة في قلب أوروبا.', 'en' => 'Ski in the Alps, stroll through chocolate villages, and visit stunning Lake Geneva in the heart of Europe.'],
                    'highlights'      => ['ar' => ['جبل يونغفراو', 'زيرمات', 'بحيرة جنيف', 'إنترلاكن'], 'en' => ['Jungfrau Mountain', 'Zermatt', 'Lake Geneva', 'Interlaken']],
                    'destination_id'  => null,
                    'price' => 2800, 'currency' => '$', 'duration' => 8,
                    'category' => 'adventure', 'climate' => 'mountain', 'travel_type' => ['family', 'couple'],
                    'budget_tier' => 'luxury', 'color_from' => '#D52B1E', 'color_to' => '#FFFFFF',
                    'is_egyptian' => false, 'spots_total' => 12, 'spots_left' => 5,
                    'departure_dates' => ['2026-08-01', '2026-09-15', '2026-10-22'],
                    'is_active' => true, 'sort_order' => 15,
                    'meta_title'    => ['ar' => 'رحلة سويسرا — قلب الألب وبحيرة جنيف', 'en' => 'Switzerland Trip — Alps & Lake Geneva'],
                    'meta_desc'     => ['ar' => 'رحلة 8 أيام في سويسرا بين جبل يونغفراو وزيرمات وبحيرة جنيف وإنترلاكن الخلابة. احجز من 2800$.', 'en' => '8-day Switzerland adventure through Jungfrau Mountain, Zermatt, Lake Geneva & Interlaken from $2800.'],
                    'meta_keywords' => ['ar' => 'رحلة سويسرا, جبال الألب, يونغفراو, زيرمات, بحيرة جنيف, رحلاتي', 'en' => 'switzerland trip, swiss alps, jungfrau mountain, zermatt, lake geneva, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&q=80',
            ],
            [
                'data' => [
                    'title'           => ['ar' => 'البانيا — الكنز الخفي', 'en' => 'Albania — The Hidden Gem'],
                    'desc'            => ['ar' => 'شواطئ البحر الأدرياتيكي والمتوسط بأسعار لا تُصدق وجمال طبيعي بكر لم يكتشفه الكثيرون.', 'en' => 'Adriatic and Mediterranean beaches at unbelievable prices with pristine natural beauty few have discovered.'],
                    'highlights'      => ['ar' => ['شاطئ كاميل', 'جيروكاستر', 'بحيرة شكودر', 'ساراندا'], 'en' => ['Ksamil Beach', 'Gjirokastër', 'Lake Shkodër', 'Saranda']],
                    'destination_id'  => null,
                    'price' => 450, 'currency' => '$', 'duration' => 6,
                    'category' => 'beach', 'climate' => 'beach', 'travel_type' => ['friends', 'solo', 'couple'],
                    'budget_tier' => 'low', 'color_from' => '#E41E20', 'color_to' => '#1A3A5C',
                    'is_egyptian' => false, 'spots_total' => 25, 'spots_left' => 18,
                    'departure_dates' => ['2026-07-30', '2026-08-28', '2026-09-25'],
                    'is_active' => true, 'sort_order' => 16,
                    'meta_title'    => ['ar' => 'رحلة ألبانيا — الكنز الخفي في أوروبا', 'en' => "Albania Trip — Europe's Hidden Gem"],
                    'meta_desc'     => ['ar' => 'رحلة 6 أيام في ألبانيا على شواطئ البحر الأدرياتيكي النقية بأسعار لا تصدق. احجز مع رحلاتي من 450$.', 'en' => '6-day Albania trip on pristine Adriatic & Mediterranean beaches at unbeatable prices from $450 with Rahalaty.'],
                    'meta_keywords' => ['ar' => 'رحلة ألبانيا, شواطئ أدرياتيكية, ساراندا, أوروبا بأسعار رخيصة, رحلاتي', 'en' => 'albania trip, adriatic beaches, saranda, ksamil beach, budget europe, rahalaty'],
                ],
                'image' => 'https://images.unsplash.com/photo-1555990793-da11153b4559?w=1200&q=80',
            ],
        ];

        foreach ($trips as $item) {
            $trip = Trip::updateOrCreate(
                ['sort_order' => $item['data']['sort_order']],
                $item['data']
            );

            if (!$trip->hasMedia('image')) {
                try {
                    $trip->addMediaFromUrl($item['image'])
                        ->toMediaCollection('image');
                } catch (\Exception) {
                    // No internet or URL unavailable — site uses CSS gradient fallback
                }
            }
        }
    }
}

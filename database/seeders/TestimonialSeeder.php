<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name'   => 'أحمد محمد',
                'rating' => 5,
                'review' => 'تجربة رائعة جداً! الرحلة إلى الغردقة كانت أكثر من رائعة، الفندق ممتاز والخدمة احترافية.',
                'avatar' => 'https://i.pravatar.cc/200?img=11',
            ],
            [
                'name'   => 'مي السيد',
                'rating' => 5,
                'review' => 'سافرنا كعائلة إلى الأقصر وأسوان وكانت رحلة لا تُنسى، الأطفال أحبوها جداً وشعرنا بالتاريخ المصري العريق.',
                'avatar' => 'https://i.pravatar.cc/200?img=47',
            ],
            [
                'name'   => 'كريم علي',
                'rating' => 5,
                'review' => 'حجزت رحلة تركيا وكان كل شيء مرتب بشكل احترافي من الفندق للجولات. سأحجز مرة ثانية بالتأكيد.',
                'avatar' => 'https://i.pravatar.cc/200?img=33',
            ],
            [
                'name'   => 'سارة حسن',
                'rating' => 4,
                'review' => 'رحلة بالي كانت حلماً أصبح حقيقة، الطبيعة الخلابة والمعابد الجميلة، شكراً رحلاتي!',
                'avatar' => 'https://i.pravatar.cc/200?img=56',
            ],
            [
                'name'   => 'عمر خالد',
                'rating' => 5,
                'review' => 'أفضل خدمة وأفضل أسعار، رحلة دبي كانت ممتازة وسيكون رحلاتي هو خياري دائماً للسفر.',
                'avatar' => 'https://i.pravatar.cc/200?img=68',
            ],
        ];

        foreach ($testimonials as $t) {
            $avatar = $t['avatar'];
            unset($t['avatar']);

            $testimonial = Testimonial::firstOrCreate(
                ['name' => $t['name']],
                array_merge($t, ['is_active' => true])
            );

            if (!$testimonial->hasMedia('avatar')) {
                try {
                    $testimonial->addMediaFromUrl($avatar)
                        ->toMediaCollection('avatar');
                } catch (\Exception $e) {
                    // Skip avatar if unavailable
                }
            }
        }
    }
}

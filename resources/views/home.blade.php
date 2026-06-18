@extends('layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'رحلاتي — اكتشف العالم' : 'Rahalaty — Discover the World')

@php $__homeDesc = app()->getLocale() == 'ar' ? 'رحلاتي | أفضل شركة سياحة مصرية — احجز رحلتك إلى الغردقة وشرم الشيخ والأقصر وأوروبا. أكثر من 16 وجهة سياحية بأسعار تنافسية وأجواء مصرية دافئة.' : 'Rahalaty | Best Egyptian Travel Agency — Book trips to Hurghada, Sharm El-Sheikh, Luxor, Europe & more. 16+ destinations at competitive prices with warm Egyptian hospitality.'; @endphp
@section('meta_desc', $__homeDesc)

@section('meta_keywords', 'رحلاتي, rahalaty, ra7laty.com, رحلات مصر, سياحة مصر, الغردقة, شرم الشيخ, الأقصر, أسوان, حجز رحلات, egypt travel, hurghada trips, sharm el sheikh, luxor aswan, cairo tours, سياحة داخلية, رحلات خارجية')

@section('seo_head')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebSite",
  "name": "رحلاتي | Rahalaty",
  "url": "{{ url('/') }}",
  "potentialAction": {
    "@@type": "SearchAction",
    "target": "{{ url('/') }}/?q={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>
@endsection

@php $isAr = app()->getLocale() === 'ar'; @endphp

@section('content')

{{-- =====================================================================
     HERO SECTION
     ===================================================================== --}}
<section class="hero-section" id="hero">

    {{-- Animated Stars --}}
    <div class="hero-stars" id="heroStars"></div>

    {{-- Pyramid SVG Background --}}
    <div style="position:absolute; bottom:0; left:0; right:0; pointer-events:none; overflow:hidden; opacity:0.12;">
        <svg viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="width:100%; height:320px;">
            {{-- Large pyramid center --}}
            <polygon points="720,20 480,300 960,300" fill="#C5A028"/>
            {{-- Small pyramids --}}
            <polygon points="200,120 100,300 300,300" fill="#C5A028"/>
            <polygon points="1240,120 1140,300 1340,300" fill="#C5A028"/>
            {{-- Desert ground --}}
            <rect x="0" y="295" width="1440" height="25" fill="#C5A028"/>
        </svg>
    </div>

    {{-- Content --}}
    <div style="max-width:900px; margin:0 auto; padding:2rem 1.5rem; text-align:center; position:relative; z-index:2;">

        <div style="display:inline-block; background:rgba(197,160,40,0.15); border:1px solid rgba(197,160,40,0.3); border-radius:30px; padding:0.4rem 1.2rem; color:#F0D060; font-size:0.95rem; font-weight:600; margin-bottom:1.5rem; animation:fadeSlideIn 0.6s ease;">
            {{ $isAr ? '✈ اكتشف العالم معنا' : '✈ Discover the World With Us' }}
        </div>

        <h1 style="font-size:clamp(2.5rem,7vw,5rem); font-weight:900; color:white; line-height:1.15; margin-bottom:1.25rem; text-shadow:0 4px 20px rgba(0,0,0,0.3);">
            <span>{{ $isAr ? 'رحلاتك الحلم' : 'Your Dream Trip' }}</span><br>
            <span class="text-gold-gradient">{{ $isAr ? 'تبدأ من هنا' : 'Starts Here' }}</span>
        </h1>

        <p style="color:#B8D4F0; font-size:clamp(1rem,2.5vw,1.2rem); line-height:1.8; margin-bottom:2.5rem; max-width:650px; margin-left:auto; margin-right:auto;">
            {{ $isAr ? 'أكثر من 50 وجهة سياحية حول العالم بأجواء مصرية دافئة وخبرة تزيد على 10 سنوات' : 'Over 50 destinations around the world with warm Egyptian hospitality and 10+ years of experience' }}
        </p>

        <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
            <a href="#world-trips" class="btn-gold" style="font-size:1.05rem; padding:0.75rem 2.2rem;">
                {{ $isAr ? 'اكتشف الرحلات' : 'Explore Trips' }}
            </a>
            <a href="{{ route('survey.index') }}" class="btn-outline-gold" style="font-size:1.05rem; padding:0.75rem 2.2rem;">
                {{ $isAr ? 'ابدأ الاستبيان' : 'Start Survey' }}
            </a>
        </div>

        {{-- Scroll indicator --}}
        <div style="margin-top:3rem; animation:bounce 2s ease-in-out infinite;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C5A028" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"/>
            </svg>
        </div>
    </div>
</section>

<style>
@keyframes bounce {
    0%,100% { transform: translateY(0); }
    50%      { transform: translateY(8px); }
}
</style>

{{-- =====================================================================
     STATS BAR
     ===================================================================== --}}
<section class="stats-bar">
    <div style="max-width:1000px; margin:0 auto; padding:0 1.5rem; display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; text-align:center;">
        <div class="fade-up">
            <div class="stat-number" data-counter="50" data-suffix="+">0</div>
            <div style="color:#8A9BB5; font-size:0.9rem; margin-top:0.3rem;" data-i18n="stat1Label">وجهة سياحية</div>
        </div>
        <div class="fade-up" style="transition-delay:0.1s">
            <div class="stat-number" data-counter="10" data-suffix="+">0</div>
            <div style="color:#8A9BB5; font-size:0.9rem; margin-top:0.3rem;" data-i18n="stat2Label">سنوات خبرة</div>
        </div>
        <div class="fade-up" style="transition-delay:0.2s">
            <div class="stat-number" data-counter="5000" data-suffix="+">0</div>
            <div style="color:#8A9BB5; font-size:0.9rem; margin-top:0.3rem;" data-i18n="stat3Label">عميل سعيد</div>
        </div>
        <div class="fade-up" style="transition-delay:0.3s">
            <div class="stat-number" data-suffix="">24/7</div>
            <div style="color:#8A9BB5; font-size:0.9rem; margin-top:0.3rem;" data-i18n="stat4Label">دعم متواصل</div>
        </div>
    </div>
</section>

{{-- =====================================================================
     SPECIAL OFFERS TICKER
     ===================================================================== --}}
<div class="ticker-wrap">
    <div class="ticker-track" id="tickerTrack">
        @php
        $offers = [
            ['ar'=>'🔥 خصم 30% على رحلات شرم الشيخ — احجز الآن!', 'en'=>'🔥 30% OFF Sharm El-Sheikh — Book Now!'],
            ['ar'=>'✈ رحلة باريس رومانسية — عرض خاص للزوجين!', 'en'=>'✈ Romantic Paris Trip — Couples Special!'],
            ['ar'=>'🏖 الغردقة 5 أيام شاملة بـ $350 فقط!', 'en'=>'🏖 Hurghada 5 Days All-Inclusive for $350 Only!'],
            ['ar'=>'🌍 دبي — باقات مميزة للعائلات لهذا الصيف!', 'en'=>'🌍 Dubai — Special Family Packages This Summer!'],
            ['ar'=>'⭐ إسطنبول 6 أيام كل شيء شامل — احجز قبل نفاد الأماكن!', 'en'=>'⭐ Istanbul 6 Days All-Inclusive — Book Before Spots Run Out!'],
        ];
        @endphp
        @foreach($offers as $offer)
            <span class="ticker-item">
                <span class="offer-text" data-ar="{{ $offer['ar'] }}" data-en="{{ $offer['en'] }}">{{ $isAr ? $offer['ar'] : $offer['en'] }}</span>
            </span>
            <span style="color:rgba(197,160,40,0.4);">●</span>
        @endforeach
        {{-- Duplicate for seamless loop --}}
        @foreach($offers as $offer)
            <span class="ticker-item">
                <span class="offer-text" data-ar="{{ $offer['ar'] }}" data-en="{{ $offer['en'] }}">{{ $isAr ? $offer['ar'] : $offer['en'] }}</span>
            </span>
            <span style="color:rgba(197,160,40,0.4);">●</span>
        @endforeach
    </div>
</div>

{{-- =====================================================================
     EGYPTIAN DESTINATIONS
     ===================================================================== --}}
<section id="egypt-destinations" style="padding:5rem 1.5rem; background:#FDFAF4;">
    <div style="max-width:1200px; margin:0 auto;">
        <div style="text-align:center; margin-bottom:3rem;" class="fade-up">
            <h2 class="section-title" data-i18n="egyptSectionTitle">اكتشف جمال مصر</h2>
            <p style="color:#666; margin-top:0.75rem; font-size:1.05rem;" data-i18n="egyptSectionSub">من شواطئ البحر الأحمر إلى معابد الفراعنة الخالدة</p>
        </div>

        @php
        $destCategoryEmoji = ['beach'=>'🏖', 'heritage'=>'🏛', 'culture'=>'🏺', 'adventure'=>'🧗'];
        $destLang = app()->getLocale();
        @endphp
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:1.5rem;">

            @forelse($egyptDestinations as $dest)
            @php
                $destImg  = $dest->getFirstMedia('image');
                $destName = $dest->getTranslation('name', $destLang);
                $destDesc = $dest->getTranslation('description', $destLang);
                $emoji    = $destCategoryEmoji[$dest->category] ?? '📍';
                $delay    = $loop->index * 0.1;
            @endphp
            <a href="{{ route('destinations.show', $dest->id) }}" style="display:block; text-decoration:none;">
            <div class="egypt-dest-card fade-up" style="transition-delay:{{ $delay }}s; cursor:pointer;
                @if($destImg)
                    background-image:url('{{ $destImg->getUrl() }}');
                @else
                    background:linear-gradient(135deg,#1A3A5C,#2D6A9F);
                @endif
                background-size:cover; background-position:center;">
                <div class="egypt-dest-content">
                    <h3 style="font-size:1.5rem; font-weight:800; margin-bottom:0.4rem;">{{ $destName }}</h3>
                    <p style="font-size:0.9rem; opacity:0.85; margin-bottom:1rem; line-height:1.6;">{{ Str::limit($destDesc, 90) }}</p>
                    <div style="display:flex; align-items:center; justify-content:space-between;">
                        <span style="background:rgba(255,255,255,0.2); padding:0.3rem 0.8rem; border-radius:20px; font-size:0.85rem; font-weight:700; text-transform:capitalize;">{{ $dest->category }}</span>
                        <span style="color:#F0D060; font-weight:700; font-size:0.9rem;">{{ $isAr ? 'استكشف الرحلات ←' : 'View Trips →' }}</span>
                    </div>
                </div>
            </div>
            </a>
            @empty
            <div style="grid-column:1/-1; text-align:center; padding:3rem; color:#999;">
                <div style="font-size:2rem; margin-bottom:0.5rem;">🗺</div>
                <div>{{ $isAr ? 'لا توجد وجهات متاحة حالياً' : 'No destinations available yet' }}</div>
            </div>
            @endforelse

        </div>
    </div>
</section>

{{-- =====================================================================
     WORLD TRIPS (JS-rendered)
     ===================================================================== --}}
<section id="world-trips" style="padding:5rem 1.5rem; background:white;">
    <div style="max-width:1200px; margin:0 auto;">
        <div style="text-align:center; margin-bottom:2.5rem;" class="fade-up">
            <h2 class="section-title" data-i18n="tripsSectionTitle">استكشف العالم معنا</h2>
            <p style="color:#666; margin-top:0.75rem; font-size:1.05rem;" data-i18n="tripsSectionSub">أكثر من 50 وجهة سياحية تنتظرك بأفضل الأسعار وأروع التجارب</p>
        </div>

        {{-- Filter Tabs --}}
        <div class="filter-tabs fade-up" style="margin-bottom:2.5rem;" id="filterTabsContainer">
            <button class="filter-tab active" data-category="all" data-i18n="filterAll">الكل</button>
            <button class="filter-tab" data-category="beach" data-i18n="filterBeach">شواطئ</button>
            <button class="filter-tab" data-category="culture" data-i18n="filterCulture">ثقافة وتاريخ</button>
            <button class="filter-tab" data-category="adventure" data-i18n="filterAdventure">مغامرة</button>
        </div>

        {{-- Trips Grid --}}
        <div class="trips-grid" id="tripsGrid">
            <div style="grid-column:1/-1; text-align:center; padding:3rem; color:#999;">
                <div style="font-size:2rem; margin-bottom:0.5rem;">⏳</div>
                <div>{{ $isAr ? 'جاري تحميل الرحلات...' : 'Loading trips...' }}</div>
            </div>
        </div>

        {{-- Load More --}}
        <div style="text-align:center; margin-top:2.5rem;" id="loadMoreWrap">
            <button id="loadMoreBtn"
                onclick="loadMoreTrips()"
                style="display:none; margin:0 auto; padding:0.85rem 2.5rem;
                       background:linear-gradient(135deg,#C5A028,#F0D060); color:#1A1A1A;
                       font-weight:800; font-size:1rem; border:none; border-radius:12px;
                       cursor:pointer; transition:all 0.2s; font-family:inherit;
                       align-items:center; gap:0.6rem;">
                <i class="fa-solid fa-chevron-down"></i>
                <span id="loadMoreLabel">{{ $isAr ? 'عرض المزيد' : 'Show More' }}</span>
            </button>
        </div>
    </div>
</section>

{{-- =====================================================================
     SURVEY CTA
     ===================================================================== --}}
<section class="survey-cta" style="padding:6rem 1.5rem;">
    <div style="max-width:700px; margin:0 auto; text-align:center; position:relative; z-index:1;">

        {{-- Pyramid decoration --}}
        <div style="font-size:3rem; margin-bottom:1rem; opacity:0.6;">🔺 🏺 🔺</div>

        <h2 style="font-size:clamp(1.8rem,4vw,2.8rem); font-weight:800; color:white; margin:1rem 0; line-height:1.3;" data-i18n="surveySectionTitle">
            مش عارف تختار رحلتك؟
        </h2>

        <p style="color:#8A9BB5; font-size:1.05rem; line-height:1.8; margin-bottom:2.5rem;" data-i18n="surveySectionSub">
            أجب على 4 أسئلة بسيطة وسنختار لك أنسب الرحلات بناءً على تفضيلاتك وميزانيتك
        </p>

        <a href="{{ route('survey.index') }}" class="btn-gold" style="font-size:1.1rem; padding:0.9rem 2.8rem;" data-i18n="surveyCta">
            ابدأ الاستبيان الآن
        </a>

        <div style="display:flex; justify-content:center; gap:2.5rem; margin-top:2.5rem; flex-wrap:wrap;">
            <div style="text-align:center; color:#8A9BB5;">
                <div style="font-size:1.5rem; margin-bottom:0.3rem;">⚡</div>
                <div style="font-size:0.85rem; font-weight:600;" data-i18n="surveyFeature1">نتائج فورية</div>
            </div>
            <div style="text-align:center; color:#8A9BB5;">
                <div style="font-size:1.5rem; margin-bottom:0.3rem;">🎯</div>
                <div style="font-size:0.85rem; font-weight:600;" data-i18n="surveyFeature2">رحلات مخصصة لك</div>
            </div>
            <div style="text-align:center; color:#8A9BB5;">
                <div style="font-size:1.5rem; margin-bottom:0.3rem;">🆓</div>
                <div style="font-size:0.85rem; font-weight:600;" data-i18n="surveyFeature3">مجاناً تماماً</div>
            </div>
        </div>
    </div>
</section>

{{-- =====================================================================
     TESTIMONIALS
     ===================================================================== --}}
<section style="padding:5rem 1.5rem; background:#FDFAF4;">
    <div style="max-width:1100px; margin:0 auto;">
        <div style="text-align:center; margin-bottom:3rem;" class="fade-up">
            <h2 class="section-title" data-i18n="testimonialsTitle">ماذا قالوا عنّا</h2>
        </div>

        @php
        $avatarGradients = [
            'linear-gradient(135deg,#C5A028,#F0D060)',
            'linear-gradient(135deg,#1A3A5C,#2A5A8C)',
            'linear-gradient(135deg,#CE1126,#8B0000)',
            'linear-gradient(135deg,#1A936F,#0d7a5f)',
            'linear-gradient(135deg,#7B2FBE,#5B0FBE)',
        ];
        $lang = app()->getLocale();
        @endphp
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:1.5rem;">
            @forelse($testimonials->take(3) as $testi)
            @php
                $i       = $loop->index;
                $review  = $testi->review;
                $initial = mb_substr($testi->name, 0, 1);
                $stars   = str_repeat('★', $testi->rating) . str_repeat('☆', 5 - $testi->rating);
                $gradient = $avatarGradients[$i % count($avatarGradients)];
            @endphp
            <div class="testimonial-card fade-up" style="transition-delay:{{ $i * 0.1 }}s">
                <div class="stars">{{ $stars }}</div>
                <p style="color:#444; line-height:1.8; margin:0.75rem 0; font-size:0.95rem;">
                    "{{ $review }}"
                </p>
                <div style="display:flex; align-items:center; gap:0.75rem; margin-top:1rem;">
                    <div style="width:42px; height:42px; background:{{ $gradient }}; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-weight:800; font-size:1rem;">{{ $initial }}</div>
                    <div>
                        <div style="font-weight:700; font-size:0.95rem; color:#1A3A5C;">{{ $testi->name }}</div>
                        <div style="font-size:0.8rem; color:#888;">{{ $isAr ? 'مصر' : 'Egypt' }}</div>
                    </div>
                </div>
            </div>
            @empty
            {{-- Fallback if DB is empty --}}
            <div class="testimonial-card fade-up">
                <div class="stars">★★★★★</div>
                <p style="color:#444; line-height:1.8; margin:0.75rem 0; font-size:0.95rem;">
                    "{{ $isAr ? 'رحلة رائعة ومنظمة بشكل احترافي. أنصح الجميع برحلاتي!' : 'Amazing and professionally organized trip. I recommend Rehlatyy to everyone!' }}"
                </p>
                <div style="display:flex; align-items:center; gap:0.75rem; margin-top:1rem;">
                    <div style="width:42px; height:42px; background:linear-gradient(135deg,#C5A028,#F0D060); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#1A1A1A; font-weight:800; font-size:1rem;">أ</div>
                    <div>
                        <div style="font-weight:700; font-size:0.95rem; color:#1A3A5C;">{{ $isAr ? 'أحمد محمد' : 'Ahmed Mohamed' }}</div>
                        <div style="font-size:0.8rem; color:#888;">{{ $isAr ? 'القاهرة، مصر' : 'Cairo, Egypt' }}</div>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        {{-- Form to Add a Review --}}
        <div class="fade-up" style="max-width: 600px; margin: 4rem auto 0; background: white; padding: 2.5rem; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #F0E6D2;">
            <h3 style="font-size: 1.5rem; font-weight: 800; color: #1A3A5C; text-align: center; margin-bottom: 1.5rem;" data-i18n="addReviewTitle">
                {{ $isAr ? 'شاركنا رأيك في خدماتنا' : 'Share Your Experience' }}
            </h3>
            
            @if(session('success'))
                <div style="background: #E8F5E9; color: #2E7D32; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: center; font-weight: 600;">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('testimonials.submit') }}" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem;">
                @csrf
                <div>
                    <label style="display: block; font-size: 0.9rem; font-weight: 700; color: #1A3A5C; margin-bottom: 0.5rem;" data-i18n="reviewNameLabel">
                        {{ $isAr ? 'الاسم بالكامل' : 'Full Name' }}
                    </label>
                    <input type="text" name="name" required placeholder="{{ $isAr ? 'مثال: محمد أحمد' : 'e.g. John Doe' }}" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #CCC; border-radius: 8px; font-size: 0.95rem; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='#C5A028'" onblur="this.style.borderColor='#CCC'">
                </div>

                <div>
                    <label style="display: block; font-size: 0.9rem; font-weight: 700; color: #1A3A5C; margin-bottom: 0.5rem;" data-i18n="reviewRatingLabel">
                        {{ $isAr ? 'تقييمك للخدمة' : 'Your Rating' }}
                    </label>
                    <div style="display: flex; gap: 0.5rem; flex-direction: row-reverse; justify-content: flex-end;" class="rating-stars-input">
                        @for($r = 5; $r >= 1; $r--)
                            <input type="radio" id="star-{{ $r }}" name="rating" value="{{ $r }}" required style="display: none;">
                            <label for="star-{{ $r }}" style="font-size: 2rem; color: #DDD; cursor: pointer; transition: color 0.2s; user-select: none;">★</label>
                        @endfor
                    </div>
                </div>

                <style>
                    .rating-stars-input label:hover,
                    .rating-stars-input label:hover ~ label,
                    .rating-stars-input input:checked ~ label {
                        color: #C5A028 !important;
                    }
                </style>

                <div>
                    <label style="display: block; font-size: 0.9rem; font-weight: 700; color: #1A3A5C; margin-bottom: 0.5rem;" data-i18n="reviewCommentLabel">
                        {{ $isAr ? 'رأيك وتجربتك بالتفصيل' : 'Your Review' }}
                    </label>
                    <textarea name="comment" rows="4" required placeholder="{{ $isAr ? 'اكتب رأيك هنا...' : 'Write your feedback here...' }}" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #CCC; border-radius: 8px; font-size: 0.95rem; resize: vertical; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='#C5A028'" onblur="this.style.borderColor='#CCC'"></textarea>
                </div>

                <button type="submit" class="btn-gold" style="width: 100%; padding: 0.9rem; border: none; font-size: 1.05rem; font-weight: 700; border-radius: 8px; cursor: pointer; transition: background 0.3s;">
                    {{ $isAr ? 'إرسال التقييم' : 'Submit Review' }}
                </button>
            </form>
        </div>
    </div>
</section>

{{-- =====================================================================
     NEWSLETTER
     ===================================================================== --}}
<section class="newsletter-section" style="padding:4rem 1.5rem;">
    <div style="max-width:600px; margin:0 auto; text-align:center;" class="fade-up">
        <div style="font-size:2.5rem; margin-bottom:1rem;">✉️</div>
        <h2 style="font-size:1.8rem; font-weight:800; color:#1A3A5C; margin-bottom:0.5rem;" data-i18n="newsletterTitle">
            اشترك في نشرتنا الإخبارية
        </h2>
        <p style="color:#777; margin-bottom:1.5rem;" data-i18n="newsletterSub">
            كن أول من يعلم بأحدث العروض والرحلات المميزة
        </p>
        <div style="display:flex; max-width:440px; margin:0 auto;" id="newsletterForm">
            <input type="email" class="newsletter-input" placeholder="{{ $isAr ? 'بريدك الإلكتروني' : 'Your email address' }}" id="newsletterEmail">
            <button class="newsletter-btn" onclick="subscribeNewsletter()" data-i18n="newsletterBtn">اشترك الآن</button>
        </div>
        <div id="newsletterSuccess" style="display:none; color:#1A936F; margin-top:1rem; font-weight:600;">{{ $isAr ? '✅ شكراً! تم الاشتراك بنجاح.' : '✅ Thank you! You have subscribed successfully.' }}</div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// window.* globals are exposed by app.js (compiled by Vite)
// We defer execution until app.js has run.
document.addEventListener('DOMContentLoaded', function () {

// ── Current language (already applied by app.js via initLang)
let lang = document.documentElement.lang || 'ar';

// ── Animate hero stars
(function generateStars() {
    const container = document.getElementById('heroStars');
    if (!container) return;
    for (let i = 0; i < 80; i++) {
        const star = document.createElement('div');
        star.className = 'star';
        const size = Math.random() * 3 + 1;
        star.style.cssText = `
            width:${size}px; height:${size}px;
            top:${Math.random() * 70}%;
            left:${Math.random() * 100}%;
            animation-delay:${Math.random() * 4}s;
            animation-duration:${2 + Math.random() * 3}s;
        `;
        container.appendChild(star);
    }
})();

// ── Animated number counters
(function initCounters() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            const target = parseInt(el.dataset.counter);
            const suffix = el.dataset.suffix || '';
            if (!target) return;
            let current = 0;
            const step = Math.ceil(target / 60);
            const timer = setInterval(() => {
                current = Math.min(current + step, target);
                el.textContent = current.toLocaleString() + suffix;
                if (current >= target) clearInterval(timer);
            }, 25);
            observer.unobserve(el);
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('[data-counter]').forEach(el => observer.observe(el));
})();

// window.TRIPS_DATA is already populated from the DB by the layout injection.

// ── Render trips
const tripsGrid    = document.getElementById('tripsGrid');
const loadMoreBtn  = document.getElementById('loadMoreBtn');
const loadMoreLabel = document.getElementById('loadMoreLabel');
const INITIAL_COUNT = 8;
const STEP_COUNT    = 4;

let visibleCount    = INITIAL_COUNT;
let activeCategory  = 'all';

function renderVisible() {
    const all     = window.filterByCategory(activeCategory);
    const visible = all.slice(0, visibleCount);
    window.renderTripCards(visible, lang, tripsGrid);

    if (window.__convertAllPrices) window.__convertAllPrices();

    const remaining = all.length - visibleCount;
    if (remaining > 0) {
        loadMoreLabel.textContent = lang === 'ar' ? 'عرض المزيد' : 'Show More';
        loadMoreBtn.style.display = 'inline-flex';
    } else {
        loadMoreBtn.style.display = 'none';
    }
}

window.loadMoreTrips = function() {
    visibleCount += STEP_COUNT;
    renderVisible();
};

function renderCurrentTrips(category = 'all') {
    activeCategory = category;
    visibleCount   = INITIAL_COUNT;
    renderVisible();
}

renderCurrentTrips('all');

// ── Filter tabs
document.querySelectorAll('.filter-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        renderCurrentTrips(tab.dataset.category);
    });
});

// ── Language change: re-render trips and update ticker
document.addEventListener('langChanged', (e) => {
    lang = e.detail.lang;
    renderVisible();

    // Update ticker texts
    document.querySelectorAll('.offer-text').forEach(el => {
        el.textContent = newLang === 'ar' ? el.dataset.ar : el.dataset.en;
    });

    // Update newsletter placeholder
    const emailInput = document.getElementById('newsletterEmail');
    if (emailInput) emailInput.placeholder = (window.TEXTS[newLang] || {}).newsletterPlaceholder || '';
});

// ── Newsletter
window.subscribeNewsletter = function() {
    const email = document.getElementById('newsletterEmail').value.trim();
    if (!email || !email.includes('@')) {
        alert(lang === 'ar' ? 'يرجى إدخال بريد إلكتروني صحيح' : 'Please enter a valid email address');
        return;
    }

    fetch('{{ route('newsletter.subscribe') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ email }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('newsletterForm').style.display = 'none';
            document.getElementById('newsletterSuccess').style.display = 'block';
        }
    })
    .catch(() => {
        alert(lang === 'ar' ? 'حدث خطأ، حاول مرة أخرى' : 'Something went wrong, please try again.');
    });
};

}); // end DOMContentLoaded
</script>
@endpush

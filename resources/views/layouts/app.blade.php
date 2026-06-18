<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'رحلاتي — اكتشف العالم')</title>
    <meta name="description" content="@yield('meta_desc', 'اكتشف أجمل الرحلات السياحية حول العالم مع أجواء مصرية أصيلة')">

    {{-- Canonical & hreflang --}}
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="ar" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="en" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="x-default" href="{{ url('/') }}">

    {{-- Additional SEO --}}
    <meta name="keywords" content="@yield('meta_keywords', 'رحلاتي, rahalaty, ra7laty.com, سياحة, رحلات, مصر, egypt travel, tourism, hurghada, sharm el sheikh')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <meta name="author" content="رحلاتي | Rahalaty">
    <meta name="geo.region" content="EG">
    <meta name="geo.placename" content="Cairo, Egypt">

    {{-- Open Graph --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('title', 'رحلاتي — اكتشف العالم')">
    <meta property="og:description" content="@yield('meta_desc', 'اكتشف أجمل الرحلات السياحية حول العالم مع أجواء مصرية أصيلة')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="رحلاتي | Rahalaty">
    <meta property="og:locale" content="{{ app()->getLocale() == 'ar' ? 'ar_EG' : 'en_US' }}">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="@yield('title', 'رحلاتي — اكتشف العالم')">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@rahalaty">
    <meta name="twitter:title" content="@yield('title', 'رحلاتي — اكتشف العالم')">
    <meta name="twitter:description" content="@yield('meta_desc', 'اكتشف أجمل الرحلات السياحية حول العالم مع أجواء مصرية أصيلة')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-default.jpg'))">

    {{-- Organization JSON-LD (present on all pages) --}}
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "TravelAgency",
      "name": "رحلاتي",
      "alternateName": "Rahalaty",
      "url": "{{ url('/') }}",
      "logo": "{{ asset('images/og-default.jpg') }}",
      "address": {"@@type": "PostalAddress", "addressLocality": "Cairo", "addressCountry": "EG"},
      "telephone": "+201000000000",
      "email": "info@ra7laty.com",
      "sameAs": ["{{ url('/') }}"]
    }
    </script>

    {{-- Page-specific JSON-LD & extra head --}}
    @yield('seo_head')

    <!-- Google Fonts: Cairo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 Free -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">

    @php
        $__dbTrips = \Illuminate\Support\Facades\Cache::remember('active_trips_data_json_' . app()->getLocale(), 3600, function() {
            return \App\Models\Trip::where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
                ->map(fn($t) => [
                    'id'              => $t->id,
                    'title_ar'        => $t->getTranslation('title', 'ar'),
                    'title_en'        => $t->getTranslation('title', 'en'),
                    'country_ar'      => $t->destination?->getTranslation('name', 'ar') ?? '',
                    'country_en'      => $t->destination?->getTranslation('name', 'en') ?? '',
                    'desc_ar'         => $t->getTranslation('desc', 'ar'),
                    'desc_en'         => $t->getTranslation('desc', 'en'),
                    'highlights_ar'   => $t->getTranslation('highlights', 'ar') ?? [],
                    'highlights_en'   => $t->getTranslation('highlights', 'en') ?? [],
                    'price'           => (float) $t->price,
                    'currency'        => $t->currency,
                    'duration'        => $t->duration,
                    'category'        => $t->category,
                    'climate'         => $t->climate,
                    'travel_type'     => $t->travel_type ?? [],
                    'budget_tier'     => $t->budget_tier,
                    'color_from'      => $t->color_from,
                    'color_to'        => $t->color_to,
                    'is_egyptian'     => (bool) $t->is_egyptian,
                    'spots_total'     => $t->spots_total,
                    'spots_left'      => $t->spots_left,
                    'departure_dates' => $t->departure_dates ?? [],
                    'image'           => $t->getFirstMediaUrl('image') ?: null,
                ])
                ->values()
                ->toArray();
        });
    @endphp
    <script>window.__DB_TRIPS = @json($__dbTrips);</script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body>

    {{-- Skip to main content --}}
    <a href="#main-content" class="skip-link">
        {{ app()->getLocale() === 'ar' ? 'تخطى للمحتوى الرئيسي' : 'Skip to main content' }}
    </a>

    {{-- ===================== NAVBAR ===================== --}}
    <nav class="navbar" id="mainNav" aria-label="{{ app()->getLocale() === 'ar' ? 'القائمة الرئيسية' : 'Main navigation' }}" role="navigation">
        <div style="max-width:1200px; margin:0 auto; padding:0 1.5rem; display:flex; align-items:center; justify-content:space-between; height:70px;">

            {{-- Logo --}}
            <a href="{{ route('home') }}" style="display:flex; align-items:center; gap:0.6rem; text-decoration:none;">
                {{-- Eagle of Saladin — Egypt coat of arms (Wikimedia Commons, Public Domain) --}}
                <div style="width:42px; height:42px; background:rgba(197,160,40,0.15); border-radius:50%; border:2px solid rgba(197,160,40,0.4); display:flex; align-items:center; justify-content:center; overflow:hidden; flex-shrink:0;">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Coat_of_arms_of_Egypt.svg"
                         alt="نسر مصر"
                         width="32" height="32"
                         decoding="async"
                         style="object-fit:contain; filter:brightness(1.1);">
                </div>
                <div>
                    <div style="color:#F0D060; font-weight:800; font-size:1.1rem; line-height:1.1;" data-i18n="siteName">رحلاتي</div>
                    <div style="color:#8A9BB5; font-size:0.65rem; letter-spacing:0.08em;" data-i18n="siteTagline">TRAVEL & TOURS</div>
                </div>
            </a>

            {{-- Desktop Navigation --}}
            <div style="display:flex; align-items:center; gap:0.25rem;" class="desktop-nav">
                <a href="{{ route('home') }}" class="nav-link" data-i18n="navHome">الرئيسية</a>
                <a href="{{ route('home') }}#world-trips" class="nav-link" data-i18n="navTrips">الرحلات</a>
                <a href="{{ route('destinations.index') }}" class="nav-link {{ request()->routeIs('destinations.index') ? 'active' : '' }}" data-i18n="navDestinations">كل الوجهات</a>
                <a href="{{ route('home') }}#egypt-destinations" class="nav-link" data-i18n="navEgypt">وجهات مصر</a>
                @if(session('survey_response_id'))
                <a href="{{ route('survey.results', session('survey_response_id')) }}"
                   class="nav-link"
                   style="color:#F0D060; border:1px solid rgba(197,160,40,0.4); border-radius:20px; padding:0.3rem 0.85rem; font-size:0.82rem;"
                   data-i18n="navMyResults">
                    <i class="fa-solid fa-map-location-dot fa-xs" style="margin-inline-end:0.3rem;"></i>
                    <span data-i18n="navMyResults">{{ app()->getLocale()==='ar' ? 'رحلتي' : 'My Trips' }}</span>
                </a>
                @endif
            </div>

            {{-- Right Side --}}
            <div style="display:flex; align-items:center; gap:0.75rem;">
                {{-- Currency Converter --}}
                <div style="position:relative;" id="currencyWidget">
                    <button onclick="toggleCurrencyMenu()" id="currencyBtn"
                            style="background:rgba(197,160,40,0.1); border:1px solid rgba(197,160,40,0.3); color:#F0D060; font-family:inherit; font-size:0.8rem; font-weight:700; cursor:pointer; padding:0.35rem 0.7rem; border-radius:20px; display:flex; align-items:center; gap:0.35rem; transition:all 0.2s;"
                            onmouseover="this.style.background='rgba(197,160,40,0.2)'"
                            onmouseout="this.style.background='rgba(197,160,40,0.1)'"
                            aria-haspopup="listbox"
                            aria-expanded="false"
                            aria-controls="currencyMenu"
                            aria-label="{{ app()->getLocale() === 'ar' ? 'اختيار العملة' : 'Select currency' }}">
                        <i class="fa-solid fa-coins fa-xs" aria-hidden="true"></i>
                        <span id="currencyBtnLabel">USD</span>
                        <i class="fa-solid fa-chevron-down fa-xs" style="opacity:0.6; font-size:0.6rem;" aria-hidden="true"></i>
                    </button>
                    <div id="currencyMenu" role="listbox" aria-label="{{ app()->getLocale() === 'ar' ? 'العملات المتاحة' : 'Available currencies' }}" style="display:none; position:absolute; top:calc(100% + 8px); inset-inline-end:0; background:#0D2035; border:1px solid rgba(197,160,40,0.25); border-radius:12px; padding:0.5rem; min-width:170px; z-index:999; box-shadow:0 8px 32px rgba(0,0,0,0.4);">
                        @php
                        $currencies = [
                            'USD'=>['🇺🇸','USD','$'],
                            'EUR'=>['🇪🇺','EUR','€'],
                            'GBP'=>['🇬🇧','GBP','£'],
                            'EGP'=>['🇪🇬','EGP','E£'],
                            'SAR'=>['🇸🇦','SAR','ر.س'],
                            'AED'=>['🇦🇪','AED','د.إ'],
                            'KWD'=>['🇰🇼','KWD','د.ك'],
                            'QAR'=>['🇶🇦','QAR','ر.ق'],
                        ];
                        @endphp
                        @foreach($currencies as $code => [$flag, $label, $sym])
                        <button onclick="selectCurrency('{{ $code }}','{{ $sym }}')"
                                data-currency="{{ $code }}"
                                style="display:flex; align-items:center; gap:0.5rem; width:100%; background:none; border:none; color:#C8D4E0; font-family:inherit; font-size:0.82rem; padding:0.45rem 0.65rem; border-radius:8px; cursor:pointer; text-align:start; transition:background 0.15s;"
                                onmouseover="this.style.background='rgba(197,160,40,0.12)';this.style.color='#F0D060'"
                                onmouseout="this.style.background='none';this.style.color='#C8D4E0'">
                            <span>{{ $flag }}</span>
                            <span style="font-weight:700;">{{ $label }}</span>
                            <span style="color:#64748B; font-size:0.75rem; margin-inline-start:auto;">{{ $sym }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Language Toggle --}}
                <form method="POST" action="{{ route('lang.switch', app()->getLocale() == 'ar' ? 'en' : 'ar') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="lang-btn">
                        {{ app()->getLocale() == 'ar' ? 'EN' : 'عربي' }}
                    </button>
                </form>

                {{-- CTA Button --}}
                <a href="{{ route('survey.index') }}" class="btn-gold" style="font-size:0.9rem;" data-i18n="navCta">احجز رحلتك</a>

                {{-- Mobile Menu Toggle --}}
                <button id="mobileMenuBtn"
                        style="display:none; background:none; border:none; color:#F0D060; cursor:pointer; padding:0.3rem; font-size:1.4rem;" class="mobile-only"
                        aria-label="{{ app()->getLocale() === 'ar' ? 'فتح القائمة' : 'Open menu' }}"
                        aria-expanded="false"
                        aria-controls="mobileMenu">
                    <i class="fa-solid fa-bars" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobileMenu" style="display:none; background:rgba(13,33,55,0.98); padding:1rem 1.5rem 1.5rem; border-top:1px solid rgba(197,160,40,0.2);">
            <a href="{{ route('home') }}" class="nav-link" style="display:block; padding:0.75rem 0; border-bottom:1px solid rgba(255,255,255,0.06);" data-i18n="navHome">الرئيسية</a>
            <a href="{{ route('home') }}#world-trips" class="nav-link" style="display:block; padding:0.75rem 0; border-bottom:1px solid rgba(255,255,255,0.06);" data-i18n="navTrips">الرحلات</a>
            <a href="{{ route('destinations.index') }}" class="nav-link" style="display:block; padding:0.75rem 0; border-bottom:1px solid rgba(255,255,255,0.06);" data-i18n="navDestinations">كل الوجهات</a>
            <a href="{{ route('home') }}#egypt-destinations" class="nav-link" style="display:block; padding:0.75rem 0; border-bottom:1px solid rgba(255,255,255,0.06);" data-i18n="navEgypt">وجهات مصر</a>
            <a href="{{ route('survey.index') }}" class="nav-link" style="display:block; padding:0.75rem 0; border-bottom:1px solid rgba(255,255,255,0.06);" data-i18n="navSurvey">الاستبيان</a>
            @if(session('survey_response_id'))
            <a href="{{ route('survey.results', session('survey_response_id')) }}"
               class="nav-link"
               style="display:block; padding:0.75rem 0; color:#F0D060; font-weight:700;">
                <i class="fa-solid fa-map-location-dot fa-xs" style="margin-inline-end:0.4rem;"></i>
                {{ app()->getLocale()==='ar' ? 'رحلتي' : 'My Trips' }}
            </a>
            @endif
        </div>
    </nav>

    {{-- ===================== PAGE CONTENT ===================== --}}
    <main class="page-content" id="main-content" tabindex="-1">
        @yield('content')
    </main>

    {{-- ===================== FOOTER ===================== --}}
    <footer class="site-footer">
        <div style="max-width:1200px; margin:0 auto; padding:0 1.5rem;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:2.5rem; padding-bottom:2.5rem; border-bottom:1px solid rgba(255,255,255,0.08);">

                {{-- Brand --}}
                <div>
                    <div style="display:flex; align-items:center; gap:0.6rem; margin-bottom:1rem;">
                        {{-- Eagle of Saladin — Egypt coat of arms (Wikimedia Commons, Public Domain) --}}
                        <div style="width:48px; height:48px; background:rgba(197,160,40,0.12); border-radius:50%; border:2px solid rgba(197,160,40,0.35); display:flex; align-items:center; justify-content:center; overflow:hidden; flex-shrink:0;">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Coat_of_arms_of_Egypt.svg"
                                 alt="نسر مصر"
                                 width="36" height="36"
                                 style="object-fit:contain; filter:brightness(1.1);">
                        </div>
                        <span style="color:#F0D060; font-weight:800; font-size:1.2rem;" data-i18n="siteName">رحلاتي</span>
                    </div>
                    <p style="color:#8A9BB5; font-size:0.9rem; line-height:1.7;" data-i18n="footerDesc">
                        نقدم لك أجمل الرحلات السياحية حول العالم بأجواء مصرية دافئة وخبرة تزيد على 10 سنوات.
                    </p>
                    {{-- Social Links --}}
                    <div style="display:flex; gap:0.75rem; margin-top:1.25rem;" role="list" aria-label="{{ app()->getLocale() === 'ar' ? 'روابط التواصل الاجتماعي' : 'Social media links' }}">
                        <a href="#" aria-label="Facebook" role="listitem" style="width:36px; height:36px; background:rgba(255,255,255,0.08); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#8A9BB5; text-decoration:none; transition:all 0.2s; font-size:1rem;" onmouseover="this.style.background='rgba(24,119,242,0.25)';this.style.color='#1877F2'" onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.color='#8A9BB5'">
                            <i class="fa-brands fa-facebook-f" aria-hidden="true"></i>
                        </a>
                        <a href="#" aria-label="Instagram" role="listitem" style="width:36px; height:36px; background:rgba(255,255,255,0.08); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#8A9BB5; text-decoration:none; transition:all 0.2s; font-size:1rem;" onmouseover="this.style.background='rgba(225,48,108,0.25)';this.style.color='#E1306C'" onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.color='#8A9BB5'">
                            <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                        </a>
                        <a href="#" aria-label="TikTok" role="listitem" style="width:36px; height:36px; background:rgba(255,255,255,0.08); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#8A9BB5; text-decoration:none; transition:all 0.2s; font-size:1rem;" onmouseover="this.style.background='rgba(255,255,255,0.15)';this.style.color='#ffffff'" onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.color='#8A9BB5'">
                            <i class="fa-brands fa-tiktok" aria-hidden="true"></i>
                        </a>
                        <a href="#" aria-label="YouTube" role="listitem" style="width:36px; height:36px; background:rgba(255,255,255,0.08); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#8A9BB5; text-decoration:none; transition:all 0.2s; font-size:1rem;" onmouseover="this.style.background='rgba(255,0,0,0.25)';this.style.color='#FF0000'" onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.color='#8A9BB5'">
                            <i class="fa-brands fa-youtube" aria-hidden="true"></i>
                        </a>
                        <a href="https://wa.me/201000000000" aria-label="WhatsApp" role="listitem" style="width:36px; height:36px; background:rgba(255,255,255,0.08); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#8A9BB5; text-decoration:none; transition:all 0.2s; font-size:1rem;" onmouseover="this.style.background='rgba(37,211,102,0.25)';this.style.color='#25D366'" onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.color='#8A9BB5'">
                            <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 style="color:#F0D060; font-weight:700; margin-bottom:1rem; font-size:1rem;" data-i18n="footerLinks">روابط سريعة</h4>
                    <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:0.5rem;">
                        <li><a href="{{ route('home') }}" class="footer-link" data-i18n="navHome">الرئيسية</a></li>
                        <li><a href="{{ route('home') }}#world-trips" class="footer-link" data-i18n="navTrips">الرحلات</a></li>
                        <li><a href="{{ route('home') }}#egypt-destinations" class="footer-link" data-i18n="navEgypt">وجهات مصر</a></li>
                        <li><a href="{{ route('survey.index') }}" class="footer-link" data-i18n="navSurvey">الاستبيان</a></li>
                    </ul>
                </div>

                {{-- Popular Destinations --}}
                @php $isAr = app()->getLocale() === 'ar'; @endphp
                <div>
                    <h4 style="color:#F0D060; font-weight:700; margin-bottom:1rem; font-size:1rem;" data-i18n="footerDest">{{ $isAr ? 'وجهات شهيرة' : 'Popular Destinations' }}</h4>
                    <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:0.5rem;">
                        <li><a href="#" class="footer-link">{{ $isAr ? 'الغردقة' : 'Hurghada' }}</a></li>
                        <li><a href="#" class="footer-link">{{ $isAr ? 'شرم الشيخ' : 'Sharm El-Sheikh' }}</a></li>
                        <li><a href="#" class="footer-link">{{ $isAr ? 'باريس' : 'Paris' }}</a></li>
                        <li><a href="#" class="footer-link">{{ $isAr ? 'إسطنبول' : 'Istanbul' }}</a></li>
                        <li><a href="#" class="footer-link">{{ $isAr ? 'دبي' : 'Dubai' }}</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h4 style="color:#F0D060; font-weight:700; margin-bottom:1rem; font-size:1rem;" data-i18n="footerContact">تواصل معنا</h4>
                    <div style="display:flex; flex-direction:column; gap:0.6rem; color:#8A9BB5; font-size:0.9rem;">
                        <div style="display:flex; align-items:center; gap:0.6rem;">
                            <i class="fa-solid fa-phone" style="color:#C5A028; width:14px; text-align:center;"></i>
                            <span dir="ltr">+20 100 000 0000</span>
                        </div>
                        <div style="display:flex; align-items:center; gap:0.6rem;">
                            <i class="fa-solid fa-envelope" style="color:#C5A028; width:14px; text-align:center;"></i>
                            <span>info@rehlatyy.com</span>
                        </div>
                        <div style="display:flex; align-items:center; gap:0.6rem;">
                            <i class="fa-solid fa-location-dot" style="color:#C5A028; width:14px; text-align:center;"></i>
                            <span data-i18n="footerAddress">القاهرة، مصر</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bottom bar --}}
            <div style="padding-top:1.5rem; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
                <p style="color:#4A5A6A; font-size:0.85rem; margin:0;" data-i18n="footerCopy">© 2025 رحلاتي. جميع الحقوق محفوظة.</p>
                <div style="display:flex; gap:0.5rem; align-items:center;">
                    <div style="width:20px; height:12px; background:#CE1126; border-radius:2px 0 0 2px;"></div>
                    <div style="width:20px; height:12px; background:white;"></div>
                    <div style="width:20px; height:12px; background:#000; border-radius:0 2px 2px 0;"></div>
                </div>
            </div>
        </div>
    </footer>

    {{-- ===================== WHATSAPP BUTTON ===================== --}}
    <a href="https://wa.me/201000000000?text={{ urlencode('مرحباً، أريد الاستفسار عن رحلة') }}"
       target="_blank"
       rel="noopener noreferrer"
       class="whatsapp-float"
       aria-label="{{ app()->getLocale() === 'ar' ? 'تواصل معنا عبر واتساب (يفتح في نافذة جديدة)' : 'Contact us on WhatsApp (opens in new window)' }}">
        <i class="fa-brands fa-whatsapp" style="font-size:2rem; line-height:1;" aria-hidden="true"></i>
    </a>

    @stack('scripts')

    <script>
    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        const nav = document.getElementById('mainNav');
        nav.classList.toggle('scrolled', window.scrollY > 50);
    });

    // Mobile menu toggle
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    if (mobileBtn && mobileMenu) {
        mobileBtn.addEventListener('click', () => {
            const isOpen = mobileMenu.style.display === 'block';
            mobileMenu.style.display = isOpen ? 'none' : 'block';
            mobileBtn.setAttribute('aria-expanded', String(!isOpen));
            const isAr = document.documentElement.lang === 'ar';
            mobileBtn.setAttribute('aria-label', isOpen
                ? (isAr ? 'فتح القائمة' : 'Open menu')
                : (isAr ? 'إغلاق القائمة' : 'Close menu'));
        });
    }

    // Responsive: show mobile btn
    function checkMobile() {
        const isMobile = window.innerWidth < 768;
        const desktopNav = document.querySelector('.desktop-nav');
        if (mobileBtn) mobileBtn.style.display = isMobile ? 'block' : 'none';
        if (desktopNav) desktopNav.style.display = isMobile ? 'none' : 'flex';
    }
    checkMobile();
    window.addEventListener('resize', checkMobile);

    // Fade-up on scroll (Intersection Observer)
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('visible'); }
        });
    }, { threshold: 0.12 });
    document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

    // ── Currency Converter ──────────────────────────────────────
    @php $liveRates = app(\App\Services\CurrencyService::class)->getRates(); @endphp
    const RATES = {
        USD: 1,
        EUR: {{ $liveRates['EUR'] ?? 0.92 }},
        GBP: {{ $liveRates['GBP'] ?? 0.79 }},
        EGP: {{ $liveRates['EGP'] ?? 50 }},
        SAR: {{ $liveRates['SAR'] ?? 3.75 }},
        AED: {{ $liveRates['AED'] ?? 3.67 }},
        KWD: {{ $liveRates['KWD'] ?? 0.307 }},
        QAR: {{ $liveRates['QAR'] ?? 3.64 }},
    };
    const SYMBOLS_AR = { USD:'$', EUR:'€', GBP:'£', EGP:'E£', SAR:'ر.س', AED:'د.إ', KWD:'د.ك', QAR:'ر.ق' };
    const SYMBOLS_EN = { USD:'$', EUR:'€', GBP:'£', EGP:'E£', SAR:'SAR ', AED:'AED ', KWD:'KWD ', QAR:'QAR ' };
    function getSymbols() {
        return document.documentElement.lang === 'ar' ? SYMBOLS_AR : SYMBOLS_EN;
    }
    const SYMBOLS = new Proxy({}, { get: (_, k) => getSymbols()[k] });

    let activeCurrency = localStorage.getItem('site_currency') || 'USD';

    function toggleCurrencyMenu() {
        const menu = document.getElementById('currencyMenu');
        const btn  = document.getElementById('currencyBtn');
        const open = menu.style.display === 'none';
        menu.style.display = open ? 'block' : 'none';
        btn.setAttribute('aria-expanded', String(open));
    }

    function selectCurrency(code, symbol) {
        activeCurrency = code;
        window.__activeCurrency = code;
        localStorage.setItem('site_currency', code);
        document.getElementById('currencyBtnLabel').textContent = code;
        document.getElementById('currencyMenu').style.display = 'none';
        // Highlight active
        document.querySelectorAll('[data-currency]').forEach(btn => {
            btn.style.color = btn.dataset.currency === code ? '#F0D060' : '#C8D4E0';
            btn.style.fontWeight = btn.dataset.currency === code ? '800' : 'normal';
        });
        window.__convertAllPrices();
    }

    function convertAllPrices() {
        const rate   = RATES[activeCurrency] || 1;
        const symbol = SYMBOLS[activeCurrency] || activeCurrency;
        // All elements marked data-price-usd hold the base USD price
        document.querySelectorAll('[data-price-usd]').forEach(el => {
            const usd = parseFloat(el.dataset.priceUsd);
            const converted = (usd * rate).toLocaleString(undefined, { maximumFractionDigits: 0 });
            el.textContent = symbol + converted;
        });
    }

    // Close menu on outside click
    document.addEventListener('click', function(e) {
        const widget = document.getElementById('currencyWidget');
        if (widget && !widget.contains(e.target)) {
            const menu = document.getElementById('currencyMenu');
            if (menu) menu.style.display = 'none';
        }
    });

    // Expose globally immediately (before DOMContentLoaded) so trip card
    // renderers can call convertAllPrices() even if they run first.
    window.__activeCurrency   = activeCurrency;
    window.__currencyRates    = RATES;
    window.__currencySymbols  = SYMBOLS;
    window.__convertAllPrices = convertAllPrices;

    // Init on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('currencyBtnLabel').textContent = activeCurrency;
        // Small delay to ensure JS-rendered cards (trips.js) are in DOM first
        setTimeout(convertAllPrices, 0);
    });
    </script>
</body>
</html>

@extends('layouts.app')

@php
    use Illuminate\Support\Str;
    $isAr      = app()->getLocale() === 'ar';
    $lang      = $isAr ? 'ar' : 'en';
    $tripTitle = $trip->getTranslation('title', $lang);
    $tripDesc  = $trip->getTranslation('desc',  $lang);
    $tripImage = $trip->getFirstMediaUrl('image') ?: asset('images/og-default.jpg');

    $seoTitle    = $trip->getTranslation('meta_title',    $lang) ?: $tripTitle;
    $seoDesc     = $trip->getTranslation('meta_desc',     $lang) ?: Str::limit(strip_tags($tripDesc), 155);
    $seoKeywords = $trip->getTranslation('meta_keywords', $lang) ?: ($isAr
        ? 'رحلة, ' . $tripTitle . ', رحلاتي, rahalaty, سياحة, حجز رحلات'
        : 'trip, ' . $tripTitle . ', rahalaty, tourism egypt, book trip');
@endphp

@section('title', $seoTitle . ($isAr ? ' — رحلاتي' : ' — Rahalaty'))
@section('meta_desc', $seoDesc)
@section('meta_keywords', $seoKeywords)
@section('og_type', 'product')
@section('og_image', $tripImage)

@section('seo_head')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "TouristTrip",
  "name": "{{ addslashes($tripTitle) }}",
  "description": "{{ addslashes(Str::limit(strip_tags($tripDesc), 200)) }}",
  "image": "{{ $tripImage }}",
  "touristType": @json($trip->travel_type ?? []),
  "offers": {
    "@@type": "Offer",
    "price": "{{ $trip->price }}",
    "priceCurrency": "USD",
    "availability": "{{ $trip->spots_left > 0 ? 'https://schema.org/InStock' : 'https://schema.org/SoldOut' }}",
    "url": "{{ route('trips.show', $trip->id) }}"
  },
  "provider": {
    "@@type": "TravelAgency",
    "name": "رحلاتي",
    "url": "{{ url('/') }}"
  }
}
</script>
@endsection

@push('styles')
<style>
/* ── Trip Hero ── */
.trip-hero {
    min-height: 420px;
    position: relative;
    display: flex;
    align-items: flex-end;
    overflow: hidden;
}
.trip-hero-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    transition: transform 6s ease;
}
.trip-hero:hover .trip-hero-bg { transform: scale(1.04); }
.trip-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(10,20,40,0.95) 0%, rgba(10,20,40,0.4) 60%, transparent 100%);
}
.trip-hero-content {
    position: relative;
    z-index: 2;
    padding: 2.5rem 1.5rem;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}

/* ── Breadcrumb ── */
.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.85rem;
    color: rgba(255,255,255,0.6);
    margin-bottom: 1.2rem;
    flex-wrap: wrap;
}
.breadcrumb a { color: rgba(255,255,255,0.6); text-decoration: none; }
.breadcrumb a:hover { color: #F0D060; }
.breadcrumb .sep { opacity: 0.4; }
.breadcrumb .current { color: #F0D060; }

/* ── Badge pill ── */
.badge-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.3rem 0.85rem;
    border-radius: 30px;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

/* ── Detail layout ── */
.detail-layout {
    max-width: 1200px;
    margin: 0 auto;
    padding: 3rem 1.5rem;
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 2.5rem;
    align-items: start;
}
@media (max-width: 900px) {
    .detail-layout { grid-template-columns: 1fr; }
}

/* ── Section title ── */
.det-section-title {
    font-size: 1.15rem;
    font-weight: 800;
    color: #1A3A5C;
    margin-bottom: 1.2rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #F0D060;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

/* ── Highlights grid ── */
.highlights-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}
.highlight-item {
    background: linear-gradient(135deg, #f8f4ea, #fff);
    border: 1px solid rgba(197,160,40,0.2);
    border-radius: 12px;
    padding: 1rem 1.1rem;
    display: flex;
    align-items: center;
    gap: 0.7rem;
    font-weight: 600;
    font-size: 0.9rem;
    color: #1A3A5C;
    transition: all 0.2s;
}
.highlight-item:hover {
    border-color: #C5A028;
    background: linear-gradient(135deg, #fdf5d0, #fffdf0);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(197,160,40,0.15);
}
.highlight-icon {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #C5A028, #F0D060);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1A1A1A;
    font-size: 1rem;
    flex-shrink: 0;
}

/* ── Quick facts ── */
.quick-facts {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.85rem;
    margin-top: 1rem;
}
.fact-item {
    background: #f9f9f9;
    border-radius: 10px;
    padding: 0.85rem 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}
.fact-label {
    font-size: 0.72rem;
    color: #888;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}
.fact-value {
    font-size: 1rem;
    font-weight: 800;
    color: #1A3A5C;
}

/* ── Included list ── */
.included-list {
    list-style: none;
    padding: 0;
    margin: 1rem 0 0;
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
}
.included-list li {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    font-size: 0.9rem;
    color: #444;
}
.included-list li i { color: #1A936F; width: 16px; text-align: center; }
.included-list li.not-included i { color: #C0392B; }
.included-list li.not-included { color: #999; text-decoration: line-through; }

/* ── Sidebar booking card ── */
.booking-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 40px rgba(0,0,0,0.1);
    overflow: hidden;
    position: sticky;
    top: 90px;
}
.booking-card-header {
    background: linear-gradient(135deg, #1A3A5C, #0D2138);
    padding: 1.5rem;
    text-align: center;
}
.booking-price {
    font-size: 2.4rem;
    font-weight: 900;
    color: #F0D060;
    line-height: 1;
}
.booking-price-label {
    font-size: 0.8rem;
    color: rgba(255,255,255,0.5);
    margin-top: 0.3rem;
}
.booking-card-body { padding: 1.5rem; }

.btn-book-wa {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    background: #25D366;
    color: white;
    font-weight: 800;
    font-size: 1rem;
    padding: 0.85rem 1.5rem;
    border-radius: 12px;
    text-decoration: none;
    width: 100%;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
}
.btn-book-wa:hover { background: #1ebe59; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(37,211,102,0.3); }

.btn-book-survey {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    background: linear-gradient(135deg, #C5A028, #F0D060);
    color: #1A1A1A;
    font-weight: 800;
    font-size: 0.95rem;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    text-decoration: none;
    width: 100%;
    margin-top: 0.75rem;
    transition: all 0.2s;
}
.btn-book-survey:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(197,160,40,0.3); }

.guarantee-badges {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 1.2rem;
    flex-wrap: wrap;
}
.guarantee-badge {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.2rem;
    font-size: 0.72rem;
    color: #888;
    font-weight: 600;
    text-align: center;
}
.guarantee-badge i { font-size: 1.2rem; color: #C5A028; }

/* ── Gallery ── */
.gallery-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    grid-template-rows: 160px 160px;
    gap: 0.75rem;
    border-radius: 14px;
    overflow: hidden;
    margin-top: 1rem;
}
.gallery-grid .g-main { grid-row: 1 / 3; }
.gallery-item {
    border-radius: 8px;
    overflow: hidden;
    position: relative;
}
.gallery-item-inner {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    opacity: 0.85;
    transition: opacity 0.2s, transform 0.3s;
}
.gallery-item:hover .gallery-item-inner { opacity: 1; transform: scale(1.04); }

/* ── Related trips ── */
.related-section {
    background: #FDFAF4;
    padding: 4rem 1.5rem;
}
.related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}


/* ── Loading skeleton ── */
.skeleton {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
    border-radius: 8px;
}
@keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }

/* ── Rating stars ── */
.rating-row { display: flex; align-items: center; gap: 0.4rem; margin-top: 0.4rem; }
.star-filled { color: #F0D060; }
.rating-count { font-size: 0.8rem; color: rgba(255,255,255,0.5); }
</style>
@endpush

@php
    $lang       = app()->getLocale();
    $isAr       = $lang === 'ar';
    $title      = $trip->getTranslation('title',      $lang);
    $country    = $trip->destination?->getTranslation('name', $lang) ?? '';
    $desc       = $trip->getTranslation('desc',       $lang);
    $highlights = $trip->getTranslation('highlights', $lang) ?? [];
    $catLabels  = ['beach' => ($isAr ? 'شواطئ' : 'Beach'), 'culture' => ($isAr ? 'ثقافة وتاريخ' : 'Culture'), 'adventure' => ($isAr ? 'مغامرة' : 'Adventure')];
    $catLabel   = $catLabels[$trip->category] ?? $trip->category;
    $durationLabel = $isAr ? "{$trip->duration} أيام" : "{$trip->duration} Days";
    $budgetLabels  = ['low' => ($isAr?'اقتصادية':'Budget'), 'medium' => ($isAr?'متوسطة':'Mid-range'), 'high' => ($isAr?'مرتفعة':'High-end'), 'luxury' => ($isAr?'فاخرة':'Luxury')];
    $spotsColor = $trip->spots_left <= 3 ? '#C0392B' : ($trip->spots_left <= 7 ? '#E67E22' : '#1A936F');
    $spotsPct   = $trip->spots_total > 0 ? round(($trip->spots_left / $trip->spots_total) * 100) : 0;
    $hlIcons    = ['fa-map-location-dot','fa-camera','fa-umbrella-beach','fa-mountain','fa-compass','fa-binoculars','fa-sailboat','fa-landmark'];
@endphp

@section('content')

{{-- Pass trip data to JS for related trips only --}}
<script>window.__TRIP_ID__ = {{ $trip->id }};</script>

{{-- ===================== HERO ===================== --}}
@php $heroImage = $trip->getFirstMedia('image'); @endphp
<section class="trip-hero" id="tripHero">
    <div class="trip-hero-bg" style="
        @if($heroImage)
            background-image: url('{{ $heroImage->getUrl() }}');
        @else
            background: linear-gradient(135deg, {{ $trip->color_from }} 0%, {{ $trip->color_to }} 100%);
        @endif
    "></div>
    <div class="trip-hero-overlay"></div>
    <div class="trip-hero-content">

        {{-- Breadcrumb --}}
        <nav class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house fa-xs"></i> {{ $isAr ? 'الرئيسية' : 'Home' }}</a>
            <span class="sep">/</span>
            <a href="{{ route('home') }}#world-trips">{{ $isAr ? 'الرحلات' : 'Trips' }}</a>
            <span class="sep">/</span>
            <span class="current">{{ $title }}</span>
        </nav>

        {{-- Category & Rating --}}
        <div style="display:flex; align-items:center; gap:0.75rem; flex-wrap:wrap; margin-bottom:1rem;">
            <span class="badge-pill" style="background:rgba(197,160,40,0.2); color:#F0D060; border:1px solid rgba(197,160,40,0.3);">
                <i class="fa-solid fa-tag fa-xs"></i>
                {{ $catLabel }}
            </span>
            <span class="badge-pill" style="background:rgba(255,255,255,0.1); color:white; border:1px solid rgba(255,255,255,0.15);">
                <i class="fa-regular fa-clock fa-xs"></i>
                {{ $durationLabel }}
            </span>
            <div class="rating-row">
                <span class="star-filled"><i class="fa-solid fa-star fa-xs"></i></span>
                <span class="star-filled"><i class="fa-solid fa-star fa-xs"></i></span>
                <span class="star-filled"><i class="fa-solid fa-star fa-xs"></i></span>
                <span class="star-filled"><i class="fa-solid fa-star fa-xs"></i></span>
                <span class="star-filled"><i class="fa-solid fa-star-half-stroke fa-xs"></i></span>
                <span class="rating-count" data-i18n="tripDetailReviews">(127 {{ $isAr ? 'تقييم' : 'reviews' }})</span>
            </div>
        </div>

        {{-- Title --}}
        <h1 style="font-size:clamp(2rem,5vw,3.2rem); font-weight:900; color:white; line-height:1.2; margin-bottom:0.6rem; text-shadow:0 4px 20px rgba(0,0,0,0.4);">
            {{ $title }}
        </h1>

        {{-- Country --}}
        <p style="color:rgba(255,255,255,0.7); font-size:1.05rem; display:flex; align-items:center; gap:0.5rem;">
            <i class="fa-solid fa-location-dot" style="color:#F0D060;"></i>
            {{ $country }}
        </p>

    </div>
</section>

{{-- ===================== MAIN DETAIL LAYOUT ===================== --}}
<div class="detail-layout" id="detailLayout" style="background:white;">

    {{-- ── LEFT COLUMN ── --}}
    <div>

        {{-- Description --}}
        <div style="margin-bottom:2.5rem;">
            <h2 class="det-section-title">
                <i class="fa-solid fa-circle-info" style="color:#C5A028;"></i>
                <span>{{ $isAr ? 'عن الرحلة' : 'About This Trip' }}</span>
            </h2>
            <p style="color:#555; font-size:1rem; line-height:1.9; margin-bottom:1.2rem;">{{ $desc }}</p>

            {{-- Quick facts --}}
            <div class="quick-facts">
                <div class="fact-item">
                    <span class="fact-label"><i class="fa-solid fa-dollar-sign fa-xs"></i> {{ $isAr ? 'السعر' : 'Price' }}</span>
                    <span class="fact-value" data-price-usd="{{ $trip->price }}">{{ $trip->currency }}{{ $trip->price }}</span>
                </div>
                <div class="fact-item">
                    <span class="fact-label"><i class="fa-regular fa-calendar fa-xs"></i> {{ $isAr ? 'المدة' : 'Duration' }}</span>
                    <span class="fact-value">{{ $durationLabel }}</span>
                </div>
                <div class="fact-item">
                    <span class="fact-label"><i class="fa-solid fa-tag fa-xs"></i> {{ $isAr ? 'الفئة' : 'Category' }}</span>
                    <span class="fact-value">{{ $catLabel }}</span>
                </div>
                <div class="fact-item">
                    <span class="fact-label"><i class="fa-solid fa-wallet fa-xs"></i> {{ $isAr ? 'الميزانية' : 'Budget' }}</span>
                    <span class="fact-value">{{ $budgetLabels[$trip->budget_tier] ?? $trip->budget_tier }}</span>
                </div>
            </div>
        </div>

        @php
            $galleryMedia  = $trip->getMedia('gallery');
            $galleryIcons  = ['fa-umbrella-beach', 'fa-sun', 'fa-map-location-dot', 'fa-camera', 'fa-tree'];
            $galleryColors = [
                [$trip->color_from, $trip->color_to],
                [$trip->color_to, '#1A3A5C'],
                ['#1A3A5C', $trip->color_from],
                [$trip->color_to, '#C5A028'],
                ['#C5A028', $trip->color_from],
            ];
        @endphp
        <div style="margin-bottom:2.5rem;">
            <h2 class="det-section-title">
                <i class="fa-solid fa-images" style="color:#C5A028;"></i>
                <span>{{ $isAr ? 'معرض الصور' : 'Gallery' }}</span>
            </h2>
            <div class="gallery-grid">
                @for($i = 0; $i < 5; $i++)
                <div class="gallery-item {{ $i === 0 ? 'g-main' : '' }}">
                    @if(isset($galleryMedia[$i]))
                        <div class="gallery-item-inner" style="background:#000; padding:0;">
                            <img src="{{ $galleryMedia[$i]->getUrl() }}"
                                 style="width:100%; height:100%; object-fit:cover; opacity:0.9; transition:opacity 0.2s;"
                                 alt="{{ $title }} — {{ $isAr ? 'صورة ' . ($i + 1) : 'photo ' . ($i + 1) }}"
                                 onmouseover="this.style.opacity='1'"
                                 onmouseout="this.style.opacity='0.9'">
                        </div>
                    @else
                        @php $gc = $galleryColors[$i]; @endphp
                        <div class="gallery-item-inner" style="background:linear-gradient(135deg,{{ $gc[0] }},{{ $gc[1] }}); color: white;">
                            <i class="fa-solid {{ $galleryIcons[$i] }}" style="font-size:{{ $i === 0 ? '3.5' : '2' }}rem; opacity: 0.8;"></i>
                        </div>
                    @endif
                </div>
                @endfor
            </div>
        </div>

        {{-- Highlights --}}
        <div style="margin-bottom:2.5rem;">
            <h2 class="det-section-title">
                <i class="fa-solid fa-map-pin" style="color:#C5A028;"></i>
                <span>{{ $isAr ? 'أبرز المعالم والأنشطة' : 'Highlights & Activities' }}</span>
            </h2>
            <div class="highlights-grid">
                @foreach($highlights as $i => $hl)
                <div class="highlight-item">
                    <div class="highlight-icon">
                        <i class="fa-solid {{ $hlIcons[$i % count($hlIcons)] }}"></i>
                    </div>
                    <span>{{ $hl }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- What's included --}}
        @php
            $includedItems = $trip->getTranslation('included', $lang) ?? [];
            $excludedItems = $trip->getTranslation('excluded', $lang) ?? [];
            $hasProgram    = count($includedItems) || count($excludedItems);
        @endphp
        <div style="margin-bottom:2.5rem;">
            <h2 class="det-section-title">
                <i class="fa-solid fa-list-check" style="color:#C5A028;"></i>
                <span>{{ $isAr ? 'ماذا يشمل البرنامج؟' : "What's Included?" }}</span>
            </h2>
            @if($hasProgram)
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:0 2rem;">
                @if(count($includedItems))
                <ul class="included-list">
                    @foreach($includedItems as $item)
                    <li><i class="fa-solid fa-check-circle"></i> <span>{{ $item }}</span></li>
                    @endforeach
                </ul>
                @endif
                @if(count($excludedItems))
                <ul class="included-list">
                    @foreach($excludedItems as $item)
                    <li class="not-included"><i class="fa-solid fa-xmark-circle"></i> <span>{{ $item }}</span></li>
                    @endforeach
                </ul>
                @endif
            </div>
            @else
            {{-- Fallback hardcoded list when admin hasn't filled in data yet --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:0 2rem;">
                <ul class="included-list">
                    <li><i class="fa-solid fa-check-circle"></i> <span>{{ $isAr ? 'إقامة فندقية (فطور مشمول)' : 'Hotel accommodation (breakfast included)' }}</span></li>
                    <li><i class="fa-solid fa-check-circle"></i> <span>{{ $isAr ? 'تذاكر طيران ذهاب وإياب' : 'Round-trip flight tickets' }}</span></li>
                    <li><i class="fa-solid fa-check-circle"></i> <span>{{ $isAr ? 'تأمين سفر شامل' : 'Comprehensive travel insurance' }}</span></li>
                    <li><i class="fa-solid fa-check-circle"></i> <span>{{ $isAr ? 'مرشد سياحي معتمد' : 'Certified tour guide' }}</span></li>
                </ul>
                <ul class="included-list">
                    <li><i class="fa-solid fa-check-circle"></i> <span>{{ $isAr ? 'نقل من وإلى المطار' : 'Airport transfers' }}</span></li>
                    <li><i class="fa-solid fa-check-circle"></i> <span>{{ $isAr ? 'جولات يومية منظمة' : 'Daily organized tours' }}</span></li>
                    <li class="not-included"><i class="fa-solid fa-xmark-circle"></i> <span>{{ $isAr ? 'وجبات الغداء والعشاء' : 'Lunch & dinner meals' }}</span></li>
                    <li class="not-included"><i class="fa-solid fa-xmark-circle"></i> <span>{{ $isAr ? 'النفقات الشخصية' : 'Personal expenses' }}</span></li>
                </ul>
            </div>
            @endif
        </div>

        {{-- Daily Programme --}}
        @php
            $itineraryItems = $trip->getTranslation('itinerary', $lang) ?? [];
        @endphp
        <div style="margin-bottom:2rem;">
            <h2 class="det-section-title">
                <i class="fa-solid fa-calendar-days" style="color:#C5A028;"></i>
                <span>{{ $isAr ? 'البرنامج اليومي' : 'Daily Itinerary' }}</span>
            </h2>
            <div style="margin-top:1rem;">
                @for($day = 1; $day <= $trip->duration; $day++)
                <div style="display:flex; gap:1rem; margin-bottom:1.2rem; align-items:flex-start;">
                    <div style="width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,#C5A028,#F0D060); display:flex; align-items:center; justify-content:center; font-weight:900; font-size:0.85rem; color:#1A1A1A; flex-shrink:0;">
                        {{ $day }}
                    </div>
                    <div style="flex:1; padding-top:0.2rem;">
                        <div style="font-weight:700; font-size:0.95rem; color:#1A3A5C; margin-bottom:0.2rem;">
                            {{ $isAr ? "اليوم {$day}" : "Day {$day}" }}
                        </div>
                        <div style="font-size:0.85rem; color:#777; line-height:1.6;">
                            @if(!empty($itineraryItems[$day - 1]))
                                {{ $itineraryItems[$day - 1] }}
                            @elseif($day === 1)
                                {{ $isAr ? 'الوصول إلى المطار، الاستقبال والانتقال إلى الفندق، جولة ترحيبية.' : 'Airport arrival, welcome reception, hotel check-in, orientation tour.' }}
                            @elseif($day === $trip->duration)
                                {{ $isAr ? 'إفطار في الفندق، مغادرة وإجراءات المطار، وداع دافئ.' : 'Breakfast at hotel, check-out, airport procedures, farewell.' }}
                            @else
                                @php $hlItem = $highlights[($day - 2) % max(1, count($highlights))] ?? ''; @endphp
                                {{ $isAr ? "جولة منظمة لاستكشاف {$hlItem} وأبرز المعالم." : "Organized tour to explore {$hlItem} and top attractions." }}
                            @endif
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>

    </div>

    {{-- ── RIGHT COLUMN — Booking Sidebar ── --}}
    <div>
        <div class="booking-card">
            <div class="booking-card-header">
                @if($country)<div style="font-size:0.85rem; color:rgba(255,255,255,0.7); margin-bottom:0.5rem;"><i class="fa-solid fa-location-dot fa-xs"></i> {{ $country }}</div>@endif
                <div class="booking-price" data-price-usd="{{ $trip->price }}">{{ $trip->currency }}{{ $trip->price }}</div>
                <div class="booking-price-label">{{ $isAr ? 'للشخص الواحد' : 'Per Person' }}</div>
                <div class="rating-row" style="justify-content:center; margin-top:0.6rem;">
                    <i class="fa-solid fa-star fa-xs star-filled"></i>
                    <i class="fa-solid fa-star fa-xs star-filled"></i>
                    <i class="fa-solid fa-star fa-xs star-filled"></i>
                    <i class="fa-solid fa-star fa-xs star-filled"></i>
                    <i class="fa-solid fa-star-half-stroke fa-xs star-filled"></i>
                    <span class="rating-count">4.5 / 5</span>
                </div>
            </div>
            <div class="booking-card-body">

                {{-- Duration & category pills --}}
                <div style="display:flex; gap:0.5rem; flex-wrap:wrap; margin-bottom:1.25rem;">
                    <span style="background:#f0f4f8; color:#1A3A5C; font-size:0.8rem; font-weight:700; padding:0.3rem 0.75rem; border-radius:20px; display:flex; align-items:center; gap:0.3rem;">
                        <i class="fa-regular fa-clock fa-xs" style="color:#C5A028;"></i> {{ $durationLabel }}
                    </span>
                    <span style="background:#f0f4f8; color:#1A3A5C; font-size:0.8rem; font-weight:700; padding:0.3rem 0.75rem; border-radius:20px; display:flex; align-items:center; gap:0.3rem;">
                        <i class="fa-solid fa-tag fa-xs" style="color:#C5A028;"></i> {{ $catLabel }}
                    </span>
                </div>

                {{-- Spots availability --}}
                <div style="background:#f8f9fa; border-radius:10px; padding:0.85rem 1rem; margin-bottom:1.25rem;">
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.5rem;">
                        <span style="font-size:0.8rem; color:#666; font-weight:600; display:flex; align-items:center; gap:0.4rem;">
                            <i class="fa-solid fa-user-group fa-xs" style="color:#C5A028;"></i>
                            {{ $isAr ? 'المقاعد المتاحة' : 'Available Seats' }}
                        </span>
                        <span style="font-size:0.85rem; font-weight:800; color:{{ $spotsColor }};">
                            {{ $isAr ? "{$trip->spots_left} من {$trip->spots_total} مقعد" : "{$trip->spots_left} of {$trip->spots_total} seats" }}
                        </span>
                    </div>
                    <div style="height:6px; background:#e9ecef; border-radius:4px; overflow:hidden;">
                        <div style="height:100%; border-radius:4px; width:{{ $spotsPct }}%; background:{{ $spotsColor }};"></div>
                    </div>
                    @if($trip->spots_left <= 3)
                    <div style="margin-top:0.5rem; font-size:0.75rem; color:#C0392B; font-weight:700; text-align:center;">
                        <i class="fa-solid fa-triangle-exclamation fa-xs"></i>
                        {{ $isAr ? 'سارع بالحجز — آخر المقاعد!' : 'Book now — last seats available!' }}
                    </div>
                    @endif
                </div>

                {{-- Book Now (main CTA) --}}
                <a href="{{ route('trips.book', $trip->id) }}" class="btn-book-now"
                   style="display:flex; align-items:center; justify-content:center; gap:0.6rem; background:linear-gradient(135deg,#C5A028,#F0D060); color:#1A1A1A; font-weight:800; font-size:1rem; padding:0.9rem 1.5rem; border-radius:12px; text-decoration:none; width:100%; transition:all 0.2s; margin-bottom:0.75rem;"
                   onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(197,160,40,0.4)'"
                   onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='none'">
                    <i class="fa-solid fa-calendar-check fa-lg"></i>
                    <span>{{ $isAr ? 'احجز رحلتك الآن' : 'Book Now' }}</span>
                </a>

                {{-- Book via WhatsApp --}}
                @php
                    $waMsg = urlencode($isAr ? "مرحباً، أريد الاستفسار عن رحلة: {$title}" : "Hello, I want to inquire about the trip: {$title}");
                @endphp
                <a href="https://wa.me/201000000000?text={{ $waMsg }}" class="btn-book-wa" target="_blank">
                    <i class="fa-brands fa-whatsapp fa-lg"></i>
                    <span>{{ $isAr ? 'أو احجز عبر واتساب' : 'Or Book via WhatsApp' }}</span>
                </a>

                {{-- Survey CTA --}}
                <a href="{{ route('survey.index') }}" class="btn-book-survey">
                    <i class="fa-solid fa-wand-magic-sparkles fa-sm"></i>
                    <span>{{ $isAr ? 'ابحث عن رحلة مناسبة لك' : 'Find Your Perfect Trip' }}</span>
                </a>

                {{-- Back to all trips --}}
                <a href="{{ route('home') }}#world-trips"
                   style="display:flex; align-items:center; justify-content:center; gap:0.5rem; margin-top:0.75rem; color:#8A9BB5; font-size:0.85rem; text-decoration:none; transition:color 0.2s;"
                   onmouseover="this.style.color='#1A3A5C'"
                   onmouseout="this.style.color='#8A9BB5'">
                    <i class="fa-solid fa-arrow-right fa-xs"></i>
                    <span>{{ $isAr ? 'عرض كل الرحلات' : 'View All Trips' }}</span>
                </a>

                {{-- Guarantee badges --}}
                <div class="guarantee-badges">
                    <div class="guarantee-badge">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>{{ $isAr ? 'حجز آمن' : 'Secure Booking' }}</span>
                    </div>
                    <div class="guarantee-badge">
                        <i class="fa-solid fa-headset"></i>
                        <span>{{ $isAr ? 'دعم 24/7' : '24/7 Support' }}</span>
                    </div>
                    <div class="guarantee-badge">
                        <i class="fa-solid fa-medal"></i>
                        <span>{{ $isAr ? 'ضمان الجودة' : 'Quality Guaranteed' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===================== RELATED TRIPS ===================== --}}
<div class="related-section">
    <div style="max-width:1200px; margin:0 auto;">
        <div style="text-align:center; margin-bottom:0.5rem;">
            <div class="section-badge"><i class="fa-solid fa-earth-americas" style="margin-inline-end: 0.3rem;"></i>{{ $isAr ? 'قد يعجبك أيضاً' : 'You May Also Like' }}</div>
            <h2 class="section-title" style="color:#1A3A5C;">{{ $isAr ? 'رحلات مشابهة' : 'Similar Trips' }}</h2>
        </div>
        <div class="related-grid trips-grid" id="relatedGrid"></div>
    </div>
</div>


@endsection

@push('scripts')
<script type="module">
/* Render related trips using trips.js static data (JS-side only).
   All other trip details are server-rendered via Blade above. */
(function renderRelated() {
    const tripId          = window.__TRIP_ID__;
    const lang            = document.documentElement.lang || 'ar';
    const TRIPS_DATA      = window.TRIPS_DATA      || [];
    const renderTripCards = window.renderTripCards || (() => {});

    const currentTrip = TRIPS_DATA.find(t => t.id === tripId);
    const container   = document.getElementById('relatedGrid');
    if (!container) return;

    if (!currentTrip) {
        container.innerHTML = `<p style="color:#999;text-align:center;grid-column:1/-1;">${lang === 'ar' ? 'لا توجد رحلات مشابهة حالياً.' : 'No similar trips available.'}</p>`;
        return;
    }

    const related = TRIPS_DATA.filter(t => t.category === currentTrip.category && t.id !== tripId).slice(0, 3);
    if (related.length) {
        renderTripCards(related, lang, container);
    } else {
        container.innerHTML = `<p style="color:#999;text-align:center;grid-column:1/-1;">${lang === 'ar' ? 'لا توجد رحلات مشابهة حالياً.' : 'No similar trips available.'}</p>`;
    }
})();
</script>
@endpush

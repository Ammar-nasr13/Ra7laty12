@extends('layouts.app')

@php
$isAr  = app()->getLocale() === 'ar';
$lang  = app()->getLocale();
$categoryEmoji = ['beach'=>'🏖', 'heritage'=>'🏛', 'culture'=>'🏺', 'adventure'=>'🧗'];
$currentCountry  = request('country', '');
$currentCategory = request('category', '');
@endphp

@section('title', $isAr ? 'كل الوجهات السياحية — رحلاتي' : 'All Destinations — Rahalaty')
@php $__destDesc = $isAr
    ? 'استكشف جميع الوجهات السياحية المتاحة مع رحلاتي — من شواطئ الغردقة وشرم الشيخ إلى كنوز الأقصر وأسوان والقاهرة.'
    : 'Explore all available tourist destinations with Rahalaty — from Hurghada & Sharm El-Sheikh beaches to the treasures of Luxor, Aswan & Cairo.';
@endphp
@section('meta_desc', $__destDesc)
@php $__destKw = $isAr
    ? 'وجهات سياحية, رحلاتي, الغردقة, شرم الشيخ, الأقصر, القاهرة, مصر, سياحة'
    : 'destinations, rahalaty, hurghada, sharm el sheikh, luxor, cairo, egypt tourism';
@endphp
@section('meta_keywords', $__destKw)

@section('content')

{{-- Hero --}}
<section style="background:linear-gradient(135deg,#0A1E30 0%,#1A3A5C 100%); padding:5rem 1.5rem 3rem; text-align:center;">
    <div style="max-width:700px; margin:0 auto;">
        <div style="font-size:3rem; margin-bottom:1rem;">🌍</div>
        <h1 style="font-size:clamp(2rem,5vw,3rem); font-weight:900; color:#F0D060; margin-bottom:0.75rem;">
            {{ $isAr ? 'كل الوجهات السياحية' : 'All Destinations' }}
        </h1>
        <p style="color:#94A3B8; font-size:1.05rem;">
            {{ $isAr ? 'اكتشف وجهات سياحية رائعة حول العالم' : 'Discover amazing destinations around the world' }}
        </p>
    </div>
</section>

{{-- Filters --}}
<section style="background:#F8FAFC; border-bottom:1px solid #E2E8F0; padding:1.25rem 1.5rem; position:sticky; top:0; z-index:100; box-shadow:0 2px 8px rgba(0,0,0,0.06);">
    <div style="max-width:1200px; margin:0 auto; display:flex; flex-wrap:wrap; align-items:center; gap:0.75rem;">

        {{-- Country filter --}}
        <form method="GET" action="{{ route('destinations.index') }}" id="filterForm" style="display:contents;">
            <div style="display:flex; align-items:center; gap:0.5rem; flex-wrap:wrap;">
                <span style="font-size:0.85rem; color:#64748B; font-weight:700;">
                    {{ $isAr ? 'الدولة:' : 'Country:' }}
                </span>
                <button type="submit" name="country" value=""
                        class="filter-tab {{ $currentCountry === '' ? 'active' : '' }}"
                        style="font-size:0.82rem; padding:0.35rem 0.85rem;">
                    {{ $isAr ? 'الكل' : 'All' }}
                </button>
                @foreach($countries as $c)
                <button type="submit" name="country" value="{{ $c->slug }}"
                        class="filter-tab {{ $currentCountry === $c->slug ? 'active' : '' }}"
                        style="font-size:0.82rem; padding:0.35rem 0.85rem;">
                    {{ $c->flag }} {{ $c->getTranslation('name', $lang) }}
                </button>
                @endforeach
                @if($currentCategory)
                    <input type="hidden" name="category" value="{{ $currentCategory }}">
                @endif
            </div>
        </form>

        <div style="width:1px; height:24px; background:#E2E8F0; margin:0 0.25rem;"></div>

        {{-- Category filter --}}
        <form method="GET" action="{{ route('destinations.index') }}" style="display:contents;">
            <div style="display:flex; align-items:center; gap:0.5rem; flex-wrap:wrap;">
                <span style="font-size:0.85rem; color:#64748B; font-weight:700;">
                    {{ $isAr ? 'الفئة:' : 'Category:' }}
                </span>
                @foreach(['' => ($isAr?'الكل':'All'), 'beach'=>($isAr?'🏖 شاطئ':'🏖 Beach'), 'culture'=>($isAr?'🏺 ثقافة':'🏺 Culture'), 'adventure'=>($isAr?'🧗 مغامرة':'🧗 Adventure'), 'heritage'=>($isAr?'🏛 تراث':'🏛 Heritage')] as $v => $l)
                <button type="submit" name="category" value="{{ $v }}"
                        class="filter-tab {{ $currentCategory === $v ? 'active' : '' }}"
                        style="font-size:0.82rem; padding:0.35rem 0.85rem;">
                    {{ $l }}
                </button>
                @endforeach
                @if($currentCountry)
                    <input type="hidden" name="country" value="{{ $currentCountry }}">
                @endif
            </div>
        </form>
    </div>
</section>

{{-- Destinations Grid --}}
<section style="padding:3rem 1.5rem; background:white; min-height:60vh;">
    <div style="max-width:1200px; margin:0 auto;">

        @if($destinations->count())
        <p style="font-size:0.85rem; color:#94A3B8; margin-bottom:1.5rem;">
            {{ $isAr ? 'يتم عرض ' . $destinations->count() . ' وجهة' : $destinations->count() . ' destinations found' }}
        </p>
        @endif

        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(300px, 1fr)); gap:1.5rem;">
            @forelse($destinations as $dest)
            @php
                $img     = $dest->getFirstMedia('image');
                $name    = $dest->getTranslation('name', $lang);
                $desc    = $dest->getTranslation('description', $lang);
                $emoji   = $categoryEmoji[$dest->category] ?? '📍';
                $gallery = $dest->getMedia('gallery');
            @endphp

            <a href="{{ route('destinations.show', $dest->id) }}" style="display:block; text-decoration:none;">
            <div class="egypt-dest-card fade-up"
                 style="transition-delay:{{ $loop->index * 0.05 }}s; cursor:pointer;
                    @if($img) background-image:url('{{ $img->getUrl() }}');
                    @else background:linear-gradient(135deg,#1A3A5C,#2D6A9F);
                    @endif
                    background-size:cover; background-position:center; min-height:320px;">

                {{-- Country badge --}}
                @if($dest->country)
                <div style="position:absolute; top:1rem; inset-inline-start:1rem; background:rgba(0,0,0,0.55); backdrop-filter:blur(6px); color:#fff; font-size:0.78rem; font-weight:700; padding:0.25rem 0.65rem; border-radius:20px;">
                    {{ $dest->country->flag }} {{ $dest->country->getTranslation('name', $lang) }}
                </div>
                @endif

                <div class="egypt-dest-content">
                    <h3 style="font-size:1.35rem; font-weight:800; margin-bottom:0.3rem;">{{ $name }}</h3>
                    <p style="font-size:0.88rem; opacity:0.85; margin-bottom:0.9rem; line-height:1.6;">{{ Str::limit($desc, 100) }}</p>

                    {{-- Gallery thumbnails --}}
                    @if($gallery->count() > 0)
                    <div style="display:flex; gap:4px; margin-bottom:0.75rem; overflow:hidden; border-radius:6px;">
                        @foreach($gallery->take(3) as $gm)
                        <img src="{{ $gm->getUrl() }}"
                             alt="{{ $name }}"
                             style="width:{{ $gallery->count() >= 3 ? '33.3%' : '50%' }}; height:48px; object-fit:cover; flex-shrink:0;">
                        @endforeach
                        @if($gallery->count() > 3)
                        <div style="width:33.3%; height:48px; background:rgba(0,0,0,0.55); display:flex; align-items:center; justify-content:center; font-weight:800; font-size:0.85rem; color:#fff; flex-shrink:0;">
                            +{{ $gallery->count() - 3 }}
                        </div>
                        @endif
                    </div>
                    @endif

                    <div style="display:flex; align-items:center; justify-content:space-between;">
                        <span style="background:rgba(255,255,255,0.2); padding:0.25rem 0.7rem; border-radius:20px; font-size:0.82rem; font-weight:700; text-transform:capitalize;">{{ $dest->category }}</span>
                        @if($dest->trips_count > 0)
                        <span style="color:#F0D060; font-weight:700; font-size:0.88rem;">
                            {{ $dest->trips_count }} {{ $isAr ? 'رحلة ←' : 'trips →' }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            </a>
            @empty
            <div style="grid-column:1/-1; text-align:center; padding:5rem 1rem; color:#94A3B8;">
                <div style="font-size:3rem; margin-bottom:1rem;">🗺</div>
                <h3 style="font-weight:700; color:#64748B; margin-bottom:0.5rem;">
                    {{ $isAr ? 'لا توجد وجهات' : 'No destinations found' }}
                </h3>
                <p>{{ $isAr ? 'جرّب تغيير الفلاتر' : 'Try changing the filters' }}</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

@endsection

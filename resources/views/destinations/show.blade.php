@extends('layouts.app')

@php
    use Illuminate\Support\Str;
    $isAr = app()->getLocale() === 'ar';
    $lang  = $isAr ? 'ar' : 'en';
    $name  = $destination->getTranslation('name', $lang);
    $desc  = $destination->getTranslation('description', $lang);
    $img   = $destination->getFirstMedia('image');
@endphp

@section('title', $name . ($isAr ? ' — رحلاتي' : ' — Rahalaty'))
@section('meta_desc', Str::limit(strip_tags($desc), 155))

@section('content')

{{-- Hero --}}
<section style="min-height:400px; position:relative; display:flex; align-items:flex-end; overflow:hidden;
    @if($img) background-image:url('{{ $img->getUrl() }}'); background-size:cover; background-position:center;
    @else background:linear-gradient(135deg,#0A1E30 0%,#1A3A5C 100%);
    @endif">
    <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(0,0,0,0.82) 0%, rgba(0,0,0,0.3) 55%, transparent 100%);"></div>
    <div style="position:relative; z-index:1; padding:2.5rem 1.5rem; max-width:1200px; width:100%; margin:0 auto;">
        @if($destination->country)
        <div style="display:inline-flex; align-items:center; gap:0.4rem; background:rgba(0,0,0,0.45); backdrop-filter:blur(6px); color:#fff; font-size:0.82rem; font-weight:700; padding:0.3rem 0.8rem; border-radius:20px; margin-bottom:0.9rem;">
            {{ $destination->country->flag }} {{ $destination->country->getTranslation('name', $lang) }}
        </div>
        @endif
        <h1 style="font-size:clamp(2rem,5vw,3.2rem); font-weight:900; color:white; margin-bottom:0.6rem; text-shadow:0 2px 12px rgba(0,0,0,0.5);">
            {{ $name }}
        </h1>
        @if($desc)
        <p style="color:rgba(255,255,255,0.8); font-size:1rem; line-height:1.7; max-width:620px;">
            {{ Str::limit($desc, 200) }}
        </p>
        @endif
    </div>
</section>

{{-- Trips --}}
<section style="padding:3.5rem 1.5rem; background:#F8FAFC; min-height:50vh;">
    <div style="max-width:1200px; margin:0 auto;">

        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem; flex-wrap:wrap; gap:1rem;">
            <div>
                <h2 style="font-size:1.5rem; font-weight:800; color:#1A3A5C; margin-bottom:0.2rem;">
                    {{ $isAr ? 'رحلات ' . $name : $name . ' Trips' }}
                </h2>
                <p style="color:#64748B; font-size:0.88rem;">
                    {{ $trips->count() }} {{ $isAr ? 'رحلة متاحة' : 'trips available' }}
                </p>
            </div>
            <a href="{{ route('destinations.index') }}"
               style="color:#C5A028; font-weight:700; font-size:0.9rem; text-decoration:none; display:flex; align-items:center; gap:0.4rem;">
                {{ $isAr ? '← كل الوجهات' : '← All Destinations' }}
            </a>
        </div>

        @if($trips->count())
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(300px, 1fr)); gap:1.5rem;">
            @foreach($trips as $trip)
            @php
                $tripTitle = $trip->getTranslation('title', $lang);
                $tripDesc  = $trip->getTranslation('desc', $lang);
                $tripImage = $trip->getFirstMediaUrl('image');
                $catColors = ['beach'=>'#0EA5E9','culture'=>'#8B5CF6','adventure'=>'#F97316'];
                $catColor  = $catColors[$trip->category] ?? '#64748B';
            @endphp
            <a href="{{ route('trips.show', $trip->id) }}"
               style="display:flex; flex-direction:column; text-decoration:none; border-radius:16px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,0.07); transition:transform 0.2s, box-shadow 0.2s; background:white; border:1px solid #E2E8F0;"
               onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 10px 30px rgba(0,0,0,0.13)'"
               onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 12px rgba(0,0,0,0.07)'">

                {{-- Image --}}
                <div style="height:200px; flex-shrink:0; position:relative; overflow:hidden;
                    @if($tripImage) background-image:url('{{ $tripImage }}'); background-size:cover; background-position:center;
                    @else background:linear-gradient(135deg,{{ $trip->color_from ?? '#1A3A5C' }},{{ $trip->color_to ?? '#2D6A9F' }});
                    @endif">
                    <div style="position:absolute; inset:0; background:linear-gradient(to top,rgba(0,0,0,0.35) 0%,transparent 55%);"></div>
                    <div style="position:absolute; top:0.75rem; inset-inline-start:0.75rem; background:{{ $catColor }}; color:white; font-size:0.72rem; font-weight:700; padding:0.2rem 0.6rem; border-radius:20px; text-transform:capitalize;">
                        {{ $trip->category }}
                    </div>
                    @if($trip->spots_left <= 5 && $trip->spots_left > 0)
                    <div style="position:absolute; top:0.75rem; inset-inline-end:0.75rem; background:#EF4444; color:white; font-size:0.72rem; font-weight:700; padding:0.2rem 0.6rem; border-radius:20px;">
                        {{ $isAr ? 'أماكن محدودة' : 'Limited' }}
                    </div>
                    @elseif($trip->spots_left == 0)
                    <div style="position:absolute; top:0.75rem; inset-inline-end:0.75rem; background:#6B7280; color:white; font-size:0.72rem; font-weight:700; padding:0.2rem 0.6rem; border-radius:20px;">
                        {{ $isAr ? 'مكتمل' : 'Sold out' }}
                    </div>
                    @endif
                </div>

                {{-- Body --}}
                <div style="padding:1.1rem 1.2rem; flex:1;">
                    <h3 style="font-size:1.05rem; font-weight:800; color:#1A3A5C; margin-bottom:0.35rem; line-height:1.35;">{{ $tripTitle }}</h3>
                    <p style="font-size:0.85rem; color:#64748B; line-height:1.6; margin-bottom:0.9rem;">{{ Str::limit($tripDesc, 90) }}</p>
                    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:0.5rem;">
                        <div>
                            <span data-price-usd="{{ $trip->price }}"
                                  style="font-size:1.2rem; font-weight:900; color:#C5A028;">
                                ${{ number_format($trip->price, 0) }}
                            </span>
                            <span style="font-size:0.78rem; color:#94A3B8; margin-inline-start:0.25rem;">
                                / {{ $isAr ? 'شخص' : 'person' }}
                            </span>
                        </div>
                        <div style="display:flex; align-items:center; gap:0.3rem; color:#64748B; font-size:0.82rem;">
                            <i class="fa-solid fa-clock fa-xs"></i>
                            {{ $trip->duration }} {{ $isAr ? 'يوم' : 'days' }}
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div style="padding:0.75rem 1.2rem; border-top:1px solid #F1F5F9; background:#FAFBFC;">
                    <span style="display:inline-block; background:linear-gradient(135deg,#C5A028,#F0D060); color:#1A1A1A; font-weight:800; font-size:0.85rem; padding:0.4rem 1.1rem; border-radius:20px;">
                        {{ $isAr ? 'احجز الآن ←' : 'Book Now →' }}
                    </span>
                </div>
            </a>
            @endforeach
        </div>

        @else
        <div style="text-align:center; padding:5rem 1rem; color:#94A3B8;">
            <div style="font-size:3rem; margin-bottom:1rem;">🗺</div>
            <h3 style="font-weight:700; color:#64748B; margin-bottom:0.5rem;">
                {{ $isAr ? 'لا توجد رحلات متاحة' : 'No trips available' }}
            </h3>
            <p style="margin-bottom:1.5rem;">
                {{ $isAr ? 'لا توجد رحلات نشطة لهذه الوجهة حالياً' : 'No active trips for this destination yet' }}
            </p>
            <a href="{{ route('destinations.index') }}"
               style="display:inline-block; background:linear-gradient(135deg,#C5A028,#F0D060); color:#1A1A1A; font-weight:800; padding:0.65rem 1.8rem; border-radius:12px; text-decoration:none;">
                {{ $isAr ? '← استكشف وجهات أخرى' : '← Explore Other Destinations' }}
            </a>
        </div>
        @endif

    </div>
</section>

@endsection

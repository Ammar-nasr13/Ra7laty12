@extends('layouts.app')

@php
    $isAr = app()->getLocale() === 'ar';
    $tripTitle = $booking->trip->getTranslation('title', $isAr ? 'ar' : 'en');
@endphp

@section('title', $isAr ? 'شاركنا رأيك — رحلاتي' : 'Share Your Review — Rahalaty')
@section('meta_robots', 'noindex, nofollow')

@section('content')
<div style="min-height:80vh; background:linear-gradient(135deg,#F0F4F8 0%,#EBF0F8 100%); padding:3rem 1rem; display:flex; align-items:center; justify-content:center;">
    <div style="width:100%; max-width:580px;">

        {{-- Header --}}
        <div style="text-align:center; margin-bottom:2rem;">
            <div style="font-size:3rem; margin-bottom:0.5rem;">⭐</div>
            <h1 style="font-size:1.6rem; font-weight:900; color:#1A3A5C; margin:0 0 0.5rem;">
                {{ $isAr ? 'شاركنا تجربتك!' : 'Share Your Experience!' }}
            </h1>
            <p style="color:#64748B; font-size:0.95rem; margin:0;">
                {{ $isAr ? 'رحلتك مع' : 'Your trip with' }}
                <strong style="color:#C5A028;">{{ $tripTitle }}</strong>
            </p>
        </div>

        {{-- Card --}}
        <div style="background:#fff; border-radius:20px; box-shadow:0 8px 40px rgba(0,0,0,0.08); padding:2rem;">

            @if($errors->any())
            <div role="alert" aria-live="assertive" style="background:#FEF2F2; border:1px solid #FCA5A5; border-radius:10px; padding:0.85rem 1rem; margin-bottom:1.25rem; color:#B91C1C; font-size:0.875rem;">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('review.store', ['booking' => $booking->reference]) }}{{ '?' . http_build_query(request()->query()) }}">
                @csrf

                {{-- Greeting --}}
                <div style="background:linear-gradient(135deg,#F8FAFC,#EFF6FF); border-radius:12px; padding:1rem 1.25rem; margin-bottom:1.5rem; border-{{ $isAr ? 'right' : 'left' }}:3px solid #C5A028;">
                    <p style="margin:0; font-size:0.9rem; color:#374151;">
                        {{ $isAr ? 'أهلاً' : 'Hello' }} <strong>{{ $booking->name }}</strong>،
                        {{ $isAr
                            ? ' رأيك يساعد مسافرين تانيين يختاروا رحلتهم الجاية 🙏'
                            : ' your review helps other travelers choose their next adventure 🙏' }}
                    </p>
                </div>

                {{-- Star rating --}}
                <div style="margin-bottom:1.5rem;">
                    <label style="display:block; font-size:0.875rem; font-weight:700; color:#1A3A5C; margin-bottom:0.75rem;">
                        {{ $isAr ? 'تقييمك للرحلة' : 'Your Trip Rating' }} <span style="color:#EF4444;">*</span>
                    </label>
                    <div class="star-rating" style="display:flex; gap:0.4rem; {{ $isAr ? 'flex-direction:row-reverse; justify-content:flex-end;' : '' }}">
                        @for($i = 1; $i <= 5; $i++)
                        <label style="cursor:pointer;">
                            <input type="radio" name="rating" value="{{ $i }}" style="display:none;"
                                   {{ old('rating') == $i ? 'checked' : '' }}>
                            <span class="star" data-val="{{ $i }}"
                                  style="font-size:2.2rem; color:#D1D5DB; transition:color 0.15s; user-select:none;">★</span>
                        </label>
                        @endfor
                    </div>
                    @error('rating')
                    <p id="rating-error" role="alert" style="color:#EF4444; font-size:0.78rem; margin-top:0.3rem;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Review text --}}
                <div style="margin-bottom:1.5rem;">
                    <label style="display:block; font-size:0.875rem; font-weight:700; color:#1A3A5C; margin-bottom:0.5rem;">
                        {{ $isAr ? 'اكتب رأيك' : 'Write Your Review' }} <span style="color:#EF4444;">*</span>
                    </label>
                    <textarea name="review" id="review-text" rows="5"
                              placeholder="{{ $isAr ? 'شاركنا تجربتك... ما اللي عجبك؟ وما اللي ممكن يتحسن؟' : 'Tell us about your experience... What did you love? What could be better?' }}"
                              style="width:100%; border:1px solid #E2E8F0; border-radius:10px; padding:0.85rem 1rem; font-size:0.9rem; font-family:inherit; resize:vertical; outline:none; direction:{{ $isAr ? 'rtl' : 'ltr' }}; box-sizing:border-box; transition:border-color 0.2s;"
                              onfocus="this.style.borderColor='#C5A028'"
                              onblur="this.style.borderColor='#E2E8F0'"
                              aria-describedby="review-error" @error('review') aria-invalid="true" @enderror>{{ old('review') }}</textarea>
                    @error('review')
                    <p id="review-error" role="alert" style="color:#EF4444; font-size:0.78rem; margin-top:0.3rem;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit"
                        style="width:100%; background:linear-gradient(135deg,#C5A028,#F0D060); color:#1A1A1A; font-size:1rem; font-weight:800; padding:0.9rem; border:none; border-radius:50px; cursor:pointer; font-family:inherit; letter-spacing:0.3px; transition:opacity 0.2s;"
                        onmouseover="this.style.opacity='0.88'" onmouseout="this.style.opacity='1'">
                    ✍ {{ $isAr ? 'إرسال رأيي' : 'Submit Review' }}
                </button>
            </form>
        </div>

        {{-- Back to site --}}
        <div style="text-align:center; margin-top:1.25rem;">
            <a href="{{ route('home') }}" style="color:#94A3B8; font-size:0.85rem; text-decoration:none;">
                {{ $isAr ? '← العودة للموقع' : '← Back to site' }}
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function() {
    const stars = document.querySelectorAll('.star');
    const inputs = document.querySelectorAll('input[name="rating"]');
    const isRtl = document.documentElement.dir === 'rtl';

    function highlight(val) {
        stars.forEach(s => {
            const v = parseInt(s.dataset.val);
            s.style.color = (isRtl ? v >= val : v <= val) ? '#F0D060' : '#D1D5DB';
        });
    }

    // init from old value
    const checked = document.querySelector('input[name="rating"]:checked');
    if (checked) highlight(parseInt(checked.value));

    stars.forEach(star => {
        star.addEventListener('mouseover', () => highlight(parseInt(star.dataset.val)));
        star.parentElement.addEventListener('click', () => {
            highlight(parseInt(star.dataset.val));
        });
    });

    document.querySelector('.star-rating').addEventListener('mouseleave', () => {
        const c = document.querySelector('input[name="rating"]:checked');
        highlight(c ? parseInt(c.value) : 0);
    });
})();
</script>
@endpush

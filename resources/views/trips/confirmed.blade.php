@extends('layouts.app')
@section('title', 'تم الحجز بنجاح — رحلاتي')

@push('styles')
<style>
.confirmed-page { background:#f4f7fb; min-height:100vh; padding:3rem 1.5rem; }
.confirmed-wrap { max-width:680px; margin:0 auto; }

/* ── Success card ── */
.success-card {
    background:white; border-radius:20px;
    box-shadow:0 8px 40px rgba(0,0,0,0.1);
    overflow:hidden; margin-bottom:1.5rem;
}
.success-header {
    background:linear-gradient(135deg,#1A936F,#0d7a5f);
    padding:2.5rem; text-align:center; color:white;
}
.success-icon {
    width:80px; height:80px; background:rgba(255,255,255,0.2);
    border-radius:50%; display:flex; align-items:center;
    justify-content:center; margin:0 auto 1.25rem;
    animation:popIn 0.5s cubic-bezier(0.34,1.56,0.64,1);
}
@keyframes popIn {
    from { transform:scale(0); opacity:0; }
    to   { transform:scale(1); opacity:1; }
}
.success-header h1 { font-size:1.6rem; font-weight:900; margin-bottom:0.4rem; }
.success-header p  { color:rgba(255,255,255,0.75); font-size:0.95rem; }
.ref-badge {
    display:inline-block; background:rgba(255,255,255,0.2);
    border:1px solid rgba(255,255,255,0.35);
    border-radius:30px; padding:0.4rem 1.2rem;
    font-size:0.9rem; font-weight:700; margin-top:1rem;
    letter-spacing:0.05em;
}

/* ── Details ── */
.details-body { padding:2rem; }
.det-row {
    display:flex; justify-content:space-between; align-items:flex-start;
    padding:0.75rem 0; border-bottom:1px solid #f5f5f5;
    font-size:0.9rem; gap:1rem;
}
.det-row:last-child { border-bottom:none; }
.det-label { color:#888; font-weight:600; display:flex; align-items:center; gap:0.4rem; flex-shrink:0; }
.det-label i { color:#C5A028; width:14px; text-align:center; }
.det-value { font-weight:700; color:#1A3A5C; text-align:end; }

/* ── Payment badge ── */
.pay-badge {
    display:inline-flex; align-items:center; gap:0.4rem;
    padding:0.3rem 0.8rem; border-radius:20px; font-size:0.82rem; font-weight:700;
}

/* ── Next steps ── */
.steps-card {
    background:white; border-radius:16px;
    box-shadow:0 4px 20px rgba(0,0,0,0.07);
    padding:1.75rem; margin-bottom:1.5rem;
}
.step-item {
    display:flex; gap:1rem; align-items:flex-start;
    padding:0.75rem 0; border-bottom:1px solid #f5f5f5;
}
.step-item:last-child { border-bottom:none; }
.step-num {
    width:32px; height:32px; border-radius:50%;
    background:linear-gradient(135deg,#C5A028,#F0D060);
    display:flex; align-items:center; justify-content:center;
    font-weight:900; font-size:0.85rem; color:#1A1A1A; flex-shrink:0;
}
.step-text-title { font-weight:700; font-size:0.9rem; color:#1A3A5C; margin-bottom:0.15rem; }
.step-text-sub   { font-size:0.82rem; color:#888; }

/* ── Actions ── */
.actions-row { display:flex; gap:1rem; flex-wrap:wrap; }
.btn-action-primary {
    flex:1; min-width:160px; padding:0.85rem 1.5rem;
    background:linear-gradient(135deg,#C5A028,#F0D060); color:#1A1A1A;
    font-weight:800; font-size:0.95rem; border-radius:12px;
    text-decoration:none; text-align:center; transition:all 0.2s;
    display:flex; align-items:center; justify-content:center; gap:0.5rem;
}
.btn-action-primary:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(197,160,40,0.35); }
.btn-action-secondary {
    flex:1; min-width:160px; padding:0.85rem 1.5rem;
    background:#f0f4f8; color:#1A3A5C;
    font-weight:700; font-size:0.95rem; border-radius:12px;
    text-decoration:none; text-align:center; transition:all 0.2s;
    display:flex; align-items:center; justify-content:center; gap:0.5rem;
}
.btn-action-secondary:hover { background:#e2e8f0; }
</style>
@endpush

@php
    $lang  = app()->getLocale();
    $isAr  = $lang === 'ar';
    $tripTitle   = $trip->getTranslation('title',   $lang);
    $tripCountry = $trip->destination?->getTranslation('name', $lang) ?? '';
    $durationLabel = $isAr ? "{$trip->duration} أيام" : "{$trip->duration} Days";
    $pm = ['label' => 'Paymob', 'icon' => 'fa-solid fa-shield-halved', 'bg' => '#EEF2FF', 'color' => '#1A3A5C'];
@endphp

@section('content')
<div class="confirmed-page">
<div class="confirmed-wrap">

    {{-- Success card --}}
    <div class="success-card">
        <div class="success-header">
            <div class="success-icon">
                <i class="fa-solid fa-check fa-2x"></i>
            </div>
            <h1>{{ $isAr ? 'تم الحجز بنجاح! 🎉' : 'Booking Confirmed! 🎉' }}</h1>
            <p>{{ $isAr ? 'سيتواصل معك فريقنا خلال 24 ساعة لتأكيد حجزك' : 'Our team will contact you within 24 hours to confirm your booking.' }}</p>
            <div class="ref-badge">
                <i class="fa-solid fa-hashtag fa-xs"></i>
                {{ $isAr ? 'رقم الحجز:' : 'Booking Ref:' }} {{ $booking->reference }}
            </div>
        </div>

        <div class="details-body">
            <div style="display:flex; align-items:center; gap:0.75rem; padding-bottom:1.25rem; margin-bottom:0.5rem; border-bottom:2px solid #f5f5f5;">
                <div>
                    <div style="font-weight:800; font-size:1.1rem; color:#1A3A5C;">{{ $tripTitle }}</div>
                    <div style="font-size:0.85rem; color:#888;">{{ $tripCountry }} · {{ $durationLabel }}</div>
                </div>
            </div>

            <div class="det-row">
                <span class="det-label"><i class="fa-solid fa-user"></i> {{ $isAr ? 'الاسم' : 'Name' }}</span>
                <span class="det-value">{{ $booking->name }}</span>
            </div>
            <div class="det-row">
                <span class="det-label"><i class="fa-solid fa-envelope"></i> {{ $isAr ? 'البريد' : 'Email' }}</span>
                <span class="det-value" dir="ltr">{{ $booking->email }}</span>
            </div>
            <div class="det-row">
                <span class="det-label"><i class="fa-solid fa-phone"></i> {{ $isAr ? 'الهاتف' : 'Phone' }}</span>
                <span class="det-value" dir="ltr">{{ $booking->phone }}</span>
            </div>
            <div class="det-row">
                <span class="det-label"><i class="fa-solid fa-person"></i> {{ $isAr ? 'البالغين' : 'Adults' }}</span>
                <span class="det-value">
                    {{ $booking->adults }} {{ $isAr ? ($booking->adults != 1 ? 'بالغين' : 'بالغ') : ($booking->adults != 1 ? 'Adults' : 'Adult') }}
                </span>
            </div>
            @if($booking->children > 0)
            <div class="det-row">
                <span class="det-label"><i class="fa-solid fa-child"></i> {{ $isAr ? 'الأطفال' : 'Children' }}</span>
                <span class="det-value">
                    {{ $booking->children }} {{ $isAr ? 'طفل' : ($booking->children != 1 ? 'Children' : 'Child') }}
                </span>
            </div>
            @endif
            <div class="det-row">
                <span class="det-label"><i class="fa-regular fa-calendar-check"></i> {{ $isAr ? 'تاريخ الإقلاع' : 'Departure' }}</span>
                <span class="det-value">
                    {{ \Carbon\Carbon::parse($booking->travel_date)->locale($lang)->isoFormat('D MMMM YYYY') }}
                </span>
            </div>
            <div class="det-row">
                <span class="det-label"><i class="fa-solid fa-credit-card"></i> {{ $isAr ? 'طريقة الدفع' : 'Payment' }}</span>
                <span class="det-value">
                    <span class="pay-badge" style="background:{{ $pm['bg'] }}; color:{{ $pm['color'] }};">
                        <i class="{{ $pm['icon'] }} fa-xs"></i>
                        {{ $pm['label'] }}
                    </span>
                </span>
            </div>
            <div class="det-row">
                <span class="det-label"><i class="fa-solid fa-money-bill-wave"></i> {{ $isAr ? 'المبلغ المدفوع' : 'Amount Paid' }}</span>
                <span class="det-value" style="color:#1A936F; font-size:1.15rem; font-weight:900;">
                    {{ number_format($booking->paid_amount_egp, 0) }} {{ $isAr ? 'ج.م' : 'EGP' }}
                </span>
            </div>
            @if($booking->notes)
            <div class="det-row">
                <span class="det-label"><i class="fa-regular fa-note-sticky"></i> {{ $isAr ? 'ملاحظات' : 'Notes' }}</span>
                <span class="det-value" style="max-width:300px;">{{ $booking->notes }}</span>
            </div>
            @endif
        </div>
    </div>

    {{-- Next steps --}}
    <div class="steps-card">
        <div style="font-size:1rem; font-weight:800; color:#1A3A5C; margin-bottom:1rem; display:flex; align-items:center; gap:0.5rem;">
            <i class="fa-solid fa-list-check" style="color:#C5A028;"></i>
            {{ $isAr ? 'الخطوات القادمة' : 'Next Steps' }}
        </div>
        <div class="step-item">
            <div class="step-num">1</div>
            <div>
                <div class="step-text-title">{{ $isAr ? 'تأكيد عبر البريد الإلكتروني' : 'Email Confirmation' }}</div>
                <div class="step-text-sub">{{ $isAr ? "ستصلك رسالة تأكيد على {$booking->email} خلال دقائق" : "A confirmation will be sent to {$booking->email} shortly." }}</div>
            </div>
        </div>
        <div class="step-item">
            <div class="step-num">2</div>
            <div>
                <div class="step-text-title">{{ $isAr ? 'مراجعة الحجز من فريقنا' : 'Team Review' }}</div>
                <div class="step-text-sub">{{ $isAr ? 'يراجع فريق رحلاتي حجزك ويتواصل معك خلال 24 ساعة' : 'Our team will review and contact you within 24 hours.' }}</div>
            </div>
        </div>
        <div class="step-item">
            <div class="step-num">3</div>
            <div>
                <div class="step-text-title">{{ $isAr ? 'استلام تفاصيل الرحلة' : 'Receive Trip Details' }}</div>
                <div class="step-text-sub">{{ $isAr ? 'ستستلم برنامج الرحلة الكامل وبيانات الفندق والرحلات' : 'Full itinerary, hotel info, and flight details will be sent.' }}</div>
            </div>
        </div>
        <div class="step-item">
            <div class="step-num">4</div>
            <div>
                <div class="step-text-title">{{ $isAr ? 'استمتع برحلتك! ✈' : 'Enjoy your trip! ✈' }}</div>
                <div class="step-text-sub">{{ $isAr ? 'فريقنا معك طوال الرحلة لأي مساعدة تحتاجها' : 'Our team is with you throughout your journey.' }}</div>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    @php
        $waText = urlencode($isAr
            ? 'مرحباً، حجزت رحلة برقم: '.$booking->reference.' وأريد التواصل مع فريقكم'
            : 'Hello, I booked a trip with reference: '.$booking->reference.' and would like to contact your team.');
    @endphp
    <div class="actions-row">
        <a href="https://wa.me/201000000000?text={{ $waText }}"
           target="_blank" class="btn-action-primary">
            <i class="fa-brands fa-whatsapp fa-lg"></i>
            {{ $isAr ? 'تواصل مع فريقنا' : 'Contact Our Team' }}
        </a>
        <a href="{{ route('home') }}" class="btn-action-secondary">
            <i class="fa-solid fa-house fa-sm"></i>
            {{ $isAr ? 'الرئيسية' : 'Home' }}
        </a>
        <a href="{{ route('home') }}#world-trips" class="btn-action-secondary">
            <i class="fa-solid fa-plane fa-sm"></i>
            {{ $isAr ? 'رحلات أخرى' : 'More Trips' }}
        </a>
    </div>

</div>
</div>
@endsection

@extends('layouts.app')
@section('title', app()->getLocale() == 'ar' ? 'حجز الرحلة — رحلاتي' : 'Book Trip — Rahalaty')
@section('meta_robots', 'noindex, nofollow')

@php
    $lang    = app()->getLocale();
    $isAr    = $lang === 'ar';
    $tripTitle   = $trip->getTranslation('title',   $lang);
    $tripCountry = $trip->destination?->getTranslation('name', $lang) ?? '';
    $durationLabel = $isAr ? "{$trip->duration} أيام" : "{$trip->duration} Days";
    $departureDates = $trip->departure_dates ?? [];
    $spotsColor = $trip->spots_left <= 3 ? '#C0392B' : ($trip->spots_left <= 7 ? '#E67E22' : '#1A936F');
    $spotsPct   = $trip->spots_total > 0 ? round(($trip->spots_left / $trip->spots_total) * 100) : 0;
    $monthsAr = ['يناير','فبراير','مارس','أبريل','مايو','يونيو','يوليو','أغسطس','سبتمبر','أكتوبر','نوفمبر','ديسمبر'];
    $monthsEn = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    $months   = $isAr ? $monthsAr : $monthsEn;
    $dateBadges = $isAr ? ['أقرب موعد','شهر قادم','رحلة صيفية'] : ['Nearest date','Next month','Summer trip'];
@endphp

@push('styles')
<style>
.booking-page { background:#f4f7fb; min-height:100vh; padding:2rem 1.5rem 4rem; }
.booking-wrap {
    max-width:1050px; margin:0 auto;
    display:grid; grid-template-columns:1fr 360px; gap:2rem; align-items:start;
}
@media(max-width:860px){ .booking-wrap{ grid-template-columns:1fr; } }

/* ── Step header ── */
.book-header {
    background:linear-gradient(135deg,#1A3A5C,#0D2138);
    border-radius:16px; padding:2rem; margin-bottom:2rem; color:white;
}
.book-header h1 { font-size:1.6rem; font-weight:900; margin-bottom:0.25rem; }
.book-header p  { color:rgba(255,255,255,0.6); font-size:0.9rem; }

/* ── Form card ── */
.form-card {
    background:white; border-radius:16px;
    box-shadow:0 4px 24px rgba(0,0,0,0.07); overflow:hidden;
}
.form-section { padding:1.75rem; border-bottom:1px solid #f0f0f0; }
.form-section:last-child { border-bottom:none; }
.form-section-title {
    font-size:1rem; font-weight:800; color:#1A3A5C;
    margin-bottom:1.25rem; display:flex; align-items:center; gap:0.5rem;
}
.form-section-title i { color:#C5A028; }

.form-group { margin-bottom:1.1rem; }
.form-label {
    display:block; font-size:0.85rem; font-weight:700;
    color:#444; margin-bottom:0.4rem;
}
.form-label span { color:#C0392B; margin-inline-start:2px; }
.form-control {
    width:100%; padding:0.7rem 1rem; border:1.5px solid #e2e8f0;
    border-radius:10px; font-size:0.95rem; font-family:inherit;
    transition:border-color 0.2s, box-shadow 0.2s; background:white;
    color:#1A3A5C;
}
.form-control:focus {
    outline:none; border-color:#C5A028;
    box-shadow:0 0 0 3px rgba(197,160,40,0.15);
}
.form-row { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
@media(max-width:500px){ .form-row{ grid-template-columns:1fr; } }

/* ── Paymob badge ── */
.paymob-badge {
    border:2px solid #e8f4fd; border-radius:12px; padding:1.25rem; background:#f8fbff;
}

/* ── Summary sidebar ── */
.summary-card {
    background:white; border-radius:16px;
    box-shadow:0 4px 24px rgba(0,0,0,0.07);
    overflow:hidden; position:sticky; top:90px;
}
.summary-header { padding:1.5rem; background:linear-gradient(135deg,#1A3A5C,#0D2138); color:white; }
.summary-header h3 { font-size:1.1rem; font-weight:800; margin-bottom:0.1rem; }
.summary-body { padding:1.5rem; }
.summary-row {
    display:flex; justify-content:space-between; align-items:center;
    padding:0.6rem 0; border-bottom:1px solid #f5f5f5; font-size:0.9rem;
}
.summary-row:last-child { border-bottom:none; }
.summary-row .label { color:#666; }
.summary-row .value { font-weight:700; color:#1A3A5C; }
.summary-total {
    background:linear-gradient(135deg,#f8f4ea,#fff);
    border-radius:10px; padding:1rem; margin-top:0.5rem;
    border:1px solid rgba(197,160,40,0.2);
}
.summary-total .label { font-size:0.85rem; color:#888; }
.summary-total .value { font-size:1.8rem; font-weight:900; color:#C5A028; line-height:1; }

.btn-submit-booking {
    width:100%; padding:1rem; background:linear-gradient(135deg,#C5A028,#F0D060);
    color:#1A1A1A; font-weight:800; font-size:1.05rem; border:none;
    border-radius:12px; cursor:pointer; margin-top:1.25rem;
    transition:all 0.2s; font-family:inherit;
    display:flex; align-items:center; justify-content:center; gap:0.6rem;
}
.btn-submit-booking:hover {
    transform:translateY(-2px);
    box-shadow:0 8px 24px rgba(197,160,40,0.4);
}

/* ── Error ── */
.field-error { font-size:0.78rem; color:#C0392B; margin-top:0.3rem; font-weight:600; }
</style>
@endpush

@section('content')
<div class="booking-page">
<div style="max-width:1050px; margin:0 auto;">

    {{-- Breadcrumb --}}
    <nav style="display:flex; align-items:center; gap:0.4rem; font-size:0.85rem; color:#888; margin-bottom:1.5rem; flex-wrap:wrap;">
        <a href="{{ route('home') }}" style="color:#888; text-decoration:none;"><i class="fa-solid fa-house fa-xs"></i> {{ $isAr ? 'الرئيسية' : 'Home' }}</a>
        <span>/</span>
        <a href="{{ route('home') }}#world-trips" style="color:#888; text-decoration:none;">{{ $isAr ? 'الرحلات' : 'Trips' }}</a>
        <span>/</span>
        <a href="{{ route('trips.show', $trip->id) }}" style="color:#888; text-decoration:none;">{{ $tripTitle }}</a>
        <span>/</span>
        <span style="color:#C5A028; font-weight:600;">{{ $isAr ? 'حجز الرحلة' : 'Book Trip' }}</span>
    </nav>

    {{-- Header --}}
    <div class="book-header">
        <div style="display:flex; align-items:center; gap:0.75rem; flex-wrap:wrap;">
            <div>
                <h1>{{ $tripTitle }}</h1>
                <p>{{ $tripCountry }} · {{ $durationLabel }} · {{ $isAr ? 'يبدأ من' : 'from' }} <span data-price-usd="{{ $trip->price }}">{{ $trip->currency }}{{ $trip->price }}</span></p>
            </div>
        </div>
    </div>

    <div class="booking-wrap">
        {{-- ── LEFT: Form ── --}}
        <div>
        <form method="POST" action="{{ route('trips.book.store', $trip->id) }}" id="bookingForm">
            @csrf

            {{-- 1. Traveler Info --}}
            <div class="form-card" style="margin-bottom:1.5rem;">
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-user"></i> <span data-i18n="bookSectionTraveler">بيانات المسافر</span>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label"><span data-i18n="bookLabelName">الاسم الكامل</span> <span>*</span></label>
                            <input type="text" name="name" id="booking-name" class="form-control" placeholder="مثلاً: أحمد محمد" value="{{ old('name') }}" required
                                   aria-describedby="booking-name-error" @error('name') aria-invalid="true" @enderror>
                            @error('name')<div id="booking-name-error" class="field-error" role="alert">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label"><span data-i18n="bookLabelPhone">رقم الهاتف</span> <span>*</span></label>
                            <input type="tel" name="phone" id="booking-phone" class="form-control" placeholder="+20 1XX XXX XXXX" value="{{ old('phone') }}" required
                                   aria-describedby="booking-phone-error" @error('phone') aria-invalid="true" @enderror>
                            @error('phone')<div id="booking-phone-error" class="field-error" role="alert">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><span data-i18n="bookLabelEmail">البريد الإلكتروني</span> <span>*</span></label>
                        <input type="email" name="email" id="booking-email" class="form-control" placeholder="example@email.com" value="{{ old('email') }}" required
                               aria-describedby="booking-email-error" @error('email') aria-invalid="true" @enderror>
                        @error('email')<div id="booking-email-error" class="field-error" role="alert">{{ $message }}</div>@enderror
                    </div>
                    {{-- Travelers: Adults + Children --}}
                    <div class="form-group">
                        <label class="form-label"><span data-i18n="bookLabelTravelers">عدد المسافرين</span> <span>*</span></label>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">

                            {{-- Adults --}}
                            <div style="border:1.5px solid #e2e8f0; border-radius:10px; padding:0.85rem 1rem; background:#fafafa;">
                                <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.6rem;">
                                    <i class="fa-solid fa-person" style="color:#C5A028;"></i>
                                    <span style="font-size:0.82rem; font-weight:700; color:#444;" data-i18n="bookAdults">بالغين</span>
                                    <span style="font-size:0.72rem; color:#aaa; margin-inline-start:auto;" data-i18n="bookAdultsAge">+12 سنة</span>
                                </div>
                                <div style="display:flex; align-items:center; justify-content:space-between; gap:0.5rem;">
                                    <button type="button" onclick="changeCount('adults',-1)"
                                        style="width:32px;height:32px;border-radius:50%;border:1.5px solid #e2e8f0;background:white;cursor:pointer;font-size:1.1rem;font-weight:700;color:#1A3A5C;display:flex;align-items:center;justify-content:center;transition:all 0.15s;"
                                        onmouseover="this.style.borderColor='#C5A028';this.style.color='#C5A028'"
                                        onmouseout="this.style.borderColor='#e2e8f0';this.style.color='#1A3A5C'">−</button>
                                    <span id="adultsDisplay" style="font-size:1.3rem;font-weight:900;color:#1A3A5C;min-width:24px;text-align:center;">1</span>
                                    <button type="button" onclick="changeCount('adults',1)"
                                        style="width:32px;height:32px;border-radius:50%;border:1.5px solid #e2e8f0;background:white;cursor:pointer;font-size:1.1rem;font-weight:700;color:#1A3A5C;display:flex;align-items:center;justify-content:center;transition:all 0.15s;"
                                        onmouseover="this.style.borderColor='#C5A028';this.style.color='#C5A028'"
                                        onmouseout="this.style.borderColor='#e2e8f0';this.style.color='#1A3A5C'">+</button>
                                </div>
                                <input type="hidden" name="adults" id="adultsInput" value="{{ old('adults', 1) }}">
                            </div>

                            {{-- Children --}}
                            <div style="border:1.5px solid #e2e8f0; border-radius:10px; padding:0.85rem 1rem; background:#fafafa;">
                                <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.6rem;">
                                    <i class="fa-solid fa-child" style="color:#C5A028;"></i>
                                    <span style="font-size:0.82rem; font-weight:700; color:#444;" data-i18n="bookChildren">أطفال</span>
                                    <span style="font-size:0.72rem; color:#aaa; margin-inline-start:auto;" data-i18n="bookChildrenAge">2-12 سنة</span>
                                </div>
                                <div style="display:flex; align-items:center; justify-content:space-between; gap:0.5rem;">
                                    <button type="button" onclick="changeCount('children',-1)"
                                        style="width:32px;height:32px;border-radius:50%;border:1.5px solid #e2e8f0;background:white;cursor:pointer;font-size:1.1rem;font-weight:700;color:#1A3A5C;display:flex;align-items:center;justify-content:center;transition:all 0.15s;"
                                        onmouseover="this.style.borderColor='#C5A028';this.style.color='#C5A028'"
                                        onmouseout="this.style.borderColor='#e2e8f0';this.style.color='#1A3A5C'">−</button>
                                    <span id="childrenDisplay" style="font-size:1.3rem;font-weight:900;color:#1A3A5C;min-width:24px;text-align:center;">0</span>
                                    <button type="button" onclick="changeCount('children',1)"
                                        style="width:32px;height:32px;border-radius:50%;border:1.5px solid #e2e8f0;background:white;cursor:pointer;font-size:1.1rem;font-weight:700;color:#1A3A5C;display:flex;align-items:center;justify-content:center;transition:all 0.15s;"
                                        onmouseover="this.style.borderColor='#C5A028';this.style.color='#C5A028'"
                                        onmouseout="this.style.borderColor='#e2e8f0';this.style.color='#1A3A5C'">+</button>
                                </div>
                                <input type="hidden" name="children" id="childrenInput" value="{{ old('children', 0) }}">
                            </div>

                        </div>
                        {{-- Child price note --}}
                        <div style="margin-top:0.6rem; font-size:0.78rem; color:#888; display:flex; align-items:center; gap:0.4rem;">
                            <i class="fa-solid fa-circle-info fa-xs" style="color:#C5A028;"></i>
                            <span data-i18n="bookChildNote">سعر الطفل 50% من سعر البالغ · الأطفال أقل من سنتين مجاناً</span>
                        </div>
                        @error('adults')<div class="field-error">{{ $message }}</div>@enderror
                        @error('children')<div class="field-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ $isAr ? 'تاريخ الإقلاع' : 'Departure Date' }} <span>*</span></label>
                        <div style="display:grid; gap:0.6rem; margin-top:0.25rem;" id="departureDatesWrap">
                            @foreach($departureDates as $i => $dateStr)
                            @php
                                $dt       = \Carbon\Carbon::parse($dateStr);
                                $dayNum   = $dt->day;
                                $monthIdx = (int)$dt->format('n') - 1;
                                $monthStr = $months[$monthIdx];
                                $year     = $dt->year;
                                $isChecked = old('travel_date', count($departureDates) > 0 ? $departureDates[0] : '') === $dateStr;
                                $returnDt  = $dt->copy()->addDays($trip->duration);
                                $retMonth  = $months[(int)$returnDt->format('n') - 1];
                                $badge     = $dateBadges[$i] ?? $dateBadges[array_key_last($dateBadges)];
                                $badgeBg   = $i === 0 ? 'rgba(197,160,40,0.15)' : '#f0f4f8';
                                $badgeClr  = $i === 0 ? '#C5A028' : '#888';
                            @endphp
                            <label style="display:flex; align-items:center; gap:1rem; padding:0.85rem 1rem;
                                border:2px solid {{ $isChecked ? '#C5A028' : '#e2e8f0' }};
                                border-radius:10px; cursor:pointer;
                                background:{{ $isChecked ? '#fffdf0' : 'white' }};
                                transition:all 0.2s;"
                                data-date="{{ $dateStr }}"
                                onclick="selectDate(this, '{{ $dateStr }}', '{{ $dayNum }} {{ $monthStr }} {{ $year }}')">
                                <input type="radio" name="_date_radio" value="{{ $dateStr }}"
                                    style="accent-color:#C5A028; width:18px; height:18px; flex-shrink:0;"
                                    {{ $isChecked ? 'checked' : '' }}>
                                <div style="flex:1;">
                                    <div style="font-weight:700; font-size:0.95rem; color:#1A3A5C;">
                                        <i class="fa-regular fa-calendar-check fa-xs" style="color:#C5A028; margin-inline-end:0.4rem;"></i>
                                        {{ $dayNum }} {{ $monthStr }} {{ $year }}
                                    </div>
                                    <div style="font-size:0.78rem; color:#888; margin-top:0.15rem;">
                                        <i class="fa-solid fa-clock fa-xs" style="color:#aaa;"></i>
                                        {{ $isAr ? 'مدة الرحلة' : 'Duration' }}: {{ $durationLabel }} ·
                                        {{ $isAr ? 'العودة' : 'Return' }}: {{ $returnDt->day }} {{ $retMonth }} {{ $returnDt->year }}
                                    </div>
                                </div>
                                <span style="font-size:0.75rem; font-weight:700; padding:0.2rem 0.6rem; border-radius:20px;
                                    background:{{ $badgeBg }}; color:{{ $badgeClr }};">{{ $badge }}</span>
                            </label>
                            @endforeach
                        </div>
                        <input type="hidden" name="travel_date" id="travelDateInput"
                            value="{{ old('travel_date', $departureDates[0] ?? '') }}" required
                            aria-describedby="travel-date-error" @error('travel_date') aria-invalid="true" @enderror>
                        @error('travel_date')<div id="travel-date-error" class="field-error" role="alert">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" data-i18n="bookLabelNotes">ملاحظات إضافية</label>
                        <textarea name="notes" class="form-control" rows="3" data-i18n="bookNotesPlaceholder" placeholder="أي طلبات خاصة، تفضيلات الفندق، احتياجات خاصة...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- 2. Payment Method --}}
            <div class="form-card">
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-credit-card"></i> <span>{{ $isAr ? 'طريقة الدفع' : 'Payment Method' }}</span>
                    </div>

                    <input type="hidden" name="payment_method" value="paymob">

                    <div class="paymob-badge">
                        <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:0.85rem;">
                            <img src="{{ asset('images/paymob.png') }}" alt="Paymob"
                                 style="height:40px; width:auto; object-fit:contain; flex-shrink:0;">
                            <div>
                                <div style="font-weight:800; color:#1A3A5C; font-size:0.95rem;">{{ $isAr ? 'الدفع الإلكتروني الآمن' : 'Secure Online Payment' }}</div>
                                <div style="font-size:0.78rem; color:#666;">{{ $isAr ? 'بوابة دفع معتمدة' : 'Certified payment gateway' }}</div>
                            </div>
                        </div>
                        <div style="display:flex; gap:0.5rem; flex-wrap:wrap; margin-bottom:0.85rem;">
                            <span style="padding:0.25rem 0.7rem; border-radius:6px; font-size:0.75rem; font-weight:700; border:1.5px solid #ddd; color:#1A1F71; background:white; display:flex; align-items:center; gap:0.3rem;">
                                <i class="fa-brands fa-cc-visa"></i> Visa
                            </span>
                            <span style="padding:0.25rem 0.7rem; border-radius:6px; font-size:0.75rem; font-weight:700; border:1.5px solid #ddd; color:#eb001b; background:white; display:flex; align-items:center; gap:0.3rem;">
                                <i class="fa-brands fa-cc-mastercard"></i> Mastercard
                            </span>
                            <span style="padding:0.25rem 0.7rem; border-radius:6px; font-size:0.75rem; font-weight:700; border:1.5px solid #ddd; color:#CE1126; background:white; display:flex; align-items:center; gap:0.3rem;">
                                <i class="fa-solid fa-id-card"></i> Meeza
                            </span>
                        </div>
                        <div style="font-size:0.82rem; color:#555; display:flex; align-items:center; gap:0.4rem;">
                            <i class="fa-solid fa-circle-info fa-xs" style="color:#C5A028;"></i>
                            {{ $isAr ? 'بعد تأكيد الحجز ستُحوَّل إلى صفحة الدفع الآمنة لإتمام العملية' : 'After confirming you will be redirected to the secure payment page.' }}
                        </div>
                    </div>

                    @error('payment_method')<div class="field-error" style="margin-top:0.5rem;">{{ $message }}</div>@enderror
                </div>
            </div>

        </form>
        </div>

        {{-- ── RIGHT: Summary sidebar ── --}}
        @php
            $firstDateStr = $departureDates[0] ?? null;
            $firstDateLabel = $firstDateStr
                ? (function() use ($firstDateStr, $months) {
                    $dt = \Carbon\Carbon::parse($firstDateStr);
                    return $dt->day . ' ' . $months[(int)$dt->format('n') - 1] . ' ' . $dt->year;
                  })()
                : '—';
        @endphp
        <div>
            <div class="summary-card">
                <div class="summary-header">
                    @if($tripCountry)<div style="font-size:0.8rem; opacity:0.7; margin-bottom:0.5rem;"><i class="fa-solid fa-location-dot fa-xs"></i> {{ $tripCountry }}</div>@endif
                    <h3>{{ $isAr ? 'ملخص الحجز' : 'Booking Summary' }}</h3>
                    <div style="font-size:0.8rem; color:rgba(255,255,255,0.5); margin-top:0.25rem;">{{ $tripCountry }}</div>
                </div>
                <div class="summary-body">
                    <div class="summary-row">
                        <span class="label"><i class="fa-regular fa-clock fa-xs" style="color:#C5A028;"></i> {{ $isAr ? 'المدة' : 'Duration' }}</span>
                        <span class="value">{{ $durationLabel }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="label"><i class="fa-regular fa-calendar-check fa-xs" style="color:#C5A028;"></i> {{ $isAr ? 'تاريخ الإقلاع' : 'Departure' }}</span>
                        <span class="value" id="sumDate">{{ $firstDateLabel }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="label"><i class="fa-solid fa-users fa-xs" style="color:#C5A028;"></i> {{ $isAr ? 'المسافرون' : 'Travelers' }}</span>
                        <span class="value" id="sumTravelers">{{ $isAr ? '1 بالغ' : '1 Adult' }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="label"><i class="fa-solid fa-dollar-sign fa-xs" style="color:#C5A028;"></i> {{ $isAr ? 'السعر/شخص' : 'Price/person' }}</span>
                        <span class="value" data-price-usd="{{ $trip->price }}">{{ $trip->currency }}{{ $trip->price }}</span>
                    </div>
                    <div class="summary-total">
                        <div class="label">{{ $isAr ? 'الإجمالي' : 'Total' }}</div>
                        <div class="value" id="sumTotal">{{ $trip->currency }}{{ $trip->price }}</div>
                        <div style="font-size:0.75rem; color:#888; margin-top:0.2rem;">{{ $isAr ? 'شامل جميع الخدمات' : 'All inclusive' }}</div>
                    </div>

                    {{-- Spots --}}
                    <div style="margin-top:1rem; background:#f8f9fa; border-radius:8px; padding:0.75rem;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.4rem;">
                            <span style="font-size:0.78rem; color:#666; font-weight:600;">
                                <i class="fa-solid fa-user-group fa-xs" style="color:#C5A028;"></i>
                                {{ $isAr ? 'مقاعد متبقية' : 'Seats left' }}
                            </span>
                            <span style="font-size:0.82rem; font-weight:800; color:{{ $spotsColor }};">
                                {{ $isAr ? "{$trip->spots_left} من {$trip->spots_total}" : "{$trip->spots_left} of {$trip->spots_total}" }}
                            </span>
                        </div>
                        <div style="height:5px; background:#e9ecef; border-radius:4px; overflow:hidden;">
                            <div style="height:100%; border-radius:4px; width:{{ $spotsPct }}%; background:{{ $spotsColor }};"></div>
                        </div>
                    </div>

                    {{-- Submit button --}}
                    <button type="submit" form="bookingForm" class="btn-submit-booking">
                        <i class="fa-solid fa-lock fa-sm"></i>
                        <span>{{ $isAr ? 'تأكيد الحجز — الدفع عبر Paymob' : 'Confirm & Pay via Paymob' }}</span>
                    </button>

                    <div style="display:flex; justify-content:center; gap:1.2rem; margin-top:1rem; flex-wrap:wrap;">
                        <span style="font-size:0.72rem; color:#aaa; display:flex; align-items:center; gap:0.3rem;">
                            <i class="fa-solid fa-shield-halved" style="color:#C5A028;"></i>
                            {{ $isAr ? 'دفع آمن' : 'Secure Payment' }}
                        </span>
                        <span style="font-size:0.72rem; color:#aaa; display:flex; align-items:center; gap:0.3rem;">
                            <i class="fa-solid fa-rotate-left" style="color:#C5A028;"></i>
                            {{ $isAr ? 'استرداد مجاني' : 'Free Refund' }}
                        </span>
                        <span style="font-size:0.72rem; color:#aaa; display:flex; align-items:center; gap:0.3rem;">
                            <i class="fa-solid fa-headset" style="color:#C5A028;"></i>
                            {{ $isAr ? 'دعم 24/7' : '24/7 Support' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /booking-wrap --}}
</div>
</div>
@endsection

@push('scripts')
<script>
const TRIP_PRICE    = {{ $trip->price }};
const TRIP_CURRENCY = '{{ $trip->currency }}';
const IS_AR         = {{ $isAr ? 'true' : 'false' }};

// Departure date selection → update hidden input + sumDate display
function selectDate(label, dateStr, dateLabel) {
    document.getElementById('travelDateInput').value = dateStr;
    document.getElementById('sumDate').textContent   = dateLabel;
    document.querySelectorAll('#departureDatesWrap label').forEach(l => {
        l.style.borderColor = '#e2e8f0';
        l.style.background  = 'white';
    });
    label.style.borderColor = '#C5A028';
    label.style.background  = '#fffdf0';
}

// Travelers counter + live total update
function changeCount(type, delta) {
    const input   = document.getElementById(type + 'Input');
    const display = document.getElementById(type + 'Display');
    const min = type === 'adults' ? 1 : 0;
    let val = Math.max(min, Math.min(10, parseInt(input.value) + delta));
    input.value = val;
    display.textContent = val;
    updateTotal();
}

function updateTotal() {
    const adults   = parseInt(document.getElementById('adultsInput').value)   || 0;
    const children = parseInt(document.getElementById('childrenInput').value) || 0;
    const totalUsd = (TRIP_PRICE * adults) + (TRIP_PRICE * 0.5 * children);

    const currency = window.__activeCurrency || 'USD';
    const rate     = (window.__currencyRates   || {})[currency] || 1;
    const symbol   = (window.__currencySymbols || {})[currency] || currency;
    const total    = totalUsd * rate;

    const aWord = IS_AR ? (adults !== 1 ? 'بالغين' : 'بالغ') : (adults !== 1 ? 'Adults' : 'Adult');
    const cWord = IS_AR ? 'طفل' : (children !== 1 ? 'Children' : 'Child');
    document.getElementById('sumTravelers').textContent = children > 0
        ? `${adults} ${aWord} + ${children} ${cWord}`
        : `${adults} ${aWord}`;
    document.getElementById('sumTotal').textContent = symbol + total.toLocaleString(undefined, { maximumFractionDigits: 0 });
}

document.addEventListener('DOMContentLoaded', function() {
    updateTotal();
    // إعادة حساب الإجمالي عند تغيير العملة
    const _orig = window.__convertAllPrices;
    window.__convertAllPrices = function() {
        if (_orig) _orig();
        updateTotal();
    };
});

</script>
@endpush

@extends('layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'استبيان الرحلات — رحلاتي' : 'Trip Survey — Rehlatyy')
@section('meta_desc', app()->getLocale() == 'ar' ? 'استبيان تفضيلات السفر من رحلاتي. أجب على بضعة أسئلة وسيقوم نظامنا الذكي باقتراح أفضل الرحلات المناسبة لك ميزانية ووجهة.' : 'Trip Survey by Rahalaty. Answer a few questions and our smart system will recommend the best trips matching your budget and preferences.')
@section('meta_keywords', app()->getLocale() == 'ar' ? 'استبيان السفر, استبيان تفضيلات السفر, رحلاتي, اختيار وجهة سياحية' : 'trip survey, travel preferences, rahalaty, choose destination')

@section('content')

<div style="min-height:100vh; background:linear-gradient(160deg, #0D2137 0%, #1A3A5C 50%, #2A5A8C 100%); padding:5rem 1rem 3rem; position:relative; overflow:hidden;">

    {{-- Pyramid background --}}
    <div style="position:absolute; bottom:0; left:0; right:0; pointer-events:none; opacity:0.06;">
        <svg viewBox="0 0 1440 200" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="width:100%; height:200px;">
            <polygon points="720,10 500,195 940,195" fill="#C5A028"/>
            <polygon points="150,80 60,195 240,195" fill="#C5A028"/>
            <polygon points="1290,80 1200,195 1380,195" fill="#C5A028"/>
        </svg>
    </div>

    {{-- Page Header --}}
    <div style="text-align:center; margin-bottom:2.5rem; position:relative; z-index:1;">
        <div style="font-size:2.5rem; margin-bottom:0.5rem;">🧭</div>
        <h1 style="color:white; font-size:clamp(1.6rem,4vw,2.4rem); font-weight:800; margin-bottom:0.5rem;" data-i18n="surveyPageTitle">
            استبيان الرحلات
        </h1>
        <p style="color:#8A9BB5; font-size:1rem;" data-i18n="surveyPageSub">
            أجب على هذه الأسئلة لنجد لك الرحلة المثالية
        </p>
    </div>

    {{-- Survey Form --}}
    <div class="survey-wrapper" style="position:relative; z-index:1;">

        {{-- Header with progress --}}
        <div class="survey-header" aria-live="polite" aria-atomic="true">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.5rem;">
                <span style="font-size:0.85rem; opacity:0.7;" id="stepLabel" data-i18n-template="stepOf" data-step="1" aria-live="polite">خطوة 1 من 4</span>
                <span style="font-size:0.85rem; opacity:0.7;" id="stepPercent" aria-hidden="true">25%</span>
            </div>
            <div class="survey-progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" aria-labelledby="stepLabel">
                <div class="survey-progress-fill" id="progressFill" style="width:25%;"></div>
            </div>
        </div>

        <form id="surveyForm" action="{{ route('survey.store') }}" method="POST" novalidate>
            @csrf

            {{-- ── STEP 1: Personal Info ── --}}
            <div class="survey-step active" id="step1">
                <h2 style="font-size:1.2rem; font-weight:800; color:#1A3A5C; margin-bottom:0.3rem;" data-i18n="step1Title">أولاً — بياناتك الشخصية</h2>
                <p style="color:#888; font-size:0.9rem; margin-bottom:1.5rem;" data-i18n="step1Sub">حتى نتواصل معك بنتائجك</p>

                <div style="margin-bottom:1.25rem;">
                    <label class="survey-label" for="name" data-i18n="labelName">الاسم الكريم</label>
                    <input type="text" name="name" id="name" class="survey-input" required
                        placeholder="اكتب اسمك هنا" autocomplete="name">
                    <div class="field-error" id="nameError" style="color:#CE1126; font-size:0.82rem; margin-top:0.3rem; display:none;"></div>
                </div>

                <div style="margin-bottom:1.25rem;">
                    <label class="survey-label" for="email" data-i18n="labelEmail">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email" class="survey-input" required
                        placeholder="example@email.com" dir="ltr" autocomplete="email">
                    <div class="field-error" id="emailError" style="color:#CE1126; font-size:0.82rem; margin-top:0.3rem; display:none;"></div>
                </div>

                <div style="margin-bottom:1rem;">
                    <label class="survey-label" for="phone" data-i18n="labelPhone">رقم الهاتف (اختياري)</label>
                    <input type="tel" name="phone" id="phone" class="survey-input"
                        placeholder="+20 100 000 0000" dir="ltr" autocomplete="tel">
                </div>
            </div>

            {{-- ── STEP 2: Travel Type ── --}}
            <div class="survey-step" id="step2">
                <h2 style="font-size:1.2rem; font-weight:800; color:#1A3A5C; margin-bottom:0.3rem;" id="step2Title" data-i18n="step2Title">ثانياً — نوع رحلتك</h2>
                <p style="color:#888; font-size:0.9rem; margin-bottom:1.5rem;" data-i18n="step2Sub">مع من ستسافر؟</p>

                <div class="survey-option-grid" role="group" aria-labelledby="step2Title">
                    <div class="survey-option" role="button" tabindex="0" aria-pressed="false" data-field="travel_type" data-value="family">
                        <span class="option-icon" aria-hidden="true"><i class="fa-solid fa-people-roof"></i></span>
                        <span class="option-label" data-i18n="optFamily">مع العائلة</span>
                    </div>
                    <div class="survey-option" role="button" tabindex="0" aria-pressed="false" data-field="travel_type" data-value="couple">
                        <span class="option-icon" aria-hidden="true"><i class="fa-solid fa-heart"></i></span>
                        <span class="option-label" data-i18n="optCouple">مع الشريك</span>
                    </div>
                    <div class="survey-option" role="button" tabindex="0" aria-pressed="false" data-field="travel_type" data-value="solo">
                        <span class="option-icon" aria-hidden="true"><i class="fa-solid fa-person"></i></span>
                        <span class="option-label" data-i18n="optSolo">منفرداً</span>
                    </div>
                    <div class="survey-option" role="button" tabindex="0" aria-pressed="false" data-field="travel_type" data-value="friends">
                        <span class="option-icon" aria-hidden="true"><i class="fa-solid fa-user-group"></i></span>
                        <span class="option-label" data-i18n="optFriends">مع الأصدقاء</span>
                    </div>
                </div>
                <input type="hidden" name="travel_type" id="travel_type_input" required>
                <div class="field-error" id="travelTypeError" role="alert" style="color:#CE1126; font-size:0.82rem; margin-top:0.75rem; display:none;"></div>
            </div>

            {{-- ── STEP 3: Preferences ── --}}
            <div class="survey-step" id="step3">
                <h2 style="font-size:1.2rem; font-weight:800; color:#1A3A5C; margin-bottom:0.3rem;" data-i18n="step3Title">ثالثاً — تفضيلاتك</h2>
                <p style="color:#888; font-size:0.9rem; margin-bottom:1.5rem;" data-i18n="step3Sub">أخبرنا عن ميزانيتك وتفضيلاتك</p>

                {{-- Budget --}}
                <div style="margin-bottom:1.5rem;">
                    <label class="survey-label" data-i18n="labelBudget">الميزانية المتاحة (للشخص الواحد)</label>
                    <div style="display:flex; flex-direction:column; gap:0.6rem;">
                        @foreach(['low'=>'اقتصادي (أقل من $500)','medium'=>'متوسط ($500 - $1500)','high'=>'مرتفع ($1500 - $3000)','luxury'=>'فاخر (أكثر من $3000)'] as $val=>$label)
                        <label style="display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1rem; border:2px solid #E8D5A3; border-radius:10px; cursor:pointer; transition:all 0.2s;" class="budget-option">
                            <input type="radio" name="budget" value="{{ $val }}" style="accent-color:#C5A028; width:18px; height:18px;">
                            <span style="font-weight:600; color:#1A3A5C; font-size:0.95rem;" data-i18n="optBudget{{ ucfirst($val) }}">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                    <div class="field-error" id="budgetError" style="color:#CE1126; font-size:0.82rem; margin-top:0.3rem; display:none;"></div>
                </div>

                {{-- Climate --}}
                <div style="margin-bottom:1.5rem;">
                    <p class="survey-label" id="climateLabel" data-i18n="labelClimate">المناخ المفضل</p>
                    <div class="survey-option-grid" role="group" aria-labelledby="climateLabel">
                        <div class="survey-option" role="button" tabindex="0" aria-pressed="false" data-field="preferred_climate" data-value="beach">
                            <span class="option-icon" aria-hidden="true"><i class="fa-solid fa-umbrella-beach"></i></span>
                            <span class="option-label" data-i18n="optCliBeach">شاطئ وبحر</span>
                        </div>
                        <div class="survey-option" role="button" tabindex="0" aria-pressed="false" data-field="preferred_climate" data-value="desert">
                            <span class="option-icon" aria-hidden="true"><i class="fa-solid fa-sun"></i></span>
                            <span class="option-label" data-i18n="optCliDesert">صحراء وتاريخ</span>
                        </div>
                        <div class="survey-option" role="button" tabindex="0" aria-pressed="false" data-field="preferred_climate" data-value="mountain">
                            <span class="option-icon" aria-hidden="true"><i class="fa-solid fa-mountain-sun"></i></span>
                            <span class="option-label" data-i18n="optCliMountain">جبال وطبيعة</span>
                        </div>
                        <div class="survey-option" role="button" tabindex="0" aria-pressed="false" data-field="preferred_climate" data-value="city">
                            <span class="option-icon" aria-hidden="true"><i class="fa-solid fa-city"></i></span>
                            <span class="option-label" data-i18n="optCliCity">مدن ومعالم</span>
                        </div>
                    </div>
                    <input type="hidden" name="preferred_climate" id="climate_input" required>
                    <div class="field-error" id="climateError" role="alert" style="color:#CE1126; font-size:0.82rem; margin-top:0.75rem; display:none;"></div>
                </div>

                {{-- Duration --}}
                <div>
                    <label class="survey-label" data-i18n="labelDuration">مدة الرحلة المفضلة</label>
                    <div style="display:flex; flex-direction:column; gap:0.6rem;">
                        @foreach(['weekend'=>'عطلة نهاية الأسبوع (2-3 أيام)','week'=>'أسبوع (4-7 أيام)','twoweeks'=>'أسبوعين (8-14 يوم)','month'=>'شهر أو أكثر'] as $val=>$label)
                        <label style="display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1rem; border:2px solid #E8D5A3; border-radius:10px; cursor:pointer; transition:all 0.2s;" class="duration-option">
                            <input type="radio" name="duration_preference" value="{{ $val }}" style="accent-color:#C5A028; width:18px; height:18px;">
                            <span style="font-weight:600; color:#1A3A5C; font-size:0.95rem;" data-i18n="optDur{{ ucfirst($val) }}">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                    <div class="field-error" id="durationError" style="color:#CE1126; font-size:0.82rem; margin-top:0.3rem; display:none;"></div>
                </div>
            </div>

            {{-- ── STEP 4: Notes & Submit ── --}}
            <div class="survey-step" id="step4">
                <h2 style="font-size:1.2rem; font-weight:800; color:#1A3A5C; margin-bottom:0.3rem;" data-i18n="step4Title">رابعاً — ملاحظات إضافية</h2>
                <p style="color:#888; font-size:0.9rem; margin-bottom:1.5rem;" data-i18n="step4Sub">أي طلبات خاصة تريد إضافتها؟</p>

                {{-- Summary --}}
                <div style="background:#F7EDD5; border-radius:12px; padding:1.25rem; margin-bottom:1.5rem; border:1px solid #E8D5A3;">
                    <div style="font-weight:700; color:#1A3A5C; margin-bottom:0.75rem; font-size:0.95rem;">📋 ملخص إجاباتك</div>
                    <div id="summaryCells" style="display:flex; flex-direction:column; gap:0.4rem; font-size:0.88rem; color:#555;"></div>
                </div>

                <div style="margin-bottom:1rem;">
                    <label class="survey-label" for="message" data-i18n="labelMessage">ملاحظات إضافية (اختياري)</label>
                    <textarea name="message" id="message" class="survey-input" rows="4"
                        style="resize:vertical;"
                        placeholder="مثلاً: أريد فندق 5 نجوم، أو أفضل الأماكن الهادئة..."></textarea>
                </div>
            </div>

            {{-- Navigation buttons --}}
            <div class="survey-nav">
                <button type="button" class="btn-survey-back" id="btnBack" style="visibility:hidden;" data-i18n="btnBack">→ رجوع</button>
                <button type="button" class="btn-survey-next" id="btnNext" data-i18n="btnNext">التالي ←</button>
            </div>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

const serverLang = '{{ app()->getLocale() }}';
let lang = document.documentElement.lang || serverLang || 'ar';

// ── State
let currentStep = 1;
const totalSteps = 4;
const answers = { travel_type: null, preferred_climate: null };

// ── DOM refs
const steps = () => document.querySelectorAll('.survey-step');
const btnNext = document.getElementById('btnNext');
const btnBack = document.getElementById('btnBack');
const progressFill = document.getElementById('progressFill');
const stepLabel = document.getElementById('stepLabel');
const stepPercent = document.getElementById('stepPercent');

// ── Update progress UI
function updateProgress() {
    const pct = Math.round((currentStep / totalSteps) * 100);
    progressFill.style.width = pct + '%';
    stepPercent.textContent = pct + '%';
    const progressBar = document.querySelector('.survey-progress-bar');
    if (progressBar) progressBar.setAttribute('aria-valuenow', pct);
    const t = (window.TEXTS || {})[lang] || (window.TEXTS || {})['ar'] || {};
    stepLabel.textContent = (t.stepOf || 'خطوة %s من 4').replace('%s', currentStep);
    btnBack.style.visibility = currentStep === 1 ? 'hidden' : 'visible';

    const isLast = currentStep === totalSteps;
    btnNext.dataset.i18n = isLast ? 'btnSubmit' : 'btnNext';
    btnNext.innerHTML = isLast
        ? (t.btnSubmit || '<i class="fa-solid fa-wand-magic-sparkles fa-sm"></i> اعرض رحلاتي')
        : (t.btnNext  || 'التالي <i class="fa-solid fa-arrow-left fa-sm"></i>');

    if (currentStep === totalSteps) buildSummary();
}

// ── Show step
function showStep(n) {
    steps().forEach((s, i) => {
        s.classList.toggle('active', i + 1 === n);
    });
    currentStep = n;
    updateProgress();
}

// ── Option card select handler
function selectOption(opt) {
    const field = opt.dataset.field;
    const val   = opt.dataset.value;
    answers[field] = val;

    // Update hidden input
    const input = document.getElementById(
        field === 'travel_type' ? 'travel_type_input' : 'climate_input'
    );
    if (input) input.value = val;

    // Update UI + aria-pressed
    document.querySelectorAll(`.survey-option[data-field="${field}"]`)
        .forEach(o => { o.classList.remove('selected'); o.setAttribute('aria-pressed', 'false'); });
    opt.classList.add('selected');
    opt.setAttribute('aria-pressed', 'true');

    // Clear error
    clearError(field === 'travel_type' ? 'travelTypeError' : 'climateError');
}

// ── Option card clicks (travel_type, preferred_climate)
document.querySelectorAll('.survey-option').forEach(opt => {
    opt.addEventListener('click', () => selectOption(opt));
    opt.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            selectOption(opt);
        }
    });
});

// Budget & duration radio highlight
document.querySelectorAll('.budget-option, .duration-option').forEach(label => {
    label.addEventListener('click', () => {
        const name = label.querySelector('input').name;
        document.querySelectorAll(`label.${name === 'budget' ? 'budget' : 'duration'}-option`).forEach(l => {
            l.style.borderColor = '#E8D5A3';
            l.style.background  = 'white';
        });
        label.style.borderColor = '#C5A028';
        label.style.background  = 'rgba(197,160,40,0.07)';
    });
});

// ── Validation
function validateStep(n) {
    let ok = true;

    if (n === 1) {
        const name  = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        if (!name) { showError('nameError', lang === 'ar' ? 'الاسم مطلوب' : 'Name is required'); ok = false; }
        else clearError('nameError');
        if (!email || !email.includes('@')) { showError('emailError', lang === 'ar' ? 'بريد إلكتروني صحيح مطلوب' : 'Valid email required'); ok = false; }
        else clearError('emailError');
    }

    if (n === 2) {
        if (!answers.travel_type) {
            showError('travelTypeError', lang === 'ar' ? 'يرجى اختيار نوع الرحلة' : 'Please select a travel type');
            ok = false;
        } else clearError('travelTypeError');
    }

    if (n === 3) {
        const budget   = document.querySelector('input[name="budget"]:checked');
        const duration = document.querySelector('input[name="duration_preference"]:checked');
        if (!budget) { showError('budgetError', lang === 'ar' ? 'يرجى اختيار الميزانية' : 'Please select a budget'); ok = false; }
        else clearError('budgetError');
        if (!answers.preferred_climate) {
            showError('climateError', lang === 'ar' ? 'يرجى اختيار المناخ' : 'Please select a climate');
            ok = false;
        } else clearError('climateError');
        if (!duration) { showError('durationError', lang === 'ar' ? 'يرجى اختيار المدة' : 'Please select a duration'); ok = false; }
        else clearError('durationError');
    }

    return ok;
}

function showError(id, msg) {
    const el = document.getElementById(id);
    if (el) { el.textContent = msg; el.style.display = 'block'; }
}
function clearError(id) {
    const el = document.getElementById(id);
    if (el) { el.style.display = 'none'; }
}

// ── Build step 4 summary
function buildSummary() {
    const t = (window.TEXTS || {})[lang] || (window.TEXTS || {})['ar'] || {};
    const budget   = document.querySelector('input[name="budget"]:checked')?.value;
    const duration = document.querySelector('input[name="duration_preference"]:checked')?.value;

    const budgetLabels   = { low: t.optBudgetLow, medium: t.optBudgetMed, high: t.optBudgetHigh, luxury: t.optBudgetLux };
    const climateLabels  = { beach: t.optCliBeach, desert: t.optCliDesert, mountain: t.optCliMountain, city: t.optCliCity };
    const travelLabels   = { family: t.optFamily, couple: t.optCouple, solo: t.optSolo, friends: t.optFriends };
    const durationLabels = { weekend: t.optDurWeekend, week: t.optDurWeek, twoweeks: t.optDurTwoWeeks, month: t.optDurMonth };

    const rows = [
        ['<i class="fa-solid fa-user fa-sm"></i>', t.labelName  || 'الاسم',      document.getElementById('name').value],
        ['<i class="fa-solid fa-plane-up fa-sm"></i>', t.step2Sub   || 'نوع السفر',  travelLabels[answers.travel_type]   || answers.travel_type],
        ['<i class="fa-solid fa-wallet fa-sm"></i>', t.labelBudget|| 'الميزانية',   budgetLabels[budget]   || budget],
        ['<i class="fa-solid fa-cloud-sun fa-sm"></i>', t.labelClimate|| 'المناخ',     climateLabels[answers.preferred_climate] || answers.preferred_climate],
        ['<i class="fa-regular fa-calendar fa-sm"></i>', t.labelDuration||'المدة',      durationLabels[duration]|| duration],
    ];

    document.getElementById('summaryCells').innerHTML = rows
        .filter(r => r[2])
        .map(r => `<div style="display:flex;gap:0.5rem;"><span>${r[0]}</span><span style="color:#888;">${r[1]}:</span><strong>${r[2]}</strong></div>`)
        .join('');
}

// ── Next / Submit
btnNext.addEventListener('click', () => {
    if (!validateStep(currentStep)) return;

    if (currentStep < totalSteps) {
        showStep(currentStep + 1);
    } else {
        document.getElementById('surveyForm').submit();
    }
});

// ── Back
btnBack.addEventListener('click', () => {
    if (currentStep > 1) showStep(currentStep - 1);
});

// ── Language change
document.addEventListener('langChanged', (e) => {
    lang = e.detail.lang;
    updateProgress();
    if (currentStep === totalSteps) buildSummary();
});

// ── Init
updateProgress();

}); // end DOMContentLoaded
</script>
@endpush

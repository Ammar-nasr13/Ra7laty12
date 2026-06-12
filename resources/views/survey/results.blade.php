@extends('layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'رحلاتك المقترحة — رحلاتي' : 'Your Recommended Trips — Rehlatyy')

@section('content')

{{-- Results Hero --}}
<div class="results-hero">
    <div style="max-width:700px; margin:0 auto; padding:0 1rem;">
        <div class="match-badge">
            <span data-i18n="matchBadge">✨ مطابقة لتفضيلاتك</span>
        </div>
        <h1 style="font-size:clamp(1.6rem,4vw,2.5rem); font-weight:900; margin:0.75rem 0; line-height:1.3;">
            <span data-i18n-template="resultsTitle" data-name="{{ $response->name }}">
                رحلاتك المقترحة يا {{ $response->name }}! 🎉
            </span>
        </h1>
        <p style="color:#8A9BB5; font-size:1rem;" data-i18n="resultsSub">
            بناءً على إجاباتك، اخترنا لك هذه الرحلات المثالية
        </p>

        {{-- Summary chips --}}
        <div style="display:flex; flex-wrap:wrap; gap:0.5rem; margin-top:1.25rem; justify-content:center;">
            <span style="background:rgba(197,160,40,0.15); color:#F0D060; border:1px solid rgba(197,160,40,0.3); border-radius:20px; padding:0.25rem 0.9rem; font-size:0.82rem; font-weight:600;" id="chipBudget"></span>
            <span style="background:rgba(197,160,40,0.15); color:#F0D060; border:1px solid rgba(197,160,40,0.3); border-radius:20px; padding:0.25rem 0.9rem; font-size:0.82rem; font-weight:600;" id="chipTravel"></span>
            <span style="background:rgba(197,160,40,0.15); color:#F0D060; border:1px solid rgba(197,160,40,0.3); border-radius:20px; padding:0.25rem 0.9rem; font-size:0.82rem; font-weight:600;" id="chipClimate"></span>
            <span style="background:rgba(197,160,40,0.15); color:#F0D060; border:1px solid rgba(197,160,40,0.3); border-radius:20px; padding:0.25rem 0.9rem; font-size:0.82rem; font-weight:600;" id="chipDuration"></span>
        </div>
    </div>
</div>

{{-- Results Body --}}
<div style="background:#FDFAF4; min-height:60vh; padding:3rem 1.5rem;">
    <div style="max-width:1100px; margin:0 auto;">

        {{-- Loading state --}}
        <div id="loadingState" style="text-align:center; padding:3rem; color:#888;">
            <div style="font-size:2.5rem; margin-bottom:0.75rem; animation:spin 1s linear infinite; display:inline-block;">⏳</div>
            <div style="font-size:1rem; font-weight:600;" data-i18n="resultsSub">جاري البحث عن رحلاتك المثالية...</div>
        </div>

        {{-- No results state --}}
        <div id="noResultsState" style="display:none; text-align:center; padding:3rem;">
            <div style="font-size:3rem; margin-bottom:1rem;">🔍</div>
            <h2 style="color:#1A3A5C; font-weight:800; margin-bottom:0.5rem;" data-i18n="noMatchTitle">لا توجد رحلات مطابقة تماماً</h2>
            <p style="color:#777;" data-i18n="noMatchSub">إليك أفضل رحلاتنا المقترحة</p>
        </div>

        {{-- Trips grid --}}
        <div class="trips-grid" id="resultsGrid" style="display:none;"></div>

        {{-- Actions --}}
        <div style="text-align:center; margin-top:3rem; display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
            <a href="{{ route('survey.index') }}" class="btn-outline-gold" style="color:#1A3A5C; border-color:#C5A028;" data-i18n="retakeSurvey">
                ← أعد الاستبيان
            </a>
            <a href="{{ route('home') }}#world-trips" class="btn-gold" data-i18n="navTrips">
                🌍 عرض كل الرحلات
            </a>
        </div>

    </div>
</div>

<style>
@keyframes spin {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
}
</style>

@endsection

@push('scripts')
<script>
// Pass survey answers from PHP → JS
const SURVEY_ANSWERS = @json($response->toMatchArray());
const RESPONSE_NAME  = @json($response->name);
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

const serverLang = '{{ app()->getLocale() }}';
let lang = document.documentElement.lang || serverLang || 'ar';

// ── Summary chips labels
function buildChips(l) {
    const tx = (window.TEXTS || {})[l] || (window.TEXTS || {})['ar'] || {};
    const budgetMap   = { low: tx.optBudgetLow, medium: tx.optBudgetMed, high: tx.optBudgetHigh, luxury: tx.optBudgetLux };
    const travelMap   = { family: tx.optFamily, couple: tx.optCouple, solo: tx.optSolo, friends: tx.optFriends };
    const climateMap  = { beach: tx.optCliBeach, desert: tx.optCliDesert, mountain: tx.optCliMountain, city: tx.optCliCity };
    const durationMap = { weekend: tx.optDurWeekend, week: tx.optDurWeek, twoweeks: tx.optDurTwoWeeks, month: tx.optDurMonth };

    document.getElementById('chipBudget').textContent   = '💰 ' + (budgetMap[SURVEY_ANSWERS.budget]   || SURVEY_ANSWERS.budget);
    document.getElementById('chipTravel').textContent   = '✈️ '  + (travelMap[SURVEY_ANSWERS.travel_type]  || SURVEY_ANSWERS.travel_type);
    document.getElementById('chipClimate').textContent  = '🌤 '  + (climateMap[SURVEY_ANSWERS.climate]  || SURVEY_ANSWERS.climate);
    document.getElementById('chipDuration').textContent = '🗓 '  + (durationMap[SURVEY_ANSWERS.duration] || SURVEY_ANSWERS.duration);
}

// ── Results title (uses the name)
function buildTitle(l) {
    const tx = (window.TEXTS || {})[l] || (window.TEXTS || {})['ar'] || {};
    const el = document.querySelector('[data-i18n-template="resultsTitle"]');
    if (el) el.textContent = (tx.resultsTitle || 'رحلاتك المقترحة يا %s! 🎉').replace('%s', RESPONSE_NAME);
}

// ── Render matched trips
function renderResults(l) {
    const loading    = document.getElementById('loadingState');
    const noResults  = document.getElementById('noResultsState');
    const grid       = document.getElementById('resultsGrid');

    const matched = window.matchTrips(SURVEY_ANSWERS);

    loading.style.display = 'none';

    if (!matched || matched.length === 0) {
        noResults.style.display = 'block';
        grid.style.display = 'none';
    } else {
        noResults.style.display = 'none';
        grid.style.display = 'grid';
        window.renderTripCards(matched, l, grid);
    }
}

// ── Init
buildChips(lang);
buildTitle(lang);

// Small delay for UX (show loading spinner briefly)
setTimeout(() => renderResults(lang), 600);

// ── Language change
document.addEventListener('langChanged', (e) => {
    lang = e.detail.lang;
    buildChips(lang);
    buildTitle(lang);
    renderResults(lang);
});

}); // end DOMContentLoaded
</script>
@endpush

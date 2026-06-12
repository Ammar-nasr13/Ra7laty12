@extends('admin.layouts.app')
@section('title', __('admin.add_new_trip'))
@section('page-title', __('admin.add_trip'))

@section('content')

<div class="admin-page-header">
    <div>
        <div class="admin-page-title">{{ __('admin.add_new_trip') }}</div>
    </div>
    <a href="{{ route('admin.trips.index') }}" class="admin-btn admin-btn-secondary">
        <i class="fa-solid fa-arrow-{{ app()->getLocale()==='ar' ? 'right' : 'left' }}"></i> {{ __('admin.back_to_trips') }}
    </a>
</div>

@if($errors->any())
    <div class="admin-flash admin-flash-error">
        <i class="fa-solid fa-circle-xmark"></i>
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('admin.trips.store') }}" enctype="multipart/form-data">
    @csrf

    <div style="display:grid; grid-template-columns:1fr 320px; gap:1.25rem; align-items:start;">

        {{-- Main fields --}}
        <div>
            {{-- Title --}}
            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header"><span class="admin-card-title">{{ __('admin.trip_name_card') }}</span></div>
                <div style="padding:1.25rem; display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div class="admin-form-group" style="margin:0;">
                        <label class="admin-label">{{ __('admin.title_ar') }}</label>
                        <input type="text" name="title[ar]" class="admin-input" value="{{ old('title.ar') }}" required>
                    </div>
                    <div class="admin-form-group" style="margin:0;">
                        <label class="admin-label">{{ __('admin.title_en') }}</label>
                        <input type="text" name="title[en]" class="admin-input" style="direction:ltr;" value="{{ old('title.en') }}" required>
                    </div>
                </div>
            </div>

            {{-- Destination --}}
            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header"><span class="admin-card-title"><i class="fa-solid fa-map-location-dot" style="color:#C5A028;"></i> {{ __('admin.destination') }}</span></div>
                <div style="padding:1.25rem;">
                    <div class="admin-form-group" style="margin:0;">
                        <label class="admin-label">{{ __('admin.destination') }}</label>
                        <select name="destination_id" class="admin-select">
                            <option value="">— {{ __('admin.none') }} —</option>
                            @foreach($destinations as $dest)
                                <option value="{{ $dest->id }}" {{ old('destination_id') == $dest->id ? 'selected' : '' }}>
                                    {{ $dest->getTranslation('name', app()->getLocale()) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Descriptions --}}
            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header"><span class="admin-card-title">{{ __('admin.description') }}</span></div>
                <div style="padding:1.25rem; display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div class="admin-form-group" style="margin:0;">
                        <label class="admin-label">{{ __('admin.title_ar') }}</label>
                        <textarea name="desc[ar]" class="admin-textarea" required>{{ old('desc.ar') }}</textarea>
                    </div>
                    <div class="admin-form-group" style="margin:0;">
                        <label class="admin-label">{{ __('admin.title_en') }}</label>
                        <textarea name="desc[en]" class="admin-textarea" style="direction:ltr;" required>{{ old('desc.en') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Highlights --}}
            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header">
                    <span class="admin-card-title">{{ __('admin.highlights') }}</span>
                    <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm" id="add-highlight">
                        <i class="fa-solid fa-plus"></i> {{ __('admin.add') }}
                    </button>
                </div>
                <div style="padding:1.25rem;" id="highlights-container">
                    <div class="highlight-row" style="display:grid; grid-template-columns:1fr 1fr 130px 36px; gap:0.5rem; margin-bottom:0.75rem; align-items:start;">
                        <input type="text" name="highlights[ar][]" class="admin-input" placeholder="{{ __('admin.in_arabic') }}">
                        <input type="text" name="highlights[en][]" class="admin-input" style="direction:ltr;" placeholder="In English">
                        <div>
                            <input type="file" name="highlight_images[0]" class="admin-input" accept="image/*"
                                   style="padding:0.3rem; font-size:0.75rem;" onchange="previewHl(this)">
                            <div class="hl-preview" style="margin-top:0.3rem; display:none;">
                                <img src="" alt="" style="height:32px; border-radius:4px; border:1px solid #E2E8F0;">
                            </div>
                        </div>
                        <button type="button" class="admin-btn admin-btn-danger admin-btn-sm remove-highlight" title="{{ __('admin.delete') }}" style="padding:0.3rem; margin-top:2px;">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- What's Included --}}
            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="fa-solid fa-list-check" style="color:#C5A028;"></i> {{ __('admin.program_includes') }}</span>
                </div>
                <div style="padding:1.25rem;">
                    {{-- Included --}}
                    <div style="margin-bottom:1rem;">
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.6rem;">
                            <span style="font-size:0.8rem; font-weight:700; color:#1A936F; display:flex; align-items:center; gap:0.4rem;">
                                <i class="fa-solid fa-circle-check"></i> {{ __('admin.included_items') }}
                            </span>
                            <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm" onclick="addProgramItem('included-container')">
                                <i class="fa-solid fa-plus"></i> {{ __('admin.add_item') }}
                            </button>
                        </div>
                        <div id="included-container">
                            <div class="program-item-row" style="display:grid; grid-template-columns:1fr 1fr 32px; gap:0.5rem; margin-bottom:0.5rem;">
                                <input type="text" name="included[ar][]" class="admin-input" placeholder="{{ __('admin.in_arabic') }}">
                                <input type="text" name="included[en][]" class="admin-input" style="direction:ltr;" placeholder="In English">
                                <button type="button" class="admin-btn admin-btn-danger admin-btn-sm" onclick="this.closest('.program-item-row').remove()"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                        </div>
                    </div>
                    {{-- Excluded --}}
                    <div>
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.6rem;">
                            <span style="font-size:0.8rem; font-weight:700; color:#C0392B; display:flex; align-items:center; gap:0.4rem;">
                                <i class="fa-solid fa-circle-xmark"></i> {{ __('admin.excluded_items') }}
                            </span>
                            <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm" onclick="addProgramItem('excluded-container')">
                                <i class="fa-solid fa-plus"></i> {{ __('admin.add_item') }}
                            </button>
                        </div>
                        <div id="excluded-container">
                            <div class="program-item-row" style="display:grid; grid-template-columns:1fr 1fr 32px; gap:0.5rem; margin-bottom:0.5rem;">
                                <input type="text" name="excluded[ar][]" class="admin-input" placeholder="{{ __('admin.in_arabic') }}">
                                <input type="text" name="excluded[en][]" class="admin-input" style="direction:ltr;" placeholder="In English">
                                <button type="button" class="admin-btn admin-btn-danger admin-btn-sm" onclick="this.closest('.program-item-row').remove()"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Daily Program --}}
            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="fa-solid fa-calendar-days" style="color:#C5A028;"></i> {{ __('admin.daily_program') }}</span>
                    <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm" onclick="syncItineraryDays()">
                        <i class="fa-solid fa-rotate"></i> {{ __('admin.sync_days') }}
                    </button>
                </div>
                <div style="padding:1.25rem;" id="itinerary-container">
                    {{-- rows populated by JS on load / duration change --}}
                </div>
            </div>

            {{-- Gallery --}}
            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="fa-solid fa-images" style="color:#C5A028;"></i> {{ __('admin.gallery') }}</span>
                </div>
                <div style="padding:1.25rem;">
                    <input type="file" name="gallery[]" id="galleryInput" class="admin-input" accept="image/*"
                           multiple style="padding:0.4rem;" onchange="previewGallery(this)">
                    <p style="font-size:0.75rem; color:#94A3B8; margin-top:0.4rem;">JPG, PNG, WebP — max 4MB</p>
                    <div id="galleryPreview" style="display:flex; flex-wrap:wrap; gap:0.5rem; margin-top:0.75rem;"></div>
                </div>
            </div>

            {{-- Departure Dates --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title">{{ __('admin.departure_dates') }}</span>
                    <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm" id="add-date">
                        <i class="fa-solid fa-plus"></i> {{ __('admin.add_date') }}
                    </button>
                </div>
                <div style="padding:1.25rem; display:flex; flex-wrap:wrap; gap:0.5rem;" id="dates-container">
                    <div class="date-row" style="display:flex; align-items:center; gap:0.3rem;">
                        <input type="date" name="departure_dates[]" class="admin-input" style="width:auto;">
                        <button type="button" class="admin-btn admin-btn-danger admin-btn-sm remove-date">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar options --}}
        <div>
            {{-- Publish --}}
            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header"><span class="admin-card-title">{{ __('admin.publishing') }}</span></div>
                <div style="padding:1.25rem;">
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
                        <span style="font-size:0.875rem; font-weight:700;">{{ __('admin.is_active_label') }}</span>
                        <label class="toggle-switch">
                            <input type="checkbox" name="is_active" value="1" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
                        <span style="font-size:0.875rem; font-weight:700;">{{ __('admin.is_egyptian') }}</span>
                        <label class="toggle-switch">
                            <input type="checkbox" name="is_egyptian" value="1">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div class="admin-form-group" style="margin:0;">
                        <label class="admin-label">{{ __('admin.display_order') }}</label>
                        <input type="number" name="sort_order" class="admin-input" value="{{ old('sort_order', 0) }}" min="0">
                    </div>
                </div>
            </div>

            {{-- Pricing --}}
            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header"><span class="admin-card-title">{{ __('admin.price_duration') }}</span></div>
                <div style="padding:1.25rem;">
                    <div class="admin-form-group">
                        <label class="admin-label">{{ __('admin.price') }}</label>
                        <input type="number" name="price" class="admin-input" value="{{ old('price') }}" min="0" step="0.01" required>
                    </div>
                    <div class="admin-form-group" style="margin:0;">
                        <label class="admin-label">{{ __('admin.duration_days') }}</label>
                        <input type="number" name="duration" id="durationInput" class="admin-input" value="{{ old('duration') }}" min="1" required>
                    </div>
                </div>
            </div>

            {{-- Category & Climate --}}
            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header"><span class="admin-card-title">{{ __('admin.classification') }}</span></div>
                <div style="padding:1.25rem;">
                    <div class="admin-form-group">
                        <label class="admin-label">{{ __('admin.category') }}</label>
                        <select name="category" class="admin-select" required>
                            <option value="">{{ __('admin.choose') }}</option>
                            <option value="beach"    {{ old('category')=='beach'    ?'selected':'' }}>🏖 {{ __('admin.cat_beach') }}</option>
                            <option value="culture"  {{ old('category')=='culture'  ?'selected':'' }}>🏛 {{ __('admin.cat_culture') }}</option>
                            <option value="adventure"{{ old('category')=='adventure'?'selected':'' }}>🏔 {{ __('admin.cat_adventure') }}</option>
                        </select>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-label">{{ __('admin.climate') }}</label>
                        <select name="climate" class="admin-select" required>
                            <option value="">{{ __('admin.choose') }}</option>
                            <option value="beach"   {{ old('climate')=='beach'  ?'selected':'' }}>🌊 {{ __('admin.climate_beach') }}</option>
                            <option value="desert"  {{ old('climate')=='desert' ?'selected':'' }}>🏜 {{ __('admin.climate_desert') }}</option>
                            <option value="mountain"{{ old('climate')=='mountain'?'selected':'' }}>⛰ {{ __('admin.climate_mountain') }}</option>
                            <option value="city"    {{ old('climate')=='city'   ?'selected':'' }}>🌆 {{ __('admin.climate_city') }}</option>
                        </select>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-label">{{ __('admin.budget') }}</label>
                        <select name="budget_tier" class="admin-select" required>
                            <option value="">{{ __('admin.choose') }}</option>
                            <option value="low"    {{ old('budget_tier')=='low'    ?'selected':'' }}>{{ __('admin.budget_low') }}</option>
                            <option value="medium" {{ old('budget_tier')=='medium' ?'selected':'' }}>{{ __('admin.budget_medium') }}</option>
                            <option value="high"   {{ old('budget_tier')=='high'   ?'selected':'' }}>{{ __('admin.budget_high') }}</option>
                            <option value="luxury" {{ old('budget_tier')=='luxury' ?'selected':'' }}>{{ __('admin.budget_luxury') }}</option>
                        </select>
                    </div>
                    <div class="admin-form-group" style="margin:0;">
                        <label class="admin-label">{{ __('admin.traveler_type') }}</label>
                        @foreach(['family' => __('admin.travel_family'), 'couple' => __('admin.travel_couple'), 'solo' => __('admin.travel_solo'), 'friends' => __('admin.travel_friends')] as $val => $label)
                        <label style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.4rem; cursor:pointer;">
                            <input type="checkbox" name="travel_type[]" value="{{ $val }}"
                                   style="accent-color:#C5A028;"
                                   {{ in_array($val, old('travel_type', [])) ? 'checked' : '' }}>
                            <span style="font-size:0.875rem;">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Spots --}}
            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header"><span class="admin-card-title">{{ __('admin.spots') }}</span></div>
                <div style="padding:1.25rem;">
                    <div class="admin-form-group">
                        <label class="admin-label">{{ __('admin.total_spots') }}</label>
                        <input type="number" name="spots_total" class="admin-input" value="{{ old('spots_total', 20) }}" min="1" required>
                    </div>
                    <div class="admin-form-group" style="margin:0;">
                        <label class="admin-label">{{ __('admin.available_spots') }}</label>
                        <input type="number" name="spots_left" class="admin-input" value="{{ old('spots_left', 20) }}" min="0" required>
                    </div>
                </div>
            </div>

            {{-- Image --}}
            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header"><span class="admin-card-title">{{ __('admin.trip_image') }}</span></div>
                <div style="padding:1.25rem;">
                    <input type="file" name="image" class="admin-input" accept="image/*" style="padding:0.4rem;">
                    <p style="font-size:0.75rem; color:#94A3B8; margin-top:0.4rem;">JPG, PNG, WebP — max 2MB</p>
                </div>
            </div>

            {{-- SEO --}}
            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="fa-solid fa-magnifying-glass" style="color:#C5A028;"></i> {{ __('admin.seo_section') }}</span>
                    <span style="font-size:0.75rem; color:#888;">{{ __('admin.seo_optional_hint') }}</span>
                </div>
                <div style="padding:1.25rem; display:flex; flex-direction:column; gap:1rem;">
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                        <div class="admin-form-group" style="margin:0;">
                            <label class="admin-label">{{ __('admin.meta_title_ar') }} <span id="mt_ar_count" style="float:inline-end; font-weight:400; color:#aaa; font-size:0.78rem;">0/60</span></label>
                            <input type="text" name="meta_title[ar]" class="admin-input" maxlength="60"
                                   value="{{ old('meta_title.ar') }}"
                                   oninput="document.getElementById('mt_ar_count').textContent=this.value.length+'/60'">
                        </div>
                        <div class="admin-form-group" style="margin:0;">
                            <label class="admin-label">{{ __('admin.meta_title_en') }} <span id="mt_en_count" style="float:inline-end; font-weight:400; color:#aaa; font-size:0.78rem;">0/60</span></label>
                            <input type="text" name="meta_title[en]" class="admin-input" style="direction:ltr;" maxlength="60"
                                   value="{{ old('meta_title.en') }}"
                                   oninput="document.getElementById('mt_en_count').textContent=this.value.length+'/60'">
                        </div>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                        <div class="admin-form-group" style="margin:0;">
                            <label class="admin-label">{{ __('admin.meta_desc_ar') }} <span id="md_ar_count" style="float:inline-end; font-weight:400; color:#aaa; font-size:0.78rem;">0/160</span></label>
                            <textarea name="meta_desc[ar]" class="admin-textarea" rows="3" maxlength="160"
                                      oninput="document.getElementById('md_ar_count').textContent=this.value.length+'/160'">{{ old('meta_desc.ar') }}</textarea>
                        </div>
                        <div class="admin-form-group" style="margin:0;">
                            <label class="admin-label">{{ __('admin.meta_desc_en') }} <span id="md_en_count" style="float:inline-end; font-weight:400; color:#aaa; font-size:0.78rem;">0/160</span></label>
                            <textarea name="meta_desc[en]" class="admin-textarea" rows="3" style="direction:ltr;" maxlength="160"
                                      oninput="document.getElementById('md_en_count').textContent=this.value.length+'/160'">{{ old('meta_desc.en') }}</textarea>
                        </div>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                        <div class="admin-form-group" style="margin:0;">
                            <label class="admin-label">{{ __('admin.meta_keywords_ar') }}</label>
                            <input type="text" name="meta_keywords[ar]" class="admin-input"
                                   placeholder="{{ __('admin.meta_keywords_placeholder') }}"
                                   value="{{ old('meta_keywords.ar') }}">
                        </div>
                        <div class="admin-form-group" style="margin:0;">
                            <label class="admin-label">{{ __('admin.meta_keywords_en') }}</label>
                            <input type="text" name="meta_keywords[en]" class="admin-input" style="direction:ltr;"
                                   placeholder="e.g. hurghada, beach trip, egypt"
                                   value="{{ old('meta_keywords.en') }}">
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="admin-btn admin-btn-primary" style="width:100%; justify-content:center; padding:0.75rem; font-size:0.95rem;">
                <i class="fa-solid fa-floppy-disk"></i> {{ __('admin.save_trip') }}
            </button>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
function previewGallery(input) {
    const preview = document.getElementById('galleryPreview');
    Array.from(input.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const wrap = document.createElement('div');
            wrap.style.cssText = 'position:relative; width:80px; height:80px;';
            wrap.innerHTML = `<img src="${e.target.result}" alt="" style="width:80px; height:80px; object-fit:cover; border-radius:8px; border:1px solid #E2E8F0;">`;
            preview.appendChild(wrap);
        };
        reader.readAsDataURL(file);
    });
}

function previewHl(input) {
    const preview = input.closest('.highlight-row').querySelector('.hl-preview');
    if (input.files && input.files[0]) {
        preview.querySelector('img').src = URL.createObjectURL(input.files[0]);
        preview.style.display = 'block';
    }
}

let hlIndex = 1;
document.getElementById('add-highlight').addEventListener('click', function() {
    const idx = hlIndex++;
    const row = document.createElement('div');
    row.className = 'highlight-row';
    row.style.cssText = 'display:grid; grid-template-columns:1fr 1fr 130px 36px; gap:0.5rem; margin-bottom:0.75rem; align-items:start;';
    row.innerHTML = `
        <input type="text" name="highlights[ar][]" class="admin-input" placeholder="{{ __('admin.in_arabic') }}">
        <input type="text" name="highlights[en][]" class="admin-input" style="direction:ltr;" placeholder="In English">
        <div>
            <input type="file" name="highlight_images[${idx}]" class="admin-input" accept="image/*"
                   style="padding:0.3rem; font-size:0.75rem;" onchange="previewHl(this)">
            <div class="hl-preview" style="margin-top:0.3rem; display:none;">
                <img src="" alt="" style="height:32px; border-radius:4px; border:1px solid #E2E8F0;">
            </div>
        </div>
        <button type="button" class="admin-btn admin-btn-danger admin-btn-sm remove-highlight" style="padding:0.3rem; margin-top:2px;">
            <i class="fa-solid fa-xmark"></i>
        </button>`;
    document.getElementById('highlights-container').appendChild(row);
});

document.getElementById('highlights-container').addEventListener('click', function(e) {
    if (e.target.closest('.remove-highlight')) {
        e.target.closest('.highlight-row').remove();
    }
});

// ── Program includes / itinerary helpers ──
function addProgramItem(containerId, namePrefix, arVal, enVal) {
    const c   = document.getElementById(containerId);
    const key = containerId === 'included-container' ? 'included' : 'excluded';
    const row = document.createElement('div');
    row.className = 'program-item-row';
    row.style.cssText = 'display:grid; grid-template-columns:1fr 1fr 32px; gap:0.5rem; margin-bottom:0.5rem;';
    row.innerHTML = `
        <input type="text" name="${key}[ar][]" class="admin-input" placeholder="{{ __('admin.in_arabic') }}" value="${arVal||''}">
        <input type="text" name="${key}[en][]" class="admin-input" style="direction:ltr;" placeholder="In English" value="${enVal||''}">
        <button type="button" class="admin-btn admin-btn-danger admin-btn-sm" onclick="this.closest('.program-item-row').remove()"><i class="fa-solid fa-xmark"></i></button>`;
    c.appendChild(row);
}

function syncItineraryDays() {
    const dur = parseInt(document.getElementById('durationInput').value) || 0;
    const container = document.getElementById('itinerary-container');
    const existing  = container.querySelectorAll('.itinerary-day');
    const current   = existing.length;

    if (dur > current) {
        for (let d = current + 1; d <= dur; d++) addItineraryDay(d);
    } else if (dur < current) {
        for (let i = current; i > dur; i--) existing[i - 1].remove();
    }
}

function addItineraryDay(dayNum, arVal, enVal) {
    const container = document.getElementById('itinerary-container');
    const block = document.createElement('div');
    block.className = 'itinerary-day';
    block.style.cssText = 'margin-bottom:1.25rem; padding-bottom:1.25rem; border-bottom:1px solid #F1F5F9;';
    block.innerHTML = `
        <div style="font-weight:700; font-size:0.85rem; color:#1A3A5C; margin-bottom:0.5rem; display:flex; align-items:center; gap:0.4rem;">
            <span style="width:26px; height:26px; border-radius:50%; background:linear-gradient(135deg,#C5A028,#F0D060); display:inline-flex; align-items:center; justify-content:center; font-size:0.75rem; color:#1A1A1A;">${dayNum}</span>
            {{ __('admin.day') }} ${dayNum}
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;">
            <textarea name="itinerary[ar][]" class="admin-textarea" rows="2" placeholder="{{ __('admin.in_arabic') }}">${arVal||''}</textarea>
            <textarea name="itinerary[en][]" class="admin-textarea" rows="2" style="direction:ltr;" placeholder="In English">${enVal||''}</textarea>
        </div>`;
    container.appendChild(block);
}

// Sync on duration change
document.addEventListener('DOMContentLoaded', function() {
    const durInput = document.getElementById('durationInput');
    if (durInput) {
        durInput.addEventListener('change', syncItineraryDays);
        durInput.addEventListener('input',  syncItineraryDays);
        // Init on load
        if (parseInt(durInput.value) > 0) syncItineraryDays();
    }
});

document.getElementById('add-date').addEventListener('click', function() {
    const row = document.createElement('div');
    row.className = 'date-row';
    row.style.cssText = 'display:flex; align-items:center; gap:0.3rem;';
    row.innerHTML = `
        <input type="date" name="departure_dates[]" class="admin-input" style="width:auto;">
        <button type="button" class="admin-btn admin-btn-danger admin-btn-sm remove-date">
            <i class="fa-solid fa-xmark"></i>
        </button>`;
    document.getElementById('dates-container').appendChild(row);
});

document.getElementById('dates-container').addEventListener('click', function(e) {
    if (e.target.closest('.remove-date')) {
        e.target.closest('.date-row').remove();
    }
});
</script>
@endpush

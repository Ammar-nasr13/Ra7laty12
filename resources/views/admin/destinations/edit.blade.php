@extends('admin.layouts.app')
@section('title', __('admin.edit') . ' ' . __('admin.destinations_title'))
@section('page-title', __('admin.edit') . ' ' . __('admin.destinations_title'))

@section('content')
<div class="admin-page-header">
    <div class="admin-page-title">{{ __('admin.edit') }}: {{ $destination->getTranslation('name', app()->getLocale()) }}</div>
    <a href="{{ route('admin.destinations.index') }}" class="admin-btn admin-btn-secondary">
        <i class="fa-solid fa-arrow-{{ app()->getLocale()==='ar' ? 'right' : 'left' }}"></i> {{ __('admin.back') }}
    </a>
</div>

@if($errors->any())
    <div class="admin-flash admin-flash-error"><i class="fa-solid fa-circle-xmark"></i> {{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('admin.destinations.update', $destination) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div style="display:grid; grid-template-columns:1fr 280px; gap:1.25rem;">
        <div>
            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header"><span class="admin-card-title">{{ __('admin.name') }}</span></div>
                <div style="padding:1.25rem; display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div><label class="admin-label">{{ __('admin.title_ar') }}</label><input type="text" name="name[ar]" class="admin-input" value="{{ old('name.ar', $destination->getTranslation('name','ar')) }}" required></div>
                    <div><label class="admin-label">{{ __('admin.title_en') }}</label><input type="text" name="name[en]" class="admin-input" style="direction:ltr;" value="{{ old('name.en', $destination->getTranslation('name','en')) }}" required></div>
                </div>
            </div>
            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header"><span class="admin-card-title">{{ __('admin.description') }}</span></div>
                <div style="padding:1.25rem; display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div><label class="admin-label">{{ __('admin.title_ar') }}</label><textarea name="description[ar]" class="admin-textarea" required>{{ old('description.ar', $destination->getTranslation('description','ar')) }}</textarea></div>
                    <div><label class="admin-label">{{ __('admin.title_en') }}</label><textarea name="description[en]" class="admin-textarea" style="direction:ltr;" required>{{ old('description.en', $destination->getTranslation('description','en')) }}</textarea></div>
                </div>
            </div>

            {{-- Gallery --}}
            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="fa-solid fa-images" style="color:#C5A028;"></i> {{ __('admin.gallery') }}</span>
                </div>
                <div style="padding:1.25rem;">
                    @php $galleryItems = $destination->getMedia('gallery'); @endphp
                    @if($galleryItems->count())
                    <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(110px,1fr)); gap:0.5rem; margin-bottom:1rem;">
                        @foreach($galleryItems as $media)
                        <div style="position:relative;">
                            <img src="{{ $media->getUrl() }}"
                                 alt="{{ $destination->getTranslation('name', app()->getLocale()) }}"
                                 style="width:100%; height:90px; object-fit:cover; border-radius:6px; border:1px solid #E2E8F0;">
                            <label style="position:absolute; top:4px; inset-inline-end:4px; background:rgba(220,38,38,0.85); border-radius:4px; padding:2px 5px; cursor:pointer; display:flex; align-items:center; gap:3px; font-size:0.65rem; color:#fff;">
                                <input type="checkbox" name="gallery_delete[]" value="{{ $media->id }}" style="display:none;">
                                <i class="fa-solid fa-trash"></i>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <p style="font-size:0.75rem; color:#94A3B8; margin-bottom:0.75rem;">{{ __('admin.gallery_delete_hint') }}</p>
                    @endif
                    <input type="file" name="gallery[]" class="admin-input" accept="image/*"
                           multiple style="padding:0.4rem;" id="galleryInput" onchange="previewGallery(this)">
                    <p style="font-size:0.75rem; color:#94A3B8; margin-top:0.4rem;">JPG, PNG, WebP — max 4MB {{ __('admin.per_image') }}</p>
                    <div id="galleryPreview" style="display:grid; grid-template-columns:repeat(auto-fill,minmax(100px,1fr)); gap:0.5rem; margin-top:0.75rem;"></div>
                </div>
            </div>

            {{-- SEO --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="fa-solid fa-magnifying-glass" style="color:#C5A028;"></i> {{ __('admin.seo_section') }}</span>
                    <span style="font-size:0.75rem; color:#888;">{{ __('admin.seo_optional_hint') }}</span>
                </div>
                <div style="padding:1.25rem; display:flex; flex-direction:column; gap:1rem;">
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                        <div class="admin-form-group" style="margin:0;">
                            <label class="admin-label">{{ __('admin.meta_title_ar') }} <span id="mt_ar_count" style="float:inline-end; font-weight:400; color:#aaa; font-size:0.78rem;">0/60</span></label>
                            <input type="text" name="meta_title[ar]" class="admin-input" maxlength="60"
                                   value="{{ old('meta_title.ar', $destination->getTranslation('meta_title','ar') ?? '') }}"
                                   oninput="document.getElementById('mt_ar_count').textContent=this.value.length+'/60'">
                        </div>
                        <div class="admin-form-group" style="margin:0;">
                            <label class="admin-label">{{ __('admin.meta_title_en') }} <span id="mt_en_count" style="float:inline-end; font-weight:400; color:#aaa; font-size:0.78rem;">0/60</span></label>
                            <input type="text" name="meta_title[en]" class="admin-input" style="direction:ltr;" maxlength="60"
                                   value="{{ old('meta_title.en', $destination->getTranslation('meta_title','en') ?? '') }}"
                                   oninput="document.getElementById('mt_en_count').textContent=this.value.length+'/60'">
                        </div>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                        <div class="admin-form-group" style="margin:0;">
                            <label class="admin-label">{{ __('admin.meta_desc_ar') }} <span id="md_ar_count" style="float:inline-end; font-weight:400; color:#aaa; font-size:0.78rem;">0/160</span></label>
                            <textarea name="meta_desc[ar]" class="admin-textarea" rows="3" maxlength="160"
                                      oninput="document.getElementById('md_ar_count').textContent=this.value.length+'/160'">{{ old('meta_desc.ar', $destination->getTranslation('meta_desc','ar') ?? '') }}</textarea>
                        </div>
                        <div class="admin-form-group" style="margin:0;">
                            <label class="admin-label">{{ __('admin.meta_desc_en') }} <span id="md_en_count" style="float:inline-end; font-weight:400; color:#aaa; font-size:0.78rem;">0/160</span></label>
                            <textarea name="meta_desc[en]" class="admin-textarea" rows="3" style="direction:ltr;" maxlength="160"
                                      oninput="document.getElementById('md_en_count').textContent=this.value.length+'/160'">{{ old('meta_desc.en', $destination->getTranslation('meta_desc','en') ?? '') }}</textarea>
                        </div>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                        <div class="admin-form-group" style="margin:0;">
                            <label class="admin-label">{{ __('admin.meta_keywords_ar') }}</label>
                            <input type="text" name="meta_keywords[ar]" class="admin-input"
                                   placeholder="{{ __('admin.meta_keywords_placeholder') }}"
                                   value="{{ old('meta_keywords.ar', $destination->getTranslation('meta_keywords','ar') ?? '') }}">
                        </div>
                        <div class="admin-form-group" style="margin:0;">
                            <label class="admin-label">{{ __('admin.meta_keywords_en') }}</label>
                            <input type="text" name="meta_keywords[en]" class="admin-input" style="direction:ltr;"
                                   placeholder="e.g. hurghada, beach, egypt tourism"
                                   value="{{ old('meta_keywords.en', $destination->getTranslation('meta_keywords','en') ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header"><span class="admin-card-title">{{ __('admin.options') }}</span></div>
                <div style="padding:1.25rem;">
                    <div class="admin-form-group">
                        <label class="admin-label">{{ __('admin.country') }}</label>
                        <select name="country_id" class="admin-select">
                            <option value="">— {{ __('admin.select_country') }} —</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}"
                                    {{ old('country_id', $destination->country_id) == $country->id ? 'selected' : '' }}>
                                    {{ $country->flag }} {{ $country->getTranslation('name', app()->getLocale()) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-label">{{ __('admin.category') }}</label>
                        <select name="category" class="admin-select" required>
                            @foreach(['beach' => '🏖 '.__('admin.cat_beach'), 'culture' => '🏛 '.__('admin.cat_culture'), 'adventure' => '🏔 '.__('admin.cat_adventure'), 'heritage' => '🏺 '.__('admin.cat_heritage')] as $v => $l)
                                <option value="{{ $v }}" {{ old('category',$destination->category)==$v?'selected':'' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-label">{{ __('admin.display_order') }}</label>
                        <input type="number" name="sort_order" class="admin-input" value="{{ old('sort_order', $destination->sort_order) }}" min="0">
                    </div>
                    <div style="display:flex; align-items:center; justify-content:space-between;">
                        <span style="font-size:0.875rem; font-weight:700;">{{ __('admin.featured_destination') }}</span>
                        <label class="toggle-switch"><input type="checkbox" name="is_featured" value="1" {{ $destination->is_featured?'checked':'' }}><span class="toggle-slider"></span></label>
                    </div>
                </div>
            </div>

            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header"><span class="admin-card-title"><i class="fa-solid fa-image" style="color:#C5A028;"></i> {{ __('admin.image') }}</span></div>
                <div style="padding:1.25rem;">
                    @php $destImage = $destination->getFirstMedia('image'); @endphp
                    @if($destImage)
                        <img src="{{ $destImage->getUrl() }}"
                             alt="{{ $destination->getTranslation('name', app()->getLocale()) }}"
                             style="width:100%; border-radius:8px; margin-bottom:0.75rem; max-height:160px; object-fit:cover; border:1px solid #E2E8F0;">
                    @endif
                    <input type="file" name="image" class="admin-input" accept="image/*" style="padding:0.4rem;" id="destImageInput" onchange="previewDestImage(this)">
                    <p style="font-size:0.75rem; color:#94A3B8; margin-top:0.4rem;">JPG, PNG, WebP — max 2MB</p>
                    <div id="destImagePreview" style="display:none; margin-top:0.75rem;">
                        <img id="destImagePreviewImg" src="" alt="" style="width:100%; border-radius:8px; max-height:160px; object-fit:cover; border:1px solid #E2E8F0;">
                    </div>
                </div>
            </div>

            <button type="submit" class="admin-btn admin-btn-primary" style="width:100%; justify-content:center; padding:0.75rem;">
                <i class="fa-solid fa-floppy-disk"></i> {{ __('admin.save') }}
            </button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
function previewDestImage(input) {
    const preview = document.getElementById('destImagePreview');
    const img = document.getElementById('destImagePreviewImg');
    if (input.files && input.files[0]) {
        img.src = URL.createObjectURL(input.files[0]);
        preview.style.display = 'block';
    }
}
function previewGallery(input) {
    const container = document.getElementById('galleryPreview');
    container.innerHTML = '';
    for (const file of input.files) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.style.cssText = 'width:100%; height:90px; object-fit:cover; border-radius:6px; border:1px solid #E2E8F0;';
        container.appendChild(img);
    }
}
// Toggle gallery delete checkbox on click
document.querySelectorAll('[name="gallery_delete[]"]').forEach(cb => {
    const wrapper = cb.closest('div[style*="position:relative"]');
    cb.closest('label').addEventListener('click', () => {
        cb.checked = !cb.checked;
        wrapper.style.opacity = cb.checked ? '0.4' : '1';
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var mtAr = document.querySelector('[name="meta_title[ar]"]');
    var mtEn = document.querySelector('[name="meta_title[en]"]');
    var mdAr = document.querySelector('[name="meta_desc[ar]"]');
    var mdEn = document.querySelector('[name="meta_desc[en]"]');
    if (mtAr) document.getElementById('mt_ar_count').textContent = mtAr.value.length + '/60';
    if (mtEn) document.getElementById('mt_en_count').textContent = mtEn.value.length + '/60';
    if (mdAr) document.getElementById('md_ar_count').textContent = mdAr.value.length + '/160';
    if (mdEn) document.getElementById('md_en_count').textContent = mdEn.value.length + '/160';
});
</script>
@endpush

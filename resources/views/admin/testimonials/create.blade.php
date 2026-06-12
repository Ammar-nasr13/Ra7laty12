@extends('admin.layouts.app')
@section('title', __('admin.add_testimonial'))
@section('page-title', __('admin.testimonial_add_page_title'))

@section('content')
<div class="admin-page-header">
    <div class="admin-page-title">{{ __('admin.add_new_testimonial') }}</div>
    <a href="{{ route('admin.testimonials.index') }}" class="admin-btn admin-btn-secondary">
        <i class="fa-solid fa-arrow-{{ app()->getLocale()==='ar' ? 'right' : 'left' }}"></i> {{ __('admin.back') }}
    </a>
</div>

@if($errors->any())
    <div class="admin-flash admin-flash-error"><i class="fa-solid fa-circle-xmark"></i> {{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
    @csrf
    <div style="display:grid; grid-template-columns:1fr 280px; gap:1.25rem;">
        <div>
            <div class="admin-card">
                <div class="admin-card-header"><span class="admin-card-title">{{ __('admin.customer_review_card') }}</span></div>
                <div style="padding:1.25rem;">
                    <div class="admin-form-group" style="margin:0;">
                        <label class="admin-label">{{ __('admin.review_text') }}</label>
                        <textarea name="review" class="admin-textarea" rows="5"
                                  placeholder="{{ __('admin.review_text') }}..." required>{{ old('review') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header"><span class="admin-card-title">{{ __('admin.customer_data') }}</span></div>
                <div style="padding:1.25rem;">
                    <div class="admin-form-group">
                        <label class="admin-label">{{ __('admin.name') }}</label>
                        <input type="text" name="name" class="admin-input" value="{{ old('name') }}" required>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-label">{{ __('admin.rating') }}</label>
                        <select name="rating" class="admin-select" required>
                            @for($i=5;$i>=1;$i--)
                                <option value="{{ $i }}" {{ old('rating',5)==$i?'selected':'' }}>
                                    {{ str_repeat('★', $i) }} {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
                        <span style="font-size:0.875rem; font-weight:700;">{{ __('admin.is_active_label') }}</span>
                        <label class="toggle-switch"><input type="checkbox" name="is_active" value="1" checked><span class="toggle-slider"></span></label>
                    </div>
                    <div class="admin-form-group" style="margin:0;">
                        <label class="admin-label">{{ __('admin.customer_image') }} <span style="color:#94A3B8; font-weight:400;">({{ __('admin.choose') }})</span></label>
                        <input type="file" name="avatar" class="admin-input" accept="image/*" style="padding:0.4rem;"
                               onchange="previewAvatar(this)">
                        <div id="avatarPreview" style="display:none; margin-top:0.5rem;">
                            <img id="avatarPreviewImg" src="" alt="" style="width:60px; height:60px; border-radius:50%; object-fit:cover; border:2px solid #E2E8F0;">
                        </div>
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
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        document.getElementById('avatarPreviewImg').src = URL.createObjectURL(input.files[0]);
        document.getElementById('avatarPreview').style.display = 'block';
    }
}
</script>
@endpush

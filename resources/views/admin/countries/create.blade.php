@extends('admin.layouts.app')
@section('title', __('admin.add_country'))
@section('page-title', __('admin.add_country'))

@section('content')
<div class="admin-page-header">
    <div class="admin-page-title">{{ __('admin.add_new_country') }}</div>
    <a href="{{ route('admin.countries.index') }}" class="admin-btn admin-btn-secondary">
        <i class="fa-solid fa-arrow-{{ app()->getLocale()==='ar' ? 'right' : 'left' }}"></i> {{ __('admin.back') }}
    </a>
</div>

@if($errors->any())
    <div class="admin-flash admin-flash-error"><i class="fa-solid fa-circle-xmark"></i> {{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('admin.countries.store') }}">
    @csrf
    <div style="display:grid; grid-template-columns:1fr 280px; gap:1.25rem;">
        <div>
            <div class="admin-card">
                <div class="admin-card-header"><span class="admin-card-title">{{ __('admin.name') }}</span></div>
                <div style="padding:1.25rem; display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div>
                        <label class="admin-label">{{ __('admin.title_ar') }}</label>
                        <input type="text" name="name[ar]" class="admin-input" value="{{ old('name.ar') }}" required>
                    </div>
                    <div>
                        <label class="admin-label">{{ __('admin.title_en') }}</label>
                        <input type="text" name="name[en]" class="admin-input" style="direction:ltr;" value="{{ old('name.en') }}" required>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header"><span class="admin-card-title">{{ __('admin.options') }}</span></div>
                <div style="padding:1.25rem;">
                    <div class="admin-form-group">
                        <label class="admin-label">{{ __('admin.flag_label') }}</label>
                        <input type="text" name="flag" class="admin-input" value="{{ old('flag') }}"
                               placeholder="🇪🇬" style="font-size:1.5rem; text-align:center;">
                        <p style="font-size:0.72rem; color:#94A3B8; margin-top:0.3rem;">{{ __('admin.flag_hint') }}</p>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-label">Slug</label>
                        <input type="text" name="slug" class="admin-input" value="{{ old('slug') }}"
                               placeholder="egypt" style="direction:ltr;"
                               oninput="this.value=this.value.toLowerCase().replace(/[^a-z0-9\-]/g,'')">
                        <p style="font-size:0.72rem; color:#94A3B8; margin-top:0.3rem;">{{ __('admin.slug_hint') }}</p>
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

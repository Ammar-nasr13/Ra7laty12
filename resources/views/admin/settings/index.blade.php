@extends('admin.layouts.app')
@section('title', __('admin.settings_title'))
@section('page-title', __('admin.settings_title'))

@section('content')
<div class="admin-page-header">
    <div class="admin-page-title">{{ __('admin.settings_title') }}</div>
</div>

<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf

    @php
        $grouped = $settings ?? collect();
        $groups  = [
            'general' => __('admin.settings_general'),
            'contact' => __('admin.settings_contact'),
            'social'  => __('admin.settings_social'),
        ];
        $icons   = ['general' => 'fa-globe', 'contact' => 'fa-address-book', 'social' => 'fa-share-nodes'];
    @endphp

    @foreach($groups as $groupKey => $groupLabel)
    <div class="admin-card" style="margin-bottom:1.25rem;">
        <div class="admin-card-header">
            <span class="admin-card-title">
                <i class="fa-solid {{ $icons[$groupKey] }}" style="color:#C5A028;"></i>
                {{ $groupLabel }}
            </span>
        </div>
        <div style="padding:1.25rem; display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:1rem;">
            @foreach($grouped->get($groupKey, collect()) as $setting)
            <div class="admin-form-group" style="margin:0;">
                <label class="admin-label">{{ $setting->key }}</label>
                <input type="text"
                       name="settings[{{ $setting->key }}]"
                       class="admin-input"
                       value="{{ old('settings.'.$setting->key, $setting->value) }}"
                       style="{{ in_array($setting->key, ['facebook_url','instagram_url','tiktok_url','youtube_url']) ? 'direction:ltr;' : '' }}">
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    <button type="submit" class="admin-btn admin-btn-primary" style="padding:0.75rem 2rem; font-size:0.95rem;">
        <i class="fa-solid fa-floppy-disk"></i> {{ __('admin.save_all_settings') }}
    </button>
</form>
@endsection

@extends('admin.layouts.app')
@section('title', __('admin.surveys_title'))
@section('page-title', __('admin.surveys_title'))

@section('content')
<div class="admin-page-header">
    <div class="admin-page-title">#{{ $survey->id }} — {{ $survey->name }}</div>
    <a href="{{ route('admin.surveys.index') }}" class="admin-btn admin-btn-secondary">
        <i class="fa-solid fa-arrow-{{ app()->getLocale()==='ar' ? 'right' : 'left' }}"></i> {{ __('admin.back') }}
    </a>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:1.25rem;">
    <div class="admin-card">
        <div class="admin-card-header"><span class="admin-card-title"><i class="fa-solid fa-user" style="color:#C5A028;"></i> {{ __('admin.customer_data') }}</span></div>
        <div style="padding:1.25rem;">
            @foreach([__('admin.name') => 'name', __('admin.email') => 'email', __('admin.phone') => 'phone'] as $l => $f)
            <div style="padding:0.6rem 0; border-bottom:1px solid #F0F4F8; display:flex; justify-content:space-between;">
                <span style="color:#64748B; font-size:0.85rem;">{{ $l }}</span>
                <span style="font-weight:700; font-size:0.875rem;">{{ $survey->$f ?: '—' }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-header"><span class="admin-card-title"><i class="fa-solid fa-clipboard-list" style="color:#C5A028;"></i> {{ __('admin.surveys_title') }}</span></div>
        <div style="padding:1.25rem;">
            @php
                $answers = [
                    __('admin.travel_type_col') => ['family' => __('admin.travel_family'), 'couple' => __('admin.travel_couple'), 'solo' => __('admin.travel_solo'), 'friends' => __('admin.travel_friends')][$survey->travel_type] ?? $survey->travel_type,
                    __('admin.budget')           => ['low' => __('admin.budget_low'), 'medium' => __('admin.budget_medium'), 'high' => __('admin.budget_high'), 'luxury' => __('admin.budget_luxury')][$survey->budget] ?? $survey->budget,
                    __('admin.climate_col')      => ['beach' => __('admin.climate_beach'), 'desert' => __('admin.climate_desert'), 'mountain' => __('admin.climate_mountain'), 'city' => __('admin.climate_city')][$survey->preferred_climate] ?? $survey->preferred_climate,
                    __('admin.duration_col')     => ['weekend' => __('admin.duration_weekend'), 'week' => __('admin.duration_week'), 'twoweeks' => __('admin.duration_twoweeks'), 'month' => __('admin.duration_month')][$survey->duration_preference] ?? $survey->duration_preference,
                ];
            @endphp
            @foreach($answers as $label => $value)
            <div style="padding:0.6rem 0; border-bottom:1px solid #F0F4F8; display:flex; justify-content:space-between;">
                <span style="color:#64748B; font-size:0.85rem;">{{ $label }}</span>
                <span class="status-badge status-confirmed" style="font-size:0.75rem;">{{ $value }}</span>
            </div>
            @endforeach
        </div>
    </div>

    @if($survey->message)
    <div class="admin-card" style="grid-column:1/-1;">
        <div class="admin-card-header"><span class="admin-card-title">{{ __('admin.notes') }}</span></div>
        <div style="padding:1.25rem; line-height:1.8; color:#374151;">{{ $survey->message }}</div>
    </div>
    @endif
</div>
@endsection

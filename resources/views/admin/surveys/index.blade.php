@extends('admin.layouts.app')
@section('title', __('admin.surveys_title'))
@section('page-title', __('admin.surveys_page_title'))

@section('content')
<div class="admin-page-header">
    <div>
        <div class="admin-page-title">{{ __('admin.surveys_title') }}</div>
        <div class="admin-page-subtitle">{{ $surveys->total() }}</div>
    </div>
</div>

<form method="GET" class="admin-search-bar">
    <input type="text" name="search" class="admin-input" placeholder="{{ __('admin.search_surveys') }}" value="{{ request('search') }}" style="flex:1;">
    <select name="travel_type" class="admin-select" style="width:auto;">
        <option value="">{{ __('admin.all_types') }}</option>
        @foreach(['family' => __('admin.travel_family'), 'couple' => __('admin.travel_couple'), 'solo' => __('admin.travel_solo'), 'friends' => __('admin.travel_friends')] as $v => $l)
            <option value="{{ $v }}" {{ request('travel_type')==$v?'selected':'' }}>{{ $l }}</option>
        @endforeach
    </select>
    <select name="budget" class="admin-select" style="width:auto;">
        <option value="">{{ __('admin.all_budgets') }}</option>
        @foreach(['low' => __('admin.budget_low'), 'medium' => __('admin.budget_medium'), 'high' => __('admin.budget_high'), 'luxury' => __('admin.budget_luxury')] as $v => $l)
            <option value="{{ $v }}" {{ request('budget')==$v?'selected':'' }}>{{ $l }}</option>
        @endforeach
    </select>
    <button type="submit" class="admin-btn admin-btn-primary"><i class="fa-solid fa-magnifying-glass"></i> {{ __('admin.search') }}</button>
    @if(request()->hasAny(['search','travel_type','budget']))
        <a href="{{ route('admin.surveys.index') }}" class="admin-btn admin-btn-secondary">{{ __('admin.clear') }}</a>
    @endif
</form>

<div class="admin-card">
    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ __('admin.name') }}</th>
                    <th scope="col">{{ __('admin.email') }}</th>
                    <th scope="col">{{ __('admin.travel_type_col') }}</th>
                    <th scope="col">{{ __('admin.budget') }}</th>
                    <th scope="col">{{ __('admin.climate_col') }}</th>
                    <th scope="col">{{ __('admin.duration_col') }}</th>
                    <th scope="col">{{ __('admin.date_col') }}</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $travelTypes = ['family' => __('admin.travel_family'), 'couple' => __('admin.travel_couple'), 'solo' => __('admin.travel_solo'), 'friends' => __('admin.travel_friends')];
                    $budgets     = ['low' => __('admin.budget_low'), 'medium' => __('admin.budget_medium'), 'high' => __('admin.budget_high'), 'luxury' => __('admin.budget_luxury')];
                    $climates    = ['beach' => __('admin.climate_beach'), 'desert' => __('admin.climate_desert'), 'mountain' => __('admin.climate_mountain'), 'city' => __('admin.climate_city')];
                    $durations   = ['weekend' => __('admin.duration_weekend'), 'week' => __('admin.duration_week'), 'twoweeks' => __('admin.duration_twoweeks'), 'month' => __('admin.duration_month')];
                @endphp
                @forelse($surveys as $s)
                <tr>
                    <td style="color:#64748B; font-size:0.8rem;">{{ $s->id }}</td>
                    <td style="font-weight:700;">{{ $s->name }}</td>
                    <td style="font-size:0.8rem; direction:ltr; text-align:right;">{{ $s->email }}</td>
                    <td>{{ $travelTypes[$s->travel_type] ?? $s->travel_type }}</td>
                    <td>{{ $budgets[$s->budget] ?? $s->budget }}</td>
                    <td>{{ $climates[$s->preferred_climate] ?? $s->preferred_climate }}</td>
                    <td style="font-size:0.8rem;">{{ $durations[$s->duration_preference] ?? $s->duration_preference }}</td>
                    <td style="font-size:0.8rem; color:#64748B;">{{ $s->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.surveys.show', $s) }}" class="admin-btn admin-btn-secondary admin-btn-sm">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" style="text-align:center; padding:2rem; color:#64748B;">{{ __('admin.no_surveys') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">
        <span>{{ $surveys->total() }}</span>
        {{ $surveys->links('admin.partials.pagination') }}
    </div>
</div>
@endsection

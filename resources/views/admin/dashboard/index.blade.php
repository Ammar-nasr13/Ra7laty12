@extends('admin.layouts.app')
@section('title', __('admin.control_panel'))
@section('page-title', __('admin.control_panel'))

@section('content')

{{-- KPI Cards --}}
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-icon gold"><i class="fa-solid fa-calendar-check"></i></div>
        <div class="kpi-info">
            <div class="kpi-value">{{ number_format($totalBookings) }}</div>
            <div class="kpi-label">{{ __('admin.kpi_total_bookings') }}</div>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon green"><i class="fa-solid fa-coins"></i></div>
        <div class="kpi-info">
            <div class="kpi-value" data-price-usd="{{ $totalRevenue }}">${{ number_format($totalRevenue, 0) }}</div>
            <div class="kpi-label">{{ __('admin.kpi_total_revenue') }}</div>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon nile"><i class="fa-solid fa-plane"></i></div>
        <div class="kpi-info">
            <div class="kpi-value">{{ $activeTrips }}</div>
            <div class="kpi-label">{{ __('admin.kpi_active_trips') }}</div>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon red"><i class="fa-solid fa-envelope"></i></div>
        <div class="kpi-info">
            <div class="kpi-value">{{ number_format($totalSubscribers) }}</div>
            <div class="kpi-label">{{ __('admin.kpi_total_subscribers') }}</div>
        </div>
    </div>
</div>

<div style="display:grid; grid-template-columns: 1fr 320px; gap:1.25rem; align-items:start;">

    {{-- Recent Bookings --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <span class="admin-card-title"><i class="fa-solid fa-list-check" style="color:#C5A028;"></i> {{ __('admin.recent_bookings') }}</span>
            <a href="{{ route('admin.bookings.index') }}" class="admin-btn admin-btn-secondary admin-btn-sm">
                {{ __('admin.view_all') }} <i class="fa-solid fa-arrow-{{ app()->getLocale()==='ar' ? 'left' : 'right' }} fa-xs"></i>
            </a>
        </div>
        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th scope="col">{{ __('admin.booking_reference') }}</th>
                        <th scope="col">{{ __('admin.booking_customer') }}</th>
                        <th scope="col">{{ __('admin.booking_trip') }}</th>
                        <th scope="col">{{ __('admin.travel_date') }}</th>
                        <th scope="col">{{ __('admin.booking_amount') }}</th>
                        <th scope="col">{{ __('admin.status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $b)
                    <tr>
                        <td>
                            <a href="{{ route('admin.bookings.show', $b) }}"
                               style="color:#C5A028; font-weight:700; text-decoration:none; font-size:0.8rem;">
                                {{ $b->reference }}
                            </a>
                        </td>
                        <td>
                            <div style="font-weight:600;">{{ $b->name }}</div>
                            <div style="font-size:0.75rem; color:#64748B;">{{ $b->email }}</div>
                        </td>
                        <td>{{ $b->trip ? $b->trip->getTranslation('title', app()->getLocale()) : '—' }}</td>
                        <td style="font-size:0.8rem;">{{ $b->travel_date?->format('Y-m-d') }}</td>
                        <td style="font-weight:700; color:#059669;" data-price-usd="{{ $b->total_price }}">${{ number_format($b->total_price, 0) }}</td>
                        <td>
                            <span class="status-badge status-{{ $b->status }}">
                                {{ __('admin.status_' . $b->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center; color:#64748B; padding:2rem;">{{ __('admin.no_bookings_yet') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Top Trips --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <span class="admin-card-title"><i class="fa-solid fa-trophy" style="color:#C5A028;"></i> {{ __('admin.top_trips') }}</span>
        </div>
        <div style="padding:0.5rem 0;">
            @forelse($topTrips as $i => $item)
            <div style="display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1.25rem; border-bottom:1px solid #F0F4F8;">
                <div style="width:28px; height:28px; border-radius:50%; background:{{ $i === 0 ? 'linear-gradient(135deg,#C5A028,#F0D060)' : '#F1F5F9' }}; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:0.8rem; color:{{ $i === 0 ? '#0A1E30' : '#64748B' }}; flex-shrink:0;">
                    {{ $i + 1 }}
                </div>
                <div style="flex:1; min-width:0;">
                    <div style="font-weight:700; font-size:0.85rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ $item->trip ? $item->trip->getTranslation('title', app()->getLocale()) : __('admin.deleted_trip') }}
                    </div>
                </div>
                <div style="background:#EFF6FF; color:#1D4ED8; font-weight:800; font-size:0.75rem; padding:0.2rem 0.6rem; border-radius:20px; flex-shrink:0;">
                    {{ $item->total }}
                </div>
            </div>
            @empty
            <div style="text-align:center; padding:2rem; color:#64748B; font-size:0.85rem;">{{ __('admin.no_data') }}</div>
            @endforelse
        </div>
    </div>

</div>

@endsection

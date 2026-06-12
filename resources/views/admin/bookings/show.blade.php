@extends('admin.layouts.app')
@section('title', __('admin.booking_details_title'))
@section('page-title', __('admin.booking_details_title'))

@section('content')

<div class="admin-page-header">
    <div>
        <div class="admin-page-title">{{ __('admin.booking_reference') }}: {{ $booking->reference }}</div>
        <div class="admin-page-subtitle">{{ $booking->created_at->format('Y-m-d H:i') }}</div>
    </div>
    <a href="{{ route('admin.bookings.index') }}" class="admin-btn admin-btn-secondary">
        <i class="fa-solid fa-arrow-{{ app()->getLocale()==='ar' ? 'right' : 'left' }}"></i> {{ __('admin.back') }}
    </a>
</div>

<div style="display:grid; grid-template-columns:1fr 320px; gap:1.25rem; align-items:start;">
    <div>
        {{-- Customer Info --}}
        <div class="admin-card" style="margin-bottom:1.25rem;">
            <div class="admin-card-header"><span class="admin-card-title"><i class="fa-solid fa-user" style="color:#C5A028;"></i> {{ __('admin.customer_data') }}</span></div>
            <div style="padding:1.25rem; display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                @foreach(['name' => __('admin.name'), 'email' => __('admin.email'), 'phone' => __('admin.phone')] as $field => $label)
                <div>
                    <div style="font-size:0.75rem; color:#64748B; margin-bottom:0.2rem;">{{ $label }}</div>
                    <div style="font-weight:700;">{{ $booking->$field }}</div>
                </div>
                @endforeach
                <div>
                    <div style="font-size:0.75rem; color:#64748B; margin-bottom:0.2rem;">{{ __('admin.travel_date') }}</div>
                    <div style="font-weight:700;">{{ $booking->travel_date?->format('Y-m-d') }}</div>
                </div>
            </div>
        </div>

        {{-- Trip Info --}}
        @if($booking->trip)
        <div class="admin-card" style="margin-bottom:1.25rem;">
            <div class="admin-card-header"><span class="admin-card-title"><i class="fa-solid fa-plane" style="color:#C5A028;"></i> {{ __('admin.booking_trip') }}</span></div>
            <div style="padding:1.25rem;">
                <div style="display:flex; align-items:center; gap:0.75rem;">
                    <div>
                        <div style="font-weight:800; font-size:1rem;">{{ $booking->trip->getTranslation('title', app()->getLocale()) }}</div>
                        <div style="font-size:0.85rem; color:#64748B;">{{ $booking->trip->destination?->getTranslation('name', app()->getLocale()) ?? '—' }} · {{ $booking->trip->duration }} {{ __('admin.day') }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Notes --}}
        @if($booking->notes)
        <div class="admin-card">
            <div class="admin-card-header"><span class="admin-card-title">{{ __('admin.notes') }}</span></div>
            <div style="padding:1.25rem; color:#374151; line-height:1.8;">{{ $booking->notes }}</div>
        </div>
        @endif
    </div>

    {{-- Summary sidebar --}}
    <div>
        <div class="admin-card" style="margin-bottom:1.25rem;">
            <div class="admin-card-header"><span class="admin-card-title">{{ __('admin.booking_summary') }}</span></div>
            <div style="padding:1.25rem;">
                @foreach([
                    __('admin.booking_reference') => $booking->reference,
                    __('admin.adults')             => $booking->adults,
                    __('admin.children')           => $booking->children,
                    __('admin.payment_method')     => $booking->payment_method_label,
                ] as $label => $value)
                <div style="display:flex; justify-content:space-between; padding:0.5rem 0; border-bottom:1px solid #F0F4F8; font-size:0.875rem;">
                    <span style="color:#64748B;">{{ $label }}</span>
                    <span style="font-weight:700;">{{ $value }}</span>
                </div>
                @endforeach
                <div style="display:flex; justify-content:space-between; padding:0.75rem 0; font-size:1rem; margin-top:0.25rem;">
                    <span style="font-weight:800; color:#1A3A5C;">{{ __('admin.total') }}</span>
                    <span style="font-weight:900; color:#059669; font-size:1.2rem;" data-price-usd="{{ $booking->total_price }}">${{ number_format($booking->total_price, 0) }}</span>
                </div>
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header"><span class="admin-card-title">{{ __('admin.change_status') }}</span></div>
            <div style="padding:1.25rem;">
                <div style="margin-bottom:0.75rem;">
                    <span class="status-badge status-{{ $booking->status }}">
                        {{ __('admin.status_' . $booking->status) }}
                    </span>
                </div>
                <form method="POST" action="{{ route('admin.bookings.status', $booking) }}">
                    @csrf @method('PATCH')
                    <div class="admin-form-group">
                        <select name="status" class="admin-select">
                            @foreach(['confirmed','cancelled','completed'] as $val)
                                <option value="{{ $val }}" {{ $booking->status==$val?'selected':'' }}>{{ __('admin.status_'.$val) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="admin-btn admin-btn-primary" style="width:100%; justify-content:center;">
                        <i class="fa-solid fa-floppy-disk"></i> {{ __('admin.save') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

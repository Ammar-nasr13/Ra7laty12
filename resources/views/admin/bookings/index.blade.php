@extends('admin.layouts.app')
@section('title', __('admin.bookings_title'))
@section('page-title', __('admin.bookings_page_title'))

@section('content')

<div class="admin-page-header">
    <div>
        <div class="admin-page-title">{{ __('admin.bookings_title') }}</div>
        <div class="admin-page-subtitle">{{ __('admin.trips_subtitle', ['count' => $bookings->total()]) }}</div>
    </div>
</div>

<form method="GET" class="admin-search-bar">
    <input type="text" name="search" class="admin-input" placeholder="🔍  {{ __('admin.search_bookings') }}" value="{{ request('search') }}" style="flex:1; min-width:200px;">
    <select name="status" class="admin-select" style="width:auto;">
        <option value="">{{ __('admin.all_statuses') }}</option>
        <option value="confirmed" {{ request('status')=='confirmed' ?'selected':'' }}>{{ __('admin.status_confirmed') }}</option>
        <option value="cancelled" {{ request('status')=='cancelled' ?'selected':'' }}>{{ __('admin.status_cancelled') }}</option>
        <option value="completed" {{ request('status')=='completed' ?'selected':'' }}>{{ __('admin.status_completed') }}</option>
    </select>
    <input type="date" name="date_from" class="admin-input" style="width:auto;" value="{{ request('date_from') }}" title="{{ __('admin.from_date') }}">
    <input type="date" name="date_to"   class="admin-input" style="width:auto;" value="{{ request('date_to') }}"   title="{{ __('admin.to_date') }}">
    <button type="submit" class="admin-btn admin-btn-primary"><i class="fa-solid fa-magnifying-glass"></i> {{ __('admin.search') }}</button>
    @if(request()->hasAny(['search','status','date_from','date_to']))
        <a href="{{ route('admin.bookings.index') }}" class="admin-btn admin-btn-secondary">{{ __('admin.clear') }}</a>
    @endif
</form>

<div class="admin-card">
    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th scope="col">{{ __('admin.booking_reference') }}</th>
                    <th scope="col">{{ __('admin.booking_customer') }}</th>
                    <th scope="col">{{ __('admin.booking_trip') }}</th>
                    <th scope="col">{{ __('admin.booking_date') }}</th>
                    <th scope="col">{{ __('admin.travel_date') }}</th>
                    <th scope="col">{{ __('admin.booking_amount') }}</th>
                    <th scope="col">{{ __('admin.booking_payment') }}</th>
                    <th scope="col">{{ __('admin.status') }}</th>
                    <th scope="col">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
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
                    <td style="font-size:0.85rem;">{{ $b->trip ? $b->trip->getTranslation('title', app()->getLocale()) : '—' }}</td>
                    <td style="font-size:0.8rem; color:#64748B;">{{ $b->created_at->format('Y-m-d') }}</td>
                    <td style="font-size:0.8rem;">{{ $b->travel_date?->format('Y-m-d') }}</td>
                    <td style="font-weight:700; color:#059669;" data-price-usd="{{ $b->total_price }}">${{ number_format($b->total_price, 0) }}</td>
                    <td style="font-size:0.8rem;">{{ $b->payment_method_label }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.bookings.status', $b) }}" style="margin:0;">
                            @csrf @method('PATCH')
                            <select name="status" class="admin-select" style="width:auto; font-size:0.78rem; padding:0.25rem 0.5rem;"
                                    onchange="this.form.submit()">
                                @foreach(['confirmed','cancelled','completed'] as $val)
                                    <option value="{{ $val }}" {{ $b->status==$val?'selected':'' }}>{{ __('admin.status_'.$val) }}</option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td>
                        <div style="display:flex; gap:0.3rem;">
                            <a href="{{ route('admin.bookings.show', $b) }}" class="admin-btn admin-btn-secondary admin-btn-sm" title="{{ __('admin.view_all') }}">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.bookings.destroy', $b) }}"
                                  onsubmit="return confirm('{{ __('admin.confirm_delete_booking') }}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" style="text-align:center; padding:3rem; color:#64748B;">{{ __('admin.no_bookings') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">
        <span>{{ __('admin.showing', ['from' => $bookings->firstItem(), 'to' => $bookings->lastItem(), 'total' => $bookings->total()]) }}</span>
        {{ $bookings->links('admin.partials.pagination') }}
    </div>
</div>

@endsection

@extends('admin.layouts.app')
@section('title', __('admin.trips_title'))
@section('page-title', __('admin.trips_page_title'))

@section('content')

<div class="admin-page-header">
    <div>
        <div class="admin-page-title">{{ __('admin.nav_trips') }}</div>
        <div class="admin-page-subtitle">{{ __('admin.trips_subtitle', ['count' => $trips->total()]) }}</div>
    </div>
    <a href="{{ route('admin.trips.create') }}" class="admin-btn admin-btn-primary">
        <i class="fa-solid fa-plus"></i> {{ __('admin.add_trip') }}
    </a>
</div>

{{-- Filters --}}
<form method="GET" class="admin-search-bar">
    <input type="text" name="search" class="admin-input" placeholder="{{ __('admin.search_trips') }}" value="{{ request('search') }}" style="flex:1; min-width:180px;">
    <select name="category" class="admin-select" style="width:auto;">
        <option value="">{{ __('admin.all_categories') }}</option>
        <option value="beach"    {{ request('category')=='beach'    ? 'selected':'' }}>{{ __('admin.cat_beach') }}</option>
        <option value="culture"  {{ request('category')=='culture'  ? 'selected':'' }}>{{ __('admin.cat_culture') }}</option>
        <option value="adventure"{{ request('category')=='adventure'? 'selected':'' }}>{{ __('admin.cat_adventure') }}</option>
    </select>
    <select name="status" class="admin-select" style="width:auto;">
        <option value="">{{ __('admin.all_statuses') }}</option>
        <option value="active"   {{ request('status')=='active'  ? 'selected':'' }}>{{ __('admin.status_active') }}</option>
        <option value="inactive" {{ request('status')=='inactive'? 'selected':'' }}>{{ __('admin.status_inactive') }}</option>
    </select>
    <button type="submit" class="admin-btn admin-btn-primary"><i class="fa-solid fa-magnifying-glass"></i> {{ __('admin.search') }}</button>
    @if(request()->hasAny(['search','category','status']))
        <a href="{{ route('admin.trips.index') }}" class="admin-btn admin-btn-secondary">{{ __('admin.clear') }}</a>
    @endif
</form>

<div class="admin-card">
    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ __('admin.booking_trip') }}</th>
                    <th scope="col">{{ __('admin.category') }}</th>
                    <th scope="col">{{ __('admin.budget') }}</th>
                    <th scope="col">{{ __('admin.price') }}</th>
                    <th scope="col">{{ __('admin.duration') }}</th>
                    <th scope="col">{{ __('admin.spots') }}</th>
                    <th scope="col">{{ __('admin.status') }}</th>
                    <th scope="col">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($trips as $trip)
                @php
                    $catLabels    = ['beach' => __('admin.cat_beach'), 'culture' => __('admin.cat_culture'), 'adventure' => __('admin.cat_adventure')];
                    $budgetColors = ['low'=>'#D1FAE5','medium'=>'#FEF3C7','high'=>'#DBEAFE','luxury'=>'#F3E8FF'];
                    $budgetText   = ['low'=>'#065F46','medium'=>'#92400E','high'=>'#1E40AF','luxury'=>'#6B21A8'];
                    $budgetLabels = ['low' => __('admin.budget_low'), 'medium' => __('admin.budget_medium'), 'high' => __('admin.budget_high'), 'luxury' => __('admin.budget_luxury')];
                @endphp
                <tr>
                    <td style="color:#64748B; font-size:0.8rem;">{{ $trip->id }}</td>
                    <td>
                        <div>
                            <div style="font-weight:700;">{{ $trip->getTranslation('title', app()->getLocale()) }}</div>
                            <div style="font-size:0.75rem; color:#64748B;">{{ $trip->destination?->getTranslation('name', app()->getLocale()) ?? '—' }}</div>
                        </div>
                    </td>
                    <td>
                        <span style="font-size:0.8rem;">{{ $catLabels[$trip->category] ?? $trip->category }}</span>
                    </td>
                    <td>
                        <span class="status-badge" style="background:{{ $budgetColors[$trip->budget_tier]??'#F1F5F9' }}; color:{{ $budgetText[$trip->budget_tier]??'#374151' }};">
                            {{ $budgetLabels[$trip->budget_tier] ?? $trip->budget_tier }}
                        </span>
                    </td>
                    <td style="font-weight:700; color:#059669;" data-price-usd="{{ $trip->price }}">${{ number_format($trip->price, 0) }}</td>
                    <td style="font-size:0.85rem;">{{ $trip->duration }} {{ __('admin.day') }}</td>
                    <td>
                        <span style="font-weight:700; color:{{ $trip->spots_left <= 3 ? '#DC2626' : ($trip->spots_left <= 7 ? '#D97706' : '#059669') }};">
                            {{ $trip->spots_left }}
                        </span>
                        <span style="color:#94A3B8; font-size:0.75rem;">/{{ $trip->spots_total }}</span>
                    </td>
                    <td>
                        <label class="toggle-switch"
                               title="{{ $trip->is_active ? __('admin.toggle_active_hint') : __('admin.toggle_inactive_hint') }}"
                               data-trip-id="{{ $trip->id }}">
                            <input type="checkbox" class="trip-toggle" {{ $trip->is_active ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </td>
                    <td>
                        <div style="display:flex; gap:0.3rem;">
                            <a href="{{ route('admin.trips.edit', $trip) }}"
                               class="admin-btn admin-btn-secondary admin-btn-sm"
                               title="{{ __('admin.edit') }}">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.trips.destroy', $trip) }}"
                                  onsubmit="return confirm('{{ __('admin.confirm_delete_trip') }}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm" title="{{ __('admin.delete') }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center; padding:3rem; color:#64748B;">
                        <i class="fa-solid fa-plane-slash" style="font-size:2rem; display:block; margin-bottom:0.75rem; opacity:0.3;"></i>
                        {{ __('admin.no_trips') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">
        <span>{{ __('admin.showing', ['from' => $trips->firstItem(), 'to' => $trips->lastItem(), 'total' => $trips->total()]) }}</span>
        {{ $trips->links('admin.partials.pagination') }}
    </div>
</div>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.trip-toggle').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        const label   = this.closest('label');
        const tripId  = label.dataset.tripId;

        fetch('/admin/trips/' + tripId + '/toggle', {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) {
                this.checked = !this.checked; // revert
            }
        })
        .catch(() => { this.checked = !this.checked; });
    });
});
</script>
@endpush

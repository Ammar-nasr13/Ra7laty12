@extends('admin.layouts.app')
@section('title', __('admin.countries_title'))
@section('page-title', __('admin.countries_title'))

@section('content')
<div class="admin-page-header">
    <div class="admin-page-title">
        {{ __('admin.countries_title') }}
        <span style="font-size:0.85rem; color:#64748B; font-weight:400;">— {{ $countries->total() }} {{ __('admin.countries_count') }}</span>
    </div>
    <a href="{{ route('admin.countries.create') }}" class="admin-btn admin-btn-primary">
        <i class="fa-solid fa-plus"></i> {{ __('admin.add_country') }}
    </a>
</div>

<div class="admin-card">
    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th scope="col" style="width:60px;">{{ __('admin.flag_label') }}</th>
                    <th scope="col">{{ __('admin.name') }}</th>
                    <th scope="col">Slug</th>
                    <th scope="col" style="width:120px;">{{ __('admin.destinations_count_col') }}</th>
                    <th scope="col" style="width:120px;">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($countries as $country)
                <tr>
                    <td style="font-size:1.75rem; text-align:center;">{{ $country->flag }}</td>
                    <td>
                        <div style="font-weight:700;">{{ $country->getTranslation('name', 'ar') }}</div>
                        <div style="font-size:0.78rem; color:#64748B; direction:ltr;">{{ $country->getTranslation('name', 'en') }}</div>
                    </td>
                    <td style="font-family:monospace; font-size:0.82rem; color:#64748B;">{{ $country->slug }}</td>
                    <td style="text-align:center;">
                        <span style="background:#EFF6FF; color:#1D4ED8; font-weight:700; font-size:0.8rem; padding:0.2rem 0.7rem; border-radius:20px;">
                            {{ $country->destinations_count ?? $country->destinations()->count() }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex; gap:0.4rem;">
                            <a href="{{ route('admin.countries.edit', $country) }}" class="admin-btn admin-btn-secondary admin-btn-sm">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.countries.destroy', $country) }}"
                                  onsubmit="return confirm('{{ __('admin.confirm_delete_country') }}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:2rem; color:#64748B;">{{ __('admin.no_countries') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($countries->hasPages())
        <div style="padding:1rem 1.25rem;">{{ $countries->links('admin.partials.pagination') }}</div>
    @endif
</div>
@endsection

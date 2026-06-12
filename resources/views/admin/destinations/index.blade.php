@extends('admin.layouts.app')
@section('title', __('admin.destinations_title'))
@section('page-title', __('admin.destinations_page_title'))

@section('content')
<div class="admin-page-header">
    <div>
        <div class="admin-page-title">{{ __('admin.destinations_title') }}</div>
        <div class="admin-page-subtitle">{{ $destinations->total() }} {{ __('admin.destinations_title') }}</div>
    </div>
    <a href="{{ route('admin.destinations.create') }}" class="admin-btn admin-btn-primary">
        <i class="fa-solid fa-plus"></i> {{ __('admin.add_destination') }}
    </a>
</div>

<div class="admin-card">
    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th scope="col">{{ __('admin.destination_name_col') }}</th>
                    <th scope="col">{{ __('admin.category') }}</th>
                    <th scope="col">{{ __('admin.featured_label') }}</th>
                    <th scope="col">{{ __('admin.order') }}</th>
                    <th scope="col">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($destinations as $d)
                <tr>
                    <td>
                        <div style="font-weight:700;">{{ $d->getTranslation('name', app()->getLocale()) }}</div>
                        <div style="font-size:0.75rem; color:#64748B;">{{ $d->getTranslation('name', app()->getLocale() === 'ar' ? 'en' : 'ar') }}</div>
                    </td>
                    <td style="font-size:0.85rem;">{{ $d->category }}</td>
                    <td>
                        @if($d->is_featured)
                            <span class="status-badge status-confirmed">{{ __('admin.featured_label') }}</span>
                        @else
                            <span class="status-badge status-inactive">{{ __('admin.regular_label') }}</span>
                        @endif
                    </td>
                    <td>{{ $d->sort_order }}</td>
                    <td>
                        <div style="display:flex; gap:0.3rem;">
                            <a href="{{ route('admin.destinations.edit', $d) }}" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fa-solid fa-pen"></i></a>
                            <form method="POST" action="{{ route('admin.destinations.destroy', $d) }}" onsubmit="return confirm('{{ __('admin.confirm_delete_destination') }}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center; padding:2rem; color:#64748B;">{{ __('admin.no_destinations') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">
        <span>{{ $destinations->total() }}</span>
        {{ $destinations->links('admin.partials.pagination') }}
    </div>
</div>
@endsection

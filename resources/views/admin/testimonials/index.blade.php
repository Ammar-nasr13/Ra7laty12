@extends('admin.layouts.app')
@section('title', __('admin.testimonials_title'))
@section('page-title', __('admin.testimonials_title'))

@section('content')
<div class="admin-page-header">
    <div>
        <div class="admin-page-title">{{ __('admin.testimonials_title') }}</div>
        <div class="admin-page-subtitle">{{ $testimonials->total() }}</div>
    </div>
</div>

<div class="admin-card">
    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th scope="col">{{ __('admin.booking_customer') }}</th>
                    <th scope="col">{{ __('admin.testimonial_review_col') }}</th>
                    <th scope="col">{{ __('admin.testimonial_rating_col') }}</th>
                    <th scope="col">{{ __('admin.status') }}</th>
                    <th scope="col">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonials as $t)
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:0.6rem;">
                            @php $av = $t->getFirstMedia('avatar'); @endphp
                            @if($av)
                                <img src="{{ $av->getUrl() }}" alt="{{ $t->name }}" style="width:36px; height:36px; border-radius:50%; object-fit:cover; border:2px solid #E2E8F0; flex-shrink:0;">
                            @else
                                <div style="width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,#C5A028,#F0D060); display:flex; align-items:center; justify-content:center; font-weight:800; color:#1A1A1A; font-size:0.9rem; flex-shrink:0;">
                                    {{ mb_substr($t->name, 0, 1) }}
                                </div>
                            @endif
                            <span style="font-weight:700;">{{ $t->name }}</span>
                        </div>
                    </td>
                    <td style="max-width:280px; font-size:0.85rem; color:#374151;">
                        {{ Str::limit($t->review, 80) }}
                    </td>
                    <td>
                        @for($i=1;$i<=5;$i++)
                            <span style="color:{{ $i<=$t->rating ? '#F0D060' : '#E2E8F0' }}; font-size:0.9rem;">★</span>
                        @endfor
                    </td>
                    <td>
                        @if($t->is_active)
                            <span class="status-badge status-active">{{ __('admin.status_active') }}</span>
                        @else
                            <span class="status-badge status-inactive">{{ __('admin.status_hidden') }}</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:0.4rem;">
                            <a href="{{ route('admin.testimonials.show', $t) }}" class="admin-btn admin-btn-secondary admin-btn-sm">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" onsubmit="return confirm('{{ __('admin.confirm_delete_testimonial') }}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center; padding:2rem; color:#64748B;">{{ __('admin.no_testimonials') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">
        <span>{{ $testimonials->total() }}</span>
        {{ $testimonials->links('admin.partials.pagination') }}
    </div>
</div>
@endsection

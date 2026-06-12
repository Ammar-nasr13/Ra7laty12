@extends('admin.layouts.app')
@section('title', __('admin.testimonials_title'))
@section('page-title', __('admin.testimonials_title'))

@section('content')
<div class="admin-page-header">
    <div class="admin-page-title">{{ $testimonial->name }}</div>
    <a href="{{ route('admin.testimonials.index') }}" class="admin-btn admin-btn-secondary">
        <i class="fa-solid fa-arrow-{{ app()->getLocale()==='ar' ? 'right' : 'left' }}"></i> {{ __('admin.back') }}
    </a>
</div>


<div style="display:grid; grid-template-columns:1fr 300px; gap:1.25rem; align-items:start;">

    {{-- Review text --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <span class="admin-card-title"><i class="fa-solid fa-quote-right" style="color:#C5A028;"></i> {{ __('admin.review_text') }}</span>
        </div>
        <div style="padding:1.5rem;">
            <p style="font-size:1rem; line-height:2; color:#374151; white-space:pre-wrap; margin:0;">{{ $testimonial->review }}</p>
        </div>
    </div>

    {{-- Sidebar --}}
    <div style="display:flex; flex-direction:column; gap:1.25rem;">

        {{-- Customer card --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <span class="admin-card-title">{{ __('admin.customer_data') }}</span>
            </div>
            <div style="padding:1.25rem;">

                {{-- Avatar + name --}}
                <div style="display:flex; align-items:center; gap:0.85rem; padding-bottom:1rem; border-bottom:1px solid #F1F5F9; margin-bottom:1rem;">
                    @php $av = $testimonial->getFirstMedia('avatar'); @endphp
                    @if($av)
                        <img src="{{ $av->getUrl() }}"
                             alt="{{ $testimonial->name }}"
                             style="width:60px; height:60px; border-radius:50%; object-fit:cover; border:2px solid #E2E8F0; flex-shrink:0;">
                    @else
                        <div style="width:60px; height:60px; border-radius:50%; background:linear-gradient(135deg,#C5A028,#F0D060); display:flex; align-items:center; justify-content:center; font-weight:800; color:#1A1A1A; font-size:1.4rem; flex-shrink:0;">
                            {{ mb_substr($testimonial->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <div style="font-weight:800; font-size:0.95rem; color:#1A3A5C;">{{ $testimonial->name }}</div>
                        <div style="margin-top:0.2rem;">
                            @for($i = 1; $i <= 5; $i++)
                                <span style="color:{{ $i <= $testimonial->rating ? '#F0D060' : '#D1D5DB' }}; font-size:1rem;">★</span>
                            @endfor
                        </div>
                    </div>
                </div>

                {{-- Details rows --}}
                <div style="display:flex; flex-direction:column; gap:0.6rem; font-size:0.85rem;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:#94A3B8; font-weight:600;">{{ __('admin.testimonial_rating_col') }}</span>
                        <span style="font-weight:700; color:#1A3A5C;">{{ $testimonial->rating }} / 5</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:#94A3B8; font-weight:600;">{{ __('admin.status') }}</span>
                        @if($testimonial->is_active)
                            <span class="status-badge status-active">{{ __('admin.status_active') }}</span>
                        @else
                            <span class="status-badge status-inactive">{{ __('admin.status_hidden') }}</span>
                        @endif
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:#94A3B8; font-weight:600;">{{ __('admin.registration_date') }}</span>
                        <span style="font-weight:600; color:#374151;">{{ $testimonial->created_at->format('Y-m-d') }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:#94A3B8; font-weight:600;">#ID</span>
                        <span style="font-weight:600; color:#374151;">{{ $testimonial->id }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Publishing toggle --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <span class="admin-card-title">{{ __('admin.publishing') }}</span>
            </div>
            <div style="padding:1.25rem; display:flex; flex-direction:column; gap:0.75rem;">
                <p style="font-size:0.82rem; color:#94A3B8; margin:0;">
                    {{ $testimonial->is_active ? __('admin.toggle_active_hint') : __('admin.toggle_inactive_hint') }}
                </p>
                <form method="POST" action="{{ route('admin.testimonials.toggle', $testimonial) }}">
                    @csrf @method('PATCH')
                    <button type="submit"
                            style="width:100%; justify-content:center; padding:0.65rem;"
                            class="admin-btn {{ $testimonial->is_active ? 'admin-btn-danger' : 'admin-btn-primary' }}">
                        <i class="fa-solid fa-{{ $testimonial->is_active ? 'eye-slash' : 'eye' }}"></i>
                        {{ $testimonial->is_active ? __('admin.status_hidden') : __('admin.status_active') }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Delete --}}
        <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}"
              onsubmit="return confirm('{{ __('admin.confirm_delete_testimonial') }}')">
            @csrf @method('DELETE')
            <button type="submit" class="admin-btn admin-btn-danger" style="width:100%; justify-content:center; padding:0.65rem;">
                <i class="fa-solid fa-trash"></i> {{ __('admin.delete') }}
            </button>
        </form>

    </div>
</div>
@endsection

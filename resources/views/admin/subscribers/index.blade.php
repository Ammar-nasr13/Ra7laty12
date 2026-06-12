@extends('admin.layouts.app')
@section('title', __('admin.subscribers_title'))
@section('page-title', __('admin.subscribers_page_title'))

@section('content')
<div class="admin-page-header">
    <div>
        <div class="admin-page-title">{{ __('admin.subscribers_title') }}</div>
        <div class="admin-page-subtitle">{{ $subscribers->total() }}</div>
    </div>
    <a href="{{ route('admin.subscribers.export') }}" class="admin-btn admin-btn-secondary">
        <i class="fa-solid fa-file-csv"></i> {{ __('admin.export_csv') }}
    </a>
</div>

<form method="GET" class="admin-search-bar">
    <input type="text" name="search" class="admin-input" placeholder="🔍  {{ __('admin.search_email') }}" value="{{ request('search') }}" style="flex:1;">
    <button type="submit" class="admin-btn admin-btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
    @if(request('search'))
        <a href="{{ route('admin.subscribers.index') }}" class="admin-btn admin-btn-secondary">{{ __('admin.clear') }}</a>
    @endif
</form>

<div class="admin-card">
    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th scope="col" style="width:50px;">#</th>
                    <th scope="col">{{ __('admin.email') }}</th>
                    <th scope="col">{{ __('admin.subscription_date') }}</th>
                    <th scope="col">{{ __('admin.status') }}</th>
                    <th scope="col">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscribers as $s)
                <tr>
                    <td style="color:#64748B; font-size:0.8rem; text-align:center;">{{ $loop->iteration }}</td>
                    <td style="font-weight:600; direction:ltr; text-align:start;">{{ $s->email }}</td>
                    <td style="font-size:0.85rem; color:#64748B;">{{ $s->created_at->format('Y-m-d') }}</td>
                    <td>
                        @if($s->is_active)
                            <span class="status-badge status-active">{{ __('admin.status_active') }}</span>
                        @else
                            <span class="status-badge status-inactive">{{ __('admin.status_not_active') }}</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.subscribers.destroy', $s) }}" onsubmit="return confirm('{{ __('admin.confirm_delete_subscriber') }}')">
                            @csrf @method('DELETE')
                            <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center; padding:2rem; color:#64748B;">{{ __('admin.no_subscribers') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">
        <span>{{ $subscribers->total() }}</span>
        {{ $subscribers->links('admin.partials.pagination') }}
    </div>
</div>

{{-- ── Send Newsletter ─────────────────────────────────────────── --}}
<div class="admin-card" style="margin-top:1.5rem;">
    <div class="admin-card-header">
        <span class="admin-card-title">
            <i class="fa-solid fa-paper-plane" style="color:#C5A028;"></i>
            {{ __('admin.send_newsletter') }}
        </span>
    </div>
    <div style="padding:1.5rem;">

        @if($errors->any())
            <div class="admin-flash admin-flash-error" style="margin-bottom:1rem;">
                <i class="fa-solid fa-circle-xmark"></i> {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.subscribers.send') }}">
            @csrf

            {{-- Recipients --}}
            <div class="admin-form-group">
                <label class="admin-label">{{ __('admin.newsletter_recipients') }}</label>
                <div style="display:flex; gap:1.5rem; flex-wrap:wrap; padding:0.75rem 1rem; background:#F8FAFC; border-radius:10px; border:1px solid #E2E8F0;">
                    <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; font-size:0.875rem; font-weight:600;">
                        <input type="radio" name="recipients" value="subscribers"
                               {{ old('recipients','subscribers') === 'subscribers' ? 'checked' : '' }}
                               style="accent-color:#C5A028; width:16px; height:16px;">
                        <i class="fa-solid fa-envelope" style="color:#C5A028; font-size:0.85rem;"></i>
                        {{ __('admin.newsletter_to_subscribers') }}
                        <span style="background:#EFF6FF; color:#1D4ED8; font-size:0.75rem; font-weight:700; padding:2px 8px; border-radius:20px;">{{ $subscribersCount }}</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; font-size:0.875rem; font-weight:600;">
                        <input type="radio" name="recipients" value="bookers"
                               {{ old('recipients') === 'bookers' ? 'checked' : '' }}
                               style="accent-color:#C5A028; width:16px; height:16px;">
                        <i class="fa-solid fa-suitcase" style="color:#C5A028; font-size:0.85rem;"></i>
                        {{ __('admin.newsletter_to_bookers') }}
                        <span style="background:#F0FDF4; color:#15803D; font-size:0.75rem; font-weight:700; padding:2px 8px; border-radius:20px;">{{ $bookersCount }}</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; font-size:0.875rem; font-weight:600;">
                        <input type="radio" name="recipients" value="all"
                               {{ old('recipients') === 'all' ? 'checked' : '' }}
                               style="accent-color:#C5A028; width:16px; height:16px;">
                        <i class="fa-solid fa-users" style="color:#C5A028; font-size:0.85rem;"></i>
                        {{ __('admin.newsletter_to_all') }}
                        <span style="background:#FFF7ED; color:#C2410C; font-size:0.75rem; font-weight:700; padding:2px 8px; border-radius:20px;">{{ $allCount }}</span>
                    </label>
                </div>
            </div>

            {{-- Subject --}}
            <div class="admin-form-group">
                <label class="admin-label">{{ __('admin.newsletter_subject') }}</label>
                <input type="text" name="subject" class="admin-input" required
                       value="{{ old('subject') }}"
                       placeholder="{{ app()->getLocale()==='ar' ? 'موضوع الإيميل...' : 'Email subject...' }}">
            </div>

            {{-- Body --}}
            <div class="admin-form-group" style="margin-bottom:1.25rem;">
                <label class="admin-label">{{ __('admin.newsletter_body') }}</label>
                <textarea name="body" class="admin-textarea" rows="7" required
                          placeholder="{{ app()->getLocale()==='ar' ? 'محتوى الرسالة...' : 'Message content...' }}">{{ old('body') }}</textarea>
            </div>

            <button type="submit" class="admin-btn admin-btn-primary"
                    onclick="return confirm('{{ app()->getLocale()==='ar' ? 'سيتم إرسال الإيميل للمستلمين، هل أنت متأكد؟' : 'Email will be sent to the selected recipients. Are you sure?' }}')">
                <i class="fa-solid fa-paper-plane"></i> {{ __('admin.send_newsletter') }}
            </button>
        </form>
    </div>
</div>

@endsection

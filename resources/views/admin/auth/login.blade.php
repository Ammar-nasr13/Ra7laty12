<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('admin.login_page_title') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/admin.css'])
</head>
<body style="margin:0;padding:0;">
<div class="admin-login-bg">
    <div class="admin-login-card">
        {{-- Logo --}}
        <div class="admin-login-logo">
            <div class="admin-login-logo-icon">🏺</div>
            <h1 style="font-size:1.4rem; font-weight:900; color:#1A3A5C; margin:0;">{{ __('admin.site_name') }}</h1>
            <p style="color:#64748B; font-size:0.85rem; margin-top:0.25rem;">{{ __('admin.admin_panel') }}</p>
        </div>

        {{-- Validation errors --}}
        @if($errors->any())
            <div class="admin-flash admin-flash-error" role="alert" aria-live="assertive" style="margin-bottom:1.25rem;">
                <i class="fa-solid fa-circle-xmark" aria-hidden="true"></i>
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            <div class="admin-form-group">
                <label class="admin-label" for="email">
                    <i class="fa-solid fa-envelope" style="color:#C5A028;"></i>
                    {{ __('admin.email') }}
                </label>
                <input id="email" type="email" name="email"
                       class="admin-input"
                       value="{{ old('email') }}"
                       placeholder="admin@example.com"
                       required autofocus
                       @error('email') aria-invalid="true" @enderror>
            </div>

            <div class="admin-form-group">
                <label class="admin-label" for="password">
                    <i class="fa-solid fa-lock" style="color:#C5A028;"></i>
                    {{ __('admin.password') }}
                </label>
                <input id="password" type="password" name="password"
                       class="admin-input"
                       placeholder="••••••••"
                       required
                       @error('password') aria-invalid="true" @enderror>
            </div>

            <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:1.5rem;">
                <input type="checkbox" name="remember" id="remember"
                       style="accent-color:#C5A028; width:16px; height:16px;">
                <label for="remember" style="font-size:0.825rem; color:#374151; cursor:pointer;">{{ __('admin.remember_me') }}</label>
            </div>

            <button type="submit" class="admin-btn admin-btn-primary" style="width:100%; justify-content:center; padding:0.75rem; font-size:1rem;">
                <i class="fa-solid fa-right-to-bracket"></i>
                {{ __('admin.login_btn') }}
            </button>
        </form>

        <div style="text-align:center; margin-top:1.5rem;">
            <a href="{{ route('home') }}" style="color:#64748B; font-size:0.8rem; text-decoration:none;">
                <i class="fa-solid fa-arrow-{{ app()->getLocale()==='ar' ? 'right' : 'left' }} fa-xs"></i>
                {{ __('admin.back_to_site') }}
            </a>
        </div>
    </div>
</div>
</body>
</html>

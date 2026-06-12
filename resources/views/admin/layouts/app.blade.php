<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('admin.control_panel')) — {{ __('admin.site_name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/admin.css'])
</head>
<body class="admin-body">

    <a href="#admin-main-content" class="skip-link">
        {{ app()->getLocale() === 'ar' ? 'تخطى للمحتوى الرئيسي' : 'Skip to main content' }}
    </a>

    {{-- ── Sidebar ─────────────────────────────────────────────── --}}
    <aside class="admin-sidebar">
        {{-- Logo --}}
        <div class="admin-sidebar-logo">
            <div class="admin-sidebar-logo-icon">🏺</div>
            <div class="admin-sidebar-logo-text">
                {{ __('admin.site_name') }}
                <small>{{ __('admin.control_panel') }}</small>
            </div>
        </div>

        {{-- Nav --}}
        <nav style="flex:1; padding: 0.75rem 0;" aria-label="{{ app()->getLocale() === 'ar' ? 'قائمة لوحة التحكم' : 'Admin navigation' }}" role="navigation">
            <div class="admin-nav-section">{{ __('admin.nav_main') }}</div>
            <a href="{{ route('admin.dashboard') }}"
               class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line" aria-hidden="true"></i>
                {{ __('admin.nav_dashboard') }}
            </a>

            <div class="admin-nav-section">{{ __('admin.nav_content') }}</div>
            <a href="{{ route('admin.trips.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.trips.*') ? 'active' : '' }}">
                <i class="fa-solid fa-plane-departure" aria-hidden="true"></i>
                {{ __('admin.nav_trips') }}
            </a>
            <a href="{{ route('admin.destinations.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.destinations.*') ? 'active' : '' }}">
                <i class="fa-solid fa-map-location-dot" aria-hidden="true"></i>
                {{ __('admin.nav_destinations') }}
            </a>
            <a href="{{ route('admin.countries.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.countries.*') ? 'active' : '' }}">
                <i class="fa-solid fa-flag" aria-hidden="true"></i>
                {{ __('admin.nav_countries') }}
            </a>
            <a href="{{ route('admin.testimonials.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                <i class="fa-solid fa-star" aria-hidden="true"></i>
                {{ __('admin.nav_testimonials') }}
            </a>

            <div class="admin-nav-section">{{ __('admin.nav_sales') }}</div>
            <a href="{{ route('admin.bookings.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check" aria-hidden="true"></i>
                {{ __('admin.nav_bookings') }}
            </a>
            <a href="{{ route('admin.surveys.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.surveys.*') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-list" aria-hidden="true"></i>
                {{ __('admin.nav_surveys') }}
            </a>
            <a href="{{ route('admin.subscribers.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}">
                <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                {{ __('admin.nav_subscribers') }}
            </a>

            <div class="admin-nav-section">{{ __('admin.nav_settings_sec') }}</div>
            <a href="{{ route('admin.settings.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fa-solid fa-gear" aria-hidden="true"></i>
                {{ __('admin.nav_settings') }}
            </a>
            <a href="{{ route('home') }}" target="_blank"
               class="admin-nav-link">
                <i class="fa-solid fa-globe" aria-hidden="true"></i>
                {{ __('admin.nav_view_site') }}
            </a>
        </nav>

        {{-- Admin info at bottom --}}
        <div style="padding: 1rem 1.25rem; border-top: 1px solid rgba(197,160,40,0.15);">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div class="admin-avatar" style="flex-shrink:0;">
                    {{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) }}
                </div>
                <div style="min-width:0; flex:1;">
                    <div style="color:#E8C84A; font-weight:700; font-size:0.8rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ Auth::guard('admin')->user()->name }}
                    </div>
                    <div style="color:#4A5568; font-size:0.68rem;">
                        {{ Auth::guard('admin')->user()->role === 'super_admin' ? __('admin.role_super_admin') : __('admin.role_editor') }}
                    </div>
                </div>
            </div>
        </div>
    </aside>

    {{-- ── Main Area ────────────────────────────────────────────── --}}
    <div class="admin-main">
        {{-- Top Bar --}}
        <header class="admin-topbar">
            <div class="admin-topbar-title">@yield('page-title', __('admin.control_panel'))</div>
            <div class="admin-topbar-user">
                {{-- Language switcher --}}
                @php $currentLang = app()->getLocale(); @endphp
                <form method="POST" action="{{ route('admin.lang.switch', $currentLang === 'ar' ? 'en' : 'ar') }}" style="margin:0;">
                    @csrf
                    <button type="submit"
                            style="background:rgba(197,160,40,0.12); border:1px solid rgba(197,160,40,0.35); color:#C5A028; font-family:Cairo,sans-serif; font-size:0.78rem; font-weight:800; cursor:pointer; display:flex; align-items:center; gap:0.35rem; padding:0.3rem 0.75rem; border-radius:20px; transition:all 0.2s;"
                            onmouseover="this.style.background='rgba(197,160,40,0.22)'"
                            onmouseout="this.style.background='rgba(197,160,40,0.12)'">
                        <i class="fa-solid fa-language fa-sm"></i>
                        {{ $currentLang === 'ar' ? 'English' : 'عربي' }}
                    </button>
                </form>
                <span style="color:#E2E8F0;">|</span>

                {{-- Currency widget --}}
                <div style="position:relative;" id="adminCurrencyWidget">
                    <button onclick="adminToggleCurrencyMenu()" id="adminCurrencyBtn"
                            style="background:rgba(197,160,40,0.12); border:1px solid rgba(197,160,40,0.35); color:#C5A028; font-family:Cairo,sans-serif; font-size:0.78rem; font-weight:800; cursor:pointer; display:flex; align-items:center; gap:0.35rem; padding:0.3rem 0.75rem; border-radius:20px; transition:all 0.2s;"
                            onmouseover="this.style.background='rgba(197,160,40,0.22)'"
                            onmouseout="this.style.background='rgba(197,160,40,0.12)'"
                            aria-haspopup="listbox"
                            aria-expanded="false"
                            aria-controls="adminCurrencyMenu"
                            aria-label="{{ app()->getLocale() === 'ar' ? 'اختيار العملة' : 'Select currency' }}">
                        <i class="fa-solid fa-coins fa-xs" aria-hidden="true"></i>
                        <span id="adminCurrencyBtnLabel">USD</span>
                        <i class="fa-solid fa-chevron-down fa-xs" style="opacity:0.6; font-size:0.6rem;" aria-hidden="true"></i>
                    </button>
                    <div id="adminCurrencyMenu" style="display:none; position:absolute; top:calc(100% + 8px); inset-inline-end:0; background:#0D2035; border:1px solid rgba(197,160,40,0.25); border-radius:12px; padding:0.5rem; min-width:170px; z-index:9999; box-shadow:0 8px 32px rgba(0,0,0,0.5);">
                        @php
                        $adminCurrencies = [
                            'USD'=>['🇺🇸','USD','$'],
                            'EUR'=>['🇪🇺','EUR','€'],
                            'GBP'=>['🇬🇧','GBP','£'],
                            'EGP'=>['🇪🇬','EGP','E£'],
                            'SAR'=>['🇸🇦','SAR','ر.س'],
                            'AED'=>['🇦🇪','AED','د.إ'],
                            'KWD'=>['🇰🇼','KWD','د.ك'],
                            'QAR'=>['🇶🇦','QAR','ر.ق'],
                        ];
                        @endphp
                        @foreach($adminCurrencies as $code => [$flag, $label, $sym])
                        <button onclick="adminSelectCurrency('{{ $code }}','{{ $sym }}')"
                                data-admin-currency="{{ $code }}"
                                style="display:flex; align-items:center; gap:0.5rem; width:100%; background:none; border:none; color:#C8D4E0; font-family:Cairo,sans-serif; font-size:0.82rem; padding:0.45rem 0.65rem; border-radius:8px; cursor:pointer; text-align:start; transition:background 0.15s;"
                                onmouseover="this.style.background='rgba(197,160,40,0.12)';this.style.color='#F0D060'"
                                onmouseout="this.style.background='none';this.style.color=this.dataset.adminCurrency===window.__adminActiveCurrency?'#F0D060':'#C8D4E0'">
                            <span>{{ $flag }}</span>
                            <span style="font-weight:700;">{{ $label }}</span>
                            <span style="color:#64748B; font-size:0.75rem; margin-inline-start:auto;">{{ $sym }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>
                <span style="color:#E2E8F0;">|</span>
                <a href="{{ route('home') }}" target="_blank"
                   style="color:#64748B; font-size:0.8rem; text-decoration:none; display:flex; align-items:center; gap:0.3rem;">
                    <i class="fa-solid fa-arrow-up-right-from-square fa-xs"></i>
                    {{ __('admin.topbar_site') }}
                </a>
                <span style="color:#E2E8F0;">|</span>
                <form method="POST" action="{{ route('admin.logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit"
                            style="background:none; border:none; color:#991B1B; font-family:Cairo,sans-serif; font-size:0.8rem; font-weight:700; cursor:pointer; display:flex; align-items:center; gap:0.3rem;">
                        <i class="fa-solid fa-right-from-bracket fa-xs"></i>
                        {{ __('admin.topbar_logout') }}
                    </button>
                </form>
            </div>
        </header>

        {{-- Content --}}
        <main class="admin-content" id="admin-main-content" tabindex="-1">
            {{-- Flash messages --}}
            @if(session('success'))
                <div class="admin-flash admin-flash-success" role="status" aria-live="polite">
                    <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="admin-flash admin-flash-error" role="alert" aria-live="assertive">
                    <i class="fa-solid fa-circle-xmark" aria-hidden="true"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')

    <script>
    // ── Admin Currency Converter ───────────────────────────────────
    @php $adminRates = app(\App\Services\CurrencyService::class)->getRates(); @endphp
    const ADMIN_RATES = {
        USD: 1,
        EUR: {{ $adminRates['EUR'] ?? 0.92 }},
        GBP: {{ $adminRates['GBP'] ?? 0.79 }},
        EGP: {{ $adminRates['EGP'] ?? 50 }},
        SAR: {{ $adminRates['SAR'] ?? 3.75 }},
        AED: {{ $adminRates['AED'] ?? 3.67 }},
        KWD: {{ $adminRates['KWD'] ?? 0.307 }},
        QAR: {{ $adminRates['QAR'] ?? 3.64 }},
    };
    const ADMIN_SYMBOLS = { USD:'$', EUR:'€', GBP:'£', EGP:'E£', SAR:'SAR ', AED:'AED ', KWD:'KWD ', QAR:'QAR ' };

    window.__adminActiveCurrency = localStorage.getItem('admin_currency') || 'USD';

    function adminToggleCurrencyMenu() {
        const menu = document.getElementById('adminCurrencyMenu');
        const btn  = document.getElementById('adminCurrencyBtn');
        const open = menu.style.display === 'none';
        menu.style.display = open ? 'block' : 'none';
        btn.setAttribute('aria-expanded', String(open));
    }

    function adminSelectCurrency(code) {
        window.__adminActiveCurrency = code;
        localStorage.setItem('admin_currency', code);
        document.getElementById('adminCurrencyBtnLabel').textContent = code;
        document.getElementById('adminCurrencyMenu').style.display = 'none';
        document.querySelectorAll('[data-admin-currency]').forEach(btn => {
            btn.style.color = btn.dataset.adminCurrency === code ? '#F0D060' : '#C8D4E0';
            btn.style.fontWeight = btn.dataset.adminCurrency === code ? '800' : 'normal';
        });
        adminConvertAllPrices();
    }

    function adminConvertAllPrices() {
        const code   = window.__adminActiveCurrency;
        const rate   = ADMIN_RATES[code] || 1;
        const symbol = ADMIN_SYMBOLS[code] || code;
        document.querySelectorAll('[data-price-usd]').forEach(el => {
            const usd = parseFloat(el.dataset.priceUsd);
            el.textContent = symbol + (usd * rate).toLocaleString(undefined, { maximumFractionDigits: 0 });
        });
    }

    document.addEventListener('click', function(e) {
        const widget = document.getElementById('adminCurrencyWidget');
        if (widget && !widget.contains(e.target)) {
            const menu = document.getElementById('adminCurrencyMenu');
            if (menu) menu.style.display = 'none';
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const saved = window.__adminActiveCurrency;
        document.getElementById('adminCurrencyBtnLabel').textContent = saved;
        document.querySelectorAll('[data-admin-currency]').forEach(btn => {
            if (btn.dataset.adminCurrency === saved) {
                btn.style.color = '#F0D060';
                btn.style.fontWeight = '800';
            }
        });
        adminConvertAllPrices();
    });
    </script>
</body>
</html>

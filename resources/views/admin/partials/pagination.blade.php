@if ($paginator->hasPages())
<div style="display:flex; align-items:center; gap:0.25rem; flex-wrap:wrap;">

    {{-- Previous --}}
    @if ($paginator->onFirstPage())
        <span style="display:flex; align-items:center; justify-content:center; min-width:34px; height:34px; padding:0 0.5rem; border-radius:8px; border:1.5px solid #E2E8F0; background:#F8FAFC; color:#CBD5E1; font-size:0.8rem; cursor:not-allowed;">
            <i class="fa-solid fa-chevron-{{ app()->getLocale()=='ar' ? 'right' : 'left' }} fa-xs"></i>
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" style="display:flex; align-items:center; justify-content:center; min-width:34px; height:34px; padding:0 0.5rem; border-radius:8px; border:1.5px solid #E2E8F0; background:white; color:#1A3A5C; font-size:0.8rem; font-weight:600; text-decoration:none; transition:all 0.15s;" onmouseover="this.style.borderColor='#C5A028';this.style.color='#C5A028'" onmouseout="this.style.borderColor='#E2E8F0';this.style.color='#1A3A5C'">
            <i class="fa-solid fa-chevron-{{ app()->getLocale()=='ar' ? 'right' : 'left' }} fa-xs"></i>
        </a>
    @endif

    {{-- Page Numbers --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span style="display:flex; align-items:center; justify-content:center; min-width:34px; height:34px; border-radius:8px; border:1.5px solid #E2E8F0; background:white; color:#94A3B8; font-size:0.8rem;">…</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span style="display:flex; align-items:center; justify-content:center; min-width:34px; height:34px; padding:0 0.5rem; border-radius:8px; border:1.5px solid #C5A028; background:linear-gradient(135deg,#C5A028,#F0D060); color:#1A1A1A; font-size:0.8rem; font-weight:800; box-shadow:0 2px 8px rgba(197,160,40,0.35);">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}" style="display:flex; align-items:center; justify-content:center; min-width:34px; height:34px; padding:0 0.5rem; border-radius:8px; border:1.5px solid #E2E8F0; background:white; color:#1A3A5C; font-size:0.8rem; font-weight:600; text-decoration:none; transition:all 0.15s;" onmouseover="this.style.borderColor='#C5A028';this.style.color='#C5A028'" onmouseout="this.style.borderColor='#E2E8F0';this.style.color='#1A3A5C'">
                        {{ $page }}
                    </a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" style="display:flex; align-items:center; justify-content:center; min-width:34px; height:34px; padding:0 0.5rem; border-radius:8px; border:1.5px solid #E2E8F0; background:white; color:#1A3A5C; font-size:0.8rem; font-weight:600; text-decoration:none; transition:all 0.15s;" onmouseover="this.style.borderColor='#C5A028';this.style.color='#C5A028'" onmouseout="this.style.borderColor='#E2E8F0';this.style.color='#1A3A5C'">
            <i class="fa-solid fa-chevron-{{ app()->getLocale()=='ar' ? 'left' : 'right' }} fa-xs"></i>
        </a>
    @else
        <span style="display:flex; align-items:center; justify-content:center; min-width:34px; height:34px; padding:0 0.5rem; border-radius:8px; border:1.5px solid #E2E8F0; background:#F8FAFC; color:#CBD5E1; font-size:0.8rem; cursor:not-allowed;">
            <i class="fa-solid fa-chevron-{{ app()->getLocale()=='ar' ? 'left' : 'right' }} fa-xs"></i>
        </span>
    @endif

</div>
@endif

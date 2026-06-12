@extends('layouts.app')

@php $isAr = app()->getLocale() === 'ar'; @endphp

@section('title', $isAr ? 'سبق إرسال رأيك — رحلاتي' : 'Already Reviewed — Rahalaty')
@section('meta_robots', 'noindex, nofollow')

@section('content')
<div style="min-height:80vh; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,#F0F4F8,#EBF0F8); padding:3rem 1rem;">
    <div style="text-align:center; max-width:460px; width:100%;">
        <div style="background:#fff; border-radius:20px; box-shadow:0 8px 40px rgba(0,0,0,0.08); padding:3rem 2rem;">
            <div style="font-size:3.5rem; margin-bottom:1rem;">⭐</div>
            <h1 style="font-size:1.5rem; font-weight:900; color:#1A3A5C; margin:0 0 0.75rem;">
                {{ $isAr ? 'شكراً، رأيك وصلنا!' : 'You\'ve already reviewed!' }}
            </h1>
            <p style="color:#64748B; font-size:0.9rem; line-height:1.8; margin:0 0 2rem;">
                {{ $isAr
                    ? 'أنت بالفعل شاركتنا رأيك في هذه الرحلة. نقدر ليك جداً!'
                    : 'You\'ve already submitted a review for this trip. We really appreciate it!' }}
            </p>
            <a href="{{ route('home') }}"
               style="display:inline-block; background:linear-gradient(135deg,#C5A028,#F0D060); color:#1A1A1A; font-size:0.95rem; font-weight:800; padding:0.85rem 2.5rem; border-radius:50px; text-decoration:none;">
                🌍 {{ $isAr ? 'استكشف رحلات جديدة' : 'Explore New Trips' }}
            </a>
        </div>
    </div>
</div>
@endsection

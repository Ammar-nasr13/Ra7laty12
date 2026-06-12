@extends('layouts.app')

@php $isAr = app()->getLocale() === 'ar'; @endphp

@section('title', $isAr ? 'شكراً على رأيك — رحلاتي' : 'Thank You — Rahalaty')
@section('meta_robots', 'noindex, nofollow')

@section('content')
<div style="min-height:80vh; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,#F0F4F8,#EBF0F8); padding:3rem 1rem;">
    <div style="text-align:center; max-width:480px; width:100%;">
        <div style="background:#fff; border-radius:20px; box-shadow:0 8px 40px rgba(0,0,0,0.08); padding:3rem 2rem;">
            <div style="font-size:4rem; margin-bottom:1rem;">🎉</div>
            <h1 style="font-size:1.7rem; font-weight:900; color:#1A3A5C; margin:0 0 0.75rem;">
                {{ $isAr ? 'شكراً جزيلاً!' : 'Thank You!' }}
            </h1>
            <p style="color:#64748B; font-size:0.95rem; line-height:1.8; margin:0 0 2rem;">
                {{ $isAr
                    ? 'رأيك وصلنا وبيساعد مسافرين تانيين كتير. يسعدنا نشوفك في رحلة جاية! ✈'
                    : 'Your review has been received and will help many other travelers. We hope to see you on your next adventure! ✈' }}
            </p>
            <a href="{{ route('home') }}"
               style="display:inline-block; background:linear-gradient(135deg,#C5A028,#F0D060); color:#1A1A1A; font-size:0.95rem; font-weight:800; padding:0.85rem 2.5rem; border-radius:50px; text-decoration:none;">
                🌍 {{ $isAr ? 'استكشف رحلات جديدة' : 'Explore New Trips' }}
            </a>
        </div>
    </div>
</div>
@endsection

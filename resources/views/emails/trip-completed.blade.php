<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang === 'ar' ? 'rtl' : 'ltr' }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $lang === 'ar' ? 'كيف كانت رحلتك؟' : 'How was your trip?' }}</title>
</head>
<body style="margin:0; padding:0; background:#F0F4F8; font-family: 'Segoe UI', Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#F0F4F8; padding:32px 16px;">
  <tr>
    <td align="center">
      <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px; width:100%;">

        {{-- ── HEADER ── --}}
        <tr>
          <td style="background:linear-gradient(135deg,#1A3A5C 0%,#0D2240 60%,#1A3A5C 100%); border-radius:16px 16px 0 0; overflow:hidden;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td style="padding:40px 40px 32px; text-align:{{ $lang === 'ar' ? 'right' : 'left' }};">
                  <div style="margin-bottom:24px;">
                    <span style="font-size:28px; font-weight:900; color:#C5A028; letter-spacing:-0.5px;">✈ {{ $lang === 'ar' ? 'رحلاتي' : 'Rahalaty' }}</span>
                  </div>
                  <div style="display:inline-block; background:rgba(197,160,40,0.15); border:1px solid rgba(197,160,40,0.4); border-radius:50px; padding:6px 18px; margin-bottom:16px;">
                    <span style="color:#F0D060; font-size:13px; font-weight:700;">
                      🌟 {{ $lang === 'ar' ? 'رحلتك اكتملت بنجاح!' : 'Your trip is complete!' }}
                    </span>
                  </div>
                  <h1 style="margin:0 0 10px; font-size:26px; font-weight:800; color:#FFFFFF; line-height:1.35;">
                    {{ $lang === 'ar'
                        ? 'أتمنى تكون الرحلة عجبتك يا ' . $booking->name . '! 🎉'
                        : 'Hope you had an amazing trip, ' . $booking->name . '! 🎉' }}
                  </h1>
                  <p style="margin:0; font-size:15px; color:rgba(255,255,255,0.65); line-height:1.7;">
                    {{ $lang === 'ar'
                        ? 'يسعدنا إنك كنت معنا. رأيك يهمنا كتير ويساعدنا نحسن تجربة كل المسافرين.'
                        : 'We\'re so glad you traveled with us. Your feedback means the world and helps us improve for every traveler.' }}
                  </p>
                </td>
              </tr>
              <tr>
                <td><div style="height:4px; background:linear-gradient(90deg,#C5A028,#F0D060,#C5A028);"></div></td>
              </tr>
            </table>
          </td>
        </tr>

        {{-- ── TRIP RECAP ── --}}
        <tr>
          <td style="background:#FFFFFF; padding:32px 40px 24px;">
            <p style="margin:0 0 16px; font-size:11px; font-weight:700; color:#94A3B8; text-transform:uppercase; letter-spacing:1.5px; text-align:{{ $lang === 'ar' ? 'right' : 'left' }};">
              {{ $lang === 'ar' ? '🗺 رحلتك' : '🗺 Your Trip' }}
            </p>
            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                   style="background:linear-gradient(135deg,{{ $trip->color_from }},{{ $trip->color_to }}); border-radius:12px; overflow:hidden;">
              <tr>
                <td style="padding:24px 28px;">
                  <h2 style="margin:0 0 6px; font-size:20px; font-weight:800; color:#FFFFFF; line-height:1.3; text-align:{{ $lang === 'ar' ? 'right' : 'left' }};">
                    {{ $trip->getTranslation('title', $lang) }}
                  </h2>
                  @if($trip->destination)
                  <p style="margin:0 0 14px; font-size:14px; color:rgba(255,255,255,0.75); text-align:{{ $lang === 'ar' ? 'right' : 'left' }};">
                    📍 {{ $trip->destination->getTranslation('name', $lang) }}
                  </p>
                  @endif
                  <span style="background:rgba(255,255,255,0.2); border-radius:20px; padding:5px 14px; font-size:12px; font-weight:700; color:#FFFFFF; display:inline-block;">
                    🗓 {{ \Carbon\Carbon::parse($booking->travel_date)->format('d M Y') }}
                  </span>
                  <span style="background:rgba(255,255,255,0.2); border-radius:20px; padding:5px 14px; font-size:12px; font-weight:700; color:#FFFFFF; display:inline-block; margin-{{ $lang === 'ar' ? 'right' : 'left' }}:8px;">
                    🔖 {{ $booking->reference }}
                  </span>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        {{-- ── ASK FOR REVIEW ── --}}
        <tr>
          <td style="background:#FFFFFF; padding:0 40px 24px;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                   style="background:linear-gradient(135deg,#FFFBEB,#FEF3C7); border:1px solid #FDE68A; border-radius:12px;">
              <tr>
                <td style="padding:28px 28px; text-align:{{ $lang === 'ar' ? 'right' : 'left' }};">
                  <p style="margin:0 0 8px; font-size:22px; text-align:center;">⭐⭐⭐⭐⭐</p>
                  <p style="margin:0 0 10px; font-size:16px; font-weight:800; color:#92400E; text-align:center;">
                    {{ $lang === 'ar' ? 'ما رأيك في الرحلة؟' : 'What did you think of the trip?' }}
                  </p>
                  <p style="margin:0; font-size:13px; color:#78350F; line-height:1.7; text-align:center;">
                    {{ $lang === 'ar'
                        ? 'شاركنا تجربتك في دقيقة واحدة فقط، وساعد المسافرين الآخرين يختاروا رحلتهم الجاية.'
                        : 'Share your experience in just one minute and help other travelers choose their next adventure.' }}
                  </p>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        {{-- ── CTA BUTTON ── --}}
        <tr>
          <td style="background:#FFFFFF; padding:0 40px 40px; text-align:center;">
            <a href="{{ $reviewUrl }}"
               style="display:inline-block; background:linear-gradient(135deg,#C5A028,#F0D060); color:#1A1A1A; font-size:16px; font-weight:800; padding:16px 48px; border-radius:50px; text-decoration:none; letter-spacing:0.3px; box-shadow:0 4px 15px rgba(197,160,40,0.4);">
              ✍ {{ $lang === 'ar' ? 'اكتب رأيك الآن' : 'Write Your Review Now' }}
            </a>
            <p style="margin:16px 0 0; font-size:11px; color:#94A3B8;">
              {{ $lang === 'ar' ? 'الرابط صالح لمدة 30 يوماً' : 'Link is valid for 30 days' }}
            </p>
          </td>
        </tr>

        {{-- ── FOOTER ── --}}
        <tr>
          <td style="background:#1A3A5C; border-radius:0 0 16px 16px; padding:28px 40px; text-align:center;">
            <p style="margin:0 0 8px; font-size:18px; font-weight:900; color:#C5A028;">✈ {{ $lang === 'ar' ? 'رحلاتي' : 'Rahalaty' }}</p>
            <p style="margin:0 0 12px; font-size:12px; color:rgba(255,255,255,0.5);">
              {{ $lang === 'ar' ? 'اكتشف العالم معنا — أفضل الرحلات بأفضل الأسعار' : 'Discover the World With Us — Best Trips at Best Prices' }}
            </p>
            <div style="height:1px; background:rgba(255,255,255,0.1); margin:16px 0;"></div>
            <p style="margin:0; font-size:11px; color:rgba(255,255,255,0.35); line-height:1.8;">
              {{ $lang === 'ar'
                  ? 'هذا الإيميل أُرسل تلقائياً بعد اكتمال رحلتك. الرجاء عدم الرد عليه.'
                  : 'This email was automatically sent after your trip completion. Please do not reply.' }}
              <br>© {{ date('Y') }} {{ $lang === 'ar' ? 'رحلاتي' : 'Rahalaty' }}. {{ $lang === 'ar' ? 'جميع الحقوق محفوظة.' : 'All rights reserved.' }}
            </p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>

</body>
</html>

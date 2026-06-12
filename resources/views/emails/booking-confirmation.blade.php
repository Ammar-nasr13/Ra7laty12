<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang === 'ar' ? 'rtl' : 'ltr' }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>{{ $lang === 'ar' ? 'تأكيد الحجز' : 'Booking Confirmation' }}</title>
</head>
<body style="margin:0; padding:0; background:#F0F4F8; font-family: 'Segoe UI', Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#F0F4F8; padding:32px 16px;">
  <tr>
    <td align="center">
      <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px; width:100%;">

        {{-- ── HEADER ── --}}
        <tr>
          <td style="background:linear-gradient(135deg,#1A3A5C 0%,#0D2240 60%,#1A3A5C 100%); border-radius:16px 16px 0 0; padding:0; overflow:hidden;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td style="padding:40px 40px 32px; text-align:{{ $lang === 'ar' ? 'right' : 'left' }};">
                  {{-- Logo / Brand --}}
                  <div style="margin-bottom:24px;">
                    <span style="font-size:28px; font-weight:900; color:#C5A028; letter-spacing:-0.5px;">✈ {{ $lang === 'ar' ? 'رحلاتي' : 'Rehlatyy' }}</span>
                  </div>
                  {{-- Success badge --}}
                  <div style="display:inline-block; background:rgba(197,160,40,0.15); border:1px solid rgba(197,160,40,0.4); border-radius:50px; padding:6px 18px; margin-bottom:16px;">
                    <span style="color:#F0D060; font-size:13px; font-weight:700;">
                      ✅ {{ $lang === 'ar' ? 'تم تأكيد حجزك بنجاح!' : 'Your booking is confirmed!' }}
                    </span>
                  </div>
                  {{-- Heading --}}
                  <h1 style="margin:0 0 8px; font-size:26px; font-weight:800; color:#FFFFFF; line-height:1.3;">
                    {{ $lang === 'ar' ? 'أهلاً ' . $booking->name . '! 🎉' : 'Hey ' . $booking->name . '! 🎉' }}
                  </h1>
                  <p style="margin:0; font-size:15px; color:rgba(255,255,255,0.65); line-height:1.6;">
                    {{ $lang === 'ar'
                        ? 'حجزك اتسجّل بنجاح. احتفظ بهذا الإيميل كمرجع لرحلتك.'
                        : 'Your booking has been successfully registered. Keep this email as reference for your trip.' }}
                  </p>
                </td>
              </tr>
              {{-- Decorative gold bar --}}
              <tr>
                <td style="padding:0;">
                  <div style="height:4px; background:linear-gradient(90deg,#C5A028,#F0D060,#C5A028);"></div>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        {{-- ── REFERENCE BANNER ── --}}
        <tr>
          <td style="background:#C5A028; padding:18px 40px;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td style="text-align:{{ $lang === 'ar' ? 'right' : 'left' }};">
                  <span style="font-size:12px; font-weight:700; color:rgba(26,26,26,0.65); text-transform:uppercase; letter-spacing:1px;">
                    {{ $lang === 'ar' ? 'رقم الحجز' : 'Booking Reference' }}
                  </span>
                  <br>
                  <span style="font-size:22px; font-weight:900; color:#1A1A1A; letter-spacing:2px; font-family: 'Courier New', monospace;">
                    {{ $booking->reference }}
                  </span>
                </td>
                <td style="text-align:{{ $lang === 'ar' ? 'left' : 'right' }}; vertical-align:middle;">
                  <div style="background:rgba(26,26,26,0.12); border-radius:8px; padding:8px 16px; display:inline-block;">
                    <span style="font-size:13px; font-weight:700; color:#1A1A1A;">
                      {{ $lang === 'ar' ? '✅ مؤكد' : '✅ Confirmed' }}
                    </span>
                  </div>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        {{-- ── TRIP CARD ── --}}
        <tr>
          <td style="background:#FFFFFF; padding:32px 40px 24px;">
            <p style="margin:0 0 16px; font-size:11px; font-weight:700; color:#94A3B8; text-transform:uppercase; letter-spacing:1.5px; text-align:{{ $lang === 'ar' ? 'right' : 'left' }};">
              {{ $lang === 'ar' ? '🗺 تفاصيل الرحلة' : '🗺 Trip Details' }}
            </p>
            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                   style="background:linear-gradient(135deg,{{ $trip->color_from }},{{ $trip->color_to }}); border-radius:12px; overflow:hidden;">
              <tr>
                <td style="padding:24px 28px;">
                  <h2 style="margin:0 0 8px; font-size:20px; font-weight:800; color:#FFFFFF; line-height:1.3; text-align:{{ $lang === 'ar' ? 'right' : 'left' }};">
                    {{ $trip->getTranslation('title', $lang) }}
                  </h2>
                  @if($trip->destination)
                  <p style="margin:0 0 16px; font-size:14px; color:rgba(255,255,255,0.75); text-align:{{ $lang === 'ar' ? 'right' : 'left' }};">
                    📍 {{ $trip->destination->getTranslation('name', $lang) }}
                  </p>
                  @endif
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td style="text-align:{{ $lang === 'ar' ? 'right' : 'left' }};">
                        <table cellpadding="0" cellspacing="0" border="0" style="border-collapse:separate; border-spacing:0 6px;">
                          <tr>
                            <td style="padding:0 0 0 0;">
                              <span style="background:rgba(255,255,255,0.2); border-radius:20px; padding:5px 14px; font-size:12px; font-weight:700; color:#FFFFFF; white-space:nowrap; display:inline-block; margin:3px 4px 3px 0;">
                                🗓 {{ $lang === 'ar' ? 'تاريخ السفر: ' : 'Travel Date: ' }}{{ \Carbon\Carbon::parse($booking->travel_date)->format('d M Y') }}
                              </span>
                              <span style="background:rgba(255,255,255,0.2); border-radius:20px; padding:5px 14px; font-size:12px; font-weight:700; color:#FFFFFF; white-space:nowrap; display:inline-block; margin:3px 4px 3px 0;">
                                ⏱ {{ $lang === 'ar' ? $trip->duration . ' أيام' : $trip->duration . ' Days' }}
                              </span>
                              <span style="background:rgba(255,255,255,0.2); border-radius:20px; padding:5px 14px; font-size:12px; font-weight:700; color:#FFFFFF; white-space:nowrap; display:inline-block; margin:3px 0 3px 0;">
                                @php
                                    $catAr = ['beach'=>'شواطئ','culture'=>'ثقافة','adventure'=>'مغامرة'];
                                    $catEn = ['beach'=>'Beach','culture'=>'Culture','adventure'=>'Adventure'];
                                @endphp
                                🏷 {{ $lang === 'ar' ? ($catAr[$trip->category] ?? $trip->category) : ($catEn[$trip->category] ?? $trip->category) }}
                              </span>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        {{-- ── BOOKING SUMMARY ── --}}
        <tr>
          <td style="background:#FFFFFF; padding:0 40px 24px;">
            <p style="margin:0 0 16px; font-size:11px; font-weight:700; color:#94A3B8; text-transform:uppercase; letter-spacing:1.5px; text-align:{{ $lang === 'ar' ? 'right' : 'left' }};">
              {{ $lang === 'ar' ? '📋 ملخص الحجز' : '📋 Booking Summary' }}
            </p>
            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                   style="border:1px solid #E2E8F0; border-radius:12px; overflow:hidden;">
              @php
                $rows = $lang === 'ar' ? [
                  ['الاسم',           $booking->name],
                  ['البريد الإلكتروني', $booking->email],
                  ['الهاتف',           $booking->phone],
                  ['البالغون',         $booking->adults . ' ' . ($booking->adults > 1 ? 'أشخاص' : 'شخص')],
                  ['الأطفال',           $booking->children . ' ' . ($booking->children !== 1 ? 'أطفال' : 'طفل')],
                  ['طريقة الدفع',     $booking->payment_method_label],
                ] : [
                  ['Full Name',        $booking->name],
                  ['Email',            $booking->email],
                  ['Phone',            $booking->phone],
                  ['Adults',           $booking->adults . ' ' . ($booking->adults > 1 ? 'Persons' : 'Person')],
                  ['Children',         $booking->children . ' ' . ($booking->children !== 1 ? 'Children' : 'Child')],
                  ['Payment Method',   $booking->payment_method_label],
                ];
              @endphp
              @foreach($rows as $i => [$label, $value])
              <tr style="background:{{ $i % 2 === 0 ? '#FFFFFF' : '#F8FAFC' }};">
                <td style="padding:12px 20px; font-size:13px; color:#64748B; font-weight:600; text-align:{{ $lang === 'ar' ? 'right' : 'left' }}; border-bottom:1px solid #F1F5F9; width:40%;">
                  {{ $label }}
                </td>
                <td style="padding:12px 20px; font-size:13px; color:#1A3A5C; font-weight:700; text-align:{{ $lang === 'ar' ? 'left' : 'right' }}; border-bottom:1px solid #F1F5F9;">
                  {{ $value }}
                </td>
              </tr>
              @endforeach
              @if($booking->notes)
              <tr style="background:#FFFBEB;">
                <td colspan="2" style="padding:12px 20px; font-size:13px; color:#92400E; text-align:{{ $lang === 'ar' ? 'right' : 'left' }}; border-bottom:1px solid #F1F5F9;">
                  <strong>{{ $lang === 'ar' ? 'ملاحظات: ' : 'Notes: ' }}</strong>{{ $booking->notes }}
                </td>
              </tr>
              @endif
            </table>
          </td>
        </tr>

        {{-- ── PRICE BOX ── --}}
        <tr>
          <td style="background:#FFFFFF; padding:0 40px 32px;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                   style="background:linear-gradient(135deg,#1A3A5C,#0D2240); border-radius:12px; overflow:hidden;">
              <tr>
                <td style="padding:20px 28px;">
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td style="text-align:{{ $lang === 'ar' ? 'right' : 'left' }}; vertical-align:middle;">
                        <span style="font-size:13px; color:rgba(255,255,255,0.6); font-weight:600;">
                          {{ $lang === 'ar' ? 'إجمالي المبلغ' : 'Total Amount' }}
                        </span>
                        <br>
                        <span style="font-size:14px; color:rgba(255,255,255,0.5);">
                          {{ $lang === 'ar'
                              ? $booking->adults . ' بالغ × ' . $trip->currency . number_format($trip->price,0) . ($booking->children > 0 ? ' + ' . $booking->children . ' طفل × ' . $trip->currency . number_format($trip->price * 0.5, 0) : '')
                              : $booking->adults . ' adult(s) × ' . $trip->currency . number_format($trip->price,0) . ($booking->children > 0 ? ' + ' . $booking->children . ' child(ren) × ' . $trip->currency . number_format($trip->price * 0.5, 0) : '') }}
                        </span>
                      </td>
                      <td style="text-align:{{ $lang === 'ar' ? 'left' : 'right' }}; vertical-align:middle;">
                        <span style="font-size:30px; font-weight:900; color:#F0D060;">
                          {{ $trip->currency }}{{ number_format($booking->total_price, 0) }}
                        </span>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        {{-- ── NEXT STEPS ── --}}
        <tr>
          <td style="background:#FFFFFF; padding:0 40px 32px;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                   style="background:#F0FFF4; border:1px solid #BBF7D0; border-radius:12px;">
              <tr>
                <td style="padding:20px 24px; text-align:{{ $lang === 'ar' ? 'right' : 'left' }};">
                  <p style="margin:0 0 10px; font-size:14px; font-weight:800; color:#166534;">
                    {{ $lang === 'ar' ? '✅ الخطوات التالية' : '✅ What happens next?' }}
                  </p>
                  <ul style="margin:0; padding-{{ $lang === 'ar' ? 'right' : 'left' }}:20px; color:#15803D; font-size:13px; line-height:2;">
                    @if($lang === 'ar')
                    <li>سيتواصل معك فريقنا خلال 24 ساعة لتأكيد التفاصيل.</li>
                    <li>احتفظ برقم الحجز <strong>{{ $booking->reference }}</strong> للمتابعة.</li>
                    <li>في حال أي استفسار، تواصل معنا عبر الواتساب أو الإيميل.</li>
                    @else
                    <li>Our team will contact you within 24 hours to confirm details.</li>
                    <li>Keep your booking number <strong>{{ $booking->reference }}</strong> for reference.</li>
                    <li>For any inquiries, reach us via WhatsApp or email.</li>
                    @endif
                  </ul>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        {{-- ── CTA BUTTON ── --}}
        <tr>
          <td style="background:#FFFFFF; padding:0 40px 40px; text-align:center;">
            <a href="{{ config('app.url') }}"
               style="display:inline-block; background:linear-gradient(135deg,#C5A028,#F0D060); color:#1A1A1A; font-size:15px; font-weight:800; padding:14px 40px; border-radius:50px; text-decoration:none; letter-spacing:0.3px;">
              {{ $lang === 'ar' ? '🌍 استكشف المزيد من الرحلات' : '🌍 Explore More Trips' }}
            </a>
          </td>
        </tr>

        {{-- ── FOOTER ── --}}
        <tr>
          <td style="background:#1A3A5C; border-radius:0 0 16px 16px; padding:28px 40px; text-align:center;">
            <p style="margin:0 0 8px; font-size:18px; font-weight:900; color:#C5A028;">✈ {{ $lang === 'ar' ? 'رحلاتي' : 'Rehlatyy' }}</p>
            <p style="margin:0 0 12px; font-size:12px; color:rgba(255,255,255,0.5);">
              {{ $lang === 'ar' ? 'اكتشف العالم معنا — أفضل الرحلات بأفضل الأسعار' : 'Discover the World With Us — Best Trips at Best Prices' }}
            </p>
            <div style="height:1px; background:rgba(255,255,255,0.1); margin:16px 0;"></div>
            <p style="margin:0; font-size:11px; color:rgba(255,255,255,0.35); line-height:1.8;">
              {{ $lang === 'ar'
                  ? 'هذا الإيميل أُرسل تلقائياً بعد إتمام الحجز. الرجاء عدم الرد عليه.'
                  : 'This email was automatically sent after completing your booking. Please do not reply.' }}
              <br>
              © {{ date('Y') }} {{ $lang === 'ar' ? 'رحلاتي' : 'Rehlatyy' }}. {{ $lang === 'ar' ? 'جميع الحقوق محفوظة.' : 'All rights reserved.' }}
            </p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>

</body>
</html>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $subject }}</title>
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
                <td style="padding:36px 40px 28px; text-align:left;">
                  <div style="margin-bottom:20px;">
                    <span style="font-size:26px; font-weight:900; color:#C5A028; letter-spacing:-0.5px;">✈ Rahalaty</span>
                  </div>
                  <h1 style="margin:0; font-size:22px; font-weight:800; color:#FFFFFF; line-height:1.35;">
                    {{ $subject }}
                  </h1>
                </td>
              </tr>
              <tr>
                <td><div style="height:4px; background:linear-gradient(90deg,#C5A028,#F0D060,#C5A028);"></div></td>
              </tr>
            </table>
          </td>
        </tr>

        {{-- ── BODY ── --}}
        <tr>
          <td style="background:#FFFFFF; padding:36px 40px 32px;">
            <div style="font-size:15px; color:#374151; line-height:1.9; white-space:pre-wrap;">{{ $body }}</div>
          </td>
        </tr>

        {{-- ── CTA ── --}}
        <tr>
          <td style="background:#FFFFFF; padding:0 40px 40px; text-align:center;">
            <div style="height:1px; background:#F1F5F9; margin-bottom:32px;"></div>
            <a href="{{ config('app.url') }}"
               style="display:inline-block; background:linear-gradient(135deg,#C5A028,#F0D060); color:#1A1A1A; font-size:15px; font-weight:800; padding:14px 40px; border-radius:50px; text-decoration:none;">
              🌍 Explore Our Trips
            </a>
          </td>
        </tr>

        {{-- ── FOOTER ── --}}
        <tr>
          <td style="background:#1A3A5C; border-radius:0 0 16px 16px; padding:28px 40px; text-align:center;">
            <p style="margin:0 0 8px; font-size:18px; font-weight:900; color:#C5A028;">✈ Rahalaty</p>
            <p style="margin:0 0 12px; font-size:12px; color:rgba(255,255,255,0.5);">
              Discover the World With Us — Best Trips at Best Prices
            </p>
            <div style="height:1px; background:rgba(255,255,255,0.1); margin:16px 0;"></div>
            <p style="margin:0; font-size:11px; color:rgba(255,255,255,0.35); line-height:1.8;">
              This email was sent to you because you subscribed or booked with Rahalaty.
              <br>© {{ date('Y') }} Rahalaty. All rights reserved.
            </p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>

</body>
</html>

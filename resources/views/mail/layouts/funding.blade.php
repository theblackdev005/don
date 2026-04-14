@php
  $siteName = (string) config('site.name', config('app.name', 'Around'));
  $siteEmail = (string) config('site.email', '');
  $brand = '#0f6b57';
  $text = '#1a1a1a';
  $muted = '#5c6670';
  $surface = '#ffffff';
  $pageBg = '#eef2f1';

  $ff = "-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif";
  $styleBody = "margin:0;padding:0;background-color:{$pageBg};-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;";
  $styleTableOuter = "background-color:{$pageBg};margin:0;padding:0;";
  $styleHeaderTd = "background-color:{$brand};border-radius:12px 12px 0 0;padding:22px 28px;";
  $styleCardOuter = "background-color:{$surface};padding:0 1px 1px;border-radius:0 0 12px 12px;box-shadow:0 4px 24px rgba(15,107,87,0.08);";
  $styleContentTd = "padding:28px 28px 8px;font-family:{$ff};font-size:16px;line-height:1.55;color:{$text};";
  $styleSecondaryTd = "padding:0 28px 24px;font-family:{$ff};font-size:14px;line-height:1.5;color:{$muted};";
  $styleSignoffWrapTd = "padding:0 28px 28px;font-family:{$ff};font-size:15px;line-height:1.5;color:{$text};";
  $styleSignoffP = "margin:20px 0 0;padding-top:20px;border-top:1px solid #e5ebe9;font-size:14px;color:{$muted};";
  $styleFooterTd = "padding:20px 8px 0;text-align:center;font-family:{$ff};font-size:12px;line-height:1.6;color:{$muted};";
  $styleMailtoA = "color:{$brand};text-decoration:none;font-weight:600;";
  $styleHeaderTagline = "margin:6px 0 0;font-family:{$ff};font-size:13px;color:rgba(255,255,255,0.88);line-height:1.4;";
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="x-apple-disable-message-reformatting">
  <title>@yield('title', $siteName)</title>
  <!--[if mso]>
  <noscript>
    <xml>
      <o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings>
    </xml>
  </noscript>
  <![endif]-->
</head>
<body style="@php echo e($styleBody); @endphp">
  @hasSection('preheader')
  <div style="display:none;max-height:0;overflow:hidden;mso-hide:all;font-size:1px;line-height:1px;color:transparent;opacity:0;">
    @yield('preheader')
  </div>
  @endif
  <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="@php echo e($styleTableOuter); @endphp">
    <tr>
      <td align="center" style="padding:28px 16px;">
        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width:600px;margin:0 auto;">
          <tr>
            <td style="@php echo e($styleHeaderTd); @endphp">
              <p style="margin:0;font-family:Georgia,'Times New Roman',serif;font-size:20px;font-weight:700;letter-spacing:0.02em;color:#ffffff;line-height:1.25;">
                {{ $siteName }}
              </p>
              @hasSection('header_tagline')
              <p style="@php echo e($styleHeaderTagline); @endphp">
                @yield('header_tagline')
              </p>
              @endif
            </td>
          </tr>
          <tr>
            <td style="@php echo e($styleCardOuter); @endphp">
              <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                  <td style="@php echo e($styleContentTd); @endphp">
                    @yield('content')
                  </td>
                </tr>
                @hasSection('secondary')
                <tr>
                  <td style="@php echo e($styleSecondaryTd); @endphp">
                    @yield('secondary')
                  </td>
                </tr>
                @endif
                <tr>
                  <td style="@php echo e($styleSignoffWrapTd); @endphp">
                    <p style="@php echo e($styleSignoffP); @endphp">
                      @yield('signoff', __('mail.layout.default_signoff', ['site' => $siteName]))
                    </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td style="@php echo e($styleFooterTd); @endphp">
              @if($siteEmail !== '')
              <p style="margin:0 0 6px;">
                <a href="mailto:{{ $siteEmail }}" style="@php echo e($styleMailtoA); @endphp">{{ $siteEmail }}</a>
              </p>
              @endif
              <p style="margin:0;opacity:0.85;">
                © {{ date('Y') }} {{ $siteName }}
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>

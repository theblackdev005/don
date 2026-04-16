@php
  $googleTagId = trim((string) config('site.tracking.google_tag_id', ''));
  $facebookPixelId = trim((string) config('site.tracking.facebook_pixel_id', ''));
@endphp

@if ($googleTagId !== '')
  <script async src="https://www.googletagmanager.com/gtag/js?id={{ e($googleTagId) }}"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '{{ e($googleTagId) }}');
  </script>
@endif

@if ($facebookPixelId !== '')
  <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '{{ e($facebookPixelId) }}');
    fbq('track', 'PageView');
  </script>
@endif

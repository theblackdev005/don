<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-bs-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport"
    content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">

  <title>@yield('title', config('site.name').' | '.__('funding.meta_title'))</title>
  @stack('meta')

  <link rel="manifest" href="/manifest.json">
  <link rel="icon" href="{{ \App\Support\SiteAppearance::faviconUrl() }}">
  <link rel="apple-touch-icon" href="{{ \App\Support\SiteAppearance::faviconUrl() }}">

  <script src="/assets/js/theme-switcher.js"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"
    id="google-font">

  @stack('vendor-css')

  <link rel="stylesheet" href="/assets/icons/around-icons.min.css">
  <link rel="stylesheet" media="screen" href="/assets/css/theme.min.css">

  @include('partials.site-tracking-head')
  @include('partials.preloader-head')
  @stack('head')
</head>

<body class="@yield('body-class')">

  @include('partials.preloader')

  @yield('content')

  @include('partials.scroll-top')

  @stack('vendor-scripts')
  <script src="/assets/js/theme.min.js"></script>
  <script>
    (() => {
      const initSubmitLoadingStates = () => {
        document.querySelectorAll('form').forEach((form) => {
          form.addEventListener('submit', () => {
            const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
            if (!submitButton || submitButton.disabled) {
              return;
            }

            const loadingText = submitButton.getAttribute('data-submit-loading-text');
            if (!loadingText) {
              return;
            }

            if (!submitButton.dataset.originalText) {
              submitButton.dataset.originalText = submitButton.tagName === 'INPUT'
                ? (submitButton.value || '')
                : (submitButton.innerHTML || '');
            }

            if (submitButton.tagName === 'INPUT') {
              submitButton.value = loadingText;
            } else {
              submitButton.textContent = loadingText;
            }

            submitButton.disabled = true;
            submitButton.setAttribute('aria-busy', 'true');
          });
        });
      };

      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSubmitLoadingStates, { once: true });
      } else {
        initSubmitLoadingStates();
      }
    })();
  </script>
</body>

</html>

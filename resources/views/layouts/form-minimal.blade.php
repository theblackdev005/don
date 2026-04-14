<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport"
    content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">

  <title>@yield('title', config('site.name'))</title>
  @stack('meta')

  <link rel="manifest" href="/manifest.json">
  <link rel="icon" type="image/png" href="/assets/app-icons/icon-32x32.png" sizes="32x32">
  <link rel="apple-touch-icon" href="/assets/app-icons/icon-180x180.png">

  <script src="/assets/js/theme-switcher.js"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"
    id="google-font">

  @stack('vendor-css')

  <link rel="stylesheet" href="/assets/icons/around-icons.min.css">
  <link rel="stylesheet" media="screen" href="/assets/css/theme.min.css">

  @include('partials.preloader-head')
  @stack('head')
</head>

<body class="@yield('body-class')">

  @include('partials.preloader')

  @yield('content')

  @include('partials.scroll-top')

  @stack('vendor-scripts')
  <script src="/assets/js/theme.min.js"></script>
</body>

</html>

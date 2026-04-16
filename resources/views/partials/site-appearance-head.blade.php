@php
  $sitePrimary = \App\Support\SiteAppearance::primaryColor();
  $sitePrimaryRgb = \App\Support\SiteAppearance::primaryRgb();
  $sitePrimaryText = \App\Support\SiteAppearance::contrastTextColor($sitePrimary);
  $siteSecondary = \App\Support\SiteAppearance::secondaryColor();
  $siteSecondaryRgb = \App\Support\SiteAppearance::secondaryRgb();
  $siteSecondaryText = \App\Support\SiteAppearance::contrastTextColor($siteSecondary);
@endphp
<style id="site-appearance-theme">
  :root {
    --ar-primary: {{ $sitePrimary }};
    --ar-primary-rgb: {{ $sitePrimaryRgb }};
    --ar-link-color: {{ $sitePrimary }};
    --ar-link-hover-color: {{ $sitePrimary }};
    --bs-primary: {{ $sitePrimary }};
    --bs-primary-rgb: {{ $sitePrimaryRgb }};
    --bs-link-color-rgb: {{ $sitePrimaryRgb }};
    --bs-link-hover-color-rgb: {{ $sitePrimaryRgb }};
    --bs-focus-ring-color: rgba({{ $sitePrimaryRgb }}, .25);
    --site-secondary: {{ $siteSecondary }};
    --site-secondary-rgb: {{ $siteSecondaryRgb }};
  }

  .btn-primary {
    --bs-btn-color: {{ $sitePrimaryText }};
    --bs-btn-bg: {{ $sitePrimary }};
    --bs-btn-border-color: {{ $sitePrimary }};
    --bs-btn-hover-color: {{ $sitePrimaryText }};
    --bs-btn-hover-bg: {{ $sitePrimary }};
    --bs-btn-hover-border-color: {{ $sitePrimary }};
    --bs-btn-active-color: {{ $sitePrimaryText }};
    --bs-btn-active-bg: {{ $sitePrimary }};
    --bs-btn-active-border-color: {{ $sitePrimary }};
    --bs-btn-disabled-color: {{ $sitePrimaryText }};
    --bs-btn-disabled-bg: {{ $sitePrimary }};
    --bs-btn-disabled-border-color: {{ $sitePrimary }};
  }

  .btn-outline-primary {
    --bs-btn-color: {{ $sitePrimary }};
    --bs-btn-border-color: rgba({{ $sitePrimaryRgb }}, .45);
    --bs-btn-hover-color: {{ $sitePrimaryText }};
    --bs-btn-hover-bg: {{ $sitePrimary }};
    --bs-btn-hover-border-color: {{ $sitePrimary }};
    --bs-btn-active-color: {{ $sitePrimaryText }};
    --bs-btn-active-bg: {{ $sitePrimary }};
    --bs-btn-active-border-color: {{ $sitePrimary }};
  }

  .btn-secondary {
    --bs-btn-color: {{ $siteSecondaryText }};
    --bs-btn-bg: {{ $siteSecondary }};
    --bs-btn-border-color: {{ $siteSecondary }};
    --bs-btn-hover-color: {{ $siteSecondaryText }};
    --bs-btn-hover-bg: {{ $siteSecondary }};
    --bs-btn-hover-border-color: {{ $siteSecondary }};
  }

  .text-primary,
  a.text-primary {
    color: {{ $sitePrimary }} !important;
  }

  .bg-primary,
  .badge.bg-primary,
  .badge.text-bg-primary {
    background-color: rgba({{ $sitePrimaryRgb }}, var(--bs-bg-opacity, 1)) !important;
    color: {{ $sitePrimaryText }} !important;
  }

  .page-spinner {
    border-top-color: {{ $sitePrimary }} !important;
  }

  ::selection {
    background: rgba({{ $sitePrimaryRgb }}, .2);
  }
</style>

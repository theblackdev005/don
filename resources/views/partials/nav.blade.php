@php
  $active = $active ?? 'home';
  $variant = $variant ?? 'default';
  $headerClass = match ($variant) {
    'light' => 'navbar navbar-expand-lg fixed-top bg-light',
    default => 'navbar navbar-expand-lg fixed-top',
  };
@endphp

@once
  @push('head')
    <style>
      .site-mobile-menu-toggle {
        width: 3.5rem;
        height: 3.5rem;
        padding: 0;
        border: 1px solid rgba(31, 143, 107, 0.16);
        border-radius: 1.2rem;
        background: rgba(255, 255, 255, 0.96);
        box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
      }

      .site-mobile-menu-toggle:focus {
        box-shadow: 0 0 0 .2rem rgba(31, 143, 107, 0.14), 0 14px 28px rgba(15, 23, 42, 0.06);
      }

      .site-mobile-menu-toggle-grid {
        display: grid;
        grid-template-columns: repeat(3, .45rem);
        gap: .38rem;
        justify-content: center;
      }

      .site-mobile-menu-toggle-dot {
        width: .45rem;
        height: .45rem;
        border-radius: 999px;
        background: #1f8f6b;
        box-shadow: 0 2px 6px rgba(31, 143, 107, 0.16);
        transition: transform .18s ease, opacity .18s ease;
      }

      .site-mobile-menu-toggle[aria-expanded="true"] .site-mobile-menu-toggle-dot:nth-child(2),
      .site-mobile-menu-toggle[aria-expanded="true"] .site-mobile-menu-toggle-dot:nth-child(4),
      .site-mobile-menu-toggle[aria-expanded="true"] .site-mobile-menu-toggle-dot:nth-child(6),
      .site-mobile-menu-toggle[aria-expanded="true"] .site-mobile-menu-toggle-dot:nth-child(8) {
        opacity: .55;
        transform: scale(.85);
      }

      @media (min-width: 992px) {
        .site-mobile-menu-toggle {
          display: none;
        }
      }

      @media (max-width: 575.98px) {
        .site-mobile-menu-toggle {
          width: 3.2rem;
          height: 3.2rem;
          border-radius: 1.05rem;
        }

        .site-mobile-menu-toggle-grid {
          grid-template-columns: repeat(3, .4rem);
          gap: .34rem;
        }

        .site-mobile-menu-toggle-dot {
          width: .4rem;
          height: .4rem;
        }
      }
    </style>
  @endpush
@endonce

@if ($variant === 'dark')
  <header data-bs-theme="dark">
    <div class="{{ $headerClass }}">
      <div class="container">
@else
  <header class="{{ $headerClass }}">
    <div class="container">
@endif

        <a class="navbar-brand pe-sm-3 d-flex align-items-center" href="{{ url('/') }}">
          <img src="{{ \App\Support\SiteAppearance::logoUrl() }}" alt="{{ config('site.name') }}" style="height: 42px; width: auto;" class="flex-shrink-0">
        </a>

        <div class="dropdown ms-auto order-lg-2 me-2 me-lg-0">
          <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ strtoupper(app()->getLocale()) }}
          </button>
          <ul class="dropdown-menu dropdown-menu-end my-1">
            @foreach (config('locales.supported', ['fr']) as $localeCode)
              <li><a class="dropdown-item" href="{{ route('locale.switch', ['locale' => app()->getLocale(), 'target' => $localeCode]) }}">{{ __('ui.lang.'.$localeCode) }}</a></li>
            @endforeach
          </ul>
        </div>

        @if ($variant === 'account')
          <div class="dropdown nav d-none d-sm-block order-lg-3">
            <a class="nav-link d-flex align-items-center p-0" href="#" data-bs-toggle="dropdown" aria-expanded="false">
              <img class="border rounded-circle" src="/assets/img/avatar/01.jpg" width="48" alt="">
              <div class="ps-2">
                <div class="fs-xs lh-1 opacity-60">{{ __('ui.nav.connected') }}</div>
                <div class="fs-sm dropdown-toggle">Isabella</div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end my-1">
              <a class="dropdown-item" href="{{ route('funding-request.create') }}">
                <i class="ai-user-check fs-lg opacity-70 me-2"></i>
                {{ __('ui.nav.funding_request') }}
              </a>
              <a class="dropdown-item" href="{{ route('funding.tracking') }}">
                <i class="ai-search fs-lg opacity-70 me-2"></i>
                {{ __('ui.nav.tracking') }}
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ url('/') }}">
                <i class="ai-arrow-left fs-lg opacity-70 me-2"></i>
                {{ __('ui.nav.back_to_site') }}
              </a>
              <a class="dropdown-item" href="#">
                <i class="ai-logout fs-lg opacity-70 me-2"></i>
                {{ __('ui.nav.logout') }}
              </a>
            </div>
          </div>
        @endif

        <button class="navbar-toggler site-mobile-menu-toggle ms-2 ms-sm-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-label="{{ __('ui.nav.admin_menu') }}">
          <span class="site-mobile-menu-toggle-grid" aria-hidden="true">
            <span class="site-mobile-menu-toggle-dot"></span>
            <span class="site-mobile-menu-toggle-dot"></span>
            <span class="site-mobile-menu-toggle-dot"></span>
            <span class="site-mobile-menu-toggle-dot"></span>
            <span class="site-mobile-menu-toggle-dot"></span>
            <span class="site-mobile-menu-toggle-dot"></span>
            <span class="site-mobile-menu-toggle-dot"></span>
            <span class="site-mobile-menu-toggle-dot"></span>
            <span class="site-mobile-menu-toggle-dot"></span>
          </span>
        </button>

        <nav class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav navbar-nav-scroll ms-lg-auto" style="--ar-scroll-height: 280px;">
            <li class="nav-item">
              <a class="nav-link {{ $active === 'about' ? 'active' : '' }}" @if ($active === 'about') aria-current="page" @endif href="{{ route('about') }}">{{ __('ui.nav.about') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ $active === 'services' ? 'active' : '' }}" @if ($active === 'services') aria-current="page" @endif href="{{ route('services') }}">{{ __('ui.nav.services') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ $active === 'contact' ? 'active' : '' }}" @if ($active === 'contact') aria-current="page" @endif href="{{ route('contact') }}">{{ __('ui.nav.contact') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ ($active ?? '') === 'funding' ? 'active' : '' }}" @if (($active ?? '') === 'funding') aria-current="page" @endif href="{{ route('funding-request.create') }}">{{ __('ui.nav.funding_request') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ ($active ?? '') === 'tracking' ? 'active' : '' }}" @if (($active ?? '') === 'tracking') aria-current="page" @endif href="{{ route('funding.tracking') }}">{{ __('ui.nav.tracking') }}</a>
            </li>
            @if ($variant === 'account')
              <li class="nav-item dropdown d-sm-none border-top mt-2 pt-2">
                <a class="nav-link" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                  <img class="border rounded-circle" src="/assets/img/avatar/01.jpg" width="48" alt="">
                  <div class="ps-2">
                    <div class="fs-xs lh-1 opacity-60">{{ __('ui.nav.connected') }}</div>
                    <div class="fs-sm dropdown-toggle">Isabella</div>
                  </div>
                </a>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('funding-request.create') }}">{{ __('ui.nav.funding_request') }}</a>
                  <a class="dropdown-item" href="{{ route('funding.tracking') }}">{{ __('ui.nav.tracking') }}</a>
                  <a class="dropdown-item" href="{{ url('/') }}">{{ __('ui.nav.back_to_site') }}</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">{{ __('ui.nav.logout') }}</a>
                </div>
              </li>
            @endif
          </ul>
        </nav>
    </div>
@if ($variant === 'dark')
  </div>
</header>
@else
</header>
@endif

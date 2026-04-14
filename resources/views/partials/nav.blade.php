@php
  $active = $active ?? 'home';
  $variant = $variant ?? 'default';
  $headerClass = match ($variant) {
    'light' => 'navbar navbar-expand-lg fixed-top bg-light',
    default => 'navbar navbar-expand-lg fixed-top',
  };
@endphp

@if ($variant === 'dark')
  <header data-bs-theme="dark">
    <div class="{{ $headerClass }}">
      <div class="container">
@else
  <header class="{{ $headerClass }}">
    <div class="container">
@endif

        <a class="navbar-brand pe-sm-3 d-flex align-items-center" href="{{ url('/') }}">
          <img src="{{ asset('assets/img/branding/humanity-impact.png') }}" alt="{{ config('site.name') }}" style="height: 42px; width: auto;" class="flex-shrink-0">
        </a>

        <div class="form-check form-switch mode-switch order-lg-2 me-3 me-lg-4 ms-auto" data-bs-toggle="mode">
          <input class="form-check-input" type="checkbox" id="theme-mode">
          <label class="form-check-label" for="theme-mode">
            <i class="ai-sun fs-lg"></i>
          </label>
          <label class="form-check-label" for="theme-mode">
            <i class="ai-moon fs-lg"></i>
          </label>
        </div>

        <div class="dropdown order-lg-2 me-2 me-lg-3">
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

        <button class="navbar-toggler ms-sm-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-label="{{ __('ui.nav.admin_menu') }}">
          <span class="navbar-toggler-icon"></span>
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

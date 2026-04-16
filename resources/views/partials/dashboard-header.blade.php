<header class="navbar navbar-expand-lg sticky-top bg-body border-bottom shadow-sm">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center pe-sm-3" href="{{ route('account') }}">
      <img src="{{ \App\Support\SiteAppearance::logoUrl() }}" alt="{{ config('site.name') }}" style="height: 40px; width: auto;" class="flex-shrink-0 me-2">
      <span class="d-none d-sm-inline">{{ config('site.labels.dashboard') }}</span>
    </a>

    <div class="d-flex align-items-center ms-auto order-lg-2 gap-2">
      <div class="form-check form-switch mode-switch mb-0" data-bs-toggle="mode">
        <input class="form-check-input" type="checkbox" id="theme-mode-dashboard">
        <label class="form-check-label" for="theme-mode-dashboard">
          <i class="ai-sun fs-lg"></i>
        </label>
        <label class="form-check-label" for="theme-mode-dashboard">
          <i class="ai-moon fs-lg"></i>
        </label>
      </div>

      <div class="dropdown">
        <a class="nav-link d-flex align-items-center p-1 py-lg-2" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <img class="border rounded-circle" src="/assets/img/avatar/02.jpg" width="40" height="40" alt="">
          <span class="ps-2 d-none d-sm-inline fs-sm dropdown-toggle">Isabella</span>
        </a>
        <div class="dropdown-menu dropdown-menu-end my-1">
          <a class="dropdown-item" href="{{ route('account') }}">
            <i class="ai-user-check fs-lg opacity-70 me-2"></i>
            Aperçu
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ url('/') }}">
            <i class="ai-arrow-left fs-lg opacity-70 me-2"></i>
            Retour au site
          </a>
          <a class="dropdown-item" href="#">
            <i class="ai-logout fs-lg opacity-70 me-2"></i>
            Déconnexion
          </a>
        </div>
      </div>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#dashboardNav"
        aria-label="Menu">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>

    <nav class="collapse navbar-collapse order-lg-1" id="dashboardNav">
      <ul class="navbar-nav pt-2 pt-lg-0">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('account') ? 'active' : '' }}" href="{{ route('account') }}" @if (request()->routeIs('account')) aria-current="page" @endif>
            <i class="ai-user-check fs-5 opacity-60 me-lg-2"></i>
            Aperçu
          </a>
        </li>
        <li class="nav-item d-lg-none border-top mt-2 pt-2">
          <a class="nav-link" href="{{ url('/') }}">
            <i class="ai-home fs-5 opacity-60 me-2"></i>
            Site public
          </a>
        </li>
      </ul>
    </nav>
  </div>
</header>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-bs-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport"
    content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">

  <title>@yield('title', 'Administration — '.config('site.name'))</title>
  @stack('meta')

  <link rel="manifest" href="/manifest.json">
  <link rel="icon" href="{{ \App\Support\SiteAppearance::faviconUrl() }}">
  <link rel="apple-touch-icon" href="{{ \App\Support\SiteAppearance::faviconUrl() }}">

  <script src="/assets/js/theme-switcher.js"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">

  @stack('vendor-css')

  <link rel="stylesheet" href="/assets/icons/around-icons.min.css">
  <link rel="stylesheet" media="screen" href="/assets/css/theme.min.css">

  <style>
    .admin-shell {
      --admin-border: rgba(15, 23, 42, 0.08);
      --admin-shadow: 0 18px 40px rgba(148, 163, 184, 0.16);
      --admin-surface: rgba(255, 255, 255, 0.82);
      --admin-panel: #ffffff;
      --admin-soft: #f5f7fb;
      --admin-muted: #6b7a90;
      --admin-heading: #172033;
      --admin-accent: #A87400;
    }

    body.admin-shell {
      background:
        radial-gradient(circle at top left, rgba(255, 180, 0, 0.08), transparent 28%),
        radial-gradient(circle at top right, rgba(var(--bs-primary-rgb), 0.08), transparent 24%),
        linear-gradient(180deg, #f7f9fc 0%, #eef3f9 100%);
    }

    .admin-topbar {
      backdrop-filter: blur(16px);
      background: var(--admin-surface);
      border-bottom: 1px solid rgba(15, 23, 42, 0.05);
    }

    .admin-brand {
      font-weight: 800;
      color: var(--admin-heading);
      letter-spacing: -.02em;
    }

    .admin-theme-switch {
      padding: .35rem .55rem;
      border-radius: 999px;
      background: rgba(15, 23, 42, 0.04);
    }

    .admin-profile-trigger {
      padding: .25rem;
      border-radius: 999px;
    }

    .admin-profile-trigger:hover {
      background: rgba(15, 23, 42, 0.04);
    }

    .admin-side-panel {
      border: 1px solid var(--admin-border);
      border-radius: 1.8rem;
      background: var(--admin-panel);
      box-shadow: var(--admin-shadow);
      padding: 1.4rem 1.3rem;
    }

    .admin-side-user {
      padding-bottom: 1.25rem;
      margin-bottom: 1.25rem;
      border-bottom: 1px solid rgba(148, 163, 184, 0.14);
    }

    .admin-side-avatar {
      width: 4.75rem;
      height: 4.75rem;
      object-fit: cover;
    }

    .admin-side-section {
      color: var(--admin-muted);
      font-size: .74rem;
      font-weight: 800;
      letter-spacing: .06em;
      text-transform: uppercase;
    }

    .admin-side-link {
      display: flex;
      align-items: center;
      gap: .75rem;
      min-height: 3.15rem;
      padding: .7rem .85rem;
      border-radius: 1rem;
      color: var(--admin-heading);
      text-decoration: none;
      transition: background .18s ease, color .18s ease, transform .18s ease;
    }

    .admin-side-link:hover {
      background: var(--admin-soft);
      color: var(--admin-heading);
      transform: translateX(2px);
    }

    .admin-side-link.active {
      background: rgba(255, 180, 0, 0.14);
      color: var(--admin-accent);
    }

    .admin-content-shell {
      min-height: 100%;
    }

    .admin-mobile-menu {
      min-height: 3.4rem;
      border-top-left-radius: 1rem;
      border-top-right-radius: 1rem;
      box-shadow: 0 -8px 24px rgba(15, 23, 42, 0.08);
    }

    [data-bs-theme="dark"] .admin-shell {
      --admin-border: rgba(255, 255, 255, 0.08);
      --admin-shadow: none;
      --admin-surface: rgba(23, 28, 34, 0.85);
      --admin-panel: #171c22;
      --admin-soft: #20262d;
      --admin-muted: #9aa6b8;
      --admin-heading: #f5f7fb;
    }

    [data-bs-theme="dark"] body.admin-shell {
      background:
        radial-gradient(circle at top left, rgba(255, 180, 0, 0.06), transparent 28%),
        radial-gradient(circle at top right, rgba(var(--bs-primary-rgb), 0.08), transparent 24%),
        linear-gradient(180deg, #12161b 0%, #0f1317 100%);
    }

    [data-bs-theme="dark"] .admin-topbar,
    [data-bs-theme="dark"] .admin-theme-switch,
    [data-bs-theme="dark"] .admin-profile-trigger:hover {
      border-color: rgba(255, 255, 255, 0.08);
    }

    [data-bs-theme="dark"] .admin-mobile-menu {
      box-shadow: none;
    }
  </style>

  @include('partials.preloader-head')
  @stack('head')
</head>

@php
  $navActive = $adminActive ?? 'dashboard';
  /** @var \App\Models\User|null $adminUser */
  $adminUser = auth()->user();
@endphp

<body class="admin-shell">

  @include('partials.preloader')

  <main class="page-wrapper pb-5 pb-lg-0">

    <header class="navbar navbar-expand-lg fixed-top admin-topbar">
      <div class="container">
        <a class="navbar-brand pe-sm-3 admin-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
          <img src="{{ \App\Support\SiteAppearance::logoUrl() }}" alt="{{ config('site.name') }}" style="height: 40px; width: auto;" class="flex-shrink-0">
        </a>

        <div class="form-check form-switch mode-switch order-lg-2 me-3 me-lg-4 ms-auto admin-theme-switch" data-bs-toggle="mode">
          <input class="form-check-input" type="checkbox" id="theme-mode" aria-label="Thème clair ou sombre">
          <label class="form-check-label" for="theme-mode">
            <i class="ai-sun fs-lg"></i>
          </label>
          <label class="form-check-label" for="theme-mode">
            <i class="ai-moon fs-lg"></i>
          </label>
        </div>

        @if ($adminUser)
          <div class="dropdown nav d-none d-sm-block order-lg-3">
            <a class="nav-link d-flex align-items-center p-0 admin-profile-trigger" href="#" data-bs-toggle="dropdown" aria-expanded="false">
              <img class="border rounded-circle" src="/assets/img/avatar/01.jpg" width="48" alt="">
              <div class="ps-2">
                <div class="fs-xs lh-1 opacity-60">Connecté</div>
                <div class="fs-sm dropdown-toggle text-truncate" style="max-width: 9rem;">{{ $adminUser->name }}</div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end my-1">
              <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                <i class="ai-user-check fs-lg opacity-70 me-2"></i>
                Tableau de bord
              </a>
              <a class="dropdown-item" href="{{ route('admin.funding-requests.index') }}">
                <i class="ai-folder fs-lg opacity-70 me-2"></i>
                Toutes les demandes
              </a>
              <a class="dropdown-item" href="{{ route('admin.settings.edit') }}">
                <i class="ai-settings fs-lg opacity-70 me-2"></i>
                Configuration
              </a>
              <a class="dropdown-item" href="{{ route('admin.testimonials.index') }}">
                <i class="ai-messages fs-lg opacity-70 me-2"></i>
                Témoignages
              </a>
              <a class="dropdown-item" href="{{ route('admin.settings.password.edit') }}">
                <i class="ai-lock-closed fs-lg opacity-70 me-2"></i>
                Code d’accès
              </a>
              <a class="dropdown-item" href="{{ route('admin.guide') }}">
                <i class="ai-open-book fs-lg opacity-70 me-2"></i>
                Guide admin
              </a>
              <a class="dropdown-item" href="{{ route('admin.smtp.edit') }}">
                <i class="ai-at fs-lg opacity-70 me-2"></i>
                SMTP
              </a>
              <div class="dropdown-divider"></div>
              <form method="post" action="{{ route('admin.logout') }}" class="d-grid">
                @csrf
                <button type="submit" class="dropdown-item text-start border-0 bg-transparent">
                  <i class="ai-logout fs-lg opacity-70 me-2"></i>
                  Déconnexion
                </button>
              </form>
            </div>
          </div>
        @endif

        <button class="navbar-toggler ms-sm-3" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbarNav"
          aria-label="Menu admin">
          <span class="navbar-toggler-icon"></span>
        </button>

        <nav class="collapse navbar-collapse" id="adminNavbarNav">
          <ul class="navbar-nav navbar-nav-scroll ms-lg-auto" style="--ar-scroll-height: 280px;">
            @if ($adminUser)
              <li class="nav-item dropdown d-sm-none border-top mt-2 pt-2">
                <a class="nav-link" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                  <img class="border rounded-circle" src="/assets/img/avatar/01.jpg" width="48" alt="">
                  <div class="ps-2">
                    <div class="fs-xs lh-1 opacity-60">Connecté</div>
                    <div class="fs-sm dropdown-toggle">{{ $adminUser->name }}</div>
                  </div>
                </a>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                    <i class="ai-user-check fs-lg opacity-70 me-2"></i>
                    Tableau de bord
                  </a>
                  <a class="dropdown-item" href="{{ route('admin.funding-requests.index') }}">
                    <i class="ai-folder fs-lg opacity-70 me-2"></i>
                    Toutes les demandes
                  </a>
                  <a class="dropdown-item" href="{{ route('admin.settings.edit') }}">
                    <i class="ai-settings fs-lg opacity-70 me-2"></i>
                    Configuration
                  </a>
                  <a class="dropdown-item" href="{{ route('admin.testimonials.index') }}">
                    <i class="ai-messages fs-lg opacity-70 me-2"></i>
                    Témoignages
                  </a>
                  <a class="dropdown-item" href="{{ route('admin.settings.password.edit') }}">
                    <i class="ai-lock-closed fs-lg opacity-70 me-2"></i>
                    Code d’accès
                  </a>
                  <a class="dropdown-item" href="{{ route('admin.guide') }}">
                    <i class="ai-open-book fs-lg opacity-70 me-2"></i>
                    Guide admin
                  </a>
                  <a class="dropdown-item" href="{{ route('admin.smtp.edit') }}">
                    <i class="ai-at fs-lg opacity-70 me-2"></i>
                    SMTP
                  </a>
                  <div class="dropdown-divider"></div>
                  <form method="post" action="{{ route('admin.logout') }}" class="px-3 py-1">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-primary w-100">Déconnexion</button>
                  </form>
                </div>
              </li>
            @endif
          </ul>
        </nav>
      </div>
    </header>

    <div class="container py-5 mt-4 mt-lg-5 mb-lg-4 my-xl-5">
      <div class="row pt-sm-2 pt-lg-0">

        <aside class="col-lg-3 pe-lg-4 pe-xl-5 mt-n3">
          <div class="position-lg-sticky top-0">
            <div class="d-none d-lg-block" style="padding-top: 105px;"></div>
            <div class="offcanvas-lg offcanvas-start" tabindex="-1" id="sidebarAdmin">
              <button class="btn-close position-absolute top-0 end-0 mt-3 me-3 d-lg-none" type="button" data-bs-dismiss="offcanvas" data-bs-target="#sidebarAdmin" aria-label="Fermer"></button>
              <div class="offcanvas-body">
                <div class="admin-side-panel">
                <div class="mb-4">
                  <a href="{{ route('admin.dashboard') }}" class="d-inline-flex align-items-center text-decoration-none">
                    <img src="{{ \App\Support\SiteAppearance::logoUrl() }}" alt="{{ config('site.name') }}" style="height: 38px; width: auto;" class="flex-shrink-0">
                  </a>
                </div>
                <div class="admin-side-user">
                  <h3 class="h5 mb-1">{{ $adminUser?->name ?? 'Administrateur' }}</h3>
                  <p class="fs-sm text-body-secondary mb-0 text-break">{{ $adminUser?->email }}</p>
                </div>
                <nav class="nav flex-column pb-2 pb-lg-4 mb-3">
                  <h4 class="admin-side-section pb-1 mb-2">Administration</h4>
                  <a class="admin-side-link fw-semibold {{ $navActive === 'dashboard' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="ai-user-check fs-5 opacity-60 me-2"></i>
                    Tableau de bord
                  </a>
                  <a class="admin-side-link fw-semibold {{ $navActive === 'demandes' ? 'active' : '' }}" href="{{ route('admin.funding-requests.index') }}">
                    <i class="ai-folder fs-5 opacity-60 me-2"></i>
                    Toutes les demandes
                  </a>
                  <a class="admin-side-link fw-semibold {{ $navActive === 'settings' ? 'active' : '' }}" href="{{ route('admin.settings.edit') }}">
                    <i class="ai-settings fs-5 opacity-60 me-2"></i>
                    Configuration
                  </a>
                  <a class="admin-side-link fw-semibold {{ $navActive === 'testimonials' ? 'active' : '' }}" href="{{ route('admin.testimonials.index') }}">
                    <i class="ai-messages fs-5 opacity-60 me-2"></i>
                    Témoignages
                  </a>
                  <a class="admin-side-link fw-semibold {{ $navActive === 'settings-password' ? 'active' : '' }}" href="{{ route('admin.settings.password.edit') }}">
                    <i class="ai-lock-closed fs-5 opacity-60 me-2"></i>
                    Code d’accès
                  </a>
                  <a class="admin-side-link fw-semibold {{ $navActive === 'guide' ? 'active' : '' }}" href="{{ route('admin.guide') }}">
                    <i class="ai-open-book fs-5 opacity-60 me-2"></i>
                    Guide admin
                  </a>
                  <a class="admin-side-link fw-semibold {{ $navActive === 'smtp' ? 'active' : '' }}" href="{{ route('admin.smtp.edit') }}">
                    <i class="ai-at fs-5 opacity-60 me-2"></i>
                    SMTP
                  </a>
                </nav>
                <nav class="nav flex-column">
                  <form method="post" action="{{ route('admin.logout') }}" class="mb-0">
                    @csrf
                    <button type="submit" class="admin-side-link fw-semibold btn btn-link text-start text-body text-decoration-none border-0 w-100">
                      <i class="ai-logout fs-5 opacity-60 me-2"></i>
                      Déconnexion
                    </button>
                  </form>
                </nav>
                </div>
              </div>
            </div>
          </div>
        </aside>

        <div class="col-lg-9 pt-4 pb-2 pb-sm-4 admin-content-shell">
          @yield('content')
        </div>
      </div>
    </div>

    <button class="d-lg-none btn btn-sm fs-sm btn-primary w-100 rounded-0 fixed-bottom admin-mobile-menu" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarAdmin">
      <i class="ai-menu me-2"></i>
      Menu admin
    </button>
  </main>

  @include('partials.scroll-top')

  @stack('vendor-scripts')
  <script src="/assets/js/theme.min.js"></script>
</body>

</html>

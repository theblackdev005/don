<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-bs-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport"
    content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">

  <title>@yield('title', 'Administration — '.config('site.name'))</title>
  @stack('meta')

  <link rel="manifest" href="/manifest.json">
  <link rel="icon" type="image/png" href="/assets/app-icons/icon-32x32.png" sizes="32x32">
  <link rel="apple-touch-icon" href="/assets/app-icons/icon-180x180.png">

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
      --admin-panel: #ffffff;
      --admin-muted: #6b7a90;
      --admin-heading: #172033;
      --admin-accent: #ffb400;
    }

    body.admin-shell {
      background:
        radial-gradient(circle at top left, rgba(255, 180, 0, 0.09), transparent 24%),
        radial-gradient(circle at top right, rgba(13, 110, 253, 0.08), transparent 22%),
        linear-gradient(180deg, #f7f9fc 0%, #eef3f9 100%);
      overflow-x: hidden;
    }

    .admin-topbar {
      backdrop-filter: blur(14px);
      background: rgba(255, 255, 255, 0.88);
      border-bottom: 1px solid rgba(15, 23, 42, 0.05);
    }

    .admin-topbar-inner {
      min-height: 6rem;
    }

    .admin-brand {
      display: inline-flex;
      align-items: center;
      gap: 1rem;
      text-decoration: none;
    }

    .admin-brand-badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 2.7rem;
      padding: 0 1.2rem;
      border-radius: 999px;
      background: #172033;
      color: #fff;
      font-size: 1.05rem;
      font-weight: 800;
      letter-spacing: .05em;
      text-transform: uppercase;
    }

    .admin-topbar-actions {
      display: flex;
      align-items: center;
      gap: .9rem;
      margin-left: auto;
    }

    .admin-menu-button {
      min-height: 3.1rem;
      padding: 0 1.05rem;
      border-radius: 1rem;
      border: 1px solid rgba(15, 23, 42, 0.1);
      background: rgba(255, 255, 255, 0.82);
      color: var(--admin-heading);
      font-weight: 700;
    }

    .admin-logout-button {
      min-height: 3.1rem;
      padding: 0 1.35rem;
      border: 0;
      border-radius: 1rem;
      background: var(--admin-accent);
      color: #172033;
      font-weight: 800;
      box-shadow: 0 14px 28px rgba(255, 180, 0, 0.22);
    }

    .admin-page-shell {
      padding: 8.8rem 0 3rem;
    }

    .admin-page-width {
      max-width: 1600px;
      margin: 0 auto;
    }

    [data-bs-theme="dark"] .admin-shell {
      --admin-border: rgba(255, 255, 255, 0.08);
      --admin-shadow: none;
      --admin-panel: #171c22;
      --admin-muted: #9aa6b8;
      --admin-heading: #f5f7fb;
    }

    [data-bs-theme="dark"] body.admin-shell {
      background:
        radial-gradient(circle at top left, rgba(255, 180, 0, 0.06), transparent 24%),
        radial-gradient(circle at top right, rgba(13, 110, 253, 0.08), transparent 22%),
        linear-gradient(180deg, #12161b 0%, #0f1317 100%);
    }

    [data-bs-theme="dark"] .admin-topbar {
      background: rgba(23, 28, 34, 0.88);
      border-bottom-color: rgba(255, 255, 255, 0.08);
    }

    [data-bs-theme="dark"] .admin-menu-button {
      background: rgba(255, 255, 255, 0.03);
      border-color: rgba(255, 255, 255, 0.08);
      color: #f5f7fb;
    }

    @media (max-width: 767.98px) {
      .admin-topbar-inner {
        min-height: 5rem;
      }

      .admin-brand {
        gap: .7rem;
      }

      .admin-brand-logo {
        height: 2rem !important;
      }

      .admin-brand-badge {
        min-height: 2.35rem;
        padding: 0 .9rem;
        font-size: .85rem;
      }

      .admin-topbar-actions {
        gap: .5rem;
      }

      .admin-menu-button span {
        display: none;
      }

      .admin-menu-button {
        width: 3rem;
        padding: 0;
      }

      .admin-logout-button {
        padding: 0 1rem;
        min-height: 2.9rem;
      }

      .admin-page-shell {
        padding: 7.5rem 0 2rem;
      }
    }
  </style>

  @include('partials.preloader-head')
  @stack('head')
</head>

@php
  /** @var \App\Models\User|null $adminUser */
  $adminUser = auth()->user();
@endphp

<body class="admin-shell">
  @include('partials.preloader')

  <main class="page-wrapper">
    <header class="navbar fixed-top admin-topbar">
      <div class="container admin-page-width">
        <div class="d-flex align-items-center w-100 admin-topbar-inner">
          <a class="admin-brand" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('assets/img/branding/humanity-impact.png') }}" alt="{{ config('site.name') }}" class="admin-brand-logo" style="height: 2.35rem; width: auto;">
            <span class="admin-brand-badge">Site admin</span>
          </a>

          <div class="admin-topbar-actions">
            <div class="dropdown">
              <button class="admin-menu-button" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ai-menu fs-5"></i>
                <span class="ms-2">Menu</span>
              </button>
              <div class="dropdown-menu dropdown-menu-end my-2">
                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Tableau de bord</a>
                <a class="dropdown-item" href="{{ route('admin.funding-requests.index') }}">Toutes les demandes</a>
                <a class="dropdown-item" href="{{ route('admin.settings.edit') }}">Configuration</a>
                <a class="dropdown-item" href="{{ route('admin.settings.password.edit') }}">Code d’accès</a>
                <a class="dropdown-item" href="{{ route('admin.guide') }}">Guide admin</a>
              </div>
            </div>

            @if ($adminUser)
              <form method="post" action="{{ route('admin.logout') }}" class="mb-0">
                @csrf
                <button type="submit" class="admin-logout-button">Déconnexion</button>
              </form>
            @endif
          </div>
        </div>
      </div>
    </header>

    <div class="container admin-page-width admin-page-shell">
      @yield('content')
    </div>
  </main>

  @include('partials.scroll-top')

  @stack('vendor-scripts')
  <script src="/assets/js/theme.min.js"></script>
</body>

</html>

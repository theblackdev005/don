@extends('layouts.app')

@section('title', 'Connexion — Administration')

@section('content')
<style>
  body {
    overflow-x: hidden;
  }

  .admin-login-header {
    position: fixed;
    inset: 0 0 auto;
    z-index: 1030;
    padding: 14px 0;
    background: rgba(var(--bs-body-bg-rgb), 0.88);
    border-bottom: 1px solid rgba(var(--bs-primary-rgb), 0.08);
    backdrop-filter: blur(12px);
  }

  .admin-login-header-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
  }

  .admin-login-header-brand {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    color: var(--bs-heading-color);
    text-decoration: none;
    font-size: 1.02rem;
    font-weight: 800;
    letter-spacing: -0.02em;
  }

  .admin-login-header-brand:hover {
    color: var(--bs-heading-color);
    text-decoration: none;
  }

  .admin-login-header-mark {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: rgba(var(--bs-primary-rgb), 0.06);
    flex: 0 0 auto;
    overflow: hidden;
  }

  .admin-login-header-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 40px;
    padding: 0 14px;
    border-radius: 12px;
    border: 1px solid rgba(var(--bs-primary-rgb), 0.1);
    background: var(--bs-body-bg);
    color: var(--bs-secondary-color);
    text-decoration: none;
    font-weight: 600;
  }

  .admin-login-header-link:hover {
    color: var(--bs-heading-color);
    text-decoration: none;
  }

  .admin-login-page {
    min-height: 100vh;
    padding: 88px 0 24px;
    background:
      radial-gradient(circle at top left, rgba(var(--bs-primary-rgb), 0.08), transparent 28%),
      var(--bs-secondary-bg);
    display: flex;
    align-items: center;
  }

  .admin-login-wrap {
    max-width: 460px;
    margin: 0 auto;
  }

  .admin-login-card {
    padding: 32px;
    border-radius: 24px;
    border: 1px solid rgba(var(--bs-primary-rgb), 0.1);
    background: var(--bs-body-bg);
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
  }

  .admin-login-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
    color: var(--bs-heading-color);
    font-size: 1.05rem;
    font-weight: 700;
  }

  .admin-login-brand-logo {
    height: 44px;
    width: auto;
    display: block;
    flex: 0 0 auto;
  }

  .admin-login-title {
    margin: 0 0 8px;
    color: var(--bs-heading-color);
    font-size: 2rem;
    line-height: 1.05;
    font-weight: 800;
    letter-spacing: -0.03em;
  }

  .admin-login-copy {
    margin: 0 0 24px;
    color: var(--bs-secondary-color);
    line-height: 1.65;
  }

  .admin-login-alert {
    margin-bottom: 18px;
    border-radius: 16px;
  }

  .admin-login-form .form-label {
    margin-bottom: 8px;
    color: var(--bs-heading-color);
    font-weight: 600;
  }

  .admin-login-form .form-control {
    min-height: 54px;
    border-radius: 14px;
    border-color: rgba(var(--bs-primary-rgb), 0.12);
    box-shadow: none;
  }

  .admin-login-form .form-control:focus {
    border-color: rgba(var(--bs-primary-rgb), 0.42);
    box-shadow: 0 0 0 .25rem rgba(var(--bs-primary-rgb), 0.12);
  }

  .admin-login-submit {
    min-height: 54px;
    border-radius: 14px;
    font-weight: 700;
  }

  .admin-login-password {
    position: relative;
  }

  .admin-login-password .form-control {
    padding-right: 120px;
  }

  .admin-login-password-toggle {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    padding: 0;
    border: 0;
    border-radius: 12px;
    background: rgba(var(--bs-primary-rgb), 0.1);
    color: var(--bs-primary);
    font-size: 1rem;
  }

  .admin-login-password-toggle:hover {
    background: rgba(var(--bs-primary-rgb), 0.16);
  }

  .admin-login-password-toggle svg {
    width: 18px;
    height: 18px;
    display: block;
  }

  .admin-login-note {
    margin-top: 16px;
    color: var(--bs-secondary-color);
    font-size: .92rem;
    line-height: 1.6;
  }

  @media (max-width: 575.98px) {
    .admin-login-header {
      padding: 12px 0;
    }

    .admin-login-header-inner {
      gap: 10px;
    }

    .admin-login-header-brand {
      font-size: .98rem;
    }

    .admin-login-header-brand span:last-child {
      max-width: 140px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .admin-login-page {
      padding: 84px 0 20px;
      align-items: flex-start;
    }

    .admin-login-card {
      padding: 24px 18px;
      border-radius: 20px;
    }

    .admin-login-title {
      font-size: 1.8rem;
    }
  }
</style>

<main class="page-wrapper">
  <header class="admin-login-header">
    <div class="container">
      <div class="admin-login-header-inner">
        <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="admin-login-header-brand">
          <span class="admin-login-header-mark">
            <img src="{{ \App\Support\SiteAppearance::logoUrl() }}" alt="{{ config('site.name') }}" style="width: 100%; height: 100%; object-fit: contain;">
          </span>
        </a>

        <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="admin-login-header-link">
          <i class="ai-arrow-left me-2"></i>
          <span>Retour au site</span>
        </a>
      </div>
    </div>
  </header>

  <section class="admin-login-page">
    <div class="container">
      <div class="admin-login-wrap">
        <div class="admin-login-card">
          <div class="admin-login-brand">
            <img src="{{ \App\Support\SiteAppearance::logoUrl() }}" alt="{{ config('site.name') }}" class="admin-login-brand-logo">
          </div>

          <h1 class="admin-login-title">Connexion</h1>
          <p class="admin-login-copy">
            Accédez à l’espace de gestion pour traiter les demandes et suivre les dossiers.
          </p>

          @if ($errors->any())
            <div class="alert alert-danger admin-login-alert">
              <ul class="mb-0 ps-3 small">
                @foreach ($errors->all() as $e)
                  <li>{{ $e }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          @if (session('status'))
            <div class="alert alert-success admin-login-alert">
              {{ session('status') }}
            </div>
          @endif

          <form method="post" action="{{ route('admin.login') }}" class="admin-login-form">
            @csrf

            <div class="mb-3">
              <label class="form-label" for="email">Adresse e-mail</label>
              <input
                type="email"
                class="form-control"
                id="email"
                name="email"
                value="{{ old('email', config('admin.email')) }}"
                required
                autofocus
                autocomplete="username">
            </div>

            <div class="mb-3">
              <label class="form-label" for="password">Mot de passe</label>
              <div class="admin-login-password">
                <input
                  type="password"
                  class="form-control"
                  id="password"
                  name="password"
                  required
                  autocomplete="current-password">
                <button type="button" class="admin-login-password-toggle" data-password-toggle aria-controls="password" aria-pressed="false" aria-label="Afficher le mot de passe" title="Afficher le mot de passe">
                  <svg data-eye-open xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.27 2.943 9.542 7-1.273 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15.75A3.75 3.75 0 1 0 12 8.25a3.75 3.75 0 0 0 0 7.5Z"/>
                  </svg>
                  <svg data-eye-closed xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9" aria-hidden="true" style="display:none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.584 10.587A2.25 2.25 0 0 0 13.414 13.4"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.88 5.09A10.94 10.94 0 0 1 12 4.875c4.608 0 8.494 2.958 9.75 7.125a11.45 11.45 0 0 1-4.02 5.538M6.228 6.228A11.457 11.457 0 0 0 2.25 12c1.256 4.167 5.142 7.125 9.75 7.125 1.67 0 3.252-.389 4.658-1.08"/>
                  </svg>
                </button>
              </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 admin-login-submit">Se connecter</button>
          </form>

          <div class="mt-3 text-center">
            <a href="{{ route('admin.password.request') }}" class="text-decoration-none fw-semibold">Mot de passe oublié ?</a>
          </div>

          <p class="admin-login-note">
            Accès réservé à l’équipe d’administration.
          </p>
        </div>
      </div>
    </div>
  </section>
</main>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.querySelector('[data-password-toggle]');
    const input = document.getElementById('password');
    const eyeOpen = toggle ? toggle.querySelector('[data-eye-open]') : null;
    const eyeClosed = toggle ? toggle.querySelector('[data-eye-closed]') : null;

    if (!toggle || !input) {
      return;
    }

    toggle.addEventListener('click', function () {
      const isHidden = input.type === 'password';
      input.type = isHidden ? 'text' : 'password';
      toggle.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
      toggle.setAttribute('aria-label', isHidden ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
      toggle.setAttribute('title', isHidden ? 'Masquer le mot de passe' : 'Afficher le mot de passe');

      if (eyeOpen && eyeClosed) {
        eyeOpen.style.display = isHidden ? 'none' : '';
        eyeClosed.style.display = isHidden ? '' : 'none';
      }
    });
  });
</script>
@endsection

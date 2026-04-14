@extends('layouts.app')

@section('title', 'Connexion — Administration')

@section('content')
<style>
  .admin-login-page {
    min-height: 100vh;
    padding: 112px 0 56px;
    background:
      radial-gradient(circle at top left, rgba(255, 180, 0, 0.08), transparent 24%),
      radial-gradient(circle at top right, rgba(13, 110, 253, 0.08), transparent 22%),
      linear-gradient(180deg, #f7f9fc 0%, #eef3f9 100%);
  }

  .admin-login-topbar {
    position: fixed;
    inset: 0 0 auto;
    z-index: 1030;
    background: rgba(255, 255, 255, 0.9);
    border-bottom: 1px solid rgba(15, 23, 42, 0.06);
    backdrop-filter: blur(14px);
  }

  .admin-login-topbar-inner {
    min-height: 6rem;
    display: flex;
    align-items: center;
  }

  .admin-login-brand {
    display: inline-flex;
    align-items: center;
    gap: 1rem;
    text-decoration: none;
  }

  .admin-login-badge {
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

  .admin-login-shell {
    max-width: 700px;
    margin: 0 auto;
  }

  .admin-login-card {
    padding: 2rem;
    border: 1px solid rgba(15, 23, 42, 0.08);
    border-top: 4px solid #ffb400;
    border-radius: 2rem;
    background:
      radial-gradient(circle at top right, rgba(255, 180, 0, 0.14), transparent 22%),
      #fff;
    box-shadow: 0 18px 40px rgba(148, 163, 184, 0.16);
  }

  .admin-login-kicker {
    display: inline-flex;
    align-items: center;
    gap: .8rem;
    min-height: 3.5rem;
    padding: 0 1.2rem;
    border-radius: 999px;
    background: rgba(255, 180, 0, 0.12);
    color: #172033;
    font-size: 1rem;
    font-weight: 800;
    letter-spacing: .04em;
    text-transform: uppercase;
  }

  .admin-login-kicker-dot {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: #ffb400;
    flex: 0 0 auto;
  }

  .admin-login-title {
    color: #172033;
    font-size: clamp(2.7rem, 4vw, 4.3rem);
    font-weight: 800;
    line-height: 1.02;
    letter-spacing: -0.04em;
    margin: 1.5rem 0 .8rem;
  }

  .admin-login-copy {
    color: #6b7a90;
    font-size: 1.05rem;
    line-height: 1.7;
    margin-bottom: 2rem;
    max-width: 38rem;
  }

  .admin-login-label {
    color: #172033;
    font-size: 1rem;
    font-weight: 800;
    margin-bottom: .7rem;
  }

  .admin-login-input {
    min-height: 5rem;
    border-radius: 1.35rem;
    border: 1px solid rgba(148, 163, 184, 0.32);
    background: #fff;
    box-shadow: none;
    font-size: 1.05rem;
  }

  .admin-login-input:focus {
    border-color: rgba(255, 180, 0, 0.55);
    box-shadow: 0 0 0 .25rem rgba(255, 180, 0, 0.14);
  }

  .admin-login-password {
    position: relative;
  }

  .admin-login-password .admin-login-input {
    padding-right: 5.2rem;
  }

  .admin-login-toggle {
    position: absolute;
    top: 50%;
    right: .75rem;
    transform: translateY(-50%);
    width: 3.4rem;
    height: 3.4rem;
    border-radius: 1rem;
    border: 1px solid rgba(148, 163, 184, 0.28);
    background: #fff;
    color: #172033;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  .admin-login-submit {
    width: 100%;
    min-height: 4.3rem;
    border: 0;
    border-radius: 1.2rem;
    background: linear-gradient(90deg, #ffb400 0%, #ffd766 100%);
    color: #172033;
    font-size: 1.2rem;
    font-weight: 800;
    box-shadow: 0 14px 28px rgba(255, 180, 0, 0.22);
  }

  .admin-login-hint {
    padding-top: 1.5rem;
    margin-top: 1.75rem;
    border-top: 1px solid rgba(15, 23, 42, 0.08);
    color: #6b7a90;
    font-size: 1rem;
    line-height: 1.75;
  }

  .admin-login-hint code {
    padding: .25rem .6rem;
    border-radius: 999px;
    background: rgba(255, 180, 0, 0.14);
    color: #172033;
    font-size: .98rem;
    font-weight: 800;
  }

  [data-bs-theme="dark"] .admin-login-page {
    background:
      radial-gradient(circle at top left, rgba(255, 180, 0, 0.06), transparent 24%),
      radial-gradient(circle at top right, rgba(13, 110, 253, 0.08), transparent 22%),
      linear-gradient(180deg, #12161b 0%, #0f1317 100%);
  }

  [data-bs-theme="dark"] .admin-login-topbar {
    background: rgba(23, 28, 34, 0.9);
    border-bottom-color: rgba(255, 255, 255, 0.08);
  }

  [data-bs-theme="dark"] .admin-login-card {
    background:
      radial-gradient(circle at top right, rgba(255, 180, 0, 0.08), transparent 22%),
      #171c22;
    border-color: rgba(255, 255, 255, 0.08);
    box-shadow: none;
  }

  [data-bs-theme="dark"] .admin-login-title,
  [data-bs-theme="dark"] .admin-login-label,
  [data-bs-theme="dark"] .admin-login-toggle {
    color: #f5f7fb;
  }

  [data-bs-theme="dark"] .admin-login-copy,
  [data-bs-theme="dark"] .admin-login-hint {
    color: #9aa6b8;
  }

  [data-bs-theme="dark"] .admin-login-input,
  [data-bs-theme="dark"] .admin-login-toggle {
    background: #20262d;
    border-color: rgba(255, 255, 255, 0.08);
  }

  @media (max-width: 767.98px) {
    .admin-login-topbar-inner {
      min-height: 5rem;
    }

    .admin-login-badge {
      min-height: 2.35rem;
      padding: 0 .9rem;
      font-size: .85rem;
    }

    .admin-login-card {
      padding: 1.3rem;
      border-radius: 1.5rem;
    }

    .admin-login-input {
      min-height: 4.4rem;
      font-size: 1rem;
    }
  }
</style>

<main class="page-wrapper">
  <header class="admin-login-topbar">
    <div class="container">
      <div class="admin-login-topbar-inner">
        <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="admin-login-brand">
          <img src="{{ asset('assets/img/branding/humanity-impact.png') }}" alt="{{ config('site.name') }}" style="height: 2.35rem; width: auto;">
          <span class="admin-login-badge">Site admin</span>
        </a>
      </div>
    </div>
  </header>

  <section class="admin-login-page">
    <div class="container">
      <div class="admin-login-shell">
        @if ($errors->any())
          <div class="alert alert-danger mb-4">
            <ul class="mb-0 ps-3 small">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
          </div>
        @endif

        <div class="admin-login-card">
          <div class="admin-login-kicker">
            <span class="admin-login-kicker-dot"></span>
            Connexion sécurisée
          </div>

          <h1 class="admin-login-title">Accès administrateur</h1>
          <p class="admin-login-copy">Connectez-vous avec l’adresse e-mail du site et votre code d’accès pour gérer les dossiers.</p>

          <form method="post" action="{{ route('admin.login') }}">
            @csrf

            <div class="mb-4">
              <label class="admin-login-label" for="email">Adresse e-mail</label>
              <input type="email" class="form-control admin-login-input" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            </div>

            <div class="mb-4">
              <label class="admin-login-label" for="password">Code d’accès</label>
              <div class="admin-login-password">
                <input type="password" class="form-control admin-login-input" id="password" name="password" required autocomplete="current-password">
                <button type="button" class="admin-login-toggle" data-password-toggle aria-label="Afficher le mot de passe">
                  <i class="ai-eye"></i>
                </button>
              </div>
            </div>

            <button type="submit" class="admin-login-submit">Se connecter</button>
          </form>

          <div class="admin-login-hint">
            Pour le changement de code, le format recommandé reste : chiffres puis une lettre finale. Exemple : <code>48291A</code>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.querySelector('[data-password-toggle]');
    const input = document.getElementById('password');

    if (!toggle || !input) {
      return;
    }

    toggle.addEventListener('click', function () {
      const hidden = input.type === 'password';
      input.type = hidden ? 'text' : 'password';
      toggle.innerHTML = hidden ? '<i class="ai-eye-off"></i>' : '<i class="ai-eye"></i>';
    });
  });
</script>
@endsection

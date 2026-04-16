@extends('layouts.app')

@section('title', 'Réinitialiser le mot de passe — Administration')

@section('content')
<style>
  body { overflow-x: hidden; }
  .admin-login-header { position: fixed; inset: 0 0 auto; z-index: 1030; padding: 14px 0; background: rgba(var(--bs-body-bg-rgb), 0.88); border-bottom: 1px solid rgba(var(--bs-primary-rgb), 0.08); backdrop-filter: blur(12px); }
  .admin-login-header-inner { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
  .admin-login-header-link { display: inline-flex; align-items: center; justify-content: center; min-height: 40px; padding: 0 14px; border-radius: 12px; border: 1px solid rgba(var(--bs-primary-rgb), 0.1); background: var(--bs-body-bg); color: var(--bs-secondary-color); text-decoration: none; font-weight: 600; }
  .admin-login-page { min-height: 100vh; padding: 88px 0 24px; background: radial-gradient(circle at top left, rgba(var(--bs-primary-rgb), 0.08), transparent 28%), var(--bs-secondary-bg); display: flex; align-items: center; }
  .admin-login-wrap { max-width: 460px; margin: 0 auto; }
  .admin-login-card { padding: 32px; border-radius: 24px; border: 1px solid rgba(var(--bs-primary-rgb), 0.1); background: var(--bs-body-bg); box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08); }
  .admin-login-brand-logo { height: 44px; width: auto; display: block; }
  .admin-login-title { margin: 0 0 8px; color: var(--bs-heading-color); font-size: 2rem; line-height: 1.05; font-weight: 800; letter-spacing: -0.03em; }
  .admin-login-copy { margin: 0 0 24px; color: var(--bs-secondary-color); line-height: 1.65; }
  .admin-login-form .form-label { margin-bottom: 8px; color: var(--bs-heading-color); font-weight: 600; }
  .admin-login-form .form-control { min-height: 54px; border-radius: 14px; border-color: rgba(var(--bs-primary-rgb), 0.12); box-shadow: none; }
  .admin-login-submit { min-height: 54px; border-radius: 14px; font-weight: 700; }
  @media (max-width: 575.98px) { .admin-login-page { padding: 84px 0 20px; align-items: flex-start; } .admin-login-card { padding: 24px 18px; border-radius: 20px; } .admin-login-title { font-size: 1.8rem; } }
</style>

<main class="page-wrapper">
  <header class="admin-login-header">
    <div class="container">
      <div class="admin-login-header-inner">
        <div></div>
        <a href="{{ route('admin.login') }}" class="admin-login-header-link">
          <i class="ai-arrow-left me-2"></i>
          <span>Retour à la connexion</span>
        </a>
      </div>
    </div>
  </header>

  <section class="admin-login-page">
    <div class="container">
      <div class="admin-login-wrap">
        <div class="admin-login-card">
          <div class="mb-4">
            <img src="{{ \App\Support\SiteAppearance::logoUrl() }}" alt="{{ config('site.name') }}" class="admin-login-brand-logo">
          </div>

          <h1 class="admin-login-title">Nouveau mot de passe</h1>
          <p class="admin-login-copy">Définissez un nouveau mot de passe pour votre accès administrateur.</p>

          @if ($errors->any())
            <div class="alert alert-danger mb-3">
              <ul class="mb-0 ps-3 small">
                @foreach ($errors->all() as $e)
                  <li>{{ $e }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="post" action="{{ route('admin.password.update') }}" class="admin-login-form">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
              <label class="form-label" for="email">Adresse e-mail</label>
              <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $email) }}" required autocomplete="username">
            </div>

            <div class="mb-3">
              <label class="form-label" for="password">Nouveau mot de passe</label>
              <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password">
            </div>

            <div class="mb-3">
              <label class="form-label" for="password_confirmation">Confirmer le mot de passe</label>
              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-primary w-100 admin-login-submit">Réinitialiser le mot de passe</button>
          </form>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection

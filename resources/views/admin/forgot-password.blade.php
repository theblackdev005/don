@extends('layouts.app')

@section('title', 'Mot de passe oublié — Administration')

@section('content')
<style>
  body { overflow-x: hidden; }
  .admin-login-header { position: fixed; inset: 0 0 auto; z-index: 1030; padding: 14px 0; background: rgba(var(--bs-body-bg-rgb), 0.88); border-bottom: 1px solid rgba(var(--bs-primary-rgb), 0.08); backdrop-filter: blur(12px); }
  .admin-login-header-inner { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
  .admin-login-header-brand { display: inline-flex; align-items: center; gap: 12px; color: var(--bs-heading-color); text-decoration: none; font-size: 1.02rem; font-weight: 800; letter-spacing: -0.02em; }
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
  .admin-login-note { margin-top: 16px; color: var(--bs-secondary-color); font-size: .92rem; line-height: 1.6; }
  @media (max-width: 575.98px) { .admin-login-page { padding: 84px 0 20px; align-items: flex-start; } .admin-login-card { padding: 24px 18px; border-radius: 20px; } .admin-login-title { font-size: 1.8rem; } }
</style>

<main class="page-wrapper">
  <header class="admin-login-header">
    <div class="container">
      <div class="admin-login-header-inner">
        <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="admin-login-header-brand">
          <img src="{{ \App\Support\SiteAppearance::logoUrl() }}" alt="{{ config('site.name') }}" style="width: 38px; height: 38px; object-fit: contain;">
        </a>
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

          <h1 class="admin-login-title">Mot de passe oublié</h1>
          <p class="admin-login-copy">Saisissez votre adresse administrateur. Si elle existe, nous enverrons un lien de réinitialisation.</p>

          @if (session('status'))
            <div class="alert alert-success mb-3">{{ session('status') }}</div>
          @endif

          @if ($errors->any())
            <div class="alert alert-danger mb-3">
              <ul class="mb-0 ps-3 small">
                @foreach ($errors->all() as $e)
                  <li>{{ $e }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="post" action="{{ route('admin.password.email') }}" class="admin-login-form">
            @csrf
            <div class="mb-3">
              <label class="form-label" for="email">Adresse e-mail</label>
              <input type="email" class="form-control" id="email" name="email" value="{{ old('email', config('admin.email')) }}" required autofocus autocomplete="username">
            </div>

            <button type="submit" class="btn btn-primary w-100 admin-login-submit">Envoyer le lien</button>
          </form>

          <p class="admin-login-note">Le lien de réinitialisation sera envoyé à l’adresse du compte administrateur.</p>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection

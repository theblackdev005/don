@extends('layouts.admin')

@section('title', 'Code d’accès')

@push('head')
  <style>
    .admin-password-shell {
      max-width: 1120px;
      margin: 0 auto;
    }

    .admin-password-hero {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .admin-password-title {
      color: #172033;
      font-size: clamp(2.3rem, 4vw, 3.5rem);
      font-weight: 800;
      line-height: 1.02;
      letter-spacing: -0.04em;
      margin-bottom: .55rem;
    }

    .admin-password-copy {
      color: #6b7a90;
      font-size: 1rem;
      max-width: 38rem;
      margin-bottom: 0;
    }

    .admin-password-back {
      min-height: 3.2rem;
      padding: 0 1.6rem;
      border-radius: 1rem;
      border: 1px solid rgba(15, 23, 42, 0.12);
      background: rgba(255, 255, 255, 0.82);
      color: #172033;
      font-weight: 800;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      white-space: nowrap;
    }

    .admin-password-card {
      max-width: 720px;
      margin: 0 auto;
      padding: 2rem;
      border: 1px solid rgba(15, 23, 42, 0.08);
      border-radius: 2rem;
      background: #fff;
      box-shadow: 0 18px 40px rgba(148, 163, 184, 0.16);
    }

    .admin-password-label {
      color: #172033;
      font-size: 1rem;
      font-weight: 800;
      margin-bottom: .7rem;
    }

    .admin-password-input {
      min-height: 5rem;
      padding-right: 5.2rem;
      border-radius: 1.35rem;
      border: 1px solid rgba(148, 163, 184, 0.32);
      background: #fff;
      box-shadow: none;
      font-size: 1.05rem;
    }

    .admin-password-input:focus {
      border-color: rgba(255, 180, 0, 0.55);
      box-shadow: 0 0 0 .25rem rgba(255, 180, 0, 0.14);
    }

    .admin-password-field {
      position: relative;
    }

    .admin-password-toggle {
      position: absolute;
      top: 50%;
      right: .75rem;
      transform: translateY(-50%);
      min-width: 7.4rem;
      height: 3.6rem;
      border-radius: 1rem;
      border: 1px solid rgba(148, 163, 184, 0.28);
      background: #fff;
      color: #172033;
      font-weight: 800;
    }

    .admin-password-note {
      color: #6b7a90;
      font-size: .96rem;
      margin-top: .8rem;
      margin-bottom: 0;
    }

    .admin-password-note strong {
      color: #ff9800;
      font-weight: 800;
    }

    .admin-password-submit {
      min-height: 3.9rem;
      padding: 0 1.5rem;
      border: 0;
      border-radius: 1rem;
      background: #ffb400;
      color: #fff;
      font-size: 1rem;
      font-weight: 800;
      box-shadow: 0 14px 28px rgba(255, 180, 0, 0.22);
    }

    [data-bs-theme="dark"] .admin-password-title {
      color: #f5f7fb;
    }

    [data-bs-theme="dark"] .admin-password-copy,
    [data-bs-theme="dark"] .admin-password-note {
      color: #9aa6b8;
    }

    [data-bs-theme="dark"] .admin-password-card {
      background: #171c22;
      border-color: rgba(255, 255, 255, 0.08);
      box-shadow: none;
    }

    [data-bs-theme="dark"] .admin-password-label,
    [data-bs-theme="dark"] .admin-password-back,
    [data-bs-theme="dark"] .admin-password-toggle {
      color: #f5f7fb;
    }

    [data-bs-theme="dark"] .admin-password-back,
    [data-bs-theme="dark"] .admin-password-input,
    [data-bs-theme="dark"] .admin-password-toggle {
      background: #20262d;
      border-color: rgba(255, 255, 255, 0.08);
    }

    @media (max-width: 767.98px) {
      .admin-password-hero {
        flex-direction: column;
        margin-bottom: 1.5rem;
      }

      .admin-password-card {
        padding: 1.3rem;
        border-radius: 1.5rem;
      }

      .admin-password-input {
        min-height: 4.4rem;
        font-size: 1rem;
      }

      .admin-password-toggle {
        min-width: 6.2rem;
        height: 3.1rem;
      }
    }
  </style>
@endpush

@section('content')
  <div class="admin-password-shell">
    @if (session('ok'))
      <div class="alert alert-success mb-4">{{ session('ok') }}</div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger mb-4">
        <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
      </div>
    @endif

    <div class="admin-password-hero">
      <div>
        <h1 class="admin-password-title">Code d’accès</h1>
        <p class="admin-password-copy">Modifiez ici votre code d’accès admin en toute simplicité.</p>
      </div>

      <a href="{{ route('admin.dashboard') }}" class="admin-password-back">Retour au dashboard</a>
    </div>

    <div class="admin-password-card">
      <form method="post" action="{{ route('admin.settings.password.update') }}">
        @csrf

        <div class="mb-4">
          <label class="admin-password-label" for="current_password">Code d’accès actuel</label>
          <div class="admin-password-field">
            <input type="password" id="current_password" name="current_password" class="form-control admin-password-input" autocomplete="current-password">
            <button type="button" class="admin-password-toggle" data-toggle-password="current_password">Afficher</button>
          </div>
        </div>

        <div class="mb-4">
          <label class="admin-password-label" for="new_password">Nouveau code d’accès</label>
          <div class="admin-password-field">
            <input type="password" id="new_password" name="new_password" class="form-control admin-password-input" autocomplete="new-password">
            <button type="button" class="admin-password-toggle" data-toggle-password="new_password">Afficher</button>
          </div>
          <p class="admin-password-note">Format attendu : une suite de chiffres suivie d’une lettre. Exemple : <strong>48291A</strong></p>
        </div>

        <div class="mb-4">
          <label class="admin-password-label" for="new_password_confirmation">Confirmer le nouveau code d’accès</label>
          <div class="admin-password-field">
            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control admin-password-input" autocomplete="new-password">
            <button type="button" class="admin-password-toggle" data-toggle-password="new_password_confirmation">Afficher</button>
          </div>
        </div>

        <button type="submit" class="admin-password-submit">Mettre à jour</button>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('[data-toggle-password]').forEach(function (button) {
        button.addEventListener('click', function () {
          const field = document.getElementById(button.getAttribute('data-toggle-password'));

          if (!field) return;

          const hidden = field.type === 'password';
          field.type = hidden ? 'text' : 'password';
          button.textContent = hidden ? 'Masquer' : 'Afficher';
        });
      });
    });
  </script>
@endsection

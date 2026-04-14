@extends('layouts.admin')

@section('title', 'Code d’accès')

@push('head')
  <style>
    .admin-password-wrap {
      max-width: 720px;
    }

    .admin-password-card {
      border: 1px solid rgba(15, 23, 42, 0.08);
      border-radius: 1.25rem;
      background: var(--bs-body-bg);
      box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
    }

    .admin-password-title {
      color: var(--bs-heading-color);
      font-size: 1.9rem;
      font-weight: 800;
      letter-spacing: -0.03em;
      margin-bottom: .5rem;
    }

    .admin-password-copy {
      color: var(--bs-secondary-color);
      font-size: 1rem;
      line-height: 1.7;
      margin-bottom: 0;
      max-width: 30rem;
    }

    .admin-password-section-title {
      color: var(--bs-heading-color);
      font-size: 1rem;
      font-weight: 800;
      margin-bottom: 1rem;
    }

    .admin-password-field {
      position: relative;
    }

    .admin-password-field .form-control {
      min-height: 54px;
      border-radius: 14px;
      border-color: rgba(var(--bs-primary-rgb), 0.12);
      padding-right: 4.2rem;
      box-shadow: none;
    }

    .admin-password-field .form-control:focus {
      border-color: rgba(var(--bs-primary-rgb), 0.42);
      box-shadow: 0 0 0 .25rem rgba(var(--bs-primary-rgb), 0.12);
    }

    .admin-password-toggle {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      min-width: 108px;
      height: 40px;
      border: 0;
      border-radius: 12px;
      background: rgba(var(--bs-primary-rgb), 0.1);
      color: var(--bs-primary);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: .45rem;
      padding: 0 .85rem;
      font-size: .9rem;
      font-weight: 700;
    }

    .admin-password-toggle:hover {
      background: rgba(var(--bs-primary-rgb), 0.16);
    }

    [data-bs-theme="dark"] .admin-password-card {
      background: #20262d;
      border-color: rgba(255, 255, 255, 0.08);
      box-shadow: none;
    }
  </style>
@endpush

@section('content')
@if (session('ok'))
  <div class="alert alert-success mb-4">{{ session('ok') }}</div>
@endif

@if ($errors->any())
  <div class="alert alert-danger mb-4">
    <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
@endif

<div class="admin-password-wrap">
  <div class="mb-4">
    <h1 class="admin-password-title">Code d’accès</h1>
    <p class="admin-password-copy">Modifiez ici votre code d’accès administrateur simplement.</p>
  </div>

  <div class="admin-password-card p-4">
    <div class="admin-password-section-title">Mettre à jour le code d’accès</div>

    <form method="post" action="{{ route('admin.settings.password.update') }}">
      @csrf

      <div class="mb-4">
        <label class="form-label fw-semibold" for="current_password">Code d’accès actuel</label>
        <div class="admin-password-field">
          <input type="password" class="form-control" id="current_password" name="current_password" autocomplete="current-password" required>
          <button type="button" class="admin-password-toggle" data-password-toggle="current_password" aria-label="Afficher le code d’accès actuel">
            <i class="ai-eye"></i>
            <span>Afficher</span>
          </button>
        </div>
      </div>

      <div class="mb-4">
        <label class="form-label fw-semibold" for="new_password">Nouveau code d’accès</label>
        <div class="admin-password-field">
          <input type="password" class="form-control" id="new_password" name="new_password" autocomplete="new-password" required>
          <button type="button" class="admin-password-toggle" data-password-toggle="new_password" aria-label="Afficher le nouveau code d’accès">
            <i class="ai-eye"></i>
            <span>Afficher</span>
          </button>
        </div>
      </div>

      <div class="mb-4">
        <label class="form-label fw-semibold" for="new_password_confirmation">Confirmer le nouveau code d’accès</label>
        <div class="admin-password-field">
          <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" autocomplete="new-password" required>
          <button type="button" class="admin-password-toggle" data-password-toggle="new_password_confirmation" aria-label="Afficher la confirmation du code d’accès">
            <i class="ai-eye"></i>
            <span>Afficher</span>
          </button>
        </div>
      </div>

      <button type="submit" class="btn btn-primary px-4">Mettre à jour</button>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-password-toggle]').forEach(function (button) {
      button.addEventListener('click', function () {
        const targetId = button.getAttribute('data-password-toggle');
        const input = document.getElementById(targetId);

        if (!input) {
          return;
        }

        const hidden = input.type === 'password';
        input.type = hidden ? 'text' : 'password';
        button.innerHTML = hidden
          ? '<i class="ai-eye-off"></i><span>Masquer</span>'
          : '<i class="ai-eye"></i><span>Afficher</span>';
        button.setAttribute('aria-label', hidden ? 'Masquer le code d’accès' : 'Afficher le code d’accès');
      });
    });
  });
</script>
@endsection

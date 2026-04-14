@extends('layouts.admin')

@section('title', 'Configuration')

@push('head')
  <style>
    .admin-settings-shell {
      max-width: 1440px;
      margin: 0 auto;
    }

    .admin-settings-hero {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .admin-settings-title {
      color: #172033;
      font-size: clamp(2.5rem, 4vw, 4rem);
      font-weight: 800;
      line-height: 1.02;
      letter-spacing: -0.04em;
      margin-bottom: .55rem;
    }

    .admin-settings-copy {
      color: #6b7a90;
      font-size: 1rem;
      max-width: 42rem;
      margin-bottom: 0;
    }

    .admin-settings-back {
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

    .admin-settings-card {
      padding: 2rem;
      border: 1px solid rgba(15, 23, 42, 0.08);
      border-radius: 2rem;
      background: #fff;
      box-shadow: 0 18px 40px rgba(148, 163, 184, 0.16);
    }

    .admin-settings-section {
      padding-top: 1.8rem;
      margin-top: 1.8rem;
      border-top: 1px solid rgba(15, 23, 42, 0.08);
    }

    .admin-settings-section:first-of-type {
      padding-top: 0;
      margin-top: 0;
      border-top: 0;
    }

    .admin-settings-section-title {
      color: #172033;
      font-size: 1.25rem;
      font-weight: 800;
      margin-bottom: 1.4rem;
    }

    .admin-settings-label {
      color: #172033;
      font-size: 1rem;
      font-weight: 800;
      margin-bottom: .7rem;
    }

    .admin-settings-input,
    .admin-settings-select {
      min-height: 5rem;
      border-radius: 1.35rem;
      border: 1px solid rgba(148, 163, 184, 0.32);
      background: #fff;
      box-shadow: none;
      font-size: 1.05rem;
    }

    .admin-settings-input:focus,
    .admin-settings-select:focus {
      border-color: rgba(255, 180, 0, 0.55);
      box-shadow: 0 0 0 .25rem rgba(255, 180, 0, 0.14);
    }

    .admin-settings-submit {
      min-height: 3.9rem;
      padding: 0 1.6rem;
      border: 0;
      border-radius: 1rem;
      background: #ffb400;
      color: #172033;
      font-size: 1rem;
      font-weight: 800;
      box-shadow: 0 14px 28px rgba(255, 180, 0, 0.22);
    }

    [data-bs-theme="dark"] .admin-settings-title,
    [data-bs-theme="dark"] .admin-settings-section-title,
    [data-bs-theme="dark"] .admin-settings-label,
    [data-bs-theme="dark"] .admin-settings-back {
      color: #f5f7fb;
    }

    [data-bs-theme="dark"] .admin-settings-copy {
      color: #9aa6b8;
    }

    [data-bs-theme="dark"] .admin-settings-card {
      background: #171c22;
      border-color: rgba(255, 255, 255, 0.08);
      box-shadow: none;
    }

    [data-bs-theme="dark"] .admin-settings-section {
      border-top-color: rgba(255, 255, 255, 0.08);
    }

    [data-bs-theme="dark"] .admin-settings-input,
    [data-bs-theme="dark"] .admin-settings-select,
    [data-bs-theme="dark"] .admin-settings-back {
      background: #20262d;
      border-color: rgba(255, 255, 255, 0.08);
      color: #f5f7fb;
    }

    @media (max-width: 767.98px) {
      .admin-settings-hero {
        flex-direction: column;
        margin-bottom: 1.5rem;
      }

      .admin-settings-card {
        padding: 1.3rem;
        border-radius: 1.5rem;
      }

      .admin-settings-input,
      .admin-settings-select {
        min-height: 4.4rem;
        font-size: 1rem;
      }
    }
  </style>
@endpush

@section('content')
  <div class="admin-settings-shell">
    @if (session('ok'))
      <div class="alert alert-success mb-4">{{ session('ok') }}</div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger mb-4">
        <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
      </div>
    @endif

    <div class="admin-settings-hero">
      <div>
        <h1 class="admin-settings-title">Configuration</h1>
        <p class="admin-settings-copy">Modifiez ici les informations principales du site simplement.</p>
      </div>

      <a href="{{ route('admin.dashboard') }}" class="admin-settings-back">Retour au dashboard</a>
    </div>

    <div class="admin-settings-card">
      <form method="post" action="{{ route('admin.settings.update') }}">
        @csrf

        <div class="admin-settings-section">
          <div class="admin-settings-section-title">Informations site</div>
          <div class="row g-4">
            <div class="col-lg-6">
              <label class="admin-settings-label">Nom du site</label>
              <input type="text" name="site_name" class="form-control admin-settings-input" value="{{ old('site_name', $settings['site_name']) }}">
            </div>
            <div class="col-lg-6">
              <label class="admin-settings-label">E-mail du site</label>
              <input type="email" name="site_email" class="form-control admin-settings-input" value="{{ old('site_email', $settings['site_email']) }}">
            </div>
            <div class="col-lg-6">
              <label class="admin-settings-label">Langue par défaut</label>
              <select name="site_default_locale" class="form-select admin-settings-select">
                @foreach ($availableLocales as $localeOption)
                  <option value="{{ $localeOption['code'] }}" @selected(old('site_default_locale', $settings['site_default_locale']) === $localeOption['code'])>
                    {{ $localeOption['label'] }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-lg-6">
              <label class="admin-settings-label">Téléphone</label>
              <input type="text" name="site_phone" class="form-control admin-settings-input" value="{{ old('site_phone', $settings['site_phone']) }}">
            </div>
            <div class="col-12">
              <label class="admin-settings-label">Adresse du site</label>
              <input type="text" name="site_address" class="form-control admin-settings-input" value="{{ old('site_address', $settings['site_address']) }}">
            </div>
          </div>
        </div>

        <div class="admin-settings-section">
          <div class="admin-settings-section-title">Référencement</div>
          <div class="row g-4">
            <div class="col-12">
              <label class="admin-settings-label">Description du site</label>
              <input type="text" name="site_meta_description" class="form-control admin-settings-input" value="{{ old('site_meta_description', $settings['site_meta_description']) }}">
            </div>
            <div class="col-12">
              <label class="admin-settings-label">Mots-clés</label>
              <input type="text" name="site_meta_keywords" class="form-control admin-settings-input" value="{{ old('site_meta_keywords', $settings['site_meta_keywords']) }}">
            </div>
          </div>
        </div>

        <div class="pt-4">
          <button type="submit" class="admin-settings-submit">Enregistrer la configuration</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@extends('layouts.admin')

@section('title', 'Configuration')

@push('head')
  <style>
    .admin-settings-card {
      border: 1px solid rgba(15, 23, 42, 0.08);
      border-radius: 1rem;
      background: var(--bs-body-bg);
      box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
    }

    .admin-settings-section-title {
      font-size: 1rem;
      font-weight: 700;
      color: var(--bs-heading-color);
      margin-bottom: 1rem;
    }

    .admin-settings-helper {
      color: var(--bs-secondary-color);
      font-size: .94rem;
      line-height: 1.65;
    }

    [data-bs-theme="dark"] .admin-settings-card {
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

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
  <div>
    <h1 class="h2 mb-1">Configuration</h1>
    <p class="text-body-secondary mb-0">Mettez à jour les informations visibles sur la plateforme.</p>
  </div>
</div>

<form method="post" action="{{ route('admin.settings.update') }}">
  @csrf
  <div class="row g-4">
    <div class="col-xl-7">
      <div class="admin-settings-card p-4 mb-4">
        <div class="admin-settings-section-title">Identité du site</div>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nom du site</label>
            <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $settings['site_name']) }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Langue principale du site</label>
            <select name="site_default_locale" class="form-select">
              @foreach ($availableLocales as $localeOption)
                <option value="{{ $localeOption['code'] }}" @selected(old('site_default_locale', $settings['site_default_locale']) === $localeOption['code'])>
                  {{ $localeOption['label'] }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">E-mail du site</label>
            <input type="email" name="site_email" class="form-control" value="{{ old('site_email', $settings['site_email']) }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Téléphone</label>
            <input type="text" name="site_phone" class="form-control" value="{{ old('site_phone', $settings['site_phone']) }}">
          </div>
          <div class="col-12">
            <label class="form-label">Adresse du site</label>
            <input type="text" name="site_address" class="form-control" value="{{ old('site_address', $settings['site_address']) }}">
          </div>
        </div>
      </div>

      <div class="admin-settings-card p-4">
        <div class="admin-settings-section-title">Référencement</div>
        <div class="row g-3">
          <div class="col-12">
            <label class="form-label">Description du site</label>
            <input type="text" name="site_meta_description" class="form-control" value="{{ old('site_meta_description', $settings['site_meta_description']) }}">
          </div>
          <div class="col-12">
            <label class="form-label">Mots-clés</label>
            <input type="text" name="site_meta_keywords" class="form-control" value="{{ old('site_meta_keywords', $settings['site_meta_keywords']) }}">
          </div>
        </div>
      </div>

    </div>

    <div class="col-xl-5">
      <div class="admin-settings-card p-4 mb-4">
        <div class="admin-settings-section-title">À propos</div>
        <p class="text-body-secondary mb-0">Cette page permet de gérer les informations générales affichées sur le site.</p>
      </div>

      <div class="admin-settings-card p-4">
        <div class="admin-settings-section-title">Mise à jour</div>
        <p class="text-body-secondary mb-3">Enregistrez vos changements pour mettre à jour les informations publiques de la plateforme.</p>
        <button type="submit" class="btn btn-primary w-100">Enregistrer la configuration</button>
      </div>
    </div>
  </div>
</form>
@endsection

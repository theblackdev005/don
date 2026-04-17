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

    .admin-logo-preview {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 132px;
      padding: 1.25rem;
      border: 1px dashed rgba(15, 23, 42, 0.14);
      border-radius: 1rem;
      background:
        linear-gradient(135deg, rgba(var(--bs-primary-rgb), 0.04), rgba(255, 180, 0, 0.08));
    }

    .admin-logo-preview img {
      max-width: 100%;
      max-height: 82px;
      width: auto;
      height: auto;
      object-fit: contain;
    }

    .admin-favicon-preview img {
      max-width: 52px;
      max-height: 52px;
      width: 52px;
      height: 52px;
      object-fit: contain;
      border-radius: .85rem;
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
    <ul class="mb-0 ps-3">
      @foreach ($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
  <div>
    <h1 class="h2 mb-1">Configuration</h1>
    <p class="text-body-secondary mb-0">Mettez à jour les informations visibles sur la plateforme.</p>
  </div>
  <a href="{{ route('admin.settings.preview-donation-act') }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary">
    <i class="ai-file-text me-2"></i>
    Prévisualiser le contrat
  </a>
</div>

<form method="post" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
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
          <div class="col-12">
            <label class="form-label">Logo du site</label>
            <div class="admin-logo-preview mb-3">
              <img src="{{ $settings['site_logo_url'] }}" alt="{{ $settings['site_name'] }}">
            </div>
            <input type="file" name="site_logo" class="form-control" accept=".png,.jpg,.jpeg,.webp">
            <div class="form-text">PNG ou JPG recommande pour un rendu plus fiable sur le site et dans les e-mails.</div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Favicon</label>
            <div class="admin-logo-preview admin-favicon-preview mb-3">
              <img src="{{ $settings['site_favicon_url'] }}" alt="Favicon {{ $settings['site_name'] }}">
            </div>
            <input type="file" name="site_favicon" class="form-control" accept=".png,.ico,.webp">
            <div class="form-text">Le favicon est l’icône visible dans l’onglet du navigateur.</div>
          </div>
          <div class="col-md-6 d-flex align-items-end">
            <div class="admin-settings-helper w-100">
              Le logo et le favicon sont mis a jour automatiquement.
            </div>
          </div>
          <div class="col-md-6">
            <label class="form-label">E-mail du site</label>
            <input type="email" name="site_email" class="form-control" value="{{ old('site_email', $settings['site_email']) }}">
            <div class="form-text">Cet e-mail est aussi utilisé comme e-mail public du site et dans le footer.</div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Téléphone</label>
            <input type="text" name="site_phone" class="form-control" value="{{ old('site_phone', $settings['site_phone']) }}">
            <div class="form-text">Ce numéro est aussi réutilisé comme numéro WhatsApp du site.</div>
          </div>
          <div class="col-12">
            <label class="form-label">Adresse du site</label>
            <input type="text" name="site_address" class="form-control" value="{{ old('site_address', $settings['site_address']) }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Nom complet légal</label>
            <input type="text" name="site_legal_full_name" class="form-control" value="{{ old('site_legal_full_name', $settings['site_legal_full_name']) }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Numéro d’entreprise</label>
            <input type="text" name="site_company_number" class="form-control" value="{{ old('site_company_number', $settings['site_company_number']) }}">
          </div>
          <div class="col-12">
            <label class="form-label">Adresse principale</label>
            <input type="text" name="site_main_address" class="form-control" value="{{ old('site_main_address', $settings['site_main_address']) }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Facebook</label>
            <input type="url" name="site_social_facebook" class="form-control" value="{{ old('site_social_facebook', $settings['site_social_facebook']) }}" placeholder="https://facebook.com/...">
          </div>
          <div class="col-md-6">
            <label class="form-label">Instagram</label>
            <input type="url" name="site_social_instagram" class="form-control" value="{{ old('site_social_instagram', $settings['site_social_instagram']) }}" placeholder="https://instagram.com/...">
          </div>
          <div class="col-md-6">
            <label class="form-label">LinkedIn</label>
            <input type="url" name="site_social_linkedin" class="form-control" value="{{ old('site_social_linkedin', $settings['site_social_linkedin']) }}" placeholder="https://linkedin.com/company/...">
          </div>
          <div class="col-md-6">
            <label class="form-label">Nom du représentant</label>
            <input type="text" name="donation_act_director_name" class="form-control" value="{{ old('donation_act_director_name', $settings['donation_act_director_name']) }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Sexe du représentant</label>
            <select name="donation_act_director_gender" class="form-select">
              <option value="female" @selected(old('donation_act_director_gender', $settings['donation_act_director_gender']) === 'female')>Femme</option>
              <option value="male" @selected(old('donation_act_director_gender', $settings['donation_act_director_gender']) === 'male')>Homme</option>
            </select>
          </div>
        </div>
      </div>

      <div class="admin-settings-card p-4">
        <div class="admin-settings-section-title">Référencement</div>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Google Tag ID</label>
            <input type="text" name="site_google_tag_id" class="form-control" value="{{ old('site_google_tag_id', $settings['site_google_tag_id']) }}" placeholder="G-XXXXXXXXXX">
            <div class="form-text">Ajoutez uniquement l’identifiant, pas tout le script Google.</div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Facebook Pixel ID</label>
            <input type="text" name="site_facebook_pixel_id" class="form-control" value="{{ old('site_facebook_pixel_id', $settings['site_facebook_pixel_id']) }}" placeholder="123456789012345">
            <div class="form-text">Ajoutez uniquement l’identifiant du pixel Facebook.</div>
          </div>
          <div class="col-12">
            <label class="form-label">Meta Facebook domain verification</label>
            <input type="text" name="site_facebook_domain_verification" class="form-control" value="{{ old('site_facebook_domain_verification', $settings['site_facebook_domain_verification']) }}" placeholder="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx">
            <div class="form-text">Collez uniquement la valeur de verification fournie par Meta, pas toute la balise HTML.</div>
          </div>
        </div>
      </div>

    </div>

    <div class="col-xl-5">
      <div class="admin-settings-card p-4 mb-4">
        <div class="admin-settings-section-title">À propos</div>
        <p class="text-body-secondary mb-0">Cette page permet de gérer l’identité du site, ses couleurs, son logo, son favicon, son référencement et les informations publiques affichées sur la plateforme et dans les e-mails.</p>
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

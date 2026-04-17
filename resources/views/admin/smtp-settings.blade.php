@extends('layouts.admin')

@section('title', 'Configuration SMTP')

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
    <ul class="mb-0 ps-3">
      @foreach ($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
  <div>
    <h1 class="h2 mb-1">SMTP</h1>
    <p class="text-body-secondary mb-0">Gerez l'envoi des e-mails directement depuis l'administration.</p>
  </div>
</div>

<div class="row g-4">
  <div class="col-xl-7">
    <form method="post" action="{{ route('admin.smtp.update') }}">
      @csrf
      <div class="admin-settings-card p-4 mb-4">
        <div class="admin-settings-section-title">Serveur SMTP</div>
        <div class="row g-3">
          <div class="col-md-8">
            <label class="form-label">Hote SMTP</label>
            <input type="text" name="mail_host" class="form-control" value="{{ old('mail_host', $settings['mail_host']) }}" placeholder="smtp-relay.brevo.com">
          </div>
          <div class="col-md-4">
            <label class="form-label">Port</label>
            <input type="number" name="mail_port" class="form-control" value="{{ old('mail_port', $settings['mail_port']) }}" min="1" max="65535" placeholder="587">
          </div>
          <div class="col-md-6">
            <label class="form-label">Chiffrement</label>
            <select name="mail_encryption" class="form-select">
              <option value="" @selected(old('mail_encryption', $settings['mail_encryption']) === '')>Aucun</option>
              <option value="tls" @selected(old('mail_encryption', $settings['mail_encryption']) === 'tls')>TLS</option>
              <option value="ssl" @selected(old('mail_encryption', $settings['mail_encryption']) === 'ssl')>SSL</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Domaine EHLO</label>
            <input type="text" name="mail_ehlo_domain" class="form-control" value="{{ old('mail_ehlo_domain', $settings['mail_ehlo_domain']) }}" placeholder="hiafoundation.org">
          </div>
          <div class="col-md-6">
            <label class="form-label">Nom d'utilisateur</label>
            <input type="text" name="mail_username" class="form-control" value="{{ old('mail_username', $settings['mail_username']) }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Mot de passe SMTP</label>
            <input type="password" name="mail_password" class="form-control" autocomplete="new-password" placeholder="Laisser vide pour conserver l'actuel">
            <div class="form-text">Si vous ne changez rien ici, le mot de passe actuel est conserve.</div>
          </div>
        </div>
      </div>

      <div class="admin-settings-card p-4">
        <div class="admin-settings-section-title">Expediteur et notifications</div>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Adresse d'expedition</label>
            <input type="email" name="mail_from_address" class="form-control" value="{{ old('mail_from_address', $settings['mail_from_address']) }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Nom d'expedition</label>
            <input type="text" name="mail_from_name" class="form-control" value="{{ old('mail_from_name', $settings['mail_from_name']) }}">
          </div>
          <div class="col-12">
            <label class="form-label">E-mail de notification admin</label>
            <input type="email" name="admin_notification_email" class="form-control" value="{{ old('admin_notification_email', $settings['admin_notification_email']) }}" placeholder="notifications@votredomaine.org">
            <div class="form-text">C'est cette adresse qui recoit les alertes internes du site.</div>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-primary px-4">Enregistrer la configuration SMTP</button>
      </div>
    </form>
  </div>

  <div class="col-xl-5">
    <div class="admin-settings-card p-4 mb-4">
      <div class="admin-settings-section-title">A propos</div>
      <p class="admin-settings-helper mb-0">Cette page met a jour les reglages e-mail du site automatiquement.</p>
    </div>

    <div class="admin-settings-card p-4">
      <div class="admin-settings-section-title">Test d'envoi</div>
      <p class="admin-settings-helper mb-3">Apres modification, envoyez un e-mail de test pour verifier rapidement que le SMTP fonctionne.</p>
      <form method="post" action="{{ route('admin.smtp.test') }}">
        @csrf
        <label class="form-label">Adresse de test</label>
        <input type="email" name="test_email" class="form-control mb-3" value="{{ old('test_email', '') }}" placeholder="vous@domaine.org">
        <button type="submit" class="btn btn-outline-primary w-100">
          <i class="ai-at me-2"></i>
          Envoyer un e-mail de test
        </button>
      </form>
    </div>
  </div>
</div>
@endsection

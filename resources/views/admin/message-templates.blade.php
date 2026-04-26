@extends('layouts.admin')

@section('title', 'Modèles de messages')

@push('head')
  <style>
    .admin-message-template-shell {
      --template-border: rgba(15, 23, 42, 0.08);
      --template-shadow: 0 18px 40px rgba(148, 163, 184, 0.16);
      --template-muted: #6b7a90;
      --template-heading: #172033;
      --template-soft: #f5f7fb;
      --template-surface: #ffffff;
    }

    .admin-message-template-hero,
    .admin-message-template-panel,
    .admin-message-template-item {
      border: 1px solid var(--template-border);
      border-radius: 1.25rem;
      background: var(--template-surface);
      box-shadow: var(--template-shadow);
    }

    .admin-message-template-hero {
      padding: 1.25rem 1.35rem;
      margin-bottom: 1rem;
    }

    .admin-message-template-top {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .admin-message-template-title {
      color: var(--template-heading);
      font-size: clamp(1.45rem, 2vw, 1.9rem);
      font-weight: 800;
      margin-bottom: .35rem;
    }

    .admin-message-template-note {
      color: var(--template-muted);
      font-size: .94rem;
      line-height: 1.55;
      margin: 0;
      max-width: 42rem;
    }

    .admin-message-template-languages {
      display: flex;
      gap: .45rem;
      flex-wrap: wrap;
      margin-top: 1rem;
    }

    .admin-message-template-languages .btn {
      min-height: 2.35rem;
      border-radius: 999px;
      font-size: .82rem;
      font-weight: 800;
      padding: .35rem .8rem;
    }

    .admin-message-template-grid {
      display: grid;
      grid-template-columns: minmax(0, 1fr) minmax(14rem, .34fr);
      gap: 1rem;
      align-items: start;
    }

    .admin-message-template-panel {
      padding: 1rem;
    }

    .admin-message-template-item {
      background: var(--template-soft);
      box-shadow: none;
      overflow: hidden;
    }

    .admin-message-template-item + .admin-message-template-item {
      margin-top: .75rem;
    }

    .admin-message-template-summary {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: .9rem;
      padding: .9rem 1rem;
      cursor: pointer;
      list-style: none;
    }

    .admin-message-template-summary::-webkit-details-marker {
      display: none;
    }

    .admin-message-template-heading {
      min-width: 0;
      display: flex;
      align-items: center;
      gap: .7rem;
    }

    .admin-message-template-step {
      flex: 0 0 auto;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 2rem;
      padding: .25rem .65rem;
      border-radius: 999px;
      background: rgba(15, 23, 42, 0.06);
      color: var(--template-muted);
      font-size: .74rem;
      font-weight: 800;
      white-space: nowrap;
    }

    .admin-message-template-name {
      color: var(--template-heading);
      font-size: .95rem;
      font-weight: 800;
      line-height: 1.25;
    }

    .admin-message-template-badge {
      flex: 0 0 auto;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 1.75rem;
      padding: .2rem .6rem;
      border-radius: 999px;
      background: rgba(25, 135, 84, 0.12);
      color: #198754;
      font-size: .72rem;
      font-weight: 800;
      white-space: nowrap;
    }

    .admin-message-template-body {
      padding: 0 1rem 1rem;
    }

    .admin-message-template-body textarea {
      min-height: 15rem;
      resize: vertical;
      line-height: 1.5;
    }

    .admin-message-template-variable-list {
      display: grid;
      gap: .45rem;
      margin: 0;
      padding: 0;
      list-style: none;
    }

    .admin-message-template-variable {
      display: grid;
      gap: .15rem;
      padding: .65rem .7rem;
      border-radius: .8rem;
      background: var(--template-soft);
    }

    .admin-message-template-variable code {
      color: var(--template-heading);
      font-size: .82rem;
      font-weight: 800;
      white-space: nowrap;
    }

    .admin-message-template-variable span {
      color: var(--template-muted);
      font-size: .78rem;
      line-height: 1.35;
    }

    [data-bs-theme="dark"] .admin-message-template-shell {
      --template-border: rgba(255, 255, 255, 0.08);
      --template-shadow: none;
      --template-muted: #9aa6b8;
      --template-heading: #f5f7fb;
      --template-soft: #20262d;
      --template-surface: #171c22;
    }

    @media (max-width: 991.98px) {
      .admin-message-template-grid {
        grid-template-columns: 1fr;
      }

      .admin-message-template-summary {
        align-items: flex-start;
        flex-direction: column;
      }
    }
  </style>
@endpush

@section('content')
<div class="admin-message-template-shell">
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

  <section class="admin-message-template-hero">
    <div class="admin-message-template-top">
      <div>
        <h1 class="admin-message-template-title">Modèles de messages</h1>
        <p class="admin-message-template-note">
          Les messages copiés dans les dossiers viennent d’ici. Choisissez une langue, modifiez les objets ou les contenus, puis enregistrez.
        </p>
      </div>
      <a href="{{ route('admin.funding-requests.index') }}" class="btn btn-outline-secondary">
        <i class="ai-folder me-2"></i>
        Dossiers
      </a>
    </div>

    <div class="admin-message-template-languages">
      @foreach ($supportedLocales as $localeCode)
        <a
          href="{{ route('admin.message-templates.edit', ['langue' => $localeCode]) }}"
          class="btn {{ $selectedLocale === $localeCode ? 'btn-primary' : 'btn-outline-secondary' }}">
          {{ $localeLabels[$localeCode] ?? strtoupper($localeCode) }}
        </a>
      @endforeach
    </div>
  </section>

  <div class="admin-message-template-grid">
    <form method="post" action="{{ route('admin.message-templates.update') }}" class="admin-message-template-panel">
      @csrf
      <input type="hidden" name="content_locale" value="{{ $selectedLocale }}">

      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
        <div>
          <h2 class="h5 mb-1">{{ $localeLabels[$selectedLocale] ?? strtoupper($selectedLocale) }}</h2>
          <p class="text-body-secondary mb-0">Ces modèles seront utilisés pour les clients dans cette langue.</p>
        </div>
        <button type="submit" class="btn btn-primary">
          <i class="ai-check me-2"></i>
          Enregistrer
        </button>
      </div>

      @foreach ($templates as $template)
        <details class="admin-message-template-item" @if ($loop->first) open @endif>
          <summary class="admin-message-template-summary">
            <span class="admin-message-template-heading">
              <span class="admin-message-template-step">Étape {{ $template['step'] }}</span>
              <span class="admin-message-template-name">{{ $template['title'] }}</span>
            </span>
            @if ($template['customized'])
              <span class="admin-message-template-badge">Personnalisé</span>
            @endif
          </summary>

          <div class="admin-message-template-body">
            <p class="text-body-secondary fs-sm mb-3">{{ $template['action'] }}</p>

            <div class="mb-3">
              <label class="form-label" for="template-{{ $template['key'] }}-subject">Objet e-mail</label>
              <input
                id="template-{{ $template['key'] }}-subject"
                type="text"
                name="templates[{{ $template['key'] }}][subject]"
                class="form-control"
                value="{{ old('templates.'.$template['key'].'.subject', $template['subject']) }}">
            </div>

            <div>
              <label class="form-label" for="template-{{ $template['key'] }}-body">Message</label>
              <textarea
                id="template-{{ $template['key'] }}-body"
                name="templates[{{ $template['key'] }}][body]"
                class="form-control">{{ old('templates.'.$template['key'].'.body', $template['body']) }}</textarea>
            </div>
          </div>
        </details>
      @endforeach

      <div class="d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-primary">
          <i class="ai-check me-2"></i>
          Enregistrer les modèles
        </button>
      </div>
    </form>

    <aside class="admin-message-template-panel">
      <h2 class="h6 mb-2">Variables utiles</h2>
      <p class="text-body-secondary fs-sm mb-3">
        Gardez ces mots entre crochets dans les textes. Ils seront remplacés automatiquement dans chaque dossier.
      </p>
      <ul class="admin-message-template-variable-list">
        @foreach ($variables as $variable)
          <li class="admin-message-template-variable">
            <code>{{ $variable['token'] }}</code>
            <span>{{ $variable['label'] }}</span>
          </li>
        @endforeach
      </ul>
    </aside>
  </div>
</div>
@endsection

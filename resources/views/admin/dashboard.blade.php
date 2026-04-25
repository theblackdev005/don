@extends('layouts.admin')

@section('title', 'Tableau de bord — Administration')

@php
  $pendingCard = $statusCards->firstWhere('status', \App\Models\FundingRequest::STATUS_PENDING);
  $awaitingCard = $statusCards->firstWhere('status', \App\Models\FundingRequest::STATUS_AWAITING_DOCUMENTS);
  $documentsCard = $statusCards->firstWhere('status', \App\Models\FundingRequest::STATUS_DOCUMENTS_RECEIVED);
  $actSentCard = $statusCards->firstWhere('status', \App\Models\FundingRequest::STATUS_DONATION_ACT_SENT);
  $refusedCard = $statusCards->firstWhere('status', \App\Models\FundingRequest::STATUS_REFUSED);

  $pendingCount = (int) (($pendingCard['count'] ?? null) ?? 0);
  $awaitingCount = (int) (($awaitingCard['count'] ?? null) ?? 0);
  $documentsCount = (int) (($documentsCard['count'] ?? null) ?? 0);
  $actSentCount = (int) (($actSentCard['count'] ?? null) ?? 0);
  $refusedCount = (int) (($refusedCard['count'] ?? null) ?? 0);
  $failedEmailCount = (int) ($failedEmailCount ?? 0);

  $actionCards = [
    [
      'title' => 'Demandes à examiner',
      'text' => 'Vérifiez les nouvelles demandes et envoyez un premier retour au client.',
      'count' => $pendingCount,
      'route' => 'review',
      'button' => 'Traiter les demandes',
      'tone' => 'warning',
    ],
    [
      'title' => 'Dossiers en attente de pièces',
      'text' => 'Suivez les clients qui doivent encore déposer leurs justificatifs.',
      'count' => $awaitingCount,
      'route' => 'documents',
      'button' => 'Suivre les dossiers',
      'tone' => 'info',
    ],
    [
      'title' => 'Dossiers complets',
      'text' => 'Les pièces sont reçues. Vous pouvez vérifier et décider.',
      'count' => $documentsCount,
      'route' => 'decision',
      'button' => 'Décider maintenant',
      'tone' => 'success',
    ],
    [
      'title' => 'Dossiers à finaliser',
      'text' => 'Les actes ont été envoyés. Il reste à clôturer les dossiers.',
      'count' => $actSentCount,
      'route' => 'closing',
      'button' => 'Clôturer les dossiers',
      'tone' => 'primary',
    ],
  ];
@endphp

@push('head')
  <style>
    .admin-dashboard-shell {
      --dashboard-border: rgba(15, 23, 42, 0.08);
      --dashboard-shadow: 0 18px 40px rgba(148, 163, 184, 0.16);
      --dashboard-muted: #6b7a90;
      --dashboard-heading: #172033;
      --dashboard-soft: #f5f7fb;
      --dashboard-surface: #ffffff;
      --dashboard-accent: #A87400;
      --dashboard-danger: #b42318;
    }

    .admin-dashboard-hero,
    .admin-dashboard-card {
      border: 1px solid var(--dashboard-border);
      border-radius: 1.35rem;
      background: var(--dashboard-surface);
      box-shadow: var(--dashboard-shadow);
    }

    .admin-dashboard-hero {
      padding: 1.45rem 1.55rem;
      margin-bottom: 1.2rem;
      background: linear-gradient(180deg, rgba(245, 247, 251, 0.95) 0%, rgba(255, 255, 255, 1) 100%);
    }

    .admin-dashboard-top {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .admin-dashboard-eyebrow {
      color: var(--dashboard-muted);
      font-size: .74rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: .06em;
      margin-bottom: .45rem;
    }

    .admin-dashboard-title {
      color: var(--dashboard-heading);
      font-size: clamp(1.75rem, 2vw, 2.15rem);
      font-weight: 800;
      line-height: 1.05;
      margin-bottom: .5rem;
    }

    .admin-dashboard-description {
      color: var(--dashboard-muted);
      font-size: .94rem;
      max-width: 40rem;
      margin-bottom: 0;
    }

    .admin-dashboard-hero-actions {
      display: flex;
      align-items: center;
      justify-content: flex-end;
      gap: .55rem;
      flex-wrap: wrap;
      flex: 0 0 auto;
    }

    .admin-dashboard-card {
      padding: 1.1rem 1.15rem;
      height: 100%;
    }

    .admin-dashboard-card-link {
      display: block;
      color: inherit;
      text-decoration: none;
      transition: transform .18s ease, border-color .18s ease;
    }

    .admin-dashboard-card-link:hover {
      transform: translateY(-1px);
      border-color: rgba(168, 116, 0, 0.24);
      color: inherit;
    }

    .admin-dashboard-hero-meta {
      display: flex;
      align-items: center;
      gap: .55rem;
      flex-wrap: wrap;
      margin-top: 1rem;
    }

    .admin-dashboard-hero-pill {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 2rem;
      padding: .3rem .75rem;
      border-radius: 999px;
      background: rgba(15, 23, 42, 0.04);
      color: var(--dashboard-muted);
      font-size: .8rem;
      font-weight: 800;
      white-space: nowrap;
    }

    .admin-dashboard-hero-pill.danger {
      background: rgba(244, 63, 94, 0.1);
      color: var(--dashboard-danger);
    }

    .admin-dashboard-stat-label {
      font-size: .72rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: .05em;
      color: var(--dashboard-muted);
      margin-bottom: .45rem;
    }

    .admin-dashboard-stat-value {
      font-size: 1.78rem;
      line-height: 1;
      font-weight: 800;
      color: var(--dashboard-heading);
      margin-bottom: .4rem;
    }

    .admin-dashboard-stat-note {
      color: var(--dashboard-muted);
      font-size: .86rem;
      line-height: 1.35;
      margin-bottom: 0;
    }

    .admin-dashboard-section-title {
      font-size: 1rem;
      font-weight: 800;
      color: var(--dashboard-heading);
      margin-bottom: .25rem;
    }

    .admin-dashboard-section-note {
      color: var(--dashboard-muted);
      font-size: .88rem;
      margin-bottom: 0;
    }

    .admin-dashboard-action-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: .85rem;
    }

    .admin-dashboard-action-card {
      border-radius: .95rem;
      padding: .95rem 1rem;
      border: 1px solid rgba(148, 163, 184, 0.16);
      background: var(--dashboard-soft);
    }

    .admin-dashboard-action-top {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: .8rem;
      margin-bottom: .5rem;
    }

    .admin-dashboard-action-title {
      color: var(--dashboard-heading);
      font-size: .95rem;
      font-weight: 800;
      margin-bottom: 0;
    }

    .admin-dashboard-action-text {
      color: var(--dashboard-muted);
      font-size: .84rem;
      line-height: 1.45;
      margin-bottom: .75rem;
    }

    .admin-dashboard-action-count {
      min-width: 2.2rem;
      min-height: 2.2rem;
      padding: .3rem .55rem;
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: 800;
      font-size: .88rem;
      background: rgba(15, 23, 42, 0.06);
      color: var(--dashboard-heading);
      flex: 0 0 auto;
    }

    .admin-dashboard-action-count.warning {
      background: rgba(255, 180, 0, 0.14);
      color: #9b6b00;
    }

    .admin-dashboard-action-count.info {
      background: rgba(13, 202, 240, 0.12);
      color: #146c94;
    }

    .admin-dashboard-action-count.success {
      background: rgba(25, 135, 84, 0.12);
      color: #0a7d45;
    }

    .admin-dashboard-action-count.primary {
      background: rgba(13, 110, 253, 0.12);
      color: #3056d3;
    }

    [data-bs-theme="dark"] .admin-dashboard-shell {
      --dashboard-border: rgba(255, 255, 255, 0.08);
      --dashboard-shadow: none;
      --dashboard-muted: #9aa6b8;
      --dashboard-heading: #f5f7fb;
      --dashboard-soft: #20262d;
      --dashboard-surface: #171c22;
    }

    [data-bs-theme="dark"] .admin-dashboard-hero {
      background: linear-gradient(180deg, rgba(32, 38, 45, 0.9) 0%, rgba(23, 28, 34, 1) 100%);
    }

    [data-bs-theme="dark"] .admin-dashboard-action-card {
      border-color: rgba(255, 255, 255, 0.08);
    }

    @media (max-width: 991.98px) {
      .admin-dashboard-action-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
@endpush

@section('content')
<div class="admin-dashboard-shell">
  @if (session('ok'))
    <div class="alert alert-success mb-4">{{ session('ok') }}</div>
  @endif

  <section class="admin-dashboard-hero">
    <div class="admin-dashboard-top">
      <div>
        <div class="admin-dashboard-eyebrow">Administration</div>
        <h1 class="admin-dashboard-title">Tableau de bord</h1>
        <p class="admin-dashboard-description">Retrouvez les demandes à traiter, les dossiers à relancer et les décisions à prendre.</p>
      </div>
      <div class="admin-dashboard-hero-actions">
        <a class="btn btn-primary" href="{{ route('admin.funding-requests.index') }}">Voir les demandes</a>
        @if ($failedEmailCount > 0)
          <a class="btn btn-outline-danger" href="{{ route('admin.email-notifications.index', ['status' => \App\Models\EmailNotification::STATUS_FAILED]) }}">
            Emails échoués
          </a>
        @endif
      </div>
    </div>

    <div class="admin-dashboard-hero-meta">
      <span class="admin-dashboard-hero-pill">{{ $totalCount }} dossier{{ $totalCount > 1 ? 's' : '' }} au total</span>
      <span class="admin-dashboard-hero-pill">{{ $refusedCount }} archivé{{ $refusedCount > 1 ? 's' : '' }}</span>
      @if ($failedEmailCount > 0)
        <span class="admin-dashboard-hero-pill danger">{{ $failedEmailCount }} email{{ $failedEmailCount > 1 ? 's' : '' }} échoué{{ $failedEmailCount > 1 ? 's' : '' }}</span>
      @endif
    </div>
  </section>

  <div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
      <a class="admin-dashboard-card admin-dashboard-card-link" href="{{ route('admin.funding-requests.index') }}">
        <div class="admin-dashboard-stat-label">Total</div>
        <div class="admin-dashboard-stat-value">{{ $totalCount }}</div>
        <p class="admin-dashboard-stat-note">Tous les dossiers enregistrés</p>
      </a>
    </div>
    <div class="col-6 col-xl-3">
      <a class="admin-dashboard-card admin-dashboard-card-link" href="{{ route('admin.workflow', ['stage' => 'review']) }}">
        <div class="admin-dashboard-stat-label">En attente</div>
        <div class="admin-dashboard-stat-value text-warning">{{ $pendingCount }}</div>
        <p class="admin-dashboard-stat-note">Premier examen à faire</p>
      </a>
    </div>
    <div class="col-6 col-xl-3">
      <a class="admin-dashboard-card admin-dashboard-card-link" href="{{ route('admin.workflow', ['stage' => 'decision']) }}">
        <div class="admin-dashboard-stat-label">Pièces reçues</div>
        <div class="admin-dashboard-stat-value text-success">{{ $documentsCount }}</div>
        <p class="admin-dashboard-stat-note">Dossiers prêts pour décision</p>
      </a>
    </div>
    <div class="col-6 col-xl-3">
      <a class="admin-dashboard-card admin-dashboard-card-link" href="{{ route('admin.workflow', ['stage' => 'closing']) }}">
        <div class="admin-dashboard-stat-label">Actes envoyés</div>
        <div class="admin-dashboard-stat-value text-primary">{{ $actSentCount }}</div>
        <p class="admin-dashboard-stat-note">Dossiers à clôturer</p>
      </a>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-12">
      <div class="admin-dashboard-card">
        <div class="admin-dashboard-section-title">Actions prioritaires</div>
        <p class="admin-dashboard-section-note">Accédez directement aux files utiles pour traiter les dossiers.</p>

        <div class="admin-dashboard-action-grid mt-4">
          @foreach ($actionCards as $card)
            <div class="admin-dashboard-action-card">
              <div class="admin-dashboard-action-top">
                <div class="admin-dashboard-action-title">{{ $card['title'] }}</div>
                <span class="admin-dashboard-action-count {{ $card['tone'] }}">{{ $card['count'] }}</span>
              </div>
              <p class="admin-dashboard-action-text">{{ $card['text'] }}</p>
              <a class="btn btn-outline-secondary w-100" href="{{ route('admin.workflow', ['stage' => $card['route']]) }}">
                {{ $card['button'] }}
              </a>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

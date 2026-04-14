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
@endphp

@push('head')
  <style>
    .admin-dashboard-shell {
      max-width: 1600px;
      margin: 0 auto;
    }

    .admin-dashboard-hero {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .admin-dashboard-title {
      color: #172033;
      font-size: clamp(2.8rem, 4vw, 4.1rem);
      font-weight: 800;
      line-height: 1.02;
      letter-spacing: -0.04em;
      margin-bottom: .8rem;
    }

    .admin-dashboard-copy {
      color: #6b7a90;
      font-size: 1rem;
      max-width: 42rem;
      margin-bottom: 0;
    }

    .admin-dashboard-actions {
      display: flex;
      gap: .9rem;
      flex-wrap: wrap;
    }

    .admin-dashboard-pill {
      min-height: 4rem;
      padding: 0 1.6rem;
      border-radius: 1.35rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      font-weight: 800;
      text-decoration: none;
      white-space: nowrap;
    }

    .admin-dashboard-pill.primary {
      background: #ffb400;
      color: #172033;
      box-shadow: 0 14px 28px rgba(255, 180, 0, 0.22);
    }

    .admin-dashboard-pill.secondary {
      background: #172033;
      color: #fff;
    }

    .admin-dashboard-stats {
      display: grid;
      grid-template-columns: repeat(5, minmax(0, 1fr));
      gap: 1.25rem;
    }

    .admin-dashboard-stat {
      min-height: 11.5rem;
      padding: 1.6rem;
      border: 1px solid rgba(15, 23, 42, 0.08);
      border-radius: 1.8rem;
      background: #fff;
      box-shadow: 0 18px 40px rgba(148, 163, 184, 0.16);
    }

    .admin-dashboard-stat-label {
      color: #6b7a90;
      font-size: .95rem;
      font-weight: 800;
      margin-bottom: 1.5rem;
    }

    .admin-dashboard-stat-value {
      color: #172033;
      font-size: 3rem;
      line-height: 1;
      font-weight: 800;
      letter-spacing: -0.03em;
    }

    [data-bs-theme="dark"] .admin-dashboard-title,
    [data-bs-theme="dark"] .admin-dashboard-stat-value {
      color: #f5f7fb;
    }

    [data-bs-theme="dark"] .admin-dashboard-copy,
    [data-bs-theme="dark"] .admin-dashboard-stat-label {
      color: #9aa6b8;
    }

    [data-bs-theme="dark"] .admin-dashboard-stat {
      background: #171c22;
      border-color: rgba(255, 255, 255, 0.08);
      box-shadow: none;
    }

    @media (max-width: 1399.98px) {
      .admin-dashboard-stats {
        grid-template-columns: repeat(3, minmax(0, 1fr));
      }
    }

    @media (max-width: 991.98px) {
      .admin-dashboard-hero {
        flex-direction: column;
      }

      .admin-dashboard-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }
    }

    @media (max-width: 575.98px) {
      .admin-dashboard-stats {
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

    <div class="admin-dashboard-hero">
      <div>
        <h1 class="admin-dashboard-title">Tableau de bord admin</h1>
        <p class="admin-dashboard-copy">Consultez rapidement tous les dossiers reçus et ouvrez leur fiche détaillée.</p>
      </div>

      <div class="admin-dashboard-actions">
        <a href="{{ route('admin.settings.edit') }}" class="admin-dashboard-pill primary">Config</a>
        <a href="{{ route('admin.settings.password.edit') }}" class="admin-dashboard-pill secondary">Code d’accès</a>
      </div>
    </div>

    <div class="admin-dashboard-stats">
      <div class="admin-dashboard-stat">
        <div class="admin-dashboard-stat-label">Total dossiers</div>
        <div class="admin-dashboard-stat-value">{{ $totalCount }}</div>
      </div>
      <div class="admin-dashboard-stat">
        <div class="admin-dashboard-stat-label">En préparation</div>
        <div class="admin-dashboard-stat-value">{{ $awaitingCount }}</div>
      </div>
      <div class="admin-dashboard-stat">
        <div class="admin-dashboard-stat-label">Dossiers complets</div>
        <div class="admin-dashboard-stat-value">{{ $documentsCount }}</div>
      </div>
      <div class="admin-dashboard-stat">
        <div class="admin-dashboard-stat-label">En traitement</div>
        <div class="admin-dashboard-stat-value">{{ $pendingCount }}</div>
      </div>
      <div class="admin-dashboard-stat">
        <div class="admin-dashboard-stat-label">Annulés</div>
        <div class="admin-dashboard-stat-value">{{ $refusedCount }}</div>
      </div>
    </div>
  </div>
@endsection

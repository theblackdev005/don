@extends('layouts.admin')

@section('title', 'Toutes les demandes')

@push('head')
  <style>
    .admin-crm-shell {
      --crm-border: rgba(15, 23, 42, 0.08);
      --crm-shadow: 0 18px 40px rgba(148, 163, 184, 0.16);
      --crm-muted: #6b7a90;
      --crm-heading: #172033;
      --crm-soft: #f5f7fb;
      --crm-surface: #ffffff;
    }

    .admin-crm-header,
    .admin-crm-table-card,
    .admin-crm-empty {
      border: 1px solid var(--crm-border);
      border-radius: 1.5rem;
      background: var(--crm-surface);
      box-shadow: var(--crm-shadow);
    }

    .admin-crm-header {
      padding: 1.3rem 1.4rem;
      margin-bottom: 1rem;
    }

    .admin-crm-topbar {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 1rem;
      flex-wrap: wrap;
      margin-bottom: 1rem;
    }

    .admin-crm-title {
      color: var(--crm-heading);
      font-size: clamp(1.6rem, 2vw, 2rem);
      font-weight: 800;
      margin-bottom: .35rem;
    }

    .admin-crm-subtitle {
      color: var(--crm-muted);
      font-size: .94rem;
      max-width: 38rem;
      margin-bottom: 0;
    }

    .admin-crm-meta {
      display: flex;
      align-items: center;
      gap: .6rem;
      flex-wrap: wrap;
    }

    .admin-crm-pill {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 2.1rem;
      padding: .3rem .8rem;
      border-radius: 999px;
      background: rgba(15, 23, 42, 0.04);
      color: var(--crm-muted);
      text-decoration: none;
      font-size: .8rem;
      font-weight: 800;
    }

    .admin-crm-pill.active {
      background: var(--crm-soft);
      color: var(--crm-heading);
    }

    .admin-crm-table-card {
      overflow: hidden;
    }

    .admin-crm-table {
      margin-bottom: 0;
    }

    .admin-crm-table thead th {
      background: transparent;
      color: var(--crm-muted);
      font-size: .72rem;
      text-transform: uppercase;
      letter-spacing: .05em;
      font-weight: 800;
      border-bottom-color: rgba(148, 163, 184, 0.14);
      padding: 1rem 1.1rem;
      white-space: nowrap;
    }

    .admin-crm-table tbody td {
      padding: 1rem 1.1rem;
      vertical-align: middle;
      border-bottom-color: rgba(148, 163, 184, 0.12);
    }

    .admin-crm-table tbody tr:last-child td {
      border-bottom: 0;
    }

    .admin-crm-row:hover td {
      background: rgba(15, 23, 42, 0.015);
    }

    .admin-crm-number {
      color: var(--crm-heading);
      font-size: .92rem;
      font-weight: 800;
      white-space: nowrap;
    }

    .admin-crm-client {
      color: var(--crm-heading);
      font-size: .94rem;
      font-weight: 700;
      margin-bottom: .2rem;
    }

    .admin-crm-sub {
      color: var(--crm-muted);
      font-size: .82rem;
      line-height: 1.35;
    }

    .admin-crm-status {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 2rem;
      padding: .28rem .72rem;
      border-radius: 999px;
      font-size: .78rem;
      font-weight: 800;
      border: 1px solid transparent;
      white-space: nowrap;
    }

    .admin-crm-status.pending {
      color: var(--bs-warning-text-emphasis);
      background: var(--bs-warning-bg-subtle);
      border-color: rgba(var(--bs-warning-rgb), .18);
    }

    .admin-crm-status.info {
      color: var(--bs-info-text-emphasis);
      background: var(--bs-info-bg-subtle);
      border-color: rgba(var(--bs-info-rgb), .18);
    }

    .admin-crm-status.success {
      color: var(--bs-success-text-emphasis);
      background: var(--bs-success-bg-subtle);
      border-color: rgba(var(--bs-success-rgb), .18);
    }

    .admin-crm-status.primary {
      color: var(--bs-primary-text-emphasis);
      background: var(--bs-primary-bg-subtle);
      border-color: rgba(var(--bs-primary-rgb), .18);
    }

    .admin-crm-status.secondary {
      color: var(--bs-secondary-color);
      background: var(--bs-secondary-bg);
      border-color: rgba(var(--bs-secondary-rgb), .18);
    }

    .admin-crm-actions {
      display: flex;
      justify-content: flex-end;
    }

    .admin-crm-actions .btn {
      min-height: 2.65rem;
      border-radius: .85rem;
      padding: 0 .95rem;
      font-size: .82rem;
      font-weight: 800;
      white-space: nowrap;
    }

    .admin-crm-empty {
      padding: 2.4rem 1.4rem;
      text-align: center;
    }

    .admin-crm-pagination {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      flex-wrap: wrap;
      margin-top: 1rem;
    }

    .admin-crm-page-info {
      color: var(--crm-muted);
      font-size: .92rem;
      font-weight: 700;
    }

    [data-bs-theme="dark"] .admin-crm-shell {
      --crm-border: rgba(255, 255, 255, 0.08);
      --crm-shadow: none;
      --crm-muted: #9aa6b8;
      --crm-heading: #f5f7fb;
      --crm-soft: #20262d;
      --crm-surface: #171c22;
    }

    [data-bs-theme="dark"] .admin-crm-row:hover td {
      background: rgba(255, 255, 255, 0.02);
    }

    @media (max-width: 991.98px) {
      .admin-crm-topbar {
        flex-direction: column;
        align-items: flex-start;
      }

      .admin-crm-table-card {
        overflow-x: auto;
      }

      .admin-crm-table {
        min-width: 760px;
      }
    }
  </style>
@endpush

@section('content')
@php
  $filters = [
    ['label' => 'Toutes', 'value' => ''],
    ['label' => 'À examiner', 'value' => \App\Models\FundingRequest::STATUS_PENDING],
    ['label' => 'À compléter', 'value' => \App\Models\FundingRequest::STATUS_AWAITING_DOCUMENTS],
    ['label' => 'À décider', 'value' => \App\Models\FundingRequest::STATUS_DOCUMENTS_RECEIVED],
    ['label' => 'Confirmés', 'value' => \App\Models\FundingRequest::STATUS_DONATION_ACT_SENT],
    ['label' => 'Archivés', 'value' => \App\Models\FundingRequest::STATUS_REFUSED],
    ['label' => 'Clôturés', 'value' => \App\Models\FundingRequest::STATUS_CLOSED],
  ];
@endphp

<div class="admin-crm-shell">
  <section class="admin-crm-header">
    <div class="admin-crm-topbar">
      <div>
        <h1 class="admin-crm-title">Demandes</h1>
        <p class="admin-crm-subtitle">Une version plus compacte, type CRM, pour parcourir beaucoup de dossiers rapidement et aller droit au bon dossier.</p>
      </div>

      <div class="admin-crm-meta">
        <span class="admin-crm-pill">{{ $requests->total() }} dossier{{ $requests->total() > 1 ? 's' : '' }}</span>
      </div>
    </div>

    <div class="admin-crm-meta">
      @foreach ($filters as $filter)
        <a
          href="{{ route('admin.funding-requests.index', array_filter(['status' => $filter['value']])) }}"
          class="admin-crm-pill {{ $status === $filter['value'] ? 'active' : '' }}">
          {{ $filter['label'] }}
        </a>
      @endforeach
    </div>
  </section>

  @if ($requests->count())
    <div class="admin-crm-table-card">
      <table class="table admin-crm-table">
        <thead>
          <tr>
            <th>Dossier</th>
            <th>Client</th>
            <th>Besoin</th>
            <th>Avancement</th>
            <th>Date</th>
            <th class="text-end">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($requests as $r)
            @php
              [$statusClass, $statusLabel] = match ($r->status) {
                \App\Models\FundingRequest::STATUS_PENDING => ['pending', 'À examiner'],
                \App\Models\FundingRequest::STATUS_PRELIMINARY_ACCEPTED,
                \App\Models\FundingRequest::STATUS_AWAITING_DOCUMENTS => ['info', 'À compléter'],
                \App\Models\FundingRequest::STATUS_DOCUMENTS_RECEIVED => ['success', 'À décider'],
                \App\Models\FundingRequest::STATUS_DONATION_ACT_SENT => ['primary', 'Confirmé'],
                \App\Models\FundingRequest::STATUS_REFUSED => ['secondary', 'Archivé'],
                \App\Models\FundingRequest::STATUS_CLOSED => ['secondary', 'Clôturé'],
                default => ['secondary', $r->status_label],
              };

              $clientName = trim((string) ($r->getRawOriginal('full_name') ?: $r->full_name ?: ''));
              $clientName = $clientName !== '' ? $clientName : 'Client non renseigne';
              $needLabel = $r->need_type ? (\App\Models\FundingRequest::needTypeLabels()[$r->need_type] ?? $r->need_type) : 'Besoin non précisé';
            @endphp

            <tr class="admin-crm-row">
              <td>
                <div class="admin-crm-number">{{ $r->dossier_number }}</div>
              </td>
              <td>
                <div class="admin-crm-client">{{ $clientName }}</div>
                <div class="admin-crm-sub">{{ $r->email }}</div>
              </td>
              <td>
                <div class="admin-crm-client">{{ $needLabel }}</div>
                <div class="admin-crm-sub">{{ $r->country ?: 'Pays non précisé' }}</div>
              </td>
              <td>
                <span class="admin-crm-status {{ $statusClass }}">{{ $statusLabel }}</span>
              </td>
              <td>
                <div class="admin-crm-client">{{ $r->created_at->format('d/m/Y') }}</div>
                <div class="admin-crm-sub">{{ $r->created_at->format('H:i') }}</div>
              </td>
              <td class="text-end">
                <div class="admin-crm-actions">
                  <a class="btn btn-outline-secondary" href="{{ route('admin.funding-requests.show', $r) }}">
                    Voir le dossier
                  </a>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @else
    <div class="admin-crm-empty">
      <h2 class="h5 mb-2">Aucune demande</h2>
      <p class="text-body-secondary mb-0">Aucun dossier à afficher dans cette vue pour le moment.</p>
    </div>
  @endif

  @if ($requests->hasPages())
    <div class="admin-crm-pagination">
      <div class="admin-crm-page-info">Page {{ $requests->currentPage() }} sur {{ $requests->lastPage() }}</div>
      <div>{{ $requests->onEachSide(1)->links() }}</div>
    </div>
  @endif
</div>
@endsection

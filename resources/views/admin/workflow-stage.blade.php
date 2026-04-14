@extends('layouts.admin')

@section('title', $stageConfig['title'].' — Administration')

@push('head')
  <style>
    .admin-stage-shell {
      --stage-border: rgba(15, 23, 42, 0.08);
      --stage-shadow: 0 18px 40px rgba(148, 163, 184, 0.16);
      --stage-muted: #6b7a90;
      --stage-heading: #172033;
      --stage-soft: #f5f7fb;
      --stage-surface: #ffffff;
    }

    .admin-stage-header,
    .admin-stage-card,
    .admin-stage-empty {
      border: 1px solid var(--stage-border);
      border-radius: 1.6rem;
      background: var(--stage-surface);
      box-shadow: var(--stage-shadow);
    }

    .admin-stage-header {
      padding: 1.3rem 1.4rem;
      margin-bottom: 1rem;
    }

    .admin-stage-topbar {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 1rem;
      flex-wrap: wrap;
      margin-bottom: .85rem;
    }

    .admin-stage-title {
      color: var(--stage-heading);
      font-size: clamp(1.45rem, 2vw, 1.9rem);
      font-weight: 800;
      margin-bottom: .35rem;
    }

    .admin-stage-subtitle {
      color: var(--stage-muted);
      font-size: .95rem;
      margin-bottom: 0;
      max-width: 42rem;
    }

    .admin-stage-actions {
      display: flex;
      align-items: center;
      gap: .7rem;
      flex-wrap: wrap;
    }

    .admin-stage-back {
      min-height: 2.9rem;
      border-radius: .9rem;
      padding: 0 1rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
    }

    .admin-stage-count {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 2rem;
      padding: .25rem .75rem;
      border-radius: 999px;
      background: rgba(15, 23, 42, 0.04);
      color: var(--stage-muted);
      font-size: .82rem;
      font-weight: 800;
    }

    .admin-stage-list {
      display: grid;
      gap: .85rem;
    }

    .admin-stage-card {
      padding: 1rem 1.1rem;
    }

    .admin-stage-grid {
      display: grid;
      grid-template-columns: minmax(11rem, 1fr) minmax(0, 1.4fr) minmax(10rem, .9fr) auto;
      gap: 1rem;
      align-items: center;
    }

    .admin-stage-label {
      color: var(--stage-muted);
      font-size: .72rem;
      text-transform: uppercase;
      letter-spacing: .05em;
      font-weight: 800;
      margin-bottom: .35rem;
    }

    .admin-stage-value {
      color: var(--stage-heading);
      font-size: .95rem;
      font-weight: 700;
      line-height: 1.3;
    }

    .admin-stage-note {
      color: var(--stage-muted);
      font-size: .84rem;
      margin-top: .2rem;
    }

    .admin-stage-buttons {
      display: flex;
      align-items: center;
      gap: .65rem;
      flex-wrap: wrap;
      justify-content: flex-end;
    }

    .admin-stage-buttons .btn {
      min-height: 2.75rem;
      border-radius: .85rem;
      padding: 0 .95rem;
      font-size: .84rem;
      font-weight: 800;
    }

    .admin-stage-empty {
      padding: 2.5rem 1.5rem;
      text-align: center;
    }

    .admin-stage-pagination {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      flex-wrap: wrap;
      margin-top: 1rem;
    }

    .admin-stage-page-info {
      color: var(--stage-muted);
      font-size: .92rem;
      font-weight: 700;
    }

    [data-bs-theme="dark"] .admin-stage-shell {
      --stage-border: rgba(255, 255, 255, 0.08);
      --stage-shadow: none;
      --stage-muted: #9aa6b8;
      --stage-heading: #f5f7fb;
      --stage-soft: #20262d;
      --stage-surface: #171c22;
    }

    @media (max-width: 991.98px) {
      .admin-stage-grid {
        grid-template-columns: 1fr;
      }

      .admin-stage-buttons {
        justify-content: flex-start;
      }
    }
  </style>
@endpush

@section('content')
<div class="admin-stage-shell">
  @if (session('ok'))
    <div class="alert alert-success mb-4">{{ session('ok') }}</div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger mb-4">
      <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <section class="admin-stage-header">
    <div class="admin-stage-topbar">
      <div>
        <h1 class="admin-stage-title">{{ $stageConfig['title'] }}</h1>
        <p class="admin-stage-subtitle">{{ $stageConfig['intro'] }}</p>
      </div>

      <div class="admin-stage-actions">
        <span class="admin-stage-count">{{ $requests->total() }} dossier{{ $requests->total() > 1 ? 's' : '' }}</span>
        <button type="button" class="btn btn-outline-secondary admin-stage-back" data-admin-back="{{ route('admin.dashboard') }}">
          Retour
        </button>
      </div>
    </div>
  </section>

  <div class="admin-stage-list">
    @forelse ($requests as $requestItem)
      @php
        $clientName = trim((string) ($requestItem->getRawOriginal('full_name') ?: $requestItem->full_name ?: ''));
        $clientName = $clientName !== '' ? $clientName : 'Client non renseigne';
        $needLabel = $requestItem->need_type ? (\App\Models\FundingRequest::needTypeLabels()[$requestItem->need_type] ?? $requestItem->need_type) : 'Besoin non précisé';
      @endphp

      <article class="admin-stage-card">
        <div class="admin-stage-grid">
          <div>
            <div class="admin-stage-label">Dossier</div>
            <div class="admin-stage-value">{{ $requestItem->dossier_number }}</div>
          </div>

          <div>
            <div class="admin-stage-label">Client</div>
            <div class="admin-stage-value">{{ $clientName }}</div>
            <div class="admin-stage-note">{{ $needLabel }}</div>
          </div>

          <div>
            <div class="admin-stage-label">Repère utile</div>
            <div class="admin-stage-value">{{ $requestItem->created_at->format('d/m/Y H:i') }}</div>
            <div class="admin-stage-note">{{ $requestItem->email }}</div>
          </div>

          <div class="admin-stage-buttons">
            @if ($stageConfig['primary_action'] === 'preliminary')
              <form method="post" action="{{ route('admin.funding-requests.preliminary', $requestItem) }}">
                @csrf
                <button type="submit" class="btn btn-primary">Valider la demande</button>
              </form>
            @elseif ($stageConfig['primary_action'] === 'send_act')
              <form method="post" action="{{ route('admin.funding-requests.send-act', $requestItem) }}">
                @csrf
                <button type="submit" class="btn btn-primary">Accorder le don</button>
              </form>
            @elseif ($stageConfig['primary_action'] === 'close')
              <form method="post" action="{{ route('admin.funding-requests.close', $requestItem) }}">
                @csrf
                <button type="submit" class="btn btn-primary">Clôturer la demande</button>
              </form>
            @endif

            <a class="btn btn-outline-secondary" href="{{ route('admin.funding-requests.show', $requestItem) }}">
              Ouvrir le dossier
            </a>
          </div>
        </div>
      </article>
    @empty
      <div class="admin-stage-empty">
        <h2 class="h5 mb-2">{{ $stageConfig['title'] }}</h2>
        <p class="text-body-secondary mb-0">{{ $stageConfig['empty'] }}</p>
      </div>
    @endforelse
  </div>

  @if ($requests->hasPages())
    <div class="admin-stage-pagination">
      <div class="admin-stage-page-info">Page {{ $requests->currentPage() }} sur {{ $requests->lastPage() }}</div>
      <div>{{ $requests->onEachSide(1)->links() }}</div>
    </div>
  @endif
</div>

@push('vendor-scripts')
<script>
document.addEventListener('click', function (event) {
  var btn = event.target.closest('[data-admin-back]');
  if (!btn) return;
  event.preventDefault();
  if (window.history.length > 1) {
    window.history.back();
    return;
  }
  window.location.href = btn.getAttribute('data-admin-back');
});
</script>
@endpush
@endsection

@extends('layouts.admin')

@section('title', 'Notifications e-mail — Administration')

@push('head')
  <style>
    .admin-mail-shell {
      --mail-border: rgba(15, 23, 42, 0.08);
      --mail-shadow: 0 18px 40px rgba(148, 163, 184, 0.16);
      --mail-muted: #6b7a90;
      --mail-heading: #172033;
      --mail-soft: #f5f7fb;
      --mail-surface: #ffffff;
      --mail-accent: #A87400;
      --mail-danger: #b42318;
      --mail-success: #067647;
    }

    .admin-mail-header,
    .admin-mail-table-card,
    .admin-mail-empty {
      border: 1px solid var(--mail-border);
      border-radius: 1.25rem;
      background: var(--mail-surface);
      box-shadow: var(--mail-shadow);
    }

    .admin-mail-header {
      padding: 1.35rem 1.4rem;
      margin-bottom: 1rem;
    }

    .admin-mail-top {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .admin-mail-title {
      color: var(--mail-heading);
      font-size: clamp(1.6rem, 2vw, 2rem);
      font-weight: 800;
      margin-bottom: .35rem;
    }

    .admin-mail-subtitle {
      color: var(--mail-muted);
      font-size: .94rem;
      max-width: 44rem;
      margin-bottom: 0;
    }

    .admin-mail-tabs {
      display: flex;
      gap: .45rem;
      flex-wrap: wrap;
      margin-top: 1.1rem;
    }

    .admin-mail-tab {
      display: inline-flex;
      align-items: center;
      min-height: 2.35rem;
      gap: .45rem;
      padding: .35rem .8rem;
      border-radius: 999px;
      background: var(--mail-soft);
      color: var(--mail-heading);
      font-size: .84rem;
      font-weight: 800;
      text-decoration: none;
    }

    .admin-mail-tab.active {
      background: rgba(255, 180, 0, 0.16);
      color: var(--mail-accent);
    }

    .admin-mail-count {
      min-width: 1.6rem;
      height: 1.6rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 999px;
      background: rgba(15, 23, 42, 0.08);
      font-size: .74rem;
      padding: 0 .45rem;
    }

    .admin-mail-table-card {
      overflow: hidden;
    }

    .admin-mail-table {
      margin-bottom: 0;
    }

    .admin-mail-table thead th {
      color: var(--mail-muted);
      font-size: .72rem;
      text-transform: uppercase;
      letter-spacing: .05em;
      font-weight: 800;
      border-bottom-color: rgba(148, 163, 184, 0.14);
      padding: 1rem 1.1rem;
      white-space: nowrap;
    }

    .admin-mail-table tbody td {
      padding: 1rem 1.1rem;
      vertical-align: middle;
      border-bottom-color: rgba(148, 163, 184, 0.12);
    }

    .admin-mail-table tbody tr:last-child td {
      border-bottom: 0;
    }

    .admin-mail-status {
      display: inline-flex;
      align-items: center;
      gap: .35rem;
      min-height: 1.9rem;
      padding: .25rem .65rem;
      border-radius: 999px;
      font-size: .76rem;
      font-weight: 800;
      white-space: nowrap;
    }

    .admin-mail-status.failed {
      background: rgba(244, 63, 94, 0.12);
      color: var(--mail-danger);
    }

    .admin-mail-status.sent {
      background: rgba(22, 163, 74, 0.12);
      color: var(--mail-success);
    }

    .admin-mail-status.pending {
      background: rgba(15, 23, 42, 0.08);
      color: var(--mail-muted);
    }

    .admin-mail-main {
      min-width: 14rem;
    }

    .admin-mail-name {
      color: var(--mail-heading);
      font-size: .94rem;
      font-weight: 800;
      margin-bottom: .2rem;
    }

    .admin-mail-sub {
      color: var(--mail-muted);
      font-size: .82rem;
      line-height: 1.45;
      word-break: break-word;
    }

    .admin-mail-link {
      color: var(--mail-heading);
      font-weight: 800;
      text-decoration: none;
    }

    .admin-mail-link:hover {
      text-decoration: underline;
    }

    .admin-mail-error {
      max-width: 24rem;
      color: var(--mail-muted);
      font-size: .82rem;
      line-height: 1.45;
      word-break: break-word;
    }

    .admin-mail-empty {
      padding: 2.7rem 1.4rem;
      text-align: center;
    }

    [data-bs-theme="dark"] .admin-mail-shell {
      --mail-border: rgba(255, 255, 255, 0.08);
      --mail-shadow: none;
      --mail-muted: #9aa6b8;
      --mail-heading: #f5f7fb;
      --mail-soft: #20262d;
      --mail-surface: #171c22;
    }

    [data-bs-theme="dark"] .admin-mail-count,
    [data-bs-theme="dark"] .admin-mail-status.pending {
      background: rgba(255, 255, 255, 0.08);
    }

    @media (max-width: 991.98px) {
      .admin-mail-table-card {
        overflow-x: auto;
      }

      .admin-mail-table {
        min-width: 920px;
      }
    }
  </style>
@endpush

@section('content')
<div class="admin-mail-shell">
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

  <section class="admin-mail-header">
    <div class="admin-mail-top">
      <div>
        <h1 class="admin-mail-title">Notifications e-mail</h1>
        <p class="admin-mail-subtitle">Suivez les e-mails envoyés par le site et relancez rapidement ceux qui ont échoué.</p>
      </div>
      <a href="{{ route('admin.smtp.edit') }}" class="btn btn-sm btn-outline-primary">
        <i class="ai-at me-2"></i>
        SMTP
      </a>
    </div>

    <div class="admin-mail-tabs">
      <a class="admin-mail-tab {{ $status === \App\Models\EmailNotification::STATUS_FAILED ? 'active' : '' }}" href="{{ route('admin.email-notifications.index', ['status' => \App\Models\EmailNotification::STATUS_FAILED]) }}">
        Échoués
        <span class="admin-mail-count">{{ $counts[\App\Models\EmailNotification::STATUS_FAILED] }}</span>
      </a>
      <a class="admin-mail-tab {{ $status === \App\Models\EmailNotification::STATUS_SENT ? 'active' : '' }}" href="{{ route('admin.email-notifications.index', ['status' => \App\Models\EmailNotification::STATUS_SENT]) }}">
        Envoyés
        <span class="admin-mail-count">{{ $counts[\App\Models\EmailNotification::STATUS_SENT] }}</span>
      </a>
      <a class="admin-mail-tab {{ $status === 'all' ? 'active' : '' }}" href="{{ route('admin.email-notifications.index', ['status' => 'all']) }}">
        Tous
        <span class="admin-mail-count">{{ $counts['all'] }}</span>
      </a>
    </div>
  </section>

  @if ($notifications->count() > 0)
    <section class="admin-mail-table-card">
      <div class="table-responsive">
        <table class="table admin-mail-table align-middle">
          <thead>
            <tr>
              <th>Statut</th>
              <th>E-mail</th>
              <th>Dossier</th>
              <th>Dernier essai</th>
              <th>Erreur</th>
              <th class="text-end">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($notifications as $notification)
              <tr>
                <td>
                  <span class="admin-mail-status {{ $notification->statusClass() }}">
                    {{ $notification->statusLabel() }}
                  </span>
                </td>
                <td>
                  <div class="admin-mail-main">
                    <div class="admin-mail-name">{{ $notification->mailLabel() }}</div>
                    <div class="admin-mail-sub">
                      {{ $notification->recipientLabel() }} · {{ $notification->recipient_email }}
                      @if ($notification->subject)
                        <br>{{ $notification->subject }}
                      @endif
                    </div>
                  </div>
                </td>
                <td>
                  @if ($notification->fundingRequest)
                    <a class="admin-mail-link" href="{{ route('admin.funding-requests.show', $notification->fundingRequest) }}">
                      {{ $notification->fundingRequest->dossier_number }}
                    </a>
                    <div class="admin-mail-sub">{{ $notification->fundingRequest->full_name }}</div>
                  @else
                    <span class="admin-mail-sub">Dossier supprimé</span>
                  @endif
                </td>
                <td>
                  <div class="admin-mail-sub">
                    {{ $notification->last_attempt_at?->format('d/m/Y H:i') ?? $notification->created_at?->format('d/m/Y H:i') }}
                    <br>{{ $notification->attempts }} essai{{ $notification->attempts > 1 ? 's' : '' }}
                  </div>
                </td>
                <td>
                  <div class="admin-mail-error">
                    {{ $notification->last_error ?: '—' }}
                  </div>
                </td>
                <td class="text-end">
                  @if ($notification->status === \App\Models\EmailNotification::STATUS_FAILED)
                    <form method="post" action="{{ route('admin.email-notifications.retry', $notification) }}" onsubmit="return confirm('Renvoyer cet e-mail maintenant ?');">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ai-refresh me-2"></i>
                        Renvoyer
                      </button>
                    </form>
                  @else
                    <span class="admin-mail-sub">—</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </section>

    <div class="mt-4">
      {{ $notifications->links() }}
    </div>
  @else
    <section class="admin-mail-empty">
      <div class="h4 mb-2">Aucun e-mail à afficher</div>
      <p class="text-body-secondary mb-0">Quand un envoi échoue, il apparaîtra ici avec le bouton de renvoi.</p>
    </section>
  @endif
</div>
@endsection

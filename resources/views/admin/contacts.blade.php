@extends('layouts.admin')

@section('title', 'Infos')

@push('head')
  <style>
    .admin-info-shell {
      --info-border: rgba(15, 23, 42, 0.08);
      --info-shadow: 0 18px 40px rgba(148, 163, 184, 0.16);
      --info-muted: #6b7a90;
      --info-heading: #172033;
      --info-surface: #ffffff;
    }

    .admin-info-header,
    .admin-info-table-card,
    .admin-info-empty {
      border: 1px solid var(--info-border);
      border-radius: 1.5rem;
      background: var(--info-surface);
      box-shadow: var(--info-shadow);
    }

    .admin-info-header {
      padding: 1.35rem 1.4rem;
      margin-bottom: 1rem;
    }

    .admin-info-title {
      color: var(--info-heading);
      font-size: clamp(1.6rem, 2vw, 2rem);
      font-weight: 800;
      margin-bottom: .35rem;
    }

    .admin-info-subtitle {
      color: var(--info-muted);
      font-size: .94rem;
      max-width: 42rem;
      margin-bottom: 0;
    }

    .admin-info-meta {
      display: flex;
      align-items: center;
      gap: .75rem;
      flex-wrap: wrap;
      margin-top: 1rem;
    }

    .admin-info-pill {
      display: inline-flex;
      align-items: center;
      min-height: 2.15rem;
      padding: .3rem .85rem;
      border-radius: 999px;
      background: rgba(15, 23, 42, 0.04);
      color: var(--info-muted);
      font-size: .82rem;
      font-weight: 800;
    }

    .admin-info-table-card {
      overflow: hidden;
    }

    .admin-info-table {
      margin-bottom: 0;
    }

    .admin-info-table thead th {
      color: var(--info-muted);
      font-size: .72rem;
      text-transform: uppercase;
      letter-spacing: .05em;
      font-weight: 800;
      border-bottom-color: rgba(148, 163, 184, 0.14);
      padding: 1rem 1.1rem;
      white-space: nowrap;
    }

    .admin-info-table tbody td {
      padding: 1rem 1.1rem;
      vertical-align: middle;
      border-bottom-color: rgba(148, 163, 184, 0.12);
    }

    .admin-info-table tbody tr:last-child td {
      border-bottom: 0;
    }

    .admin-info-name {
      color: var(--info-heading);
      font-size: .95rem;
      font-weight: 800;
      margin-bottom: .2rem;
    }

    .admin-info-sub {
      color: var(--info-muted);
      font-size: .82rem;
      line-height: 1.4;
    }

    .admin-info-link {
      color: var(--info-heading);
      font-weight: 700;
      text-decoration: none;
    }

    .admin-info-link:hover {
      text-decoration: underline;
    }

    .admin-info-empty {
      padding: 2.5rem 1.4rem;
      text-align: center;
    }

    [data-bs-theme="dark"] .admin-info-shell {
      --info-border: rgba(255, 255, 255, 0.08);
      --info-shadow: none;
      --info-muted: #9aa6b8;
      --info-heading: #f5f7fb;
      --info-surface: #171c22;
    }

    @media (max-width: 991.98px) {
      .admin-info-table-card {
        overflow-x: auto;
      }

      .admin-info-table {
        min-width: 760px;
      }
    }
  </style>
@endpush

@section('content')
<div class="admin-info-shell">
  <section class="admin-info-header">
    <h1 class="admin-info-title">Infos</h1>
    <p class="admin-info-subtitle">Retrouvez les coordonnees essentielles des personnes ayant soumis un dossier et exportez-les facilement.</p>

    <div class="admin-info-meta">
      <span class="admin-info-pill">{{ number_format($contacts->total(), 0, ',', ' ') }} contacts</span>
      <a href="{{ route('admin.contacts.export') }}" class="btn btn-sm btn-outline-primary">
        <i class="ai-download me-2"></i>
        Exporter les donnees
      </a>
    </div>
  </section>

  @if ($contacts->count() > 0)
    <section class="admin-info-table-card">
      <div class="table-responsive">
        <table class="table admin-info-table align-middle">
          <thead>
            <tr>
              <th>Nom complet</th>
              <th>E-mail</th>
              <th>Téléphone</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($contacts as $contact)
              @php
                $phoneDisplay = trim(implode(' ', array_filter([
                  trim((string) $contact->phone_prefix),
                  trim((string) $contact->phone),
                ])));
              @endphp
              <tr>
                <td>
                  <div class="admin-info-name">{{ $contact->full_name ?: 'Sans nom' }}</div>
                </td>
                <td>
                  @if ($contact->email)
                    <a href="mailto:{{ $contact->email }}" class="admin-info-link">{{ $contact->email }}</a>
                  @else
                    <span class="admin-info-sub">Non renseigné</span>
                  @endif
                </td>
                <td>
                  @if ($phoneDisplay !== '')
                    <a href="tel:{{ preg_replace('/\s+/', '', $phoneDisplay) }}" class="admin-info-link">{{ $phoneDisplay }}</a>
                  @else
                    <span class="admin-info-sub">Non renseigné</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </section>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-3">
      <div class="text-body-secondary small">
        Affichage de {{ $contacts->firstItem() }} à {{ $contacts->lastItem() }} sur {{ $contacts->total() }} contacts
      </div>
      {{ $contacts->links() }}
    </div>
  @else
    <section class="admin-info-empty">
      <h2 class="h5 mb-2">Aucune info disponible</h2>
      <p class="text-body-secondary mb-0">Les coordonnees des demandeurs apparaitront ici des qu’au moins un dossier aura ete soumis.</p>
    </section>
  @endif
</div>
@endsection

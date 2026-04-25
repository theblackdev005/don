@extends('layouts.admin')

@section('title', 'Base de données — Administration')

@push('head')
  <style>
    .admin-db-shell {
      --db-border: rgba(15, 23, 42, 0.08);
      --db-shadow: 0 18px 40px rgba(148, 163, 184, 0.16);
      --db-muted: #6b7a90;
      --db-heading: #172033;
      --db-soft: #f5f7fb;
      --db-surface: #ffffff;
      --db-accent: #A87400;
    }

    .admin-db-header,
    .admin-db-card {
      border: 1px solid var(--db-border);
      border-radius: 1.25rem;
      background: var(--db-surface);
      box-shadow: var(--db-shadow);
    }

    .admin-db-header {
      padding: 1.3rem 1.4rem;
      margin-bottom: 1rem;
    }

    .admin-db-top {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .admin-db-title {
      color: var(--db-heading);
      font-size: clamp(1.6rem, 2vw, 2rem);
      font-weight: 800;
      margin-bottom: .35rem;
    }

    .admin-db-subtitle {
      color: var(--db-muted);
      font-size: .94rem;
      max-width: 42rem;
      margin-bottom: 0;
    }

    .admin-db-summary {
      display: flex;
      align-items: center;
      gap: .55rem;
      flex-wrap: wrap;
    }

    .admin-db-pill {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 2.15rem;
      padding: .3rem .8rem;
      border-radius: 999px;
      background: var(--db-soft);
      color: var(--db-heading);
      font-size: .8rem;
      font-weight: 800;
      white-space: nowrap;
    }

    .admin-db-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: .85rem;
    }

    .admin-db-card {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      padding: 1rem;
      text-decoration: none;
      transition: transform .18s ease, border-color .18s ease, background .18s ease;
    }

    .admin-db-card:hover {
      transform: translateY(-1px);
      border-color: rgba(168, 116, 0, 0.24);
      background: linear-gradient(180deg, rgba(255, 180, 0, 0.05) 0%, var(--db-surface) 100%);
    }

    .admin-db-card-main {
      display: flex;
      align-items: center;
      gap: .85rem;
      min-width: 0;
    }

    .admin-db-icon {
      width: 2.7rem;
      height: 2.7rem;
      border-radius: .95rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      flex: 0 0 auto;
      background: rgba(255, 180, 0, 0.13);
      color: var(--db-accent);
      font-size: 1.1rem;
    }

    .admin-db-name {
      color: var(--db-heading);
      font-size: .98rem;
      font-weight: 800;
      line-height: 1.25;
      word-break: break-word;
    }

    .admin-db-meta {
      color: var(--db-muted);
      font-size: .82rem;
      margin-top: .2rem;
    }

    .admin-db-arrow {
      color: var(--db-muted);
      font-size: 1.1rem;
      flex: 0 0 auto;
    }

    [data-bs-theme="dark"] .admin-db-shell {
      --db-border: rgba(255, 255, 255, 0.08);
      --db-shadow: none;
      --db-muted: #9aa6b8;
      --db-heading: #f5f7fb;
      --db-soft: #20262d;
      --db-surface: #171c22;
    }

    @media (max-width: 991.98px) {
      .admin-db-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
@endpush

@section('content')
<div class="admin-db-shell">
  @if (session('ok'))
    <div class="alert alert-success mb-4">{{ session('ok') }}</div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger mb-4">
      <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <section class="admin-db-header">
    <div class="admin-db-top">
      <div>
        <h1 class="admin-db-title">Base de données</h1>
        <p class="admin-db-subtitle">Tables de l’application accessibles depuis l’administration.</p>
      </div>
      <div class="admin-db-summary">
        <span class="admin-db-pill">{{ $tables->count() }} table{{ $tables->count() > 1 ? 's' : '' }}</span>
      </div>
    </div>
  </section>

  <div class="admin-db-grid">
    @foreach ($tables as $table)
      <a class="admin-db-card" href="{{ route('admin.database.table', ['table' => $table['name']]) }}">
        <div class="admin-db-card-main">
          <span class="admin-db-icon"><i class="ai-database"></i></span>
          <span class="min-w-0">
            <span class="admin-db-name">{{ $table['name'] }}</span>
            <span class="admin-db-meta d-block">
              {{ $table['rows'] ?? '—' }} ligne{{ ($table['rows'] ?? 0) > 1 ? 's' : '' }} · {{ $table['columns'] }} colonne{{ $table['columns'] > 1 ? 's' : '' }}
              @if ($table['primary_key'])
                · clé {{ $table['primary_key'] }}
              @endif
            </span>
          </span>
        </div>
        <span class="admin-db-arrow"><i class="ai-chevron-right"></i></span>
      </a>
    @endforeach
  </div>
</div>
@endsection

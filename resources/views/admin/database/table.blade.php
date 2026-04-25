@extends('layouts.admin')

@section('title', 'Table '.$table.' — Base de données')

@php
  $columnCollection = collect($columns);
  $preferredColumnNames = collect([
      $primaryKey,
      'dossier_number',
      'full_name',
      'name',
      'email',
      'phone',
      'status',
      'amount_requested',
      'created_at',
      'updated_at',
  ])->filter()->unique();

  $visibleColumnNames = $preferredColumnNames
      ->filter(fn ($name) => in_array($name, $columnNames, true))
      ->merge($columnCollection->pluck('name'))
      ->unique()
      ->take(7)
      ->values();

  $visibleColumns = $visibleColumnNames
      ->map(fn ($name) => $columnCollection->firstWhere('name', $name))
      ->filter()
      ->values();

  $hiddenColumnCount = max(0, count($columns) - $visibleColumns->count());

  $formatValue = function ($value, int $limit = 92) {
      if ($value === null) {
          return null;
      }

      if (is_bool($value)) {
          return $value ? '1' : '0';
      }

      if (is_array($value) || is_object($value)) {
          $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
      }

      return \Illuminate\Support\Str::limit((string) $value, $limit);
  };

  $inputValue = function ($value) {
      if ($value === null) {
          return '';
      }

      if (is_bool($value)) {
          return $value ? '1' : '0';
      }

      if (is_array($value) || is_object($value)) {
          return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
      }

      return (string) $value;
  };

  $usesTextarea = function (array $column, $value = null) {
      $type = strtolower((string) ($column['type'] ?? ''));
      $stringValue = $value === null ? '' : (string) $value;

      return str_contains($type, 'text')
          || str_contains($type, 'json')
          || str_contains($type, 'blob')
          || strlen($stringValue) > 160;
  };
@endphp

@push('head')
  <style>
    .admin-db-detail {
      --db-border: rgba(15, 23, 42, 0.08);
      --db-shadow: 0 18px 40px rgba(148, 163, 184, 0.16);
      --db-muted: #6b7a90;
      --db-heading: #172033;
      --db-soft: #f5f7fb;
      --db-surface: #ffffff;
      --db-accent: #A87400;
    }

    .admin-db-header,
    .admin-db-panel,
    .admin-db-empty {
      border: 1px solid var(--db-border);
      border-radius: 1.25rem;
      background: var(--db-surface);
      box-shadow: var(--db-shadow);
    }

    .admin-db-header {
      padding: 1.25rem 1.35rem;
      margin-bottom: 1rem;
    }

    .admin-db-topbar {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 1rem;
      flex-wrap: wrap;
      margin-bottom: 1rem;
    }

    .admin-db-title {
      color: var(--db-heading);
      font-size: clamp(1.45rem, 2vw, 1.9rem);
      font-weight: 800;
      margin-bottom: .35rem;
      word-break: break-word;
    }

    .admin-db-subtitle,
    .admin-db-muted {
      color: var(--db-muted);
      font-size: .88rem;
    }

    .admin-db-actions-top {
      display: flex;
      align-items: center;
      gap: .6rem;
      flex-wrap: wrap;
    }

    .admin-db-actions-top .btn,
    .admin-db-toolbar .btn {
      min-height: 2.8rem;
      border-radius: .85rem;
      font-weight: 800;
    }

    .admin-db-toolbar {
      display: grid;
      grid-template-columns: 1fr auto;
      gap: .75rem;
      align-items: end;
    }

    .admin-db-toolbar .form-control {
      min-height: 2.8rem;
      border-radius: .85rem;
    }

    .admin-db-panel {
      overflow: hidden;
      margin-bottom: 1rem;
    }

    .admin-db-panel-head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: .75rem;
      flex-wrap: wrap;
      padding: .85rem 1rem;
      border-bottom: 1px solid rgba(148, 163, 184, 0.14);
      background: rgba(15, 23, 42, 0.015);
    }

    .admin-db-pill {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 2rem;
      padding: .25rem .72rem;
      border-radius: 999px;
      background: var(--db-soft);
      color: var(--db-heading);
      font-size: .8rem;
      font-weight: 800;
      white-space: nowrap;
    }

    .admin-db-table-wrap {
      overflow-x: auto;
    }

    .admin-db-table {
      min-width: 860px;
      margin-bottom: 0;
    }

    .admin-db-table thead th {
      color: var(--db-muted);
      font-size: .71rem;
      text-transform: uppercase;
      letter-spacing: .05em;
      font-weight: 800;
      border-bottom-color: rgba(148, 163, 184, 0.14);
      padding: .85rem 1rem;
      white-space: nowrap;
    }

    .admin-db-table thead a {
      color: inherit;
      text-decoration: none;
    }

    .admin-db-table tbody td {
      padding: .9rem 1rem;
      vertical-align: middle;
      border-bottom-color: rgba(148, 163, 184, 0.12);
      max-width: 15rem;
    }

    .admin-db-table tbody tr:last-child td {
      border-bottom: 0;
    }

    .admin-db-value {
      color: var(--db-heading);
      font-size: .87rem;
      white-space: pre-wrap;
      word-break: break-word;
    }

    .admin-db-null {
      color: var(--db-muted);
      font-size: .78rem;
      font-weight: 800;
    }

    .admin-db-actions {
      display: flex;
      align-items: center;
      justify-content: flex-end;
      gap: .45rem;
      min-width: 10rem;
    }

    .admin-db-actions .btn {
      min-height: 2.35rem;
      border-radius: .75rem;
      padding: 0 .75rem;
      font-size: .78rem;
      font-weight: 800;
      white-space: nowrap;
    }

    .admin-db-empty {
      padding: 2rem 1.4rem;
      text-align: center;
    }

    .admin-db-pagination {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      flex-wrap: wrap;
      margin-top: 1rem;
    }

    .admin-db-modal .modal-content {
      border-radius: 1rem;
      overflow: hidden;
    }

    .admin-db-form-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: .85rem;
    }

    .admin-db-field-meta {
      color: var(--db-muted);
      font-size: .75rem;
      margin-top: .25rem;
    }

    .admin-db-modal .form-control {
      border-radius: .85rem;
    }

    .admin-db-modal textarea.form-control {
      min-height: 6rem;
      resize: vertical;
    }

    [data-bs-theme="dark"] .admin-db-detail {
      --db-border: rgba(255, 255, 255, 0.08);
      --db-shadow: none;
      --db-muted: #9aa6b8;
      --db-heading: #f5f7fb;
      --db-soft: #20262d;
      --db-surface: #171c22;
    }

    [data-bs-theme="dark"] .admin-db-panel-head {
      background: rgba(255, 255, 255, 0.02);
    }

    @media (max-width: 767.98px) {
      .admin-db-toolbar,
      .admin-db-form-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
@endpush

@section('content')
<div class="admin-db-detail">
  @if (session('ok'))
    <div class="alert alert-success mb-4">{{ session('ok') }}</div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger mb-4">
      <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <section class="admin-db-header">
    <div class="admin-db-topbar">
      <div>
        <div class="admin-db-muted mb-2">
          <a href="{{ route('admin.database.index') }}" class="text-decoration-none text-body-secondary">Base de données</a>
          <span class="mx-1">/</span>
          <span>{{ $table }}</span>
        </div>
        <h1 class="admin-db-title">{{ $table }}</h1>
        <p class="admin-db-subtitle mb-0">{{ $rows->total() }} ligne{{ $rows->total() > 1 ? 's' : '' }} · {{ count($columns) }} colonne{{ count($columns) > 1 ? 's' : '' }}</p>
      </div>

      <div class="admin-db-actions-top">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adminDbCreateModal">
          <i class="ai-plus me-1"></i>
          Ajouter
        </button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.database.index') }}">Tables</a>
      </div>
    </div>

    <form method="get" action="{{ route('admin.database.table', ['table' => $table]) }}" class="admin-db-toolbar">
      <div>
        <label class="form-label" for="db-search">Recherche</label>
        <input id="db-search" type="search" class="form-control" name="q" value="{{ $search }}" placeholder="Nom, e-mail, statut, référence...">
      </div>
      <button class="btn btn-outline-secondary" type="submit">Filtrer</button>
    </form>
  </section>

  <div class="admin-db-panel">
    <div class="admin-db-panel-head">
      <span class="admin-db-pill">Vue compacte</span>
      @if ($hiddenColumnCount > 0)
        <span class="admin-db-muted">{{ $hiddenColumnCount }} colonne{{ $hiddenColumnCount > 1 ? 's' : '' }} en édition</span>
      @endif
    </div>

    @if ($rows->count())
      <div class="admin-db-table-wrap">
        <table class="table admin-db-table">
          <thead>
            <tr>
              @foreach ($visibleColumns as $column)
                <th>
                  <a href="{{ route('admin.database.table', array_filter(['table' => $table, 'q' => $search, 'sort' => $column['name'], 'direction' => $sort === $column['name'] && $direction === 'asc' ? 'desc' : 'asc'], fn ($value) => $value !== null && $value !== '')) }}">
                    {{ $column['name'] }}
                    @if ($primaryKey === $column['name'])
                      <span class="text-primary">PK</span>
                    @endif
                  </a>
                </th>
              @endforeach
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($rows as $row)
              @php
                $rowArray = (array) $row;
                $record = $primaryKey ? (string) ($rowArray[$primaryKey] ?? '') : '';
                $modalId = 'edit-db-row-'.md5($table.'-'.$record.'-'.$loop->index);
              @endphp
              <tr>
                @foreach ($visibleColumns as $column)
                  @php
                    $columnName = $column['name'];
                    $rawValue = $rowArray[$columnName] ?? null;
                    $displayValue = $formatValue($rawValue);
                  @endphp
                  <td>
                    @if ($displayValue === null)
                      <span class="admin-db-null">NULL</span>
                    @else
                      <div class="admin-db-value">{{ $displayValue }}</div>
                    @endif
                  </td>
                @endforeach
                <td>
                  <div class="admin-db-actions">
                    @if ($primaryKey)
                      <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
                        Modifier
                      </button>
                      <form method="post" action="{{ route('admin.database.destroy', ['table' => $table, 'record' => $record]) }}" onsubmit="return confirm('Supprimer définitivement cette ligne ?');">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-outline-danger">Supprimer</button>
                      </form>
                    @else
                      <span class="admin-db-muted">Pas de clé primaire</span>
                    @endif
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      @if ($primaryKey)
        @foreach ($rows as $row)
          @php
            $rowArray = (array) $row;
            $record = (string) ($rowArray[$primaryKey] ?? '');
            $modalId = 'edit-db-row-'.md5($table.'-'.$record.'-'.$loop->index);
          @endphp
          <div class="modal fade admin-db-modal" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content">
                <form method="post" action="{{ route('admin.database.update', ['table' => $table, 'record' => $record]) }}">
                  @csrf
                  @method('put')
                  <div class="modal-header">
                    <h2 class="modal-title fs-5 fw-bold">Modifier {{ $table }} #{{ $record }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                  </div>
                  <div class="modal-body">
                    <div class="admin-db-form-grid">
                      @foreach ($columns as $column)
                        @php
                          $columnName = $column['name'];
                          $rawValue = $rowArray[$columnName] ?? null;
                          $readonly = $primaryKey === $columnName;
                        @endphp
                        <div>
                          <label class="form-label" for="{{ $modalId }}-{{ $columnName }}">{{ $columnName }}</label>
                          @if ($usesTextarea($column, $rawValue))
                            <textarea class="form-control" id="{{ $modalId }}-{{ $columnName }}" name="values[{{ $columnName }}]" @readonly($readonly)>{{ $inputValue($rawValue) }}</textarea>
                          @else
                            <input class="form-control" id="{{ $modalId }}-{{ $columnName }}" name="values[{{ $columnName }}]" value="{{ $inputValue($rawValue) }}" @readonly($readonly)>
                          @endif
                          <div class="admin-db-field-meta">{{ $column['type'] }}{{ $column['nullable'] ? ' · nullable' : '' }}{{ $readonly ? ' · clé primaire' : '' }}</div>
                        </div>
                      @endforeach
                    </div>
                  </div>
                  <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      @endif
    @else
      <div class="admin-db-empty">
        <h2 class="h5 mb-2">Aucune ligne</h2>
        <p class="text-body-secondary mb-0">Aucun résultat pour cette table.</p>
      </div>
    @endif
  </div>

  @if ($rows->hasPages())
    <div class="admin-db-pagination">
      <div class="admin-db-muted">Page {{ $rows->currentPage() }} sur {{ $rows->lastPage() }}</div>
      <div>{{ $rows->onEachSide(1)->links() }}</div>
    </div>
  @endif

  <div class="modal fade admin-db-modal" id="adminDbCreateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <form method="post" action="{{ route('admin.database.store', ['table' => $table]) }}">
          @csrf
          <div class="modal-header">
            <h2 class="modal-title fs-5 fw-bold">Ajouter dans {{ $table }}</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <div class="admin-db-form-grid">
              @foreach ($columns as $column)
                @php
                  $columnName = $column['name'];
                  $skipAuto = (bool) ($column['auto_increment'] ?? false);
                @endphp
                <div>
                  <label class="form-label" for="create-{{ $columnName }}">{{ $columnName }}</label>
                  @if ($usesTextarea($column))
                    <textarea class="form-control" id="create-{{ $columnName }}" name="values[{{ $columnName }}]" @disabled($skipAuto)></textarea>
                  @else
                    <input class="form-control" id="create-{{ $columnName }}" name="values[{{ $columnName }}]" value="" @disabled($skipAuto)>
                  @endif
                  <div class="admin-db-field-meta">{{ $column['type'] }}{{ $column['nullable'] ? ' · nullable' : '' }}{{ $skipAuto ? ' · auto' : '' }}</div>
                </div>
              @endforeach
            </div>
          </div>
          <div class="modal-footer border-0">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary">Créer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

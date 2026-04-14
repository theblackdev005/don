@extends('layouts.form-minimal')

@section('title', config('site.name').' | '.__('pages.documents.title'))

@push('meta')
  @include('partials.meta-default')
@endpush

@push('head')
  <style>
    .documents-page {
      padding-top: clamp(1rem, 3vh, 2rem);
      padding-bottom: clamp(2rem, 5vh, 3rem);
    }

    .documents-shell {
      max-width: 58rem;
      margin: 0 auto;
    }

    .documents-title {
      color: var(--bs-heading-color);
      font-size: clamp(1.6rem, 3.5vw, 2.2rem);
      font-weight: 800;
      line-height: 1.1;
      margin-bottom: .4rem;
    }

    .documents-subtitle {
      margin: 0;
      color: var(--bs-secondary-color);
      font-size: .95rem;
      line-height: 1.55;
    }

    .documents-card {
      border: 1px solid rgba(15, 23, 42, 0.08);
      border-radius: 1.75rem;
      background: var(--bs-body-bg);
      box-shadow: 0 22px 50px rgba(148, 163, 184, 0.14);
      overflow: hidden;
    }

    .documents-card-head {
      padding: 1rem 1.1rem .9rem;
      border-bottom: 1px solid rgba(15, 23, 42, 0.08);
      background: rgba(248, 250, 252, 0.78);
    }

    .documents-card-body {
      padding: 1.1rem;
    }

    .documents-dossier-label {
      color: var(--bs-secondary-color);
      font-size: .78rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: .05em;
      margin-bottom: .45rem;
    }

    .documents-dossier-value {
      color: var(--bs-heading-color);
      font-size: 1.05rem;
      font-weight: 800;
      line-height: 1.2;
      margin-bottom: .2rem;
    }

    .documents-dossier-note {
      color: var(--bs-secondary-color);
      font-size: .95rem;
      margin-bottom: 0;
    }

    .documents-alert {
      border-radius: 1.1rem;
      border: 0;
      padding: 1rem 1.1rem;
    }

    .documents-help {
      border: 1px solid rgba(15, 23, 42, 0.08);
      border-radius: 1.1rem;
      background: rgba(248, 250, 252, 0.62);
      padding: .85rem .95rem;
      color: var(--bs-secondary-color);
      font-size: .9rem;
      line-height: 1.5;
      margin-bottom: .9rem;
    }

    .documents-form {
      display: grid;
      gap: 1rem;
    }

    .documents-block {
      border: 1px solid rgba(15, 23, 42, 0.08);
      border-radius: 1.25rem;
      background: rgba(248, 250, 252, 0.58);
      padding: .9rem;
    }

    .documents-block-title {
      color: var(--bs-heading-color);
      font-size: .95rem;
      font-weight: 800;
      margin-bottom: .55rem;
    }

    .documents-form .form-label {
      color: var(--bs-heading-color);
      font-weight: 700;
      margin-bottom: .45rem;
    }

    .documents-form .form-select,
    .documents-form .form-control {
      min-height: 3.1rem;
      border-radius: 1rem;
      border-color: rgba(148, 163, 184, 0.28);
      background: var(--bs-body-bg);
      box-shadow: none;
    }

    .documents-form .form-select:focus,
    .documents-form .form-control:focus {
      border-color: rgba(var(--bs-primary-rgb), .45);
      box-shadow: 0 0 0 .2rem rgba(var(--bs-primary-rgb), .10);
    }

    .documents-file-row + .documents-file-row {
      margin-top: .8rem;
      padding-top: .8rem;
      border-top: 1px solid rgba(15, 23, 42, 0.08);
    }

    .documents-state {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 2rem;
      padding: .35rem .8rem;
      border-radius: 999px;
      font-size: .8rem;
      font-weight: 800;
      margin-bottom: .55rem;
    }

    .documents-state.received {
      color: var(--bs-success-text-emphasis);
      background: var(--bs-success-bg-subtle);
    }

    .documents-state.missing {
      color: var(--bs-secondary-color);
      background: var(--bs-secondary-bg);
    }

    .documents-submit {
      display: flex;
      justify-content: flex-end;
      padding-top: 0;
    }

    .documents-submit .btn {
      min-height: 3rem;
      border-radius: 999px;
      padding-inline: 1.4rem;
      font-weight: 700;
    }

    [data-bs-theme="dark"] .documents-card,
    [data-bs-theme="dark"] .documents-block,
    [data-bs-theme="dark"] .documents-help,
    [data-bs-theme="dark"] .documents-card-head {
      border-color: rgba(255, 255, 255, 0.08);
      box-shadow: none;
    }

    [data-bs-theme="dark"] .documents-card-head,
    [data-bs-theme="dark"] .documents-block,
    [data-bs-theme="dark"] .documents-help {
      background: #171c22;
    }

    @media (max-width: 575.98px) {
      .documents-card-head,
      .documents-card-body {
        padding: 1rem;
      }

      .documents-submit {
        justify-content: stretch;
      }

      .documents-submit .btn {
        width: 100%;
      }
    }
  </style>
@endpush

@section('content')
<main class="page-wrapper">
  @include('partials.form-page-header')

  <section class="documents-page container">
    <div class="documents-shell">
      <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb mb-0 small">
          <li class="breadcrumb-item"><a href="{{ route('home', ['locale' => request()->route('locale')]) }}">{{ __('ui.nav.home') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('pages.documents.breadcrumb') }}</li>
        </ol>
      </nav>

      <div class="mb-3">
        <h1 class="documents-title">{{ __('pages.documents.heading') }}</h1>
        <p class="documents-subtitle">{{ __('pages.documents.accepted_formats') }}</p>
      </div>

      @php
        $identityType = old('identity_document_type', $fr->identity_document_type);
        $clientName = trim((string) ($fr->full_name ?? ''));
        $clientName = $clientName !== '' ? $clientName : 'Client';
      @endphp

      <div class="documents-card">
        <div class="documents-card-head">
          <div class="documents-dossier-label">{{ __('pages.documents.dossier_label') }}</div>
          <div class="documents-dossier-value">{{ $fr->dossier_number }}</div>
          <p class="documents-dossier-note">{{ $clientName }}</p>
        </div>

        <div class="documents-card-body">
          @if (session('ok'))
            <div class="alert alert-success documents-alert">{{ session('ok') }}</div>
          @endif
          @if ($errors->any())
            <div class="alert alert-danger documents-alert">
              <ul class="mb-0 ps-3 small">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
          @endif

          <div class="documents-help">
            <strong>{{ __('pages.documents.security_notice') }}</strong><br>
            {{ __('pages.documents.intro') }}
          </div>

          <form method="post" action="{{ route('funding-request.documents.store', ['locale' => request()->route('locale'), 'public_slug' => $fr->public_slug]) }}" enctype="multipart/form-data" class="documents-form">
            @csrf

            <div class="documents-block">
              <div class="documents-block-title">{{ __('pages.documents.identity_section') }}</div>
              <label class="form-label" for="identity_document_type">{{ __('pages.documents.identity_type') }} <span class="text-danger">*</span></label>
              <select name="identity_document_type" id="identity_document_type" class="form-select">
                <option value="" disabled @selected(! filled($identityType))>{{ __('pages.documents.identity_type') }}</option>
                <option value="{{ \App\Models\FundingRequest::IDENTITY_DOCUMENT_ID_CARD }}" @selected($identityType === \App\Models\FundingRequest::IDENTITY_DOCUMENT_ID_CARD)>{{ __('pages.documents.id_card') }}</option>
                <option value="{{ \App\Models\FundingRequest::IDENTITY_DOCUMENT_PASSPORT }}" @selected($identityType === \App\Models\FundingRequest::IDENTITY_DOCUMENT_PASSPORT)>{{ __('pages.documents.passport') }}</option>
              </select>
            </div>

            <div id="identity-passport-block" class="documents-block @if ($identityType !== \App\Models\FundingRequest::IDENTITY_DOCUMENT_PASSPORT) d-none @endif">
              <div class="documents-block-title">{{ __('pages.documents.identity_section') }}</div>
              <div class="documents-file-row">
                <span class="documents-state {{ $fr->doc_passport_path ? 'received' : 'missing' }}">
                  {{ $fr->doc_passport_path ? __('pages.documents.file_received') : __('pages.documents.file_missing') }}
                </span>
                <label class="form-label" for="doc_passport">{{ __('pages.documents.passport_file') }} @if (! $fr->doc_passport_path)<span class="text-danger">*</span>@endif</label>
                <input type="file" name="doc_passport" id="doc_passport" class="form-control" accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/jpeg,image/png">
              </div>
            </div>

            <div id="identity-card-block" class="documents-block @if ($identityType !== \App\Models\FundingRequest::IDENTITY_DOCUMENT_ID_CARD) d-none @endif">
              <div class="documents-block-title">{{ __('pages.documents.identity_section') }}</div>

              <div class="documents-file-row">
                <span class="documents-state {{ $fr->doc_id_front_path ? 'received' : 'missing' }}">
                  {{ $fr->doc_id_front_path ? __('pages.documents.file_received') : __('pages.documents.file_missing') }}
                </span>
                <label class="form-label" for="doc_id_front">{{ __('pages.documents.id_front') }} @if (! $fr->doc_id_front_path)<span class="text-danger">*</span>@endif</label>
                <input type="file" name="doc_id_front" id="doc_id_front" class="form-control" accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/jpeg,image/png">
              </div>

              <div class="documents-file-row">
                <span class="documents-state {{ $fr->doc_id_back_path ? 'received' : 'missing' }}">
                  {{ $fr->doc_id_back_path ? __('pages.documents.file_received') : __('pages.documents.file_missing') }}
                </span>
                <label class="form-label" for="doc_id_back">{{ __('pages.documents.id_back') }} @if (! $fr->doc_id_back_path)<span class="text-danger">*</span>@endif</label>
                <input type="file" name="doc_id_back" id="doc_id_back" class="form-control" accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/jpeg,image/png">
              </div>
            </div>

            <div class="documents-block">
              <div class="documents-block-title">{{ __('pages.documents.situation_doc') }}</div>
              <div class="documents-file-row">
                @if ($fr->doc_situation_path)
                  <span class="documents-state received">
                    {{ __('pages.documents.file_received') }}
                  </span>
                @endif
                <label class="form-label" for="doc_situation">{{ __('pages.documents.situation_file_label') }}</label>
                <input type="file" name="doc_situation" id="doc_situation" class="form-control" accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/jpeg,image/png">
                <p class="form-text small mb-0">{{ __('pages.documents.situation_help') }}</p>
              </div>
            </div>

            <div class="documents-submit">
              <button type="submit" class="btn btn-primary">{{ __('pages.documents.send') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</main>

@push('vendor-scripts')
<script>
(function () {
  var select = document.getElementById('identity_document_type');
  var passport = document.getElementById('identity-passport-block');
  var card = document.getElementById('identity-card-block');
  if (!select || !passport || !card) return;

  function sync() {
    var v = select.value;
    passport.classList.toggle('d-none', v !== 'passport');
    card.classList.toggle('d-none', v !== 'id_card');
  }

  select.addEventListener('change', sync);
  sync();
})();
</script>
@endpush
@endsection

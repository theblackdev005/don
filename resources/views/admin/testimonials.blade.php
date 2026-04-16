@extends('layouts.admin')

@section('title', 'Témoignages')

@push('head')
  <style>
    .admin-settings-card {
      border: 1px solid rgba(15, 23, 42, 0.08);
      border-radius: 1rem;
      background: var(--bs-body-bg);
      box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
    }

    .admin-settings-section-title {
      font-size: 1rem;
      font-weight: 700;
      color: var(--bs-heading-color);
      margin-bottom: 1rem;
    }

    .admin-settings-helper {
      color: var(--bs-secondary-color);
      font-size: .94rem;
      line-height: 1.65;
    }

    .admin-testimonial-card {
      border: 1px solid rgba(15, 23, 42, 0.08);
      border-radius: 1rem;
      padding: 1rem;
      background: rgba(255, 255, 255, 0.72);
    }

    .admin-testimonial-quote {
      min-height: 140px;
      resize: vertical;
    }

    .admin-locale-tabs .nav-link {
      border-radius: 999px;
      font-weight: 600;
    }

    [data-bs-theme="dark"] .admin-settings-card {
      background: #20262d;
      border-color: rgba(255, 255, 255, 0.08);
      box-shadow: none;
    }

    [data-bs-theme="dark"] .admin-testimonial-card {
      background: rgba(255, 255, 255, 0.02);
      border-color: rgba(255, 255, 255, 0.08);
    }
  </style>
@endpush

@section('content')
@if (session('ok'))
  <div class="alert alert-success mb-4">{{ session('ok') }}</div>
@endif

@if ($errors->any())
  <div class="alert alert-danger mb-4">
    <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
@endif

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
  <div>
    <h1 class="h2 mb-1">Témoignages</h1>
    <p class="text-body-secondary mb-0">Gérez les témoignages affichés sur la page d’accueil.</p>
  </div>
</div>

<div class="admin-settings-card p-4">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
    <div>
      <div class="admin-settings-section-title mb-1">Liste des témoignages</div>
      <p class="admin-settings-helper mb-0">Ajoutez, modifiez, désactivez ou supprimez les témoignages sans passer par la configuration générale. Si une traduction n’est pas renseignée, la version anglaise sera affichée sur le site.</p>
    </div>
  </div>

  <div class="row g-3">
    @forelse ($testimonials as $testimonial)
      <div class="col-12">
        @php
          $translationMap = $testimonial->translations->keyBy('locale');
        @endphp
        <div class="admin-testimonial-card">
          <form method="post" action="{{ route('admin.testimonials.update', $testimonial) }}">
            @csrf
            @method('put')
            <div class="row g-3">
              <div class="col-md-2">
                <label class="form-label">Ordre</label>
                <input type="number" name="sort_order" class="form-control" min="0" max="9999" value="{{ $testimonial->sort_order }}">
              </div>
              <div class="col-md-5">
                <div class="d-flex flex-wrap gap-3 pt-md-4">
                  <div class="form-check form-switch m-0">
                    <input type="hidden" name="is_active" value="0">
                    <input class="form-check-input" type="checkbox" name="is_active" id="testimonial-active-{{ $testimonial->id }}" value="1" @checked($testimonial->is_active)>
                    <label class="form-check-label" for="testimonial-active-{{ $testimonial->id }}">Visible sur le site</label>
                  </div>
                  <div class="form-check form-switch m-0">
                    <input type="hidden" name="is_anonymous" value="0">
                    <input class="form-check-input" type="checkbox" name="is_anonymous" id="testimonial-anonymous-{{ $testimonial->id }}" value="1" @checked($testimonial->is_anonymous)>
                    <label class="form-check-label" for="testimonial-anonymous-{{ $testimonial->id }}">Afficher en anonyme</label>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <ul class="nav nav-pills admin-locale-tabs gap-2 mb-3" role="tablist">
                  @foreach ($supportedLocales as $localeCode)
                    <li class="nav-item" role="presentation">
                      <button
                        class="nav-link {{ $localeCode === $primaryLocale ? 'active' : '' }}"
                        data-bs-toggle="pill"
                        data-bs-target="#testimonial-{{ $testimonial->id }}-{{ $localeCode }}"
                        type="button"
                        role="tab"
                      >
                        {{ $localeLabels[$localeCode] ?? strtoupper($localeCode) }}
                      </button>
                    </li>
                  @endforeach
                </ul>
                <div class="tab-content">
                  @foreach ($supportedLocales as $localeCode)
                    @php
                      $translation = $translationMap->get($localeCode);
                    @endphp
                    <div class="tab-pane fade {{ $localeCode === $primaryLocale ? 'show active' : '' }}" id="testimonial-{{ $testimonial->id }}-{{ $localeCode }}" role="tabpanel">
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label">Nom affiché @if ($localeCode === $primaryLocale)<span class="text-danger">*</span>@endif</label>
                          <input type="text" name="translations[{{ $localeCode }}][author_name]" class="form-control" value="{{ old("translations.$localeCode.author_name", $translation?->author_name) }}">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Rôle / titre</label>
                          <input type="text" name="translations[{{ $localeCode }}][role]" class="form-control" value="{{ old("translations.$localeCode.role", $translation?->role) }}">
                        </div>
                        <div class="col-12">
                          <label class="form-label">Témoignage @if ($localeCode === $primaryLocale)<span class="text-danger">*</span>@endif</label>
                          <textarea name="translations[{{ $localeCode }}][quote]" class="form-control admin-testimonial-quote" rows="5">{{ old("translations.$localeCode.quote", $translation?->quote) }}</textarea>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
              <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
              </div>
            </div>
          </form>
          <form class="mt-3" method="post" action="{{ route('admin.testimonials.destroy', $testimonial) }}" onsubmit="return confirm('Supprimer définitivement ce témoignage ?');">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-outline-danger btn-sm">Supprimer</button>
          </form>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="admin-testimonial-card">
          <p class="mb-0 text-body-secondary">Aucun témoignage enregistré pour le moment.</p>
        </div>
      </div>
    @endforelse
  </div>

  <div class="border-top mt-4 pt-4">
    <div class="admin-settings-section-title">Ajouter un témoignage</div>
    <form method="post" action="{{ route('admin.testimonials.store') }}">
      @csrf
      <div class="row g-3">
        <div class="col-md-2">
          <label class="form-label">Ordre</label>
          <input type="number" name="sort_order" class="form-control" min="0" max="9999" value="{{ old('sort_order', ($testimonials->max('sort_order') ?? 0) + 10) }}">
        </div>
        <div class="col-md-5">
          <div class="d-flex flex-wrap gap-3 pt-md-4">
            <div class="form-check form-switch m-0">
              <input type="hidden" name="is_active" value="0">
              <input class="form-check-input" type="checkbox" name="is_active" id="testimonial-create-active" value="1" @checked(old('is_active', true))>
              <label class="form-check-label" for="testimonial-create-active">Visible sur le site</label>
            </div>
            <div class="form-check form-switch m-0">
              <input type="hidden" name="is_anonymous" value="0">
              <input class="form-check-input" type="checkbox" name="is_anonymous" id="testimonial-create-anonymous" value="1" @checked(old('is_anonymous', false))>
              <label class="form-check-label" for="testimonial-create-anonymous">Afficher en anonyme</label>
            </div>
          </div>
        </div>
        <div class="col-12">
          <ul class="nav nav-pills admin-locale-tabs gap-2 mb-3" role="tablist">
            @foreach ($supportedLocales as $localeCode)
              <li class="nav-item" role="presentation">
                <button
                  class="nav-link {{ $localeCode === $primaryLocale ? 'active' : '' }}"
                  data-bs-toggle="pill"
                  data-bs-target="#testimonial-create-{{ $localeCode }}"
                  type="button"
                  role="tab"
                >
                  {{ $localeLabels[$localeCode] ?? strtoupper($localeCode) }}
                </button>
              </li>
            @endforeach
          </ul>
          <div class="tab-content">
            @foreach ($supportedLocales as $localeCode)
              <div class="tab-pane fade {{ $localeCode === $primaryLocale ? 'show active' : '' }}" id="testimonial-create-{{ $localeCode }}" role="tabpanel">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label">Nom affiché @if ($localeCode === $primaryLocale)<span class="text-danger">*</span>@endif</label>
                    <input type="text" name="translations[{{ $localeCode }}][author_name]" class="form-control" value="{{ old("translations.$localeCode.author_name") }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Rôle / titre</label>
                    <input type="text" name="translations[{{ $localeCode }}][role]" class="form-control" value="{{ old("translations.$localeCode.role") }}">
                  </div>
                  <div class="col-12">
                    <label class="form-label">Témoignage @if ($localeCode === $primaryLocale)<span class="text-danger">*</span>@endif</label>
                    <textarea name="translations[{{ $localeCode }}][quote]" class="form-control admin-testimonial-quote" rows="5">{{ old("translations.$localeCode.quote") }}</textarea>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
        <div class="col-12 d-flex justify-content-end">
          <button type="submit" class="btn btn-primary">Ajouter le témoignage</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

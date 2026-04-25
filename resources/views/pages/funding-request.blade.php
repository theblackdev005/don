@extends('layouts.form-minimal')

@section('title', __('funding.meta_title'))

@push('meta')
  @include('partials.meta-default')
@endpush

@push('head')
  <style>
    .funding-page {
      --funding-accent: #1f8f6b;
      --funding-accent-rgb: 31, 143, 107;
    }

    .funding-page {
      padding-top: clamp(1.5rem, 4vh, 3rem);
      padding-bottom: clamp(3rem, 6vh, 4.5rem);
    }

    .funding-shell {
      max-width: 54rem;
      margin: 0 auto;
    }

    .funding-intro {
      text-align: center;
      margin-bottom: 1.75rem;
    }

    .funding-title {
      color: var(--bs-heading-color);
      font-size: clamp(2rem, 4vw, 3rem);
      font-weight: 800;
      line-height: 1.04;
      margin-bottom: .85rem;
    }

    .funding-subtitle {
      max-width: 38rem;
      margin: 0 auto;
      color: var(--bs-secondary-color);
      font-size: 1rem;
      line-height: 1.7;
    }

    .funding-card {
      border: 1px solid rgba(15, 23, 42, 0.08);
      border-radius: 1.75rem;
      background: var(--bs-body-bg);
      box-shadow: 0 22px 50px rgba(148, 163, 184, 0.14);
      overflow: hidden;
    }

    .funding-card-head {
      padding: 1.25rem 1.25rem 1rem;
      border-bottom: 1px solid rgba(15, 23, 42, 0.08);
      background: rgba(248, 250, 252, 0.78);
    }

    .funding-steps {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: .75rem;
    }

    .funding-step {
      display: flex;
      align-items: center;
      gap: .7rem;
      padding: .75rem .85rem;
      border-radius: 1rem;
      border: 1px solid rgba(15, 23, 42, 0.08);
      background: rgba(255, 255, 255, 0.8);
      transition: border-color .2s ease, background .2s ease;
    }

    .funding-step.active {
      border-color: rgba(var(--funding-accent-rgb), .24);
      background: rgba(var(--funding-accent-rgb), .08);
      box-shadow: 0 10px 24px rgba(31, 143, 107, 0.08);
    }

    .funding-step-index {
      width: 2rem;
      height: 2rem;
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: rgba(15, 23, 42, 0.08);
      color: var(--bs-secondary-color);
      font-size: .9rem;
      font-weight: 800;
      flex: 0 0 auto;
    }

    .funding-step.active .funding-step-index {
      background: var(--funding-accent);
      color: #fff;
      box-shadow: 0 10px 18px rgba(31, 143, 107, 0.18);
    }

    .funding-step-text {
      color: var(--bs-heading-color);
      font-size: .92rem;
      font-weight: 700;
      line-height: 1.35;
    }

    .funding-card-body {
      padding: 1.25rem;
    }

    .funding-alert {
      border: 0;
      border-radius: 1.1rem;
      padding: 1rem 1.1rem;
    }

    .funding-panel {
      border: 1px solid rgba(15, 23, 42, 0.08);
      border-radius: 1.25rem;
      background: rgba(248, 250, 252, 0.55);
      padding: 1.1rem;
    }

    .funding-panel + .funding-panel {
      margin-top: 1rem;
    }

    .funding-panel-head {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 1rem;
      margin-bottom: 1rem;
      padding-bottom: .85rem;
      border-bottom: 1px solid rgba(15, 23, 42, 0.08);
    }

    .funding-panel-title {
      color: var(--bs-heading-color);
      font-size: 1.15rem;
      font-weight: 800;
      margin-bottom: .25rem;
    }

    .funding-panel-note {
      color: var(--bs-secondary-color);
      font-size: .93rem;
      margin-bottom: 0;
    }

    .funding-panel-badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 2rem;
      padding: .35rem .75rem;
      border-radius: 999px;
      background: rgba(var(--funding-accent-rgb), .08);
      color: var(--funding-accent);
      font-size: .8rem;
      font-weight: 800;
      white-space: nowrap;
    }

    .funding-form .form-label,
    .funding-form legend.form-label {
      color: var(--bs-heading-color);
      font-weight: 700;
      margin-bottom: .45rem;
    }

    .funding-form .form-control,
    .funding-form .form-select {
      min-height: 3.15rem;
      border-radius: 1rem;
      border-color: rgba(148, 163, 184, 0.28);
      background: var(--bs-body-bg);
      box-shadow: none;
    }

    .funding-form textarea.form-control {
      min-height: unset;
      padding-top: .9rem;
      padding-bottom: .9rem;
    }

    .funding-form .form-control:focus,
    .funding-form .form-select:focus {
      border-color: rgba(var(--funding-accent-rgb), .45);
      box-shadow: 0 0 0 .2rem rgba(var(--funding-accent-rgb), .10);
    }

    .funding-option-list {
      display: grid;
      gap: .7rem;
    }

    .funding-option {
      position: relative;
      display: block;
      padding: .95rem 1rem .95rem 2.9rem;
      border-radius: 1rem;
      border: 1px solid rgba(15, 23, 42, 0.08);
      background: var(--bs-body-bg);
      transition: border-color .2s ease, background .2s ease;
      cursor: pointer;
    }

    .funding-option .form-check-input {
      position: absolute;
      top: 1rem;
      left: 1rem;
      margin: 0;
    }

    .funding-option .form-check-label {
      display: block;
      color: var(--bs-heading-color);
      font-weight: 700;
      cursor: pointer;
    }

    .funding-option:has(.form-check-input:checked) {
      border-color: rgba(var(--funding-accent-rgb), .24);
      background: rgba(var(--funding-accent-rgb), .06);
      box-shadow: 0 10px 22px rgba(31, 143, 107, 0.06);
    }

    .funding-phone {
      display: grid;
      grid-template-columns: minmax(7rem, 8.75rem) minmax(0, 1fr);
      gap: .75rem;
    }

    .funding-actions {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: .85rem;
      margin-top: 1.25rem;
      padding-top: 1rem;
      border-top: 1px solid rgba(15, 23, 42, 0.08);
    }

    .funding-actions-end {
      display: flex;
      align-items: center;
      gap: .75rem;
      margin-left: auto;
    }

    .funding-actions .btn {
      min-height: 3.1rem;
      border-radius: 999px;
      padding-inline: 1.25rem;
      font-weight: 700;
    }

    .funding-submit-wrap {
      display: none;
    }

    .funding-submit-wrap.is-visible {
      display: block;
    }

    [data-bs-theme="dark"] .funding-card,
    [data-bs-theme="dark"] .funding-panel,
    [data-bs-theme="dark"] .funding-step,
    [data-bs-theme="dark"] .funding-option,
    [data-bs-theme="dark"] .funding-card-head {
      border-color: rgba(255, 255, 255, 0.08);
      box-shadow: none;
    }

    [data-bs-theme="dark"] .funding-card-head,
    [data-bs-theme="dark"] .funding-panel {
      background: #171c22;
    }

    [data-bs-theme="dark"] .funding-step,
    [data-bs-theme="dark"] .funding-option {
      background: #20262d;
    }

    @media (max-width: 767.98px) {
      .funding-steps,
      .funding-phone {
        grid-template-columns: 1fr;
      }

      .funding-actions,
      .funding-actions-end {
        flex-direction: column;
        align-items: stretch;
      }

      .funding-actions-end {
        width: 100%;
        margin-left: 0;
      }

      .funding-actions .btn {
        width: 100%;
      }
    }
  </style>
@endpush

@php
  $fundingWizardStepFields = [
    1 => ['full_name', 'country', 'address', 'email', 'phone', 'phone_prefix'],
    2 => ['current_situation', 'monthly_income_approx', 'family_situation'],
    3 => ['amount_requested', 'need_type', 'situation', 'declare_accurate'],
  ];
  $initialFundingWizardStep = 1;
  if ($errors->any()) {
    foreach ($fundingWizardStepFields as $stepNum => $keys) {
      foreach ($errors->keys() as $err) {
        if (in_array($err, $keys, true)) {
          $initialFundingWizardStep = $stepNum;
          break 2;
        }
      }
    }
  }
@endphp

@section('content')
@php
  $countryOptions = collect(__('country_contact'))
    ->map(fn ($label, $index) => ['index' => $index, 'label' => $label])
    ->values();

  $phonePrefixOptions = [
    ['country_index' => 13, 'flag' => '🇫🇷', 'prefix' => '+33'],
    ['country_index' => 14, 'flag' => '🇩🇪', 'prefix' => '+49'],
    ['country_index' => 2, 'flag' => '🇦🇹', 'prefix' => '+43'],
    ['country_index' => 3, 'flag' => '🇧🇪', 'prefix' => '+32'],
    ['country_index' => 6, 'flag' => '🇧🇬', 'prefix' => '+359'],
    ['country_index' => 8, 'flag' => '🇨🇾', 'prefix' => '+357'],
    ['country_index' => 7, 'flag' => '🇭🇷', 'prefix' => '+385'],
    ['country_index' => 10, 'flag' => '🇩🇰', 'prefix' => '+45'],
    ['country_index' => 40, 'flag' => '🇪🇸', 'prefix' => '+34'],
    ['country_index' => 11, 'flag' => '🇪🇪', 'prefix' => '+372'],
    ['country_index' => 12, 'flag' => '🇫🇮', 'prefix' => '+358'],
    ['country_index' => 15, 'flag' => '🇬🇷', 'prefix' => '+30'],
    ['country_index' => 16, 'flag' => '🇭🇺', 'prefix' => '+36'],
    ['country_index' => 18, 'flag' => '🇮🇪', 'prefix' => '+353'],
    ['country_index' => 19, 'flag' => '🇮🇹', 'prefix' => '+39'],
    ['country_index' => 21, 'flag' => '🇱🇻', 'prefix' => '+371'],
    ['country_index' => 23, 'flag' => '🇱🇹', 'prefix' => '+370'],
    ['country_index' => 24, 'flag' => '🇱🇺', 'prefix' => '+352'],
    ['country_index' => 25, 'flag' => '🇲🇹', 'prefix' => '+356'],
    ['country_index' => 29, 'flag' => '🇳🇱', 'prefix' => '+31'],
    ['country_index' => 32, 'flag' => '🇵🇱', 'prefix' => '+48'],
    ['country_index' => 33, 'flag' => '🇵🇹', 'prefix' => '+351'],
    ['country_index' => 34, 'flag' => '🇷🇴', 'prefix' => '+40'],
    ['country_index' => 38, 'flag' => '🇸🇰', 'prefix' => '+421'],
    ['country_index' => 39, 'flag' => '🇸🇮', 'prefix' => '+386'],
    ['country_index' => 41, 'flag' => '🇸🇪', 'prefix' => '+46'],
    ['country_index' => 42, 'flag' => '🇨🇭', 'prefix' => '+41'],
    ['country_index' => 9, 'flag' => '🇨🇿', 'prefix' => '+420'],
  ];

  $phonePrefixOptions = collect($phonePrefixOptions)
    ->map(function (array $option) use ($countryOptions) {
      $country = $countryOptions->firstWhere('index', $option['country_index']);
      $option['country_label'] = $country['label'] ?? null;

      return $option;
    })
    ->all();
@endphp
<main class="page-wrapper">
  @include('partials.form-page-header')
  @php($pageLocale = request()->route('locale') ?? app()->getLocale())

  <section class="funding-page container">
    <div class="funding-shell">
      <nav aria-label="breadcrumb" class="d-flex justify-content-center mb-4">
        <ol class="breadcrumb mb-0 justify-content-center">
          <li class="breadcrumb-item"><a href="{{ route('home', ['locale' => $pageLocale]) }}">{{ __('ui.nav.home') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('funding.breadcrumb_current') }}</li>
        </ol>
      </nav>

      <div class="funding-intro">
        <h1 class="funding-title">{{ __('funding.heading') }}</h1>
        <p class="funding-subtitle">{!! __('funding.intro_html') !!}</p>
      </div>

      <div class="funding-card">
        <div class="funding-card-head" id="funding-wizard-root" data-initial-step="{{ $initialFundingWizardStep }}" data-total-steps="3" data-step-label="{{ __('funding.step_label') }}">
          <div class="funding-steps" role="list" aria-label="{{ __('funding.steps_aria') }}">
            <div class="funding-step" data-funding-step-chip="1" role="listitem">
              <span class="funding-step-index">1</span>
              <span class="funding-step-text">{{ __('funding.step1_title') }}</span>
            </div>
            <div class="funding-step" data-funding-step-chip="2" role="listitem">
              <span class="funding-step-index">2</span>
              <span class="funding-step-text">{{ __('funding.step2_title') }}</span>
            </div>
            <div class="funding-step" data-funding-step-chip="3" role="listitem">
              <span class="funding-step-index">3</span>
              <span class="funding-step-text">{{ __('funding.step3_title') }}</span>
            </div>
          </div>
        </div>

        <div class="funding-card-body">
          @if ($errors->any())
            <div class="alert alert-danger funding-alert text-start mb-3">
              <p class="fw-semibold mb-2">{{ __('funding.errors_intro') }}</p>
              <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $e)
                  <li>{{ $e }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form id="funding-request-form" class="funding-form needs-validation" action="{{ \App\Support\LocalizedRouteSlugs::route('funding-request.store', ['locale' => $pageLocale]) }}" method="post" novalidate>
            @csrf

            <section class="funding-panel" data-funding-step-panel="1">
              <div class="funding-panel-head">
                <div>
                  <h2 class="funding-panel-title">{{ __('funding.step1_title') }}</h2>
                  <p class="funding-panel-note">{{ __('funding.step1_note') }}</p>
                </div>
                <span class="funding-panel-badge">{{ __('funding.step_badge', ['number' => 1]) }}</span>
              </div>

              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label" for="full_name">{{ __('funding.full_name') }} <span class="text-danger">*</span></label>
                  <input class="form-control" type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" required maxlength="240" autocomplete="name" placeholder="{{ __('funding.placeholder_full_name') }}">
                  <div class="invalid-feedback">{{ __('funding.invalid_full_name') }}</div>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="country">{{ __('funding.country') }} <span class="text-danger">*</span></label>
                  <select class="form-select" name="country" id="country" required>
                    <option value="" disabled @selected(! old('country', ''))>{{ __('funding.placeholder_country') }}</option>
                    @foreach ($countryOptions as $country)
                      <option value="{{ $country['label'] }}" @selected(old('country') === $country['label'])>{{ $country['label'] }}</option>
                    @endforeach
                  </select>
                  <div class="invalid-feedback">{{ __('funding.invalid_country') }}</div>
                </div>
                <div class="col-12">
                  <label class="form-label" for="address">{{ __('funding.address') }} <span class="text-danger">*</span></label>
                  <textarea class="form-control" name="address" id="address" rows="3" required maxlength="2000" placeholder="{{ __('funding.placeholder_address') }}">{{ old('address') }}</textarea>
                  <div class="invalid-feedback">{{ __('funding.invalid_address') }}</div>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="email">{{ __('funding.email') }} <span class="text-danger">*</span></label>
                  <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}" required maxlength="255" autocomplete="email" placeholder="{{ __('funding.placeholder_email') }}">
                  <div class="invalid-feedback d-block">{{ $errors->first('email') ?: __('funding.invalid_email') }}</div>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="phone">{{ __('funding.phone') }} <span class="text-danger">*</span></label>
                  <div class="funding-phone">
                    <select class="form-select" name="phone_prefix" id="phone_prefix">
                      @foreach ($phonePrefixOptions as $phoneOption)
                        <option
                          value="{{ $phoneOption['prefix'] }}"
                          @selected(old('phone_prefix') === $phoneOption['prefix'] || (!old('phone_prefix') && old('country') === ($phoneOption['country_label'] ?? null)))
                        >{{ $phoneOption['flag'] }} {{ $phoneOption['prefix'] }}</option>
                      @endforeach
                    </select>
                    <input class="form-control" type="tel" name="phone" id="phone" value="{{ old('phone') }}" required maxlength="15" autocomplete="tel" placeholder="{{ __('funding.placeholder_phone') }}">
                  </div>
                  <div class="invalid-feedback d-block">{{ $errors->first('phone') ?: __('funding.invalid_phone') }}</div>
                </div>
              </div>
            </section>

            <section class="funding-panel d-none" data-funding-step-panel="2">
              <div class="funding-panel-head">
                <div>
                  <h2 class="funding-panel-title">{{ __('funding.step2_title') }}</h2>
                  <p class="funding-panel-note">{{ __('funding.step2_note') }}</p>
                </div>
                <span class="funding-panel-badge">{{ __('funding.step_badge', ['number' => 2]) }}</span>
              </div>

              <fieldset class="mb-4">
                <legend class="form-label fs-6 mb-3">{{ __('funding.legend_current_situation') }} <span class="text-danger">*</span></legend>
                <div class="funding-option-list">
                  @foreach (\App\Models\FundingRequest::currentSituationLabels() as $val => $label)
                    <label class="funding-option form-check">
                      <input class="form-check-input" type="radio" name="current_situation" id="cs_{{ $val }}" value="{{ $val }}" required @checked(old('current_situation') === $val)>
                      <span class="form-check-label">{{ $label }}</span>
                    </label>
                  @endforeach
                </div>
              </fieldset>

              <div class="mb-4">
                <label class="form-label" for="monthly_income_approx">{{ __('funding.monthly_income') }}</label>
                <input class="form-control" type="text" name="monthly_income_approx" id="monthly_income_approx" value="{{ old('monthly_income_approx') }}" maxlength="120" placeholder="{{ __('funding.placeholder_income') }}">
              </div>

              <fieldset>
                <legend class="form-label fs-6 mb-3">{{ __('funding.legend_family') }}</legend>
                <div class="funding-option-list">
                  @foreach (\App\Models\FundingRequest::familySituationLabels() as $val => $label)
                    <label class="funding-option form-check">
                      <input class="form-check-input" type="radio" name="family_situation" id="fs_{{ $val }}" value="{{ $val }}" @checked(old('family_situation') === $val)>
                      <span class="form-check-label">{{ $label }}</span>
                    </label>
                  @endforeach
                </div>
              </fieldset>
            </section>

            <section class="funding-panel d-none" data-funding-step-panel="3">
              <div class="funding-panel-head">
                <div>
                  <h2 class="funding-panel-title">{{ __('funding.step3_title') }}</h2>
                  <p class="funding-panel-note">{{ __('funding.step3_note') }}</p>
                </div>
                <span class="funding-panel-badge">{{ __('funding.step_badge', ['number' => 3]) }}</span>
              </div>

              <div class="mb-4">
                <label class="form-label" for="amount_requested">{{ __('funding.amount_label') }} <span class="text-danger">*</span></label>
                <select class="form-select" name="amount_requested" id="amount_requested" required>
                  <option value="" disabled @selected(! old('amount_requested', ''))>{{ __('funding.amount_select_placeholder') }}</option>
                  @foreach ($amountChoices as $amount)
                    <option value="{{ $amount }}" @selected((string) old('amount_requested') === (string) $amount)>{{ number_format($amount, 0, ',', ' ') }} €</option>
                  @endforeach
                </select>
                <div class="invalid-feedback">{{ __('funding.invalid_amount') }}</div>
              </div>

              <fieldset class="mb-4">
                <legend class="form-label fs-6 mb-3">{{ __('funding.legend_need_type') }} <span class="text-danger">*</span></legend>
                <div class="funding-option-list">
                  @foreach (\App\Models\FundingRequest::needTypeLabels() as $val => $label)
                    <label class="funding-option form-check">
                      <input class="form-check-input" type="radio" name="need_type" id="nt_{{ $val }}" value="{{ $val }}" required @checked(old('need_type') === $val)>
                      <span class="form-check-label">{{ $label }}</span>
                    </label>
                  @endforeach
                </div>
              </fieldset>

              <div class="mb-4">
                <label class="form-label" for="situation">{{ __('funding.situation_label') }} <span class="text-danger">*</span></label>
                <p class="small text-body-secondary mb-2">{{ __('funding.situation_help') }}</p>
                <textarea class="form-control" name="situation" id="situation" rows="7" required maxlength="10000" placeholder="{{ __('funding.situation_placeholder') }}">{{ old('situation') }}</textarea>
                <div class="invalid-feedback">{{ __('funding.invalid_situation') }}</div>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="declare_accurate" id="declare_accurate" value="1" required @checked(old('declare_accurate'))>
                <label class="form-check-label" for="declare_accurate">{{ __('funding.declare_accurate') }} <span class="text-danger">*</span></label>
              </div>
            </section>

            <div class="funding-actions">
              <button type="button" class="btn btn-outline-secondary" id="funding-prev">{{ __('funding.btn_prev') }}</button>

              <div class="funding-actions-end">
                <button type="button" class="btn btn-primary" id="funding-next">{{ __('funding.btn_next') }}</button>
                <div id="funding-submit-group" class="funding-submit-wrap">
                  <button class="btn btn-primary" type="submit" data-submit-loading-text="{{ __('ui.common.submitting') }}">{{ __('funding.submit') }}</button>
                </div>
              </div>
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
  const root = document.getElementById('funding-wizard-root');
  const form = document.getElementById('funding-request-form');
  if (!root || !form) return;

  const totalSteps = parseInt(root.dataset.totalSteps || '3', 10);
  let step = parseInt(root.dataset.initialStep || '1', 10);
  if (step < 1 || step > totalSteps) step = 1;

  const panels = form.querySelectorAll('[data-funding-step-panel]');
  const chips = document.querySelectorAll('[data-funding-step-chip]');
  const btnPrev = document.getElementById('funding-prev');
  const btnNext = document.getElementById('funding-next');
  const submitGroup = document.getElementById('funding-submit-group');

  function validatePanel(n) {
    const panel = form.querySelector('[data-funding-step-panel="' + n + '"]');
    if (!panel) return true;

    const fields = panel.querySelectorAll('input, select, textarea');
    for (let i = 0; i < fields.length; i++) {
      const el = fields[i];
      if (el.type === 'hidden' || el.disabled) continue;
      if (!el.checkValidity()) {
        el.reportValidity();
        el.focus();
        return false;
      }
    }

    return true;
  }

  function render() {
    panels.forEach(function (panel) {
      const n = parseInt(panel.getAttribute('data-funding-step-panel'), 10);
      panel.classList.toggle('d-none', n !== step);
    });

    chips.forEach(function (chip) {
      const n = parseInt(chip.getAttribute('data-funding-step-chip'), 10);
      chip.classList.toggle('active', n === step);
    });

    if (btnPrev) btnPrev.classList.toggle('d-none', step === 1);
    if (btnNext) btnNext.classList.toggle('d-none', step === totalSteps);
    if (submitGroup) submitGroup.classList.toggle('is-visible', step === totalSteps);
  }

  function scrollToTop() {
    window.scrollTo({
      top: root.getBoundingClientRect().top + window.scrollY - 24,
      behavior: 'smooth'
    });
  }

  if (btnNext) {
    btnNext.addEventListener('click', function () {
      if (!validatePanel(step)) return;
      if (step < totalSteps) {
        step += 1;
        render();
        scrollToTop();
      }
    });
  }

  if (btnPrev) {
    btnPrev.addEventListener('click', function () {
      if (step > 1) {
        step -= 1;
        render();
        scrollToTop();
      }
    });
  }

  form.addEventListener('submit', function (event) {
    if (!validatePanel(step) || !form.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
    }
    form.classList.add('was-validated');
  });

  render();
})();
</script>
@endpush
@endsection

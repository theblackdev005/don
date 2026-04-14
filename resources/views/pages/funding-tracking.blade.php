@extends('layouts.app')

@section('title', config('site.name').' | '.__('pages.tracking.title'))

@push('meta')
  @include('partials.meta-default')
@endpush

@section('content')
<main class="page-wrapper">
  @include('partials.nav', ['active' => 'tracking', 'variant' => 'default'])
  @php
    $pageLocale = request()->route('locale') ?? app()->getLocale();
  @endphp
  <section class="container py-5 my-5">
    <nav aria-label="breadcrumb" class="mb-4">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home', ['locale' => $pageLocale]) }}">{{ __('ui.nav.home') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('pages.tracking.breadcrumb') }}</li>
      </ol>
    </nav>

    <div class="row justify-content-center">
      <div class="col-lg-8 col-xl-7">

        @if ($trackingResult)
          @php
            $summary = $trackingResult->publicTrackingSummary();
            $badge = match ($trackingResult->status) {
              \App\Models\FundingRequest::STATUS_PENDING => 'warning',
              \App\Models\FundingRequest::STATUS_PRELIMINARY_ACCEPTED => 'info',
              \App\Models\FundingRequest::STATUS_AWAITING_DOCUMENTS => 'info',
              \App\Models\FundingRequest::STATUS_DOCUMENTS_RECEIVED => 'success',
              \App\Models\FundingRequest::STATUS_DONATION_ACT_SENT => 'primary',
              \App\Models\FundingRequest::STATUS_CLOSED => 'secondary',
              default => 'secondary',
            };
          @endphp
          <div class="card border-0 shadow rounded-4 mb-4">
            <div class="card-body p-4 p-md-5">
              <p class="small text-body-secondary mb-2">{{ __('pages.tracking.result_caption') }}</p>
              <p class="h3 fw-bold text-primary mb-3">{{ $trackingResult->dossier_number }}</p>
              <p class="mb-2"><span class="badge text-bg-{{ $badge }}">{{ $trackingResult->status_label }}</span></p>
              <h1 class="h4 mt-4">{{ $summary['headline'] }}</h1>
              <p class="text-body-secondary mb-0">{{ $summary['body'] }}</p>
              @if ($trackingResult->applicantCanDownloadDonationAct())
                <div class="mt-4">
                  <a class="btn btn-success btn-lg" href="{{ route('funding-request.download-act', ['locale' => $pageLocale, 'public_slug' => $trackingResult->public_slug]) }}">{{ __('pages.tracking.download_donation_act') }}</a>
                  <p class="small text-body-secondary mt-2 mb-0">{{ __('pages.tracking.download_donation_act_help') }}</p>
                </div>
              @endif
              <p class="small text-body-secondary mt-4 mb-0">{{ __('pages.tracking.result_filed', ['datetime' => $trackingResult->created_at->format('d/m/Y H:i')]) }}@if ($trackingResult->applicantCanUploadDocuments()) <span class="d-block mt-2">{!! __('pages.tracking.result_upload_docs_html') !!}</span>@endif</p>
            </div>
          </div>
          <div class="text-center">
            @if ($trackingResult->applicantCanDownloadDonationAct())
              <a class="btn btn-success me-2 mb-2" href="{{ route('funding-request.download-act', ['locale' => $pageLocale, 'public_slug' => $trackingResult->public_slug]) }}">{{ __('pages.tracking.download_donation_act') }}</a>
            @endif
            <a class="btn btn-outline-primary me-2 mb-2" href="{{ route('funding.tracking', ['locale' => $pageLocale]) }}">{{ __('pages.tracking.check_other') }}</a>
            @php
              $trackingContactEmail = trim((string) config('site.email', ''));
            @endphp
            @if ($trackingContactEmail !== '')
              <a class="btn btn-primary mb-2" href="mailto:{{ e($trackingContactEmail) }}">{{ __('pages.tracking.contact') }}</a>
            @else
              <a class="btn btn-primary mb-2" href="{{ route('contact', ['locale' => $pageLocale]) }}">{{ __('pages.tracking.contact') }}</a>
            @endif
          </div>
        @else
          <h1 class="h2 mb-3">{{ __('pages.tracking.heading') }}</h1>
          <p class="text-body-secondary mb-4">{{ __('pages.tracking.intro') }}</p>

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0 ps-3 small">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
          @endif

          <div id="tracking-step-1" class="card border-0 shadow-sm rounded-4 mb-3 @if ($errors->any()) d-none @endif">
            <div class="card-body p-4 p-md-5">
              <h2 class="h5 mb-3"><span class="badge bg-primary me-2">1</span> {{ __('pages.tracking.step1') }}</h2>
              <p class="text-body-secondary mb-4 mb-md-0">{!! __('pages.tracking.step1_body_html') !!}</p>
              <div class="d-grid d-sm-flex justify-content-sm-end mt-4">
                <button type="button" class="btn btn-primary btn-lg" id="tracking-go-step-2">{{ __('pages.tracking.continue') }}</button>
              </div>
            </div>
          </div>

          <div id="tracking-step-2" class="card border-0 shadow rounded-4 @if (! $errors->any()) d-none @endif">
            <div class="card-body p-4 p-md-5">
              <h2 class="h5 mb-3"><span class="badge bg-primary me-2">2</span> {{ __('pages.tracking.step2') }}</h2>
              <p class="text-body-secondary small mb-3">{{ __('pages.tracking.number_example') }} <kbd class="user-select-all">ARD-2026-A7K9Q2</kbd></p>
              <form method="post" action="{{ route('funding.tracking.lookup', ['locale' => $pageLocale]) }}" class="needs-validation" novalidate>
                @csrf
                <div class="mb-4">
                  <label class="form-label fw-semibold" for="dossier_number">{{ __('pages.tracking.number_label') }}</label>
                  <input class="form-control form-control-lg text-uppercase" type="text" name="dossier_number" id="dossier_number" value="{{ old('dossier_number') }}" required autocomplete="off" placeholder="ARD-2026-A7K9Q2" pattern="(?:[Aa][Rr][Dd]-\d{4}-[A-Za-z0-9]{6}|[Jj][Gg][Ff]-\d{4}-\d{5})">
                  <div class="invalid-feedback">{{ __('pages.tracking.invalid_feedback') }}</div>
                </div>
                <div class="d-flex flex-wrap gap-2 justify-content-between">
                  <button type="button" class="btn btn-outline-secondary" id="tracking-back-step-1">{{ __('pages.tracking.back') }}</button>
                  <button type="submit" class="btn btn-primary btn-lg">{{ __('pages.tracking.submit') }}</button>
                </div>
              </form>
            </div>
          </div>
        @endif

      </div>
    </div>
  </section>
</main>
@include('partials.footers.compact')

@unless ($trackingResult)
@push('vendor-scripts')
<script>
(function () {
  var s1 = document.getElementById('tracking-step-1');
  var s2 = document.getElementById('tracking-step-2');
  var btnGo = document.getElementById('tracking-go-step-2');
  var btnBack = document.getElementById('tracking-back-step-1');
  if (btnGo && s1 && s2) {
    btnGo.addEventListener('click', function () {
      s1.classList.add('d-none');
      s2.classList.remove('d-none');
      var input = document.getElementById('dossier_number');
      if (input) input.focus();
    });
  }
  if (btnBack && s1 && s2) {
    btnBack.addEventListener('click', function () {
      s2.classList.add('d-none');
      s1.classList.remove('d-none');
    });
  }
})();
</script>
@endpush
@endunless
@endsection

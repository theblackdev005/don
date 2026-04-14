@extends('layouts.app')

@section('title', config('site.name').' | '.__('pages.contact.title'))

@push('meta')
  @include('partials.meta-default')
@endpush

@section('content')
<main class="page-wrapper">
  @include('partials.nav', ['active' => 'contact', 'variant' => 'default'])
        <!-- Page title + Contact form -->
    <section class="container pt-5 pb-lg-2 pb-xl-4 py-xxl-5 my-5">

      <!-- Breadcrumb-->
      <nav aria-label="breadcrumb">
        <ol class="pt-lg-3 pb-lg-4 pb-2 breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('ui.nav.home') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('pages.contact.breadcrumb') }}</li>
        </ol>
      </nav>

      <div class="row pb-1 pb-sm-3 pb-lg-4">
        <div class="col-lg-4 pe-xxl-4">

          <!-- Page title -->
          <h1 class="display-2">{{ __('pages.contact.heading') }}</h1>
          <p class="fs-lg pb-4 mb-0 mb-sm-2">{{ __('pages.contact.subtitle') }}</p>
        </div>
        <div class="col-lg-8 col-xl-7 offset-xl-1">

          <!-- Contact form -->
          <form class="row g-4 needs-validation" novalidate>
            <div class="col-sm-6">
              <label class="form-label fs-base" for="name">{{ __('pages.contact.name_label') }}</label>
              <input class="form-control form-control-lg" type="text" placeholder="{{ __('pages.contact.name_placeholder') }}" required id="name">
              <div class="invalid-feedback">{{ __('pages.contact.name_invalid') }}</div>
            </div>
            <div class="col-sm-6">
              <label class="form-label fs-base" for="email">{{ __('pages.contact.email_label') }}</label>
              <input class="form-control form-control-lg" type="email" placeholder="{{ __('pages.contact.email_placeholder') }}" required id="email">
              <div class="invalid-feedback">{{ __('pages.contact.email_invalid') }}</div>
            </div>
            <div class="col-sm-6">
              <label class="form-label fs-base" for="phone">{{ __('pages.contact.phone_label') }}</label>
              <input class="form-control form-control-lg" type="text" placeholder="{{ __('pages.contact.phone_placeholder') }}"
                id="phone">
            </div>
            <div class="col-sm-6">
              <label class="form-label fs-base" for="location">{{ __('pages.contact.country_label') }}</label>
              <select class="form-select form-select-lg" id="location">
                <option value="">{{ __('pages.contact.country_placeholder') }}</option>
                @foreach (config('contact_countries.values') as $index => $canonicalFr)
                  <option value="{{ $canonicalFr }}">{{ __('country_contact.'.$index) }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-12">
              <label class="form-label fs-base" for="message">{{ __('pages.contact.message_label') }}</label>
              <textarea class="form-control form-control-lg" rows="5" placeholder="{{ __('pages.contact.message_placeholder') }}" required
                id="message"></textarea>
              <div class="invalid-feedback">{{ __('pages.contact.message_invalid') }}</div>
            </div>
            <div class="col-sm-12">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="agree">
                <label class="form-check-label" for="agree">{{ __('pages.contact.agree_prefix') }} <a
                    class="nav-link d-inline fs-normal text-decoration-underline p-0" href="#">{{ __('pages.contact.terms') }}</a>
                  {{ __('pages.contact.agree_and') }}
                  <a class="nav-link d-inline fs-normal text-decoration-underline p-0" href="{{ route('privacy') }}">{{ __('pages.contact.privacy') }}</a></label>
              </div>
            </div>
            <div class="col-sm-12 pt-2">
              <button class="btn btn-lg btn-primary" type="submit">{{ __('pages.contact.submit') }}</button>
            </div>
          </form>
        </div>
      </div>
    </section>


    <!-- Contact details -->
    <section class="bg-secondary py-5">
      <div class="container py-lg-3 py-xl-4 py-xxl-5">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4 py-sm-2 py-md-3 py-lg-4">
          @foreach (config('site.offices') as $office)
            <div class="col">
              <h2 class="h4 mb-4">{{ $office['label'] }}</h2>
              <ul class="list-unstyled mb-0">
                <li class="nav flex-nowrap mb-3">
                  <i class="ai-phone lead text-primary me-2"></i>
                  <a class="nav-link fw-normal p-0 mt-n1" href="tel:{{ preg_replace('/[^+\d]/', '', $office['phone']) }}">{!! str_replace(' ', '&nbsp;', e($office['phone_display'])) !!}</a>
                </li>
                <li class="nav flex-nowrap mb-3">
                  <i class="ai-mail lead text-primary me-2"></i>
                  <a class="nav-link fw-normal p-0 mt-n1" href="mailto:{{ $office['email'] }}">{{ $office['email'] }}</a>
                </li>
                <li class="nav flex-nowrap mb-3">
                  <i class="ai-map-pin lead text-primary me-2"></i>
                  <a class="nav-link fw-normal p-0 mt-n1" href="{{ $office['map_url'] }}">{{ $office['address'] }}</a>
                </li>
              </ul>
            </div>
          @endforeach
        </div>
      </div>
    </section>
</main>
@include('partials.footers.compact')
@endsection

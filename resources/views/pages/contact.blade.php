@extends('layouts.app')

@section('title', __('pages.contact.title'))

@push('meta')
  @include('partials.meta-default')
@endpush

@section('content')
<main class="page-wrapper">
  @include('partials.nav', ['active' => 'contact', 'variant' => 'default'])

  <section class="container pt-5 pb-5 my-5">
    <nav aria-label="breadcrumb">
      <ol class="pt-lg-3 pb-lg-4 pb-2 breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('ui.nav.home') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('pages.contact.breadcrumb') }}</li>
      </ol>
    </nav>

    <div class="mx-auto mb-4 mb-md-5" style="max-width: 760px;">
      <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 mb-3">{{ __('pages.contact.kicker') }}</span>
      <h1 class="display-4 mb-3">{{ __('pages.contact.heading') }}</h1>
      <p class="fs-lg text-body-secondary mb-0">{{ __('pages.contact.subtitle') }}</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8 col-xl-7">
        <div class="card border-0 shadow-sm rounded-5">
          <div class="card-body p-4 p-md-5">
            @if (session('contact_ok'))
              <div class="alert alert-success rounded-4 mb-4">{{ session('contact_ok') }}</div>
            @endif

            @if ($errors->any())
              <div class="alert alert-danger rounded-4 mb-4">
                <ul class="mb-0 ps-3">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form method="post" action="{{ route('contact.submit') }}" class="row g-4">
              @csrf

              <div class="d-none" aria-hidden="true">
                <label for="website">{{ __('pages.contact.website_label') }}</label>
                <input type="text" name="website" id="website" tabindex="-1" autocomplete="off" value="">
              </div>

              <div class="col-12">
                <label class="form-label fs-base" for="full_name">{{ __('pages.contact.full_name_label') }}</label>
                <input class="form-control form-control-lg" type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" placeholder="{{ __('pages.contact.full_name_placeholder') }}" required>
              </div>

              <div class="col-12">
                <label class="form-label fs-base" for="email">{{ __('pages.contact.email_label') }}</label>
                <input class="form-control form-control-lg" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="{{ __('pages.contact.email_placeholder') }}" required>
              </div>

              <div class="col-12">
                <label class="form-label fs-base" for="subject">{{ __('pages.contact.subject_label') }}</label>
                <input class="form-control form-control-lg" type="text" id="subject" name="subject" value="{{ old('subject') }}" placeholder="{{ __('pages.contact.subject_placeholder') }}" required>
              </div>

              <div class="col-12">
                <label class="form-label fs-base" for="message">{{ __('pages.contact.message_label') }}</label>
                <textarea class="form-control form-control-lg" rows="7" id="message" name="message" placeholder="{{ __('pages.contact.message_placeholder') }}" required>{{ old('message') }}</textarea>
              </div>

              <div class="col-12">
                <button class="btn btn-lg btn-primary" type="submit" data-submit-loading-text="{{ __('ui.common.submitting') }}">{{ __('pages.contact.submit') }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@include('partials.footers.marketing')
@endsection

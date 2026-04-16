@extends('layouts.app')

@section('title', __('pages.services.title'))

@push('meta')
  @include('partials.meta-default')
@endpush

@push('vendor-css')
  <link rel="stylesheet" media="screen" href="/assets/vendor/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<main class="page-wrapper">
  @include('partials.nav', ['active' => 'services', 'variant' => 'light'])
        <!-- Services -->
    <section class="container pt-5 pb-xxl-3 mt-5">

      <!-- Breadcrumb -->
      <nav aria-label="breadcrumb">
        <ol class="pt-lg-3 pb-lg-4 pb-2 breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('ui.nav.home') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('pages.services.breadcrumb') }}</li>
        </ol>
      </nav>

      <!-- Grid -->
      <div class="row">
        <div class="col-lg-4 pb-3 mb-3">
          <h2 class="h1">{{ __('pages.services.heading') }}</h2>
          <p class="pe-5 mb-0">{{ __('pages.services.intro') }}</p>
        </div>
        <div class="col-lg-8">
          <div class="row row-cols-1 row-cols-sm-2 g-4">
            <div class="col">

              <!-- Item -->
              <div class="card border-0 bg-secondary rounded-5 mb-4">
                <div class="card-body pb-3">
                  <svg class="d-block mt-1 mt-sm-0 mb-4" width="40" height="40" viewBox="0 0 40 40"
                    xmlns="http://www.w3.org/2000/svg">
                    <g class="text-info">
                      <path d="M34.9811 16.2655C34.3635 26.3194 26.3194 34.3634 16.2656 34.981V40H40V16.2655H34.9811Z"
                        fill="currentColor"></path>
                    </g>
                    <g class="text-info">
                      <path d="M15.0195 30.0413C23.3152 30.0413 30.0403 23.3163 30.0403 15.0205H15.0195V30.0413Z"
                        fill="currentColor"></path>
                    </g>
                    <g class="text-primary">
                      <path
                        d="M29.1953 10.0415C27.141 4.19328 21.571 0 15.0208 0C6.725 0 0 6.725 0 15.0208C0 21.571 4.19328 27.141 10.0415 29.1953V10.0415H29.1953Z"
                        fill="currentColor"></path>
                    </g>
                  </svg>
                  <h3 class="h4">{{ __('pages.services.card_exceptional_title') }}</h3>
                  <p class="mb-0">{{ __('pages.services.card_exceptional_text') }}</p>
                </div>
                <div class="card-footer border-0 pt-3 mb-3">
                  <a class="btn btn-link text-primary p-0 fw-semibold" href="{{ route('funding-request.create') }}">{{ __('pages.services.request_link') }}</a>
                </div>
              </div>

              <!-- Item -->
              <div class="card border-0 bg-secondary rounded-5">
                <div class="card-body pb-3">
                  <svg class="d-block mt-1 mt-sm-0 mb-4" width="40" height="40" viewBox="0 0 40 40"
                    xmlns="http://www.w3.org/2000/svg">
                    <g class="text-info">
                      <path
                        d="M20.0004 36.0226L10.982 21.3535C9.42594 23.3156 8.49609 25.7968 8.49609 28.4955C8.49609 34.8492 13.6467 39.9998 20.0004 39.9998C26.3541 39.9998 31.5047 34.8492 31.5047 28.4955C31.5047 25.7969 30.5749 23.3156 29.0188 21.3535L20.0004 36.0226Z"
                        fill="currentColor"></path>
                    </g>
                    <g class="text-primary">
                      <path
                        d="M39.3962 0H0.605469L20.0009 31.5477L39.3962 0ZM25.7601 7.62359L20.0009 16.9914L14.2416 7.62359H25.7601Z"
                        fill="currentColor"></path>
                    </g>
                  </svg>
                  <h3 class="h4">{{ __('pages.services.card_urgent_title') }}</h3>
                  <p class="mb-0">{{ __('pages.services.card_urgent_text') }}</p>
                </div>
                <div class="card-footer border-0 pt-3 mb-3">
                  <a class="btn btn-link text-primary p-0 fw-semibold" href="{{ route('funding-request.create') }}">{{ __('pages.services.request_link') }}</a>
                </div>
              </div>

            </div>
            <div class="col">

              <!-- Item -->
              <div class="card border-0 bg-secondary rounded-5 mb-4">
                <div class="card-body pb-3">
                  <svg class="d-block mt-1 mt-sm-0 mb-4" width="40" height="40" viewBox="0 0 40 40"
                    xmlns="http://www.w3.org/2000/svg">
                    <g class="text-primary">
                      <path
                        d="M25.2791 12.7502C28.1954 9.83389 28.1954 5.10556 25.2791 2.18921C22.3627 -0.727136 17.6344 -0.727137 14.718 2.18921C11.8017 5.10556 11.8017 9.83389 14.718 12.7502C17.6344 15.6666 22.3627 15.6666 25.2791 12.7502Z"
                        fill="currentColor"></path>
                    </g>
                    <g class="text-info">
                      <path
                        d="M14.6859 29.3056C15.6559 27.0123 16.9202 24.8838 18.4577 22.9467C13.8666 17.9802 7.29664 14.8701 0 14.8701V40.0004H12.5259C12.5259 36.2925 13.2527 32.6942 14.6859 29.3056Z"
                        fill="currentColor"></path>
                    </g>
                    <g class="text-primary">
                      <path d="M40.0014 40.0004V14.8701C26.1223 14.8701 14.8711 26.1214 14.8711 40.0004H40.0014Z"
                        fill="currentColor"></path>
                    </g>
                  </svg>
                  <h3 class="h4">{{ __('pages.services.card_family_title') }}</h3>
                  <p class="mb-0">{{ __('pages.services.card_family_text') }}</p>
                </div>
                <div class="card-footer border-0 pt-3 mb-3">
                  <a class="btn btn-link text-primary p-0 fw-semibold" href="{{ route('funding-request.create') }}">{{ __('pages.services.request_link') }}</a>
                </div>
              </div>

              <!-- Item -->
              <div class="card border-0 bg-secondary rounded-5">
                <div class="card-body pb-3">
                  <svg class="d-block mt-1 mt-sm-0 mb-4" width="40" height="40" viewBox="0 0 40 40"
                    xmlns="http://www.w3.org/2000/svg">
                    <g class="text-primary">
                      <path
                        d="M19.9999 0C11.1313 0 3.61211 5.77313 0.992188 13.7659H39.0077C36.3877 5.77313 28.8686 0 19.9999 0Z"
                        fill="currentColor"></path>
                    </g>
                    <g class="text-info">
                      <path
                        d="M7.29328 16.1094H0.379453C0.131328 17.368 0 18.6684 0 19.9998C0 26.9291 3.52437 33.0348 8.87797 36.6237L18.3427 27.1589L7.29328 16.1094Z"
                        fill="currentColor"></path>
                    </g>
                    <g class="text-primary">
                      <path
                        d="M10.9688 37.848C13.6819 39.2238 16.7505 39.9998 20.0007 39.9998C31.0464 39.9998 40.0007 31.0455 40.0007 19.9998C40.0007 18.6684 39.8694 17.3679 39.6213 16.1094H32.7074L10.9688 37.848Z"
                        fill="currentColor"></path>
                    </g>
                  </svg>
                  <h3 class="h4">{{ __('pages.services.card_accomp_title') }}</h3>
                  <p class="mb-0">{{ __('pages.services.card_accomp_text') }}</p>
                </div>
                <div class="card-footer border-0 pt-3 mb-3">
                  <a class="btn btn-link text-primary p-0 fw-semibold" href="{{ route('funding-request.create') }}">{{ __('pages.services.request_link') }}</a>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- Features -->
    <section class="container py-4 pt-sm-5 pb-md-5 my-2 my-lg-3 my-xxl-4">

      <!-- Item -->
      <div class="row align-items-center py-3 py-sm-4 py-lg-5 mb-3 my-sm-2 my-md-3 my-lg-0 my-xl-2 my-xxl-4">
        <div class="col-md-6 col-lg-7 col-xl-6 offset-xl-1 order-md-2 pb-1 pb-sm-2 pb-md-0 mb-4 mb-md-0"><img
            class="d-block rounded-5" src="/assets/img/landing/corporate/features/01.jpg" alt="{{ __('pages.services.img_alt') }}"></div>
        <div class="col-md-6 col-lg-5 order-md-1">
          <div class="pe-md-4 pe-lg-0">
            <h2 class="h1 pb-sm-2 pb-lg-3">{{ __('pages.services.trust_title') }}</h2>
            <p class="fs-xl">{{ __('pages.services.trust_text', ['site' => config('site.name')]) }}
            </p>
            <div class="border-dashed mb-4 mt-5"></div>
            <div class="row row-cols-3 pt-2 g-4">
              <div class="col">
                <img class="d-block d-dark-mode-none mx-auto" src="/assets/img/brands/starcraft-dark.svg" width="160"
                  alt="Starcraft">
                <img class="d-none d-dark-mode-block mx-auto" src="/assets/img/brands/starcraft-light.svg" width="160"
                  alt="Starcraft">
              </div>
              <div class="col">
                <img class="d-block mx-auto" src="/assets/img/brands/klinos.svg" width="160" alt="Klinos">
              </div>
              <div class="col">
                <img class="d-block mx-auto" src="/assets/img/brands/auchan.svg" width="160" alt="Auchan">
              </div>
              <div class="col">
                <img class="d-block d-dark-mode-none mx-auto" src="/assets/img/brands/champion-dark.svg" width="160"
                  alt="Champion">
                <img class="d-none d-dark-mode-block mx-auto" src="/assets/img/brands/champion-light.svg" width="160"
                  alt="Champion">
              </div>
              <div class="col">
                <img class="d-block mx-auto" src="/assets/img/brands/suzuki.svg" width="160" alt="Suzuki">
              </div>
              <div class="col">
                <img class="d-block mx-auto" src="/assets/img/brands/philips.svg" width="160" alt="Philips">
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Item -->
      <div class="row align-items-center py-3 py-sm-4 py-lg-5 mb-3 my-sm-2 my-md-3 my-lg-0 my-xl-2 my-xxl-4">
        <div class="col-md-6 col-lg-7 col-xl-6 offset-xl-1 order-md-2 pb-1 pb-sm-2 pb-md-0 mb-4 mb-md-0"><img
            class="d-block rounded-5" src="/assets/img/landing/corporate/features/02.jpg" alt="{{ __('pages.services.img_alt') }}"></div>
        <div class="col-md-6 col-lg-5 order-md-1">
          <div class="pe-md-4 pe-lg-0">
            <h2 class="h1 pb-3 mb-2 mb-lg-3 mb-xl-4">{{ __('pages.services.approach_title') }}</h2>
            <div class="row row-cols-1 row-cols-sm-2 g-4">
              <div class="col">
                <div class="text-body-secondary mb-2">01</div>
                <h3 class="h5">{{ __('pages.services.step1_title') }}</h3>
                <p class="mb-1">{{ __('pages.services.step1_text') }}</p>
              </div>
              <div class="col">
                <div class="text-body-secondary mb-2">02</div>
                <h3 class="h5">{{ __('pages.services.step2_title') }}</h3>
                <p class="mb-1">{{ __('pages.services.step2_text') }}</p>
              </div>
              <div class="col">
                <div class="text-body-secondary mb-2">03</div>
                <h3 class="h5">{{ __('pages.services.step3_title') }}</h3>
                <p class="mb-1">{{ __('pages.services.step3_text') }}
                </p>
              </div>
              <div class="col">
                <div class="text-body-secondary mb-2">04</div>
                <h3 class="h5">{{ __('pages.services.step4_title') }}</h3>
                <p class="mb-1">{{ __('pages.services.step4_text') }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Item -->
      <div class="row align-items-center py-3 py-sm-4 py-lg-5 my-sm-2 my-md-3 my-lg-0 my-xl-2 my-xxl-4">
        <div class="col-md-6 col-lg-7 col-xl-6 offset-xl-1 order-md-2 pb-1 pb-sm-2 pb-md-0 mb-4 mb-md-0"><img
            class="d-block rounded-5" src="/assets/img/landing/corporate/features/03.jpg" alt="{{ __('pages.services.img_alt') }}"></div>
        <div class="col-md-6 col-lg-5 order-md-1">
          <div class="pe-md-4 pe-lg-0">
            <h2 class="h1 pb-sm-2 pb-lg-3">{{ __('pages.services.structured_title') }}</h2>
            <p class="fs-xl mb-lg-4">{{ __('pages.services.structured_text') }}</p>
            <ul class="list-unstyled pb-3 mb-3 mb-lg-4">
              <li class="d-flex pt-1 mt-2 mx-2 mx-md-0"><i class="ai-check-alt text-primary fs-4 mt-n1 me-2"></i>{{ __('pages.services.structured_li1') }}</li>
              <li class="d-flex pt-1 mt-2 mx-2 mx-md-0"><i class="ai-check-alt text-primary fs-4 mt-n1 me-2"></i>{{ __('pages.services.structured_li2') }}</li>
              <li class="d-flex pt-1 mt-2 mx-2 mx-md-0"><i
                  class="ai-check-alt text-primary fs-4 mt-n1 me-2"></i>{{ __('pages.services.structured_li3') }}</li>
            </ul><a class="btn btn-primary" href="{{ route('funding-request.create') }}">{{ __('pages.services.structured_cta') }}</a>
          </div>
        </div>
      </div>
    </section>


    <!-- Contact CTA -->
    <section class="position-relative mt-n5 mt-lg-0">
      <div class="bg-secondary position-absolute bottom-0 start-0 w-100" style="height: calc(100% - 3rem);"></div>
      <div class="container position-relative z-2">
        <div class="row">
          <div class="col-lg-6 py-5 mb-sm-2 mb-md-3 mb-lg-5 mt-3 mt-sm-4 mt-md-5">
            <h2 class="h1 text-center text-lg-start pt-3 mt-3 mb-4">{{ __('pages.services.cta_title_line1') }} <br
                class="d-none d-lg-inline">{{ __('pages.services.cta_title_line2') }} </h2>
            <div class="d-flex justify-content-between mx-auto mx-lg-0" style="max-width: 370px;">
              <ul class="ps-4 me-3">
                <li class="mt-2">{{ __('pages.services.cta_bullet1') }}</li>
                <li class="mt-2">{{ __('pages.services.cta_bullet2') }}</li>
              </ul>
              <ul class="ps-4">
                <li class="mt-2">{{ __('pages.services.cta_bullet3') }}</li>
                <li class="mt-2">{{ __('pages.services.cta_bullet4') }}</li>
              </ul>
            </div>
            <div class="text-center text-lg-start pt-4"><a class="btn btn-outline-dark" href="{{ route('funding-request.create') }}">{{ __('pages.services.cta_submit') }}</a>
            </div>
          </div>
          <div class="col-lg-6">
            <div
              class="bg-primary d-flex flex-column align-items-center justify-content-center position-relative h-100 rounded-5 rounded-bottom-0 p-5">
              <div class="position-relative z-2 py-sm-3 py-md-4" style="max-width: 360px;" data-bs-theme="dark">
                <h2 class="h1">{{ __('pages.services.help_title') }}</h2>
                <p class="text-body mb-0">{{ __('pages.services.help_text') }}</p>
                <div class="d-flex flex-column flex-sm-row align-items-center pt-3 mt-3 mt-lg-4">
                  <a class="btn btn-light w-100 w-sm-auto me-sm-4 mb-2 mb-sm-0" href="{{ route('contact') }}">{{ __('pages.services.contact') }}</a>
                  <a class="d-inline-block text-white fw-medium p-2"
                    href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</main>
@include('partials.footers.marketing')
@endsection

@push('vendor-scripts')
  <script src="/assets/vendor/swiper/swiper-bundle.min.js"></script>
@endpush

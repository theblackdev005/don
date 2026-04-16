@extends('layouts.app')

@section('title', __('about.meta_title'))

@push('meta')
  @include('partials.meta-default')
@endpush

@push('vendor-css')
  <style>
    .about-gallery-mw-306 { max-width: 306px; }
    .about-gallery-mw-367 { max-width: 367px; }
    .about-gallery-mw-416 { max-width: 416px; }
    .about-gallery-mw-526 { max-width: 526px; }
  </style>
  <link rel="stylesheet" media="screen" href="/assets/vendor/swiper/swiper-bundle.min.css">
  <link rel="stylesheet" media="screen" href="/assets/vendor/lightgallery/css/lightgallery-bundle.min.css">
@endpush

@section('content')
<main class="page-wrapper">
  @include('partials.nav', ['active' => 'about', 'variant' => 'dark'])
        <!-- Hero -->
    <section class="bg-dark position-relative py-5">
      <div class="d-none d-dark-mode-block position-absolute top-0 start-0 w-100 h-100"
        style="background-color: rgba(255,255,255, .03);"></div>
      <div class="container position-relative z-2 py-5 mb-4 mb-sm-5" data-bs-theme="dark">
        <div class="row pb-5 mb-2 mb-sm-0 mb-lg-3">
          <div class="col-lg-10 col-xl-9">

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
              <ol class="pt-lg-3 pb-lg-4 pb-2 breadcrumb">
                <li class="breadcrumb-item">
                  <a href="{{ route('home') }}">{{ __('ui.nav.home') }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('about.breadcrumb') }}</li>
              </ol>
            </nav>

            <h1 class="display-2 pb-2 pb-sm-3">{{ __('about.hero_h1') }}</h1>
            <ul class="list-unstyled d-flex flex-wrap mb-0">
              <li class="d-flex text-body py-1 me-4">
                <i class="ai-check-alt text-primary lead me-2"></i>
                {{ __('about.hero_li_1') }}
              </li>
              <li class="d-flex text-body py-1 me-4">
                <i class="ai-check-alt text-primary lead me-2"></i>
                {{ __('about.hero_li_2') }}
              </li>
              <li class="d-flex text-body py-1">
                <i class="ai-check-alt text-primary lead me-2"></i>
                {{ __('about.hero_li_3') }}
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>


    <!-- About -->
    <section class="container position-relative z-3" style="margin-top: -135px;">
      <div class="rounded-5 overflow-hidden">
        <div class="jarallax ratio ratio-16x9" data-jarallax data-speed="0.6">
          <img class="jarallax-img" src="/assets/img/about/agency/parallax-image.jpg" alt="">
        </div>
      </div>
      <div class="row pt-5 mt-n2 mt-sm-0 mt-md-2 mt-lg-4 mt-xl-5">
        <div class="col-md-6 col-lg-5">
          <div class="fs-sm text-uppercase mb-3">{{ __('about.who_kicker') }}</div>
          <h2 class="display-6">{{ __('about.who_h2') }}</h2>
        </div>
        <div class="col-md-6 col-xl-5 offset-lg-1 offset-xl-2 pt-1 pt-sm-2 pt-md-5">
          <p class="fs-xl">{!! __('about.who_p1_html', ['site' => config('site.name')]) !!}</p>
          <p class="fs-xl">{!! __('about.who_p2_html') !!}</p>
          <p class="fs-xl mb-0">{{ __('about.who_p3') }}</p>
        </div>
      </div>
    </section>


    <!-- Approach -->
    <section class="pt-5 mt-md-2 mt-xl-4 mt-xxl-5">
      <div class="container pt-2 pt-sm-4 pt-lg-5 mt-xxl-2">
        <div class="fs-sm text-uppercase mb-3">{{ __('about.mission_kicker') }}</div>
        <h2 class="display-6 pb-3 mb-lg-4">{{ __('about.mission_h2') }}</h2>
        <div class="swiper" data-swiper-options='
            {
              "spaceBetween": 24,
              "pagination": {
                "el": ".swiper-pagination",
                "clickable": true
              },
              "breakpoints": {
                "576": { "slidesPerView": 2 },
                "992": { "slidesPerView": 3 }
              }
            }
          '>
          <div class="swiper-wrapper">

            <!-- Item -->
            <div class="swiper-slide h-auto">
              <div class="card border-0 bg-secondary rounded-5 h-100">
                <div class="card-body">
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
                  <h3 class="h4">{{ __('about.m1_title') }}</h3>
                  <p class="mb-0">{{ __('about.m1_text') }}</p>
                </div>
              </div>
            </div>

            <!-- Item -->
            <div class="swiper-slide h-auto">
              <div class="card border-0 bg-secondary rounded-5 h-100">
                <div class="card-body">
                  <svg class="d-block mt-1 mt-sm-0 mb-4" width="40" height="40" viewBox="0 0 40 40"
                    xmlns="http://www.w3.org/2000/svg">
                    <g class="text-info">
                      <path
                        d="M26.307 23.1116C26.307 28.3136 22.09 32.5307 16.888 32.5307C11.6859 32.5307 7.46891 28.3136 7.46891 23.1116C7.46891 17.9096 11.6859 13.6925 16.888 13.6925C17.1467 13.6925 17.4028 13.7038 17.6562 13.7243V6.24121C17.4016 6.22973 17.1455 6.22363 16.888 6.22363C7.56102 6.22363 0 13.7846 0 23.1116C0 32.4386 7.56102 39.9996 16.888 39.9996C26.2149 39.9996 33.7759 32.4386 33.7759 23.1116C33.7759 22.8541 33.7698 22.598 33.7584 22.3433H26.2753C26.2958 22.5968 26.307 22.8529 26.307 23.1116Z"
                        fill="currentColor"></path>
                    </g>
                    <g class="text-primary">
                      <path d="M40 20C40 8.9543 31.0457 0 20 0V20H40Z" fill="currentColor"></path>
                    </g>
                  </svg>
                  <h3 class="h4">{{ __('about.m2_title') }}</h3>
                  <p class="mb-0">{{ __('about.m2_text') }}</p>
                </div>
              </div>
            </div>

            <!-- Item -->
            <div class="swiper-slide h-auto">
              <div class="card border-0 bg-secondary rounded-5 h-100">
                <div class="card-body">
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
                  <h3 class="h4">{{ __('about.m3_title') }}</h3>
                  <p class="mb-0">{{ __('about.m3_text') }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Pagination (bullets) -->
          <div class="swiper-pagination position-relative bottom-0 mt-2 pt-4 d-lg-none"></div>
        </div>
      </div>
    </section>


    <!-- How we work (Steps) -->
    <section class="container pt-5 mt-1 mt-sm-2 mt-xl-4 mt-xxl-5">
      <div class="row align-items-center pt-2 pt-sm-3 pt-md-4 pt-lg-5 mt-xl-2 mt-xxl-3">
        <div class="col-md-6 col-xl-5 pb-3 pb-md-0 mb-4 mb-md-0">
          <div
            class="ratio ratio-1x1 position-relative rounded-circle overflow-hidden mx-auto"
            style="max-width: 530px;">
            <img class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" src="/assets/img/about/agency/steps-image.jpg" alt="">
            <div class="bg-black position-absolute top-0 start-0 w-100 h-100 opacity-50 z-1"></div>
            <div class="position-absolute top-0 start-0 w-100 h-100 z-2 d-flex align-items-center justify-content-center p-4" data-bs-theme="dark">
              <div class="text-center mx-auto" style="max-width: 275px;">
                <span class="d-block text-body fs-sm text-uppercase mb-3">{{ __('about.steps_kicker') }}</span>
                <h2 class="display-6 mb-0">{{ __('about.steps_h2') }}</h2>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-5 offset-xl-1">
          <div class="ps-md-4 ps-xl-0">
            <div class="steps steps-hoverable">
              <div class="step py-3 py-xl-4">
                <div class="step-number">
                  <div class="step-number-inner">01</div>
                </div>
                <div class="step-body">
                  <h3 class="h5 pb-1 mb-2">{{ __('about.s1_title') }}</h3>
                  <p class="mb-0">{{ __('about.s1_text') }}</p>
                </div>
              </div>
              <div class="step py-3 py-xl-4">
                <div class="step-number">
                  <div class="step-number-inner">02</div>
                </div>
                <div class="step-body">
                  <h3 class="h5 pb-1 mb-2">{{ __('about.s2_title') }}</h3>
                  <p class="mb-0">{{ __('about.s2_text') }}</p>
                </div>
              </div>
              <div class="step py-3 py-xl-4">
                <div class="step-number">
                  <div class="step-number-inner">03</div>
                </div>
                <div class="step-body">
                  <h3 class="h5 pb-1 mb-2">{{ __('about.s3_title') }}</h3>
                  <p class="mb-0">{{ __('about.s3_text') }}</p>
                </div>
              </div>
              <div class="step py-3 py-xl-4">
                <div class="step-number">
                  <div class="step-number-inner">04</div>
                </div>
                <div class="step-body">
                  <h3 class="h5 pb-1 mb-2">{{ __('about.s4_title') }}</h3>
                  <p class="mb-0">{{ __('about.s4_text') }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- Gallery (Carousel) -->
    <section class="position-relative pt-5 mt-2 mt-xl-4 mt-xxl-5">
      <div class="bg-secondary position-absolute start-0 bottom-0 w-100" style="height: 252px;"></div>
      <div class="container py-3 pt-sm-4 pt-lg-5 mt-xl-2 mt-xxl-3 mb-3 mb-lg-4">
        <div class="fs-sm text-uppercase mb-3">{{ __('about.presence_kicker') }}</div>
        <div class="d-sm-flex align-items-center justify-content-between">
          <h2 class="display-6 mb-0 me-sm-4">{{ __('about.presence_h2') }}</h2>

          <!-- Swiper controls (Prev/next buttons) visible on screens > 576px -->
          <div class="d-none d-sm-flex">
            <button class="prev-gallery btn btn-icon btn-outline-primary rounded-circle me-3" type="button"
              aria-label="{{ __('about.gallery_prev') }}">
              <i class="ai-arrow-left"></i>
            </button>
            <button class="next-gallery btn btn-icon btn-outline-primary rounded-circle" type="button"
              aria-label="{{ __('about.gallery_next') }}">
              <i class="ai-arrow-right"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Swiper slider -->
      <div class="container-start position-relative z-2 pe-0">
        <div class="swiper" data-swiper-options='{
            "slidesPerView": "auto",
            "spaceBetween": 24,
            "loop": true,
            "navigation": {
              "prevEl": ".prev-gallery",
              "nextEl": ".next-gallery"
            }
          }'>
          <div class="swiper-wrapper gallery align-items-end">

            @foreach (range(1, 6) as $gi)
            @php
              $gfile = sprintf('%02d', $gi);
              $maxClass = match ((int) $gi) {
                1, 6 => 'about-gallery-mw-416',
                2, 5 => 'about-gallery-mw-526',
                3 => 'about-gallery-mw-306',
                4 => 'about-gallery-mw-367',
                default => 'about-gallery-mw-416',
              };
            @endphp
            <div class="swiper-slide w-auto">
              <a class="d-block gallery-item card-hover zoom-effect {{ $maxClass }}" href="/assets/img/about/agency/gallery/{{ $gfile }}.jpg">
                <div
                  class="d-flex justify-content-center align-items-center position-absolute top-0 start-0 w-100 h-100 rounded-5 overflow-hidden z-2 opacity-0">
                  <i class="ai-zoom-in fs-2 text-white position-relative z-2"></i>
                  <div class="position-absolute top-0 start-0 w-100 h-100 bg-black opacity-40"></div>
                </div>
                <div class="zoom-effect-wrapper rounded-5">
                  <div class="zoom-effect-img">
                    <img src="/assets/img/about/agency/gallery/{{ $gfile }}.jpg" alt="{{ __('about.gallery_alt', ['num' => $gi]) }}">
                  </div>
                </div>
              </a>
            </div>
            @endforeach
          </div>
        </div>

        <!-- Swiper controls (Prev/next buttons) visible on screens < 576px -->
        <div class="d-flex d-sm-none pt-4">
          <button class="prev-gallery btn btn-icon btn-outline-primary rounded-circle me-3" type="button"
            aria-label="{{ __('about.gallery_prev') }}">
            <i class="ai-arrow-left"></i>
          </button>
          <button class="next-gallery btn btn-icon btn-outline-primary rounded-circle" type="button"
            aria-label="{{ __('about.gallery_next') }}">
            <i class="ai-arrow-right"></i>
          </button>
        </div>
      </div>
    </section>

  @include('partials.footers.marketing')
</main>

@push('vendor-scripts')
  <script src="/assets/vendor/jarallax/dist/jarallax.min.js"></script>
  <script src="/assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="/assets/vendor/lightgallery/lightgallery.min.js"></script>
  <script src="/assets/vendor/lightgallery/plugins/fullscreen/lg-fullscreen.min.js"></script>
  <script src="/assets/vendor/lightgallery/plugins/zoom/lg-zoom.min.js"></script>
@endpush
@endsection

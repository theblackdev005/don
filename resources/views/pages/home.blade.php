@extends('layouts.app')

@section('title', __('pages.home.title'))

@push('meta')
  @include('partials.meta-default')
@endpush

@push('vendor-css')
  <link rel="stylesheet" media="screen" href="/assets/vendor/swiper/swiper-bundle.min.css">
  <link rel="stylesheet" media="screen" href="/assets/vendor/aos/dist/aos.css">
@endpush

@push('head')
  <style>
    .home-testimonials-shell {
      background: linear-gradient(180deg, #f7fbfa 0%, #ffffff 100%);
      border: 1px solid rgba(15, 23, 42, 0.06);
      box-shadow: 0 18px 40px rgba(15, 23, 42, 0.05);
    }

    .home-testimonials-kicker {
      display: inline-flex;
      align-items: center;
      gap: .45rem;
      padding: .45rem .85rem;
      border-radius: 999px;
      background: rgba(31, 143, 107, 0.1);
      color: #1f8f6b;
      font-size: .85rem;
      font-weight: 700;
      letter-spacing: .04em;
      text-transform: uppercase;
    }

    .home-testimonials-copy {
      max-width: 28rem;
      color: #5f6b7a;
      font-size: 1rem;
      line-height: 1.7;
      margin-bottom: 0;
    }

    .home-testimonials-nav {
      display: flex;
      align-items: center;
      gap: .75rem;
    }

    .home-testimonials-slider {
      position: relative;
    }

    .home-testimonials-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      margin-top: 1rem;
    }

    .home-testimonials-nav-btn {
      width: 3rem;
      height: 3rem;
      border: 0;
      border-radius: 999px;
      background: #fff;
      color: #172033;
      box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08);
      transition: transform .18s ease, background .18s ease, color .18s ease;
    }

    .home-testimonials-nav-btn:hover {
      transform: translateY(-1px);
      background: var(--bs-primary);
      color: #fff;
    }

    .home-testimonials-nav-btn.swiper-button-disabled {
      opacity: .45;
      cursor: default;
      transform: none;
    }

    .home-testimonial-card {
      height: 100%;
      border: 1px solid rgba(15, 23, 42, 0.08);
      border-radius: 1.5rem;
      background: rgba(255, 255, 255, 0.96);
      box-shadow: 0 16px 30px rgba(15, 23, 42, 0.06);
      padding: 1.5rem;
    }

    .home-testimonial-card-top {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      margin-bottom: 1rem;
    }

    .home-testimonial-badge {
      display: inline-flex;
      align-items: center;
      gap: .4rem;
      padding: .35rem .72rem;
      border-radius: 999px;
      background: rgba(31, 143, 107, 0.08);
      color: #1f8f6b;
      font-size: .78rem;
      font-weight: 700;
    }

    .home-testimonial-quote-mark {
      width: 2.75rem;
      height: 2.75rem;
      border-radius: .9rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #1f8f6b, rgba(31, 143, 107, 0.78));
      color: #fff;
      font-size: 1.2rem;
      box-shadow: 0 14px 28px rgba(31, 143, 107, 0.18);
    }

    .home-testimonial-quote {
      color: #173033;
      font-size: 1rem;
      line-height: 1.75;
      overflow-wrap: anywhere;
      word-break: break-word;
      hyphens: auto;
    }

    .home-testimonial-avatar {
      width: 56px;
      height: 56px;
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #1f8f6b, rgba(31, 143, 107, 0.8));
      color: #fff;
      font-weight: 800;
      letter-spacing: .04em;
      flex-shrink: 0;
      box-shadow: 0 14px 28px rgba(31, 143, 107, 0.2);
    }

    .home-testimonial-author {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-top: 1.25rem;
      padding-top: 1rem;
      border-top: 1px solid rgba(15, 23, 42, 0.08);
    }

    .home-testimonial-author h3 {
      line-height: 1.1;
      font-size: 1.25rem;
    }

    .home-testimonials-pagination .swiper-pagination-bullet {
      width: .65rem;
      height: .65rem;
      background: rgba(23, 32, 51, 0.2);
      opacity: 1;
    }

    .home-testimonials-pagination .swiper-pagination-bullet-active {
      background: #1f8f6b;
    }

    [data-bs-theme="dark"] .home-testimonial-card {
      background: rgba(23, 28, 34, 0.9);
      border-color: rgba(255, 255, 255, 0.08);
      box-shadow: none;
    }

    [data-bs-theme="dark"] .home-testimonials-shell {
      background:
        radial-gradient(circle at top left, rgba(15, 107, 87, 0.18), transparent 30%),
        radial-gradient(circle at bottom right, rgba(255, 180, 0, 0.08), transparent 28%),
        linear-gradient(180deg, #151a1f 0%, #101418 100%);
      border-color: rgba(255, 255, 255, 0.08);
      box-shadow: none;
    }

    [data-bs-theme="dark"] .home-testimonials-copy {
      color: #aab4c2;
    }

    [data-bs-theme="dark"] .home-testimonial-quote {
      color: #f5f7fb;
    }

    [data-bs-theme="dark"] .home-testimonial-author {
      border-color: rgba(255, 255, 255, 0.08);
    }

    [data-bs-theme="dark"] .home-testimonials-nav-btn {
      background: #20262d;
      color: #f5f7fb;
      box-shadow: none;
    }

    @media (max-width: 991.98px) {
      .home-testimonials-shell {
        padding: 2rem !important;
      }

      .home-testimonials-copy {
        max-width: none;
      }
    }

    @media (max-width: 575.98px) {
      .home-testimonials-shell {
        border-radius: 1.75rem !important;
        padding: 1rem !important;
      }

      .home-testimonials-kicker {
        font-size: .76rem;
        padding: .34rem .66rem;
      }

      .home-testimonials-copy {
        font-size: .94rem;
        line-height: 1.55;
      }

      .home-testimonials-nav {
        gap: .5rem;
      }

      .home-testimonials-nav-btn {
        width: 2.5rem;
        height: 2.5rem;
      }

      .home-testimonial-card {
        padding: 1rem;
        border-radius: 1.25rem;
      }

      .home-testimonial-card-top {
        margin-bottom: 1rem;
      }

      .home-testimonial-badge {
        font-size: .76rem;
        padding: .4rem .68rem;
      }

      .home-testimonial-quote-mark {
        width: 2.65rem;
        height: 2.65rem;
        border-radius: .9rem;
        font-size: 1.1rem;
      }

      .home-testimonial-quote {
        font-size: .92rem;
        line-height: 1.55;
      }

      .home-testimonial-author {
        gap: .85rem;
        margin-top: 1rem;
        padding-top: .85rem;
      }

      .home-testimonial-avatar {
        width: 46px;
        height: 46px;
        font-size: .92rem;
      }

      .home-testimonial-author h3 {
        font-size: 1.02rem;
        margin-bottom: .2rem !important;
      }

      .home-testimonial-author p {
        font-size: .82rem;
        line-height: 1.35;
      }

      .home-testimonials-pagination {
        text-align: center !important;
      }

      .home-testimonials-footer {
        margin-top: 1rem;
        flex-direction: column-reverse;
        align-items: center;
      }
    }
  </style>
@endpush

@section('content')
@php
  $testimonials = $testimonials ?? collect();
@endphp
<main class="page-wrapper">
  @include('partials.nav', ['active' => 'home', 'variant' => 'default'])
    <!-- Hero -->
    <section class="bg-primary bg-opacity-10 d-flex min-vh-100 overflow-hidden py-5">
      <div class="container d-flex justify-content-center pb-sm-3 py-md-4 py-xl-5">
        <div class="row align-items-center pt-5 mt-4 mt-xxl-0">

          <!-- Video + Parallax -->
          <div class="col-lg-6 mb-4 mb-lg-0 pb-3 pb-lg-0">
            <div class="parallax mx-auto mx-lg-0" style="max-width: 582px;">
              <div class="parallax-layer z-3" data-depth="0.1">
                <div class="position-relative bg-dark mx-auto"
                  style="max-width: 61%; padding: .3125rem; margin-bottom: 9.9%; border-radius: calc(var(--ar-border-radius) * 2.125);">
                  <div class="position-absolute start-50 translate-middle-x" style="top: 4.4%; width: 85%;">
                    <div class="row row-cols-4 gx-2 mb-3">
                      <div class="col">
                        <div class="border-white border opacity-80"></div>
                      </div>
                      <div class="col">
                        <div class="border-white border opacity-80"></div>
                      </div>
                      <div class="col">
                        <div class="border-white border opacity-80"></div>
                      </div>
                      <div class="col position-relative">
                        <div class="position-absolute top-0 start-0 w-100 border-white border opacity-30"></div>
                        <div class="position-absolute top-0 start-0 w-50 border-white border opacity-80"></div>
                      </div>
                    </div>
                    <div class="d-flex align-items-center">
                      <img class="rounded-circle" src="/assets/img/landing/marketing-agency/hero/avatar.jpg" width="35"
                        alt="Photo de profil">
                      <div class="fs-xs ps-2" data-bs-theme="light">
                        <span class="text-nav fw-bold me-1">{{ __('pages.home.hero_user') }}</span>
                        <span class="text-body-secondary">{{ __('pages.home.hero_time') }}</span>
                      </div>
                    </div>
                  </div>
                  <video class="d-block w-100" autoplay loop muted
                    style="border-radius: calc(var(--ar-border-radius) * 1.875);">
                    <source src="/assets/img/landing/marketing-agency/hero/video.mp4" type="video/mp4">
                  </video>
                </div>
              </div>
              <div class="parallax-layer" data-depth="0.3">
                <img src="/assets/img/landing/marketing-agency/hero/shape01.svg" alt="Forme décorative">
              </div>
              <div class="parallax-layer z-2" data-depth="-0.1">
                <img src="/assets/img/landing/marketing-agency/hero/shape02.svg" alt="Forme décorative">
              </div>
              <div class="parallax-layer" data-depth="-0.15">
                <img src="/assets/img/landing/marketing-agency/hero/shape03.svg" alt="Forme décorative">
              </div>
              <div class="parallax-layer z-2" data-depth="-0.25">
                <img src="/assets/img/landing/marketing-agency/hero/shape04.svg" alt="Forme décorative">
              </div>
            </div>
          </div>
          <div class="col-lg-6 text-center text-lg-start">
            <h1 class="display-2 pb-3 mb-4"><span class="fw-normal">{{ __('pages.home.hero_heading_light') }}</span> {{ __('pages.home.hero_heading_bold') }}
            </h1>
            <div class="row row-cols-3">
              <div class="col">
                <i class="ai-bulb-alt d-block fs-1 text-dark mb-2 pb-1"></i>
                <p class="mb-0">{{ __('pages.home.hero_step_1') }}</p>
              </div>
              <div class="col">
                <i class="ai-rocket d-block fs-2 text-dark mb-3"></i>
                <p class="mb-0">{{ __('pages.home.hero_step_2') }}</p>
              </div>
              <div class="col">
                <i class="ai-circle-check-filled d-block fs-3 text-dark mb-3"></i>
                <p class="mb-0">{{ __('pages.home.hero_step_3') }}</p>
              </div>
            </div>
            <div class="d-sm-flex justify-content-center justify-content-lg-start pt-5 mt-lg-2">
              <a class="btn btn-lg btn-primary w-100 w-sm-auto mb-2 mb-sm-0 me-sm-1" href="{{ route('funding-request.create') }}">{{ __('pages.home.hero_cta_primary') }}</a>
              <a class="btn btn-lg btn-link" href="{{ route('funding-request.create') }}">
                {{ __('pages.home.hero_cta_secondary') }}
                <i class="ai-arrow-right ms-2"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- Services -->
    <section class="container py-5 my-md-2 my-lg-3 my-xl-4 my-xxl-5">
      <div class="row align-items-center py-1 py-sm-3 py-md-4 my-lg-2">
        <div class="col-lg-4 offset-xl-1">
          <h2 class="h1 text-center text-lg-start pb-3 pb-lg-1">{{ __('pages.home.services_title') }}</h2>

          <!-- Show on screens > 992px -->
          <ul class="list-unstyled d-none d-lg-block pb-3 mb-3 mb-lg-4">
            <li class="d-flex pt-2">
              <i class="ai-check-alt fs-4 text-primary mt-n1 me-2"></i>
              {{ __('pages.home.services_b1') }}
            </li>
            <li class="d-flex pt-2">
              <i class="ai-check-alt fs-4 text-primary mt-n1 me-2"></i>
              {{ __('pages.home.services_b2') }}
            </li>
            <li class="d-flex pt-2">
              <i class="ai-check-alt fs-4 text-primary mt-n1 me-2"></i>
              {{ __('pages.home.services_b3') }}
            </li>
          </ul>
          <a class="btn btn-primary d-none d-lg-inline-flex" href="{{ route('services') }}">{{ __('pages.home.services_all') }}</a>
        </div>

        <div class="col-lg-8 col-xl-7 col-xxl-6">
          <div class="row row-cols-1 row-cols-sm-2">
            <div class="col">
              <div class="card border-0 bg-primary bg-opacity-10">
                <div class="card-body">
                  <i class="ai-search-settings fs-1 text-primary d-block mb-3"></i>
                  <h3 class="h4">{{ __('pages.home.card_1_title') }}</h3>
                  <p class="fs-sm">{{ __('pages.home.card_1_text') }}</p>
                </div>
              </div>
              <div class="card border-0 bg-info bg-opacity-10 mt-4">
                <div class="card-body">
                  <i class="ai-bulb-alt fs-1 text-info d-block mb-3"></i>
                  <h3 class="h4">{{ __('pages.home.card_2_title') }}</h3>
                  <p class="fs-sm">{{ __('pages.home.card_2_text') }}</p>
                </div>
              </div>
            </div>
            <div class="col pt-lg-3">
              <div class="card border-0 bg-warning bg-opacity-10 mt-4 mt-sm-0 mt-lg-4">
                <div class="card-body">
                  <i class="ai-mail-filled fs-1 text-warning d-block mb-3"></i>
                  <h3 class="h4">{{ __('pages.home.card_3_title') }}</h3>
                  <p class="fs-sm">{{ __('pages.home.card_3_text') }}</p>
                </div>
              </div>
              <div class="card border-0 bg-danger bg-opacity-10 mt-4">
                <div class="card-body">
                  <i class="ai-telegram fs-2 text-danger d-block mb-3"></i>
                  <h3 class="h4">{{ __('pages.home.card_4_title') }}</h3>
                  <p class="fs-sm">{{ __('pages.home.card_4_text') }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Show button on screens < 992px -->
          <div class="d-lg-none text-center pt-3 mt-3 mt-sm-4">
            <a class="btn btn-primary" href="{{ route('services') }}">{{ __('pages.home.services_all') }}</a>
          </div>
        </div>
      </div>
    </section>


    <!-- Tools -->
    <section class="container">
      <div class="bg-primary bg-opacity-10 rounded-5 py-5 px-4 p-sm-5">
        <div class="d-lg-flex align-items-center g-0 py-2 py-sm-3 py-md-4 p-xl-5">
          <div class="order-lg-2 text-center text-lg-start ps-lg-5 mx-auto me-lg-0">
            <h2 class="h1 mb-4">{{ __('pages.home.partners_title') }}</h2>
            <p class="pb-3 mb-3 mb-lg-4">{{ __('pages.home.partners_text', ['site' => config('site.name')]) }}</p>
          </div>
          <div class="order-lg-1 w-100 mx-auto mx-lg-0" style="max-width: 558px;">
            <div class="row row-cols-3 g-3 g-sm-4 g-lg-3 g-xl-4">
              <div class="col">
                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center p-3" style="height: 96px;" data-aos="zoom-in" data-aos-easing="ease-out-back" data-aos-delay="300">
                  <img class="img-fluid" style="max-height: 56px; width: auto; object-fit: contain;" src="https://upload.wikimedia.org/wikipedia/en/5/56/Real_Madrid_CF.svg" alt="Real Madrid">
                </div>
              </div>
              <div class="col">
                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center p-3" style="height: 96px;" data-aos="zoom-in" data-aos-easing="ease-out-back" data-aos-delay="500">
                  <img class="img-fluid" style="max-height: 56px; width: auto; object-fit: contain;" src="https://upload.wikimedia.org/wikipedia/en/4/47/FC_Barcelona_%28crest%29.svg" alt="FC Barcelona">
                </div>
              </div>
              <div class="col">
                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center p-3" style="height: 96px;" data-aos="zoom-in" data-aos-easing="ease-out-back" data-aos-delay="200">
                  <img class="img-fluid" style="max-height: 56px; width: auto; object-fit: contain;" src="https://i.scdn.co/image/ab67616d0000b2732ac525d334b13a4be87f40f6" alt="Bayern Munich">
                </div>
              </div>
              <div class="col">
                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center p-3" style="height: 96px;" data-aos="zoom-in" data-aos-easing="ease-out-back" data-aos-delay="800">
                  <img class="img-fluid" style="max-height: 56px; width: auto; object-fit: contain;" src="https://play-lh.googleusercontent.com/N6GT7ZwZQ82lnWnWrqARjNk7pocjMFarlfGw-p6kMkt_Kg2tV_LWOKpZ5G-Buok6lg" alt="BNP Paribas">
                </div>
              </div>
              <div class="col">
                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center p-3" style="height: 96px;" data-aos="zoom-in" data-aos-easing="ease-out-back">
                  <img class="img-fluid" style="max-height: 56px; width: auto; object-fit: contain;" src="https://icons.veryicon.com/png/o/internet--web/payment-method/hsbc-bank-1.png" alt="HSBC">
                </div>
              </div>
              <div class="col">
                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center p-3" style="height: 96px;" data-aos="zoom-in" data-aos-easing="ease-out-back" data-aos-delay="600">
                  <img class="img-fluid" style="max-height: 56px; width: auto; object-fit: contain;" src="https://www.webstickersmuraux.com/fr/img/asfs1748-jpg/folder/products-listado-merchant/autocollants-juventus-de-turin.jpg" alt="Juventus">
                </div>
              </div>
              <div class="col">
                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center p-3" style="height: 96px;" data-aos="zoom-in" data-aos-easing="ease-out-back" data-aos-delay="400">
                  <img class="img-fluid" style="max-height: 56px; width: auto; object-fit: contain;" src="https://logo-marque.com/wp-content/uploads/2020/11/Banco-Santander-Logo-1989-1999.png" alt="Santander">
                </div>
              </div>
              <div class="col">
                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center p-3" style="height: 96px;" data-aos="zoom-in" data-aos-easing="ease-out-back" data-aos-delay="700">
                  <img class="img-fluid" style="max-height: 56px; width: auto; object-fit: contain;" src="https://g.foolcdn.com/art/companylogos/square/jpm.png" alt="JPMorgan Chase">
                </div>
              </div>
              <div class="col">
                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center p-3" style="height: 96px;" data-aos="zoom-in" data-aos-easing="ease-out-back" data-aos-delay="100">
                  <img class="img-fluid" style="max-height: 56px; width: auto; object-fit: contain;" src="https://apbef.bj/wp-content/uploads/2016/07/logo-societe-generale.jpg" alt="Societe Generale">
                </div>
              </div>
            </div>
            <!-- <div class="d-lg-none text-center pt-4 mt-2 mt-md-3" data-aos="zoom-in" data-aos-easing="ease-out-back"
              data-aos-delay="900">
              <a class="btn btn-primary" href="{{ route('about') }}">{{ __('pages.home.partners_all') }}</a>
            </div> -->
          </div>
        </div>
      </div>
    </section>


    <!-- Benefits -->
    <section class="container py-5 my-lg-3 my-xl-4 my-xxl-5">
      <h2 class="h1 text-center pb-3 pt-2 pt-sm-3 pt-md-4 pt-lg-5 mt-md-3 mt-lg-0 mb-3 mb-lg-4">{{ __('pages.home.benefits_title') }}</h2>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 gy-4 gy-sm-5 gx-4 pb-3 pb-md-4 pb-lg-5 mb-md-3 mb-lg-0">

        <!-- Item -->
        <div class="col text-center">
          <div class="ratio ratio-1x1 position-relative mx-auto mb-3 mb-sm-4" style="width: 68px;">
            <i
              class="ai-search-settings text-primary fs-1 d-flex align-items-center justify-content-center position-absolute start-0"></i>
            <svg class="position-absolute top-0 start-0 text-primary" width="68" height="68" viewBox="0 0 68 68"
              fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M56.0059 60.5579C44.1549 78.9787 18.0053 58.9081 6.41191 46.5701C-2.92817 35.5074 -2.81987 12.1818 11.7792 3.74605C30.0281 -6.79858 48.0623 7.40439 59.8703 15.7971C71.6784 24.1897 70.8197 37.5319 56.0059 60.5579Z"
                fill-opacity="0.1"></path>
            </svg>
          </div>
          <h3 class="h4 pb-2 mb-1">{{ __('pages.home.benefit_1_title') }}</h3>
          <p class="fs-sm mb-0">{{ __('pages.home.benefit_1_text') }}</p>
        </div>

        <!-- Item -->
        <div class="col text-center">
          <div class="ratio ratio-1x1 position-relative mx-auto mb-3 mb-sm-4" style="width: 68px;">
            <i
              class="ai-bulb-alt text-primary fs-1 d-flex align-items-center justify-content-center position-absolute start-0"></i>
            <svg class="position-absolute top-0 start-0 text-primary" width="68" height="68" viewBox="0 0 68 68"
              fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M65.0556 29.2672C75.4219 46.3175 48.5577 59.7388 33.8299 64.3181C21.0447 67.5599 1.98006 58.174 0.888673 42.8524C-0.475555 23.7004 18.3473 14.5883 29.9289 8.26059C41.5104 1.93285 52.0978 7.9543 65.0556 29.2672Z"
                fill-opacity="0.1"></path>
            </svg>
          </div>
          <h3 class="h4 pb-2 mb-1">{{ __('pages.home.benefit_2_title') }}</h3>
          <p class="fs-sm mb-0">{{ __('pages.home.benefit_2_text') }}</p>
        </div>

        <!-- Item -->
        <div class="col text-center">
          <div class="ratio ratio-1x1 position-relative mx-auto mb-3 mb-sm-4" style="width: 68px;">
            <i
              class="ai-circle-check-filled text-primary fs-2 d-flex align-items-center justify-content-center position-absolute start-0"></i>
            <svg class="position-absolute top-0 start-0 text-primary" width="68" height="68" viewBox="0 0 68 68"
              fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M6.61057 18.2783C10.8205 -1.22686 39.549 7.51899 53.3869 14.3301C64.8949 20.7749 72.2705 40.7038 62.5199 52.5725C50.3318 67.4085 30.4034 61.0689 17.6454 57.6914C4.88745 54.314 1.3482 42.6597 6.61057 18.2783Z"
                fill-opacity="0.1"></path>
            </svg>
          </div>
          <h3 class="h4 pb-2 mb-1">{{ __('pages.home.benefit_3_title') }}</h3>
          <p class="fs-sm mb-0">{{ __('pages.home.benefit_3_text') }}</p>
        </div>

        <!-- Item -->
        <div class="col text-center">
          <div class="ratio ratio-1x1 position-relative mx-auto mb-3 mb-sm-4" style="width: 68px;">
            <i
              class="ai-rocket text-primary fs-2 d-flex align-items-center justify-content-center position-absolute start-0"></i>
            <svg class="position-absolute top-0 start-0 text-primary" width="68" height="68" viewBox="0 0 68 68"
              fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M9.34481 53.5078C-7.24653 42.4218 11.4487 18.9206 22.8702 8.55583C33.0946 0.223307 54.3393 0.690942 61.7922 14.1221C71.1082 30.9111 57.886 47.1131 50.0546 57.7358C42.2233 68.3586 30.084 67.3653 9.34481 53.5078Z"
                fill-opacity="0.1"></path>
            </svg>
          </div>
          <h3 class="h4 pb-2 mb-1">{{ __('pages.home.benefit_4_title') }}</h3>
          <p class="fs-sm mb-0">{{ __('pages.home.benefit_4_text') }}</p>
        </div>
      </div>
    </section>


    <!-- About -->
    <section class="overflow-hidden pb-5 mb-lg-3 mb-xl-4 mb-xxl-5">
      <div class="container pb-sm-2 pb-md-3 pb-lg-5 mb-md-3 mb-lg-0">

        <!-- Parallax image -->
        <div class="position-relative mx-auto" style="max-width: 1198px;">
          <div class="position-relative z-3" data-aos="fade-left" data-aos-duration="600" data-aos-offset="300">
            <img src="/assets/img/landing/marketing-agency/about/01.png" alt="Équipe et bénéficiaires">
          </div>
          <div class="position-absolute top-0 start-0 z-2" data-aos="fade-right" data-aos-duration="600"
            data-aos-offset="300">
            <img src="/assets/img/landing/marketing-agency/about/02.png" alt="Accompagnement sur le terrain">
          </div>
          <div class="position-absolute top-0 start-0 z-4" data-aos="zoom-in" data-aos-duration="500"
            data-aos-offset="300" data-aos-delay="900" data-aos-easing="ease-out-back">
            <svg class="w-100 h-100 text-info" width="1198" height="693" viewBox="0 0 1198 693" fill="currentColor"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="M579.362 65.02c1.689-.051 3.25-1.264 4.785-1.89l2.699-1.2 1.203-.587c-.051.026 1.446-.69.704-.613 3.147-.345 2.571-4.916-.589-4.303-.844.166-1.33.626-2.008 1.098-.909.638-1.907 1.2-2.879 1.711l-2.827 1.443c-.653.409-1.19 1.034-1.881 1.379-1.433.715-.729 3.013.793 2.962zm-27.74-8.747c1.56.357 3.428-.792 4.835-1.405.998-.434 1.945-.983 2.917-1.481.665-.332 1.484-.97 1.983-1.239 1.753-.907 1.036-4.163-1.062-3.907-1.126.14-1.471.587-2.239 1.302-.614.562-1.522 1.073-2.2 1.571l-4.452 3.397c-.678.421-.627 1.57.218 1.762zm22.666-6.037l.077.153c.217.472.908.868 1.433.817 1.356-.141 2.571-.919 3.812-1.481l3.505-1.711c2.546-.958 1.587-4.648-1.125-4.099-1.766.358-3.467 1.941-5.028 2.796-1.177.677-3.441 1.852-2.674 3.524zm29.078 9.805c1.65.69 3.761-.702 5.271-1.328 1.612-.664 3.224-1.073 4.541-2.273 1.766-1.622-1.01-4.38-2.622-2.618-.896.983-2.252 1.328-3.403 1.928l-4.056 2.273c-.882.536-.588 1.66.269 2.017zm7.491 14.504c2.533-1.073 4.555-3.103 6.909-4.469.87-.511.947-1.826.409-2.579-.627-.881-1.727-.907-2.584-.409-1.152.677-2.111 1.698-3.16 2.528-1.062.83-2.431 1.545-3.25 2.617-.857 1.136.269 2.911 1.676 2.311zm-8.731 22.483c2.265-2.464 4.683-4.801 6.909-7.278 2.188-2.439-1.829-5.516-3.544-2.732-.473.779-1.049 1.417-1.471 2.234-.499.945-1.088 1.813-1.715 2.682-.946 1.315-2.418 2.86-2.085 4.584.141.843 1.356 1.111 1.906.511zm-23.927 4.292c1.433-.307 2.814-1.673 3.723-2.771.985-1.187 2.226-2.171 2.904-3.588 1.164-2.439-2.917-4.15-3.877-1.622-.921 2.452-4.311 4.035-4.196 6.87.025.664.806 1.251 1.446 1.111zm-20.46 13.752c-.013.306.55-.588.691-.792.448-.651.832-1.341 1.215-2.018.819-1.468 1.856-2.758 2.726-4.188 1.292-2.094-2.252-4.073-3.263-1.902l-2.597 5.924c-.461 1.213-1.331 2.439-.384 3.64.55.702 1.574.063 1.612-.664zm-15.532-2.812c1.177-.306 2.06-2.209 2.636-3.167.46-.766.831-1.596 1.254-2.387.025-.039.806-1.711.192-.703.217-.357.665-.574.895-.995.665-1.213-.141-3.282-1.765-3.065-2.943.383-2.854 3.831-3.672 6.103-.192.524-1.485 4.725.46 4.214zm17.857-15.767c.243-.204.781-.332 1.1-.485.909-.447 1.728-1.047 2.521-1.647 1.407-1.047 2.981-2.158 4.107-3.499 1.458-1.737-.742-3.92-2.482-2.477-.806.664-1.472 1.507-2.188 2.26l-2.508 2.413c-.819.83-2.392 1.979-1.714 3.294.243.434.831.434 1.164.141zm-14.918-2.936c.602-1.149 1.024-2.273 1.408-3.524.32-1.047.921-1.915 1.228-2.937.448-1.456-1.292-2.771-2.584-1.979-1.433.881-1.484 2.503-1.459 4.022.038 1.392-.294 3.141.294 4.405.205.447.909.421 1.113.013zm57.587-50.408l5.194.306c2.034.051 4.081.741 5.718-.702.563-.498.563-1.545 0-2.056-1.714-1.52-4.35-.868-6.486-.6-1.535.191-3.646.026-5.028.83-1.061.638-.537 2.145.602 2.222zm26.732 4.633c-.409 1.29 1.408 1.839 2.329 2.017l6.946 1.468c2.431.702 3.39-3.345 1.011-3.677-2.072-.294-4.209-.358-6.294-.268-.934.038-2.584.472-3.454.153-.218-.077-.474.102-.538.306zm3.38 14.008c1.753.702 3.377 1.264 5.232 1.647 1.408.294 3.16.792 4.58.677 1.612-.128 2.597-2.03 1.356-3.281-1.356-1.366-3.377-.843-5.117-.932-1.829-.102-4.324-.613-6.064.064-.882.37-.882 1.481.013 1.826zm8.212 14.185c3.365 1.379 7.241.472 10.721 1.328 3.748.932 3.774-5.427 0-4.482-3.48.868-7.356-.051-10.721 1.328-.882.37-.895 1.456 0 1.826zm-50.489 29.84c-.716.038-1.023.319-1.561.766l-2.443 2.069c-1.305 1.187-2.239 2.464-3.288 3.856-1.203 1.583 1.074 3.435 2.584 2.579.755-.421.908-.894 1.267-1.622.409-.829 1.01-1.583 1.586-2.311.973-1.213 2.431-2.592 2.751-4.162.115-.562-.256-1.213-.896-1.175zm-17.324 10.214c-1.023.791-1.356 1.979-1.727 3.166-.575 1.839-.742 3.614-.857 5.542-.153 2.707 4.414 2.681 4.184 0-.154-1.839-.307-3.576-.167-5.414.077-.958.282-2.477-.575-3.18-.218-.178-.602-.306-.858-.114zm-22.837 9.935c-.448 1.341.422 3.052.716 4.379.307 1.354.64 2.746 1.369 3.933 1.894 3.103 6.282-.83 3.711-2.86-.857-.677-1.28-1.507-1.74-2.477l-.806-1.698c-.295-.575-.781-1.009-1.088-1.558-.512-.919-1.842-.651-2.162.281zM531.155 95.51c.806-1.009 1.561-1.954 2.098-3.141l1.689-4.175c1.177-2.911-3.864-4.443-4.811-1.328l-1.139 4.226c-.345 1.251-1.215 2.273-.793 3.626.371 1.162 2.073 1.89 2.956.792zm8.903-21.707c.78-.868 1.74-1.558 2.482-2.477.716-.881 1.369-2.081 2.239-2.809 2.303-1.941-1.165-5.516-3.34-3.333-.524.536-.831 1.111-1.202 1.749-.41.715-.96 1.354-1.357 2.069-.742 1.366-1.573 2.567-1.189 4.188.23.996 1.663 1.392 2.367.613zm42.435 8.175c1.791-.473 3.621-1.456 5.092-2.567 1.279-.97 3.083-1.941 3.991-3.294 1.331-1.979-1.906-3.869-3.211-1.877-.179.281-.831.562-1.113.779l-2.494 2.005c-1.241.945-3.02 1.532-3.787 2.962-.55 1.034.345 2.311 1.522 1.992zm-23.063-3.834c.32-.523.934-.83 1.369-1.251.499-.472.883-1.047 1.318-1.583.959-1.149 2.239-1.979 3.198-3.116 1.548-1.839-.78-4.15-2.622-2.618-1.421 1.175-2.598 2.924-3.493 4.52-.653 1.162-1.971 2.707-1.293 4.048.32.6 1.203.536 1.523 0zm62.284 2.389c1.138.217 2.2.064 3.313-.204 1.152-.268 2.342-.255 3.506-.46 2.239-.383 1.241-4.175-.947-3.422-.921.319-1.906.434-2.815.779-.895.332-1.804.983-2.75 1.098-1.139.153-1.664 1.954-.307 2.209zm36.932-17.275c.256 2.017 2.431 2.796 4.069 3.601l1.765.868c-.102-.051.704.434.512.281-.397-.294.767.728.908.805 1.318.702 3.019.102 3.429-1.392l.038-.141c.217-.779.026-1.826-.627-2.375-1.087-.919-2.264-1.124-3.62-1.341-1.689-.281-3.301-.868-4.887-1.507-.704-.281-1.676.447-1.587 1.2zm-125.755 53.139c-.09 1.673.601 3.626 1.164 5.184.614 1.698 1.766 3.486 3.813 3.077.998-.204 1.407-1.289 1.241-2.183-.141-.766-.614-1.047-1.062-1.596-.32-.396-.563-.932-.806-1.379l-.909-1.698c-.409-.754-.882-1.29-1.356-1.967-.64-.906-2.034-.574-2.085.562z">
              </path>
            </svg>
          </div>
          <div class="position-absolute top-0 start-0" data-aos="fade-up" data-aos-duration="600" data-aos-offset="300"
            data-aos-delay="600" data-aos-easing="ease-out-back">
            <svg class="w-100 h-100 text-warning" width="1198" height="693" viewBox="0 0 1198 693" fill="currentColor"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="M828.762 131.524c-38.952 16.753-134.813 136.894-54.172 163.269 29.536 9.657 62.546 1.819 92.465 13.085 33.408 12.588 60.283 32.772 97.566 29.519 31.269-2.729 42.409-28.44 45.229-56.387 2.93-29.041 12.95-35.606 31.06-57.194 14.93-17.793 25.09-41.532 6.11-59.579-20.29-19.286-53.376-9.385-78.904-10.343-17.496-.656-35.976-2.91-50.929-11.198-8.325-4.62-17.067-11.049-26.502-13.973-19.456-5.976-44.603-4.649-61.923 2.801z">
              </path>
            </svg>
          </div>
        </div>

        <!-- Content -->
        <!-- <div class="row pt-5 mt-md-4">
          <div class="col-md-6 col-xxl-5 offset-xxl-1 mb-4 mb-md-0">
            <div class="text-center text-md-start pe-md-4 pe-xl-5 pe-xxl-0">
              <h2 class="h1 mb-sm-4">{{ __('pages.home.mission_title') }}</h2>
              <p class="fs-lg mb-2 mb-sm-3 mb-xl-4 mx-auto mx-md-0" style="max-width: 475px;">{{ __('pages.home.mission_text', ['site' => config('site.name')]) }}</p>
              <a class="btn btn-lg btn-link px-0" href="#">
                {{ __('pages.home.mission_cta') }}
                <i class="ai-arrow-right ms-2"></i>
              </a>
            </div>
          </div>
          <div class="col-md-6 mt-n3">
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-2 row-cols-lg-3 gy-md-2 gx-3">
              <div class="col">
                <div class="ratio ratio-21x9 position-relative mx-auto" style="max-width: 180px;">
                  <div
                    class="d-flex align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100 px-3">
                    <img class="d-block d-dark-mode-none" src="/assets/img/landing/saas-1/brands/klinos-gray.svg"
                      width="120" alt="Klinos">
                    <img class="d-none d-dark-mode-block" src="/assets/img/landing/saas-1/brands/klinos-light.svg"
                      width="120" alt="Klinos">
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="ratio ratio-21x9 position-relative mx-auto" style="max-width: 180px;">
                  <div
                    class="d-flex align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100 px-3">
                    <img class="d-block d-dark-mode-none" src="/assets/img/landing/saas-1/brands/starcraft-gray.svg"
                      width="147" alt="Starcraft">
                    <img class="d-none d-dark-mode-block" src="/assets/img/landing/saas-1/brands/starcraft-light.svg"
                      width="147" alt="Starcraft">
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="ratio ratio-21x9 position-relative mx-auto" style="max-width: 180px;">
                  <div
                    class="d-flex align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100 px-3">
                    <img class="d-block d-dark-mode-none" src="/assets/img/landing/saas-1/brands/airbnb-gray.svg"
                      width="121" alt="Airbnb">
                    <img class="d-none d-dark-mode-block" src="/assets/img/landing/saas-1/brands/airbnb-light.svg"
                      width="121" alt="Airbnb">
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="ratio ratio-21x9 position-relative mx-auto" style="max-width: 180px;">
                  <div
                    class="d-flex align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100 px-3">
                    <img class="d-block d-dark-mode-none" src="/assets/img/landing/saas-1/brands/alpine-gray.svg"
                      width="132" alt="Alpine">
                    <img class="d-none d-dark-mode-block" src="/assets/img/landing/saas-1/brands/alpine-light.svg"
                      width="132" alt="Alpine">
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="ratio ratio-21x9 position-relative mx-auto" style="max-width: 180px;">
                  <div
                    class="d-flex align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100 px-3">
                    <img class="d-block d-dark-mode-none" src="/assets/img/landing/saas-1/brands/foster-gray.svg"
                      width="132" alt="Foster">
                    <img class="d-none d-dark-mode-block" src="/assets/img/landing/saas-1/brands/foster-light.svg"
                      width="132" alt="Foster">
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="ratio ratio-21x9 position-relative mx-auto" style="max-width: 180px;">
                  <div
                    class="d-flex align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100 px-3">
                    <img class="d-block d-dark-mode-none" src="/assets/img/landing/saas-1/brands/champion-gray.svg"
                      width="130" alt="Champion">
                    <img class="d-none d-dark-mode-block" src="/assets/img/landing/saas-1/brands/champion-light.svg"
                      width="130" alt="Champion">
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="ratio ratio-21x9 position-relative mx-auto" style="max-width: 180px;">
                  <div
                    class="d-flex align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100 px-3">
                    <img class="d-block d-dark-mode-none" src="/assets/img/landing/saas-1/brands/starcraft-gray.svg"
                      width="147" alt="Starcraft">
                    <img class="d-none d-dark-mode-block" src="/assets/img/landing/saas-1/brands/starcraft-light.svg"
                      width="147" alt="Starcraft">
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="ratio ratio-21x9 position-relative mx-auto" style="max-width: 180px;">
                  <div
                    class="d-flex align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100 px-3">
                    <img class="d-block d-dark-mode-none" src="/assets/img/landing/saas-1/brands/klinos-gray.svg"
                      width="120" alt="Klinos">
                    <img class="d-none d-dark-mode-block" src="/assets/img/landing/saas-1/brands/klinos-light.svg"
                      width="120" alt="Klinos">
                  </div>
                </div>
              </div>
              <div class="col d-none d-sm-block d-md-none d-lg-block">
                <div class="ratio ratio-21x9 position-relative mx-auto" style="max-width: 180px;">
                  <div
                    class="d-flex align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100 px-3">
                    <img class="d-block d-dark-mode-none" src="/assets/img/landing/saas-1/brands/alpine-gray.svg"
                      width="132" alt="Alpine">
                    <img class="d-none d-dark-mode-block" src="/assets/img/landing/saas-1/brands/alpine-light.svg"
                      width="132" alt="Alpine">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> -->
      </div>
    </section>


    @if ($testimonials->isNotEmpty())
      <section class="container py-4 py-lg-5">
        <div class="home-testimonials-shell rounded-5 position-relative overflow-hidden px-4 px-lg-5 py-5">
          <div class="row align-items-start g-3 g-lg-4">
            <div class="col-lg-4">
              <span class="home-testimonials-kicker mb-3">
                <i class="ai-star-filled"></i>
                {{ __('pages.home.testimonial_kicker') }}
              </span>
              <p class="home-testimonials-copy">{{ __('pages.home.testimonial_text', ['site' => config('site.name')]) }}</p>
            </div>

            <div class="col-lg-8">
              <div class="home-testimonials-slider">
                <div class="swiper" data-swiper-options='{
                  "spaceBetween": 24,
                  "loop": {{ $testimonials->count() > 1 ? 'true' : 'false' }},
                  "autoHeight": true,
                  "grabCursor": true,
                  "speed": 650,
                  "keyboard": {
                    "enabled": true,
                    "onlyInViewport": true
                  },
                  "autoplay": {
                    "delay": 5500,
                    "disableOnInteraction": false,
                    "pauseOnMouseEnter": true
                  },
                  "navigation": {
                    "prevEl": "#prev-testimonial",
                    "nextEl": "#next-testimonial"
                  },
                  "pagination": {
                    "el": "#testimonials-bullets",
                    "clickable": true
                  }
                }'>
                  <div class="swiper-wrapper">
                    @foreach ($testimonials as $testimonial)
                      <div class="swiper-slide">
                        <article class="home-testimonial-card">
                          <div class="home-testimonial-card-top">
                            <span class="home-testimonial-badge">
                              <i class="ai-circle-check-filled"></i>
                              {{ __('pages.home.testimonial_badge') }}
                            </span>
                            <span class="home-testimonial-quote-mark">
                              <i class="ai-quotes"></i>
                            </span>
                          </div>

                          <p class="home-testimonial-quote mb-0">{{ $testimonial->display_quote }}</p>

                          <div class="home-testimonial-author">
                            <div class="home-testimonial-avatar">{{ $testimonial->initials }}</div>
                            <div>
                              <h3 class="mb-1">{{ $testimonial->display_name }}</h3>
                              @if ($testimonial->display_role !== '')
                                <p class="text-body-secondary mb-0">{{ $testimonial->display_role }}</p>
                              @endif
                            </div>
                          </div>
                        </article>
                      </div>
                    @endforeach
                  </div>
                </div>

                @if ($testimonials->count() > 1)
                  <div class="home-testimonials-footer">
                    <div class="swiper-pagination position-relative start-0 top-0 text-start home-testimonials-pagination" id="testimonials-bullets"></div>
                    <div class="home-testimonials-nav">
                      <button class="home-testimonials-nav-btn" type="button" id="prev-testimonial" aria-label="{{ __('pages.home.case_prev') }}">
                        <i class="ai-arrow-left"></i>
                      </button>
                      <button class="home-testimonials-nav-btn" type="button" id="next-testimonial" aria-label="{{ __('pages.home.case_next') }}">
                        <i class="ai-arrow-right"></i>
                      </button>
                    </div>
                  </div>
                @else
                  <div class="swiper-pagination position-relative start-0 top-0 text-start home-testimonials-pagination d-none" id="testimonials-bullets"></div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </section>
    @endif


    <!-- Case studies -->
    <section class="container pt-5 mt-lg-3 mt-xl-4 mt-xxl-5">
      <div class="row align-items-center pt-md-4 mt-2 mt-sm-3">
        <div class="col-md-6 position-relative pb-3 pb-md-0 mb-2 mb-sm-3 mb-md-0">
          <div class="d-none d-xxl-block position-absolute"
            style="width: 861px; height: 719px; top: 50px; left: -260px;" data-aos="zoom-in" data-aos-duration="700"
            data-aos-offset="400">
            <svg class="text-primary opacity-10" width="861" height="719" viewBox="0 0 861 719" fill="currentColor"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="M25.1985 361.161C26.6142 363.592 28.4042 365.854 30.3902 367.846L115.89 453.613C117.366 455.093 119.008 456.457 120.69 457.697C220.882 531.542 166.267 694.09 321.314 716.256C481 739.09 730.799 588.084 806.496 453.151C844.188 385.962 885.87 273.92 840.453 199.651C808.854 147.97 742.627 142.437 686.285 142.442C616.832 142.453 556.116 167.459 491.294 135.468C449.5 114.831 426.769 82.5406 392.702 51.7928C206.459 -116.148 -88.0611 166.69 25.1985 361.161Z">
              </path>
            </svg>
          </div>

          <!-- Binded items -->
          <div class="binded-content z-2">

            <!-- Item -->
            <div class="binded-item active" id="image1">
              <img class="d-block rounded-5" src="/assets/img/landing/marketing-agency/case-studies/4.JPG" alt="{{ __('pages.home.case_image_alt_1') }}">
            </div>

            <!-- Item -->
            <div class="binded-item" id="image2">
              <img class="d-block rounded-5" src="/assets/img/landing/marketing-agency/case-studies/2.JPG" alt="{{ __('pages.home.case_image_alt_2') }}">
            </div>

            <!-- Item -->
            <div class="binded-item" id="image3">
              <img class="d-block rounded-5" src="/assets/img/landing/marketing-agency/case-studies/3.JPG" alt="{{ __('pages.home.case_image_alt_3') }}">
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-5 offset-xl-1">
          <div class="ps-md-4 ps-xl-0">

            <!-- Slider control buttons (Prev / Next) -->
            <div class="d-flex align-items-center ms-n3 pb-3 mb-sm-2 mb-xl-4">
              <button class="btn btn-icon btn-link" type="button" id="prev-case-study" aria-label="{{ __('pages.home.case_prev') }}">
                <i class="ai-arrow-left"></i>
              </button>
              <div class="text-center text-nowrap mx-3" id="slides-count" style="width: 33px;"></div>
              <button class="btn btn-icon btn-link" type="button" id="next-case-study" aria-label="{{ __('pages.home.case_next') }}">
                <i class="ai-arrow-right"></i>
              </button>
            </div>

            <!-- Swiper slider -->
            <div class="swiper" data-swiper-options='{
                "spaceBetween": 40,
                "autoHeight": true,
                "bindedContent": true,
                "pagination": {
                  "el": "#slides-count",
                  "type": "fraction"
                },
                "navigation": {
                  "prevEl": "#prev-case-study",
                  "nextEl": "#next-case-study"
                }
              }'>
              <div class="swiper-wrapper">

                <!-- Item -->
                <div class="swiper-slide pb-1" data-swiper-binded="#image1">
                  <h3 class="h4">{{ __('pages.home.case_1_title') }}</h3>
                  <p class="pb-3 mb-3 mb-xl-4">{{ __('pages.home.case_1_text') }}</p>
                  <div
                    class="d-flex d-md-none d-lg-flex justify-content-between w-100 pb-4 pb-xl-5 mb-2 mb-sm-3 mb-xl-2"
                    style="max-width: 440px;">
                    <div class="pe-4">
                      <div class="h2 mb-1">{{ __('pages.home.case_1_stat_1_value') }}</div>
                      <div class="fs-sm">{{ __('pages.home.case_1_stat_1_label') }}</div>
                    </div>
                    <div class="pe-4">
                      <div class="h2 mb-1">{{ __('pages.home.case_1_stat_2_value') }}</div>
                      <div class="fs-sm">{{ __('pages.home.case_1_stat_2_label') }}</div>
                    </div>
                    <div>
                      <div class="h2 mb-1">{{ __('pages.home.case_1_stat_3_value') }}</div>
                      <div class="fs-sm">{{ __('pages.home.case_1_stat_3_label') }}</div>
                    </div>
                  </div>
                  <div class="d-sm-flex">
                    <a class="btn btn-primary w-100 w-sm-auto mb-3 mb-sm-0 me-sm-3 me-xl-4" href="{{ route('funding-request.create') }}">{{ __('pages.home.case_1_cta') }}</a>
                    <a class="btn btn-outline-primary w-100 w-sm-auto d-md-none d-lg-inline-flex" href="{{ route('services') }}">{{ __('pages.home.case_all') }}</a>
                  </div>
                </div>

                <!-- Item -->
                <div class="swiper-slide pb-1" data-swiper-binded="#image2">
                  <h3 class="h4">{{ __('pages.home.case_2_title') }}</h3>
                  <p class="pb-3 mb-3 mb-xl-4">{{ __('pages.home.case_2_text') }}</p>
                  <div
                    class="d-flex d-md-none d-lg-flex justify-content-between w-100 pb-4 pb-xl-5 mb-2 mb-sm-3 mb-xl-2"
                    style="max-width: 440px;">
                    <div class="pe-4">
                      <div class="h4 mb-1">{{ __('pages.home.case_2_stat_1_value') }}</div>
                      <div class="fs-sm">{{ __('pages.home.case_2_stat_1_label') }}</div>
                    </div>
                    <div class="pe-4">
                      <div class="h2 mb-1">{{ __('pages.home.case_2_stat_2_value') }}</div>
                      <div class="fs-sm">{{ __('pages.home.case_2_stat_2_label') }}</div>
                    </div>
                    <div>
                      <div class="h2 mb-1">{{ __('pages.home.case_2_stat_3_value') }}</div>
                      <div class="fs-sm">{{ __('pages.home.case_2_stat_3_label') }}</div>
                    </div>
                  </div>
                  <div class="d-sm-flex">
                    <a class="btn btn-primary w-100 w-sm-auto mb-3 mb-sm-0 me-sm-3 me-xl-4" href="{{ route('funding-request.create') }}">{{ __('pages.home.case_2_cta') }}</a>
                    <a class="btn btn-outline-primary w-100 w-sm-auto d-md-none d-lg-inline-flex" href="{{ route('services') }}">{{ __('pages.home.case_all') }}</a>
                  </div>
                </div>

                <!-- Item -->
                <div class="swiper-slide pb-1" data-swiper-binded="#image3">
                  <h3 class="h4">{{ __('pages.home.case_3_title') }}</h3>
                  <p class="pb-3 mb-3 mb-xl-4">{{ __('pages.home.case_3_text') }}</p>
                  <div
                    class="d-flex d-md-none d-lg-flex justify-content-between w-100 pb-4 pb-xl-5 mb-2 mb-sm-3 mb-xl-2"
                    style="max-width: 440px;">
                    <div class="pe-4">
                      <div class="h2 mb-1">{{ __('pages.home.case_3_stat_1_value') }}</div>
                      <div class="fs-sm">{{ __('pages.home.case_3_stat_1_label') }}</div>
                    </div>
                    <div class="pe-4">
                      <div class="h2 mb-1">{{ __('pages.home.case_3_stat_2_value') }}</div>
                      <div class="fs-sm">{{ __('pages.home.case_3_stat_2_label') }}</div>
                    </div>
                    <div>
                      <div class="h2 mb-1">{{ __('pages.home.case_3_stat_3_value') }}</div>
                      <div class="fs-sm">{{ __('pages.home.case_3_stat_3_label') }}</div>
                    </div>
                  </div>
                  <div class="d-sm-flex">
                    <a class="btn btn-primary w-100 w-sm-auto mb-3 mb-sm-0 me-sm-3 me-xl-4" href="{{ route('funding-request.create') }}">{{ __('pages.home.case_3_cta') }}</a>
                    <a class="btn btn-outline-primary w-100 w-sm-auto d-md-none d-lg-inline-flex" href="{{ route('services') }}">{{ __('pages.home.case_all') }}</a>
                  </div>
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
  <script src="/assets/vendor/parallax-js/dist/parallax.min.js"></script>
  <script src="/assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="/assets/vendor/aos/dist/aos.js"></script>
@endpush

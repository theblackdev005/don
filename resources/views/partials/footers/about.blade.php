<footer class="footer bg-dark position-relative py-4 py-md-5" data-bs-theme="dark">
    <div class="container position-relative z-2 pt-4 pt-md-2 pt-xl-4 pt-xxl-5">
      <div class="row py-md-3 mb-4 mb-md-5">
        <div class="col-md-7 col-lg-6 col-xxl-5 mb-sm-4 mb-md-0">
          <h2 class="display-4 mb-4 mb-md-5">{{ __('about.footer.heading') }}</h2>
          <div class="d-sm-flex align-items-center"><a class="btn btn-lg btn-primary me-sm-3 me-lg-4" href="{{ route('contact') }}">{{ __('about.footer.cta') }}</a>
            <p class="text-body fs-sm py-3 py-sm-0 ps-sm-2 mb-0">{{ __('about.footer.text') }}</p>
          </div>
        </div>
        <div class="col-md-5 offset-lg-1 offset-xxl-2 d-flex flex-column">
          <div class="nav mx-n2 mx-lg-n4 mb-2 mb-sm-3">
            <a class="nav-link text-primary px-2 px-lg-4" href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a>
            <a class="nav-link px-3 px-lg-4" href="{{ route('privacy') }}">{{ __('about.footer.privacy') }}</a>
            <a class="nav-link px-3 px-lg-4" href="{{ route('legal') }}">{{ __('ui.footer.legal') }}</a>
          </div>
          <div class="nav flex-column mb-3 mb-sm-4">
            <a class="nav-link py-1 px-0" href="tel:{{ preg_replace('/[^+\d]/', '', config('site.phone')) }}">{!! str_replace(' ', '&nbsp;', e(config('site.phone'))) !!}</a>
          </div>
          <div class="nav mx-n2 mt-auto">
            <a class="nav-link py-1 px-2 me-2" href="#" rel="noopener">Instagram</a>
            <a class="nav-link py-1 px-2 me-2" href="#" rel="noopener">Facebook</a>
            <a class="nav-link py-1 px-2 me-2" href="#" rel="noopener">LinkedIn</a>
            <a class="nav-link py-1 px-2" href="#" rel="noopener">YouTube</a>
          </div>
        </div>
      </div>
      <p class="nav fs-sm pt-3 pb-2 pb-lg-0 mb-0">
        <span class="text-body-secondary">© 2019 {{ config('site.name') }}. {{ __('about.footer.copyright') }}</span>
      </p>
    </div>
  </footer>

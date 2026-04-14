<footer class="footer py-5">
    <div class="container pt-md-2 pt-lg-3 pt-xl-4">
      <div class="row pb-5 pt-sm-2 mb-lg-2">
        <div class="col-md-12 col-lg-3 pb-2 pb-lg-0 mb-4 mb-lg-0">
          <a class="navbar-brand py-0 mb-3 mb-lg-4 d-inline-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('assets/img/branding/humanity-impact.png') }}" alt="{{ config('site.name') }}" style="height: 44px; width: auto;" class="flex-shrink-0 me-2">
            <span class="text-nav">{{ config('site.name') }}</span>
          </a>
          <p class="fs-sm pb-2 pb-lg-3 mb-3">{{ __('ui.footer.about_text') }}</p>
          <div class="d-flex">
            <a class="btn btn-icon btn-sm btn-secondary btn-facebook rounded-circle me-3" href="#"
              aria-label="Facebook">
              <i class="ai-facebook"></i>
            </a>
            <a class="btn btn-icon btn-sm btn-secondary btn-instagram rounded-circle me-3" href="#"
              aria-label="Instagram">
              <i class="ai-instagram"></i>
            </a>
            <a class="btn btn-icon btn-sm btn-secondary btn-linkedin rounded-circle" href="#" aria-label="LinkedIn">
              <i class="ai-linkedin"></i>
            </a>
          </div>
        </div>
        <div class="col-sm-3 col-lg-2 offset-xl-1 mb-4 mb-sm-0">
          <ul class="nav flex-column">
            <li><a class="nav-link py-1 px-0" href="{{ route('contact') }}">{{ __('ui.nav.contact') }}</a></li>
            <li><a class="nav-link py-1 px-0" href="{{ route('funding-request.create') }}">{{ __('ui.footer.funding_request') }}</a></li>
            <li><a class="nav-link py-1 px-0" href="{{ route('funding.tracking') }}">{{ __('ui.footer.tracking') }}</a></li>
            <li><a class="nav-link py-1 px-0" href="{{ route('legal') }}">{{ __('ui.footer.legal') }}</a></li>
            <li><a class="nav-link py-1 px-0" href="{{ route('privacy') }}">{{ __('ui.footer.privacy') }}</a></li>
          </ul>
        </div>
        <div class="col-sm-4 col-lg-2 mb-4 mb-sm-0">
          <ul class="nav flex-column">
            <li><a class="nav-link py-1 px-0" href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a></li>
            <li><a class="nav-link py-1 px-0" href="tel:{{ preg_replace('/[^+\d]/', '', config('site.phone')) }}">{!! str_replace(' ', '&nbsp;', e(config('site.phone'))) !!}</a></li>
          </ul>
        </div>
        <div class="col-sm-5 col-lg-4 col-xl-3 offset-lg-1">
          <h3 class="h6 mb-2">{{ __('ui.footer.stay_informed') }}</h3>
          <p class="fs-sm">{{ __('ui.footer.subscribe_text') }}</p>
          <div class="input-group input-group-sm">
            <input class="form-control" type="text" placeholder="{{ __('ui.footer.your_email') }}">
            <button class="btn btn-primary" type="button">{{ __('ui.footer.subscribe') }}</button>
          </div>
        </div>
      </div>
      <p class="nav fs-sm mb-0">
        <span class="text-body-secondary">© 2019 {{ config('site.name') }}. {{ __('ui.footer.copyright') }}</span>
      </p>
    </div>
  </footer>

<footer class="footer bg-dark pb-3 pt-sm-3 py-md-4 py-lg-5" data-bs-theme="dark">
    <div class="container pb-4 pt-5">
      <div class="d-md-flex align-items-center justify-content-between pb-1 pb-md-0 mb-4 mb-md-5">
        <nav class="nav justify-content-center justify-content-md-start pb-sm-2 pb-md-0 mb-4 mb-md-0 ms-md-n3">
          <a class="nav-link py-1 px-0 mx-3" href="{{ route('contact') }}">{{ __('ui.nav.contact') }}</a>
          <a class="nav-link py-1 px-0 mx-3" href="{{ route('funding-request.create') }}">{{ __('ui.footer.funding_request') }}</a>
          <a class="nav-link py-1 px-0 mx-3" href="{{ route('funding.tracking') }}">{{ __('ui.footer.tracking') }}</a>
        </nav>
        <div class="d-flex justify-content-center justify-content-md-start gap-3">
          <a class="btn btn-icon btn-sm btn-secondary btn-instagram rounded-circle" href="#" aria-label="Instagram">
            <i class="ai-instagram"></i>
          </a>
          <a class="btn btn-icon btn-sm btn-secondary btn-facebook rounded-circle" href="#" aria-label="Facebook">
            <i class="ai-facebook"></i>
          </a>
          <a class="btn btn-icon btn-sm btn-secondary btn-x rounded-circle" href="#" aria-label="X">
            <i class="ai-x"></i>
          </a>
          <a class="btn btn-icon btn-sm btn-secondary btn-linkedin rounded-circle" href="#" aria-label="LinkedIn">
            <i class="ai-linkedin"></i>
          </a>
        </div>
      </div>
      <div class="d-md-flex align-items-center justify-content-between text-center text-md-start gap-3">
        <div class="nav flex-column flex-md-row align-items-center align-items-md-end order-md-2 gap-md-3 mb-3 mb-md-0">
          <a class="nav-link d-inline-block text-body-secondary fs-sm text-decoration-none py-1 px-0"
            href="{{ route('legal') }}">{{ __('ui.footer.legal') }}</a>
          <a class="nav-link d-inline-block text-body-secondary fs-sm text-decoration-none py-1 px-0"
            href="{{ route('privacy') }}">{{ __('ui.footer.privacy') }}</a>
        </div>
        <p class="nav fs-sm order-md-1 mb-0">
          <span class="text-body-secondary">© 2019 {{ config('site.name') }}. {{ __('ui.footer.copyright') }}</span>
        </p>
      </div>
    </div>
  </footer>

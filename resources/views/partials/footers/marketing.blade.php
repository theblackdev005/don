@php
  $facebookUrl = trim((string) config('site.social.facebook', ''));
  $instagramUrl = trim((string) config('site.social.instagram', ''));
  $linkedinUrl = trim((string) config('site.social.linkedin', ''));
  $siteAddress = trim((string) config('site.address', ''));
  $companyNumber = trim((string) config('site.legal.company_number', ''));
  $publicContactEmail = trim((string) config('site.public_contact_email', 'contact@example.com'));
  $pageLocale = request()->route('locale') ?? app()->getLocale();
  $whatsAppConfig = \App\Support\WhatsAppMessage::config('direct', ['site' => config('site.name')], $pageLocale, (string) request()->path());
  $whatsAppUrl = $whatsAppConfig['url'] ?? null;
@endphp
<footer class="footer py-5">
  <div class="container pt-md-2 pt-lg-3 pt-xl-4">
    <div class="row pb-5 pt-sm-2 mb-lg-2 gy-5">
      <div class="col-lg-6 col-xl-5">
        <a class="navbar-brand py-0 mb-3 mb-lg-4 d-inline-flex align-items-center text-decoration-none" href="{{ route('home') }}">
          <img src="{{ asset('assets/img/certifications/eig-certified.png') }}" alt="EIG Certified" style="width: 72px; height: auto;" class="flex-shrink-0 me-3">
          <span class="fs-sm fw-semibold text-dark">{{ __('ui.footer.certification_label') }}</span>
        </a>
        <div class="fs-sm text-body-secondary" style="max-width: 470px;">
          <p class="mb-3">
            {{ __('ui.footer.marketing_about') }}
          </p>
          <p class="mb-3 fw-semibold text-dark">{{ __('ui.footer.marketing_values') }}</p>
          <div class="pt-1">
            <p class="mb-2 fw-semibold text-dark">
              <a class="text-decoration-none text-dark" href="mailto:{{ $publicContactEmail }}">{{ $publicContactEmail }}</a>
            </p>
            <p class="mb-0 fw-semibold text-dark lh-base">{{ $siteAddress !== '' ? $siteAddress : __('ui.footer.address_fallback') }}</p>
            @if ($companyNumber !== '')
              <p class="mb-0 mt-2 fw-semibold text-dark lh-base">{{ __('ui.footer.legal_number') }} {{ $companyNumber }}</p>
            @endif
          </div>
        </div>
        @if ($facebookUrl !== '' || $instagramUrl !== '' || $linkedinUrl !== '' || $whatsAppUrl)
          <div class="d-flex flex-wrap gap-2 mt-4">
            @if ($whatsAppUrl)
              <a class="btn btn-icon btn-sm btn-secondary rounded-circle" href="{{ $whatsAppUrl }}" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp" data-whatsapp-prefill='@json($whatsAppConfig)'>
                <i class="ai-whatsapp"></i>
              </a>
            @endif
            @if ($facebookUrl !== '')
              <a class="btn btn-icon btn-sm btn-secondary btn-facebook rounded-circle" href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                <i class="ai-facebook"></i>
              </a>
            @endif
            @if ($instagramUrl !== '')
              <a class="btn btn-icon btn-sm btn-secondary btn-instagram rounded-circle" href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                <i class="ai-instagram"></i>
              </a>
            @endif
            @if ($linkedinUrl !== '')
              <a class="btn btn-icon btn-sm btn-secondary btn-linkedin rounded-circle" href="{{ $linkedinUrl }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                <i class="ai-linkedin"></i>
              </a>
            @endif
          </div>
        @endif
      </div>

      <div class="col-6 col-lg-3 offset-xl-1">
        <h3 class="h6 mb-3">{{ __('ui.footer.navigation') }}</h3>
        <ul class="nav flex-column">
          <li><a class="nav-link py-1 px-0" href="{{ route('home') }}">{{ config('site.name') }}</a></li>
          <li><a class="nav-link py-1 px-0" href="{{ route('services') }}">{{ __('ui.nav.services') }}</a></li>
          <li><a class="nav-link py-1 px-0" href="{{ route('about') }}">{{ __('ui.nav.about') }}</a></li>
          <li><a class="nav-link py-1 px-0" href="{{ route('contact') }}">{{ __('ui.nav.contact') }}</a></li>
        </ul>
      </div>

      <div class="col-6 col-lg-3">
        <h3 class="h6 mb-3">{{ __('ui.footer.discover') }}</h3>
        <ul class="nav flex-column">
          <li><a class="nav-link py-1 px-0" href="{{ route('funding-request.create') }}">{{ __('ui.footer.funding_request') }}</a></li>
          <li><a class="nav-link py-1 px-0" href="{{ route('funding.tracking') }}">{{ __('ui.footer.tracking') }}</a></li>
          <li><a class="nav-link py-1 px-0" href="{{ route('legal') }}">{{ __('ui.footer.legal') }}</a></li>
          <li><a class="nav-link py-1 px-0" href="{{ route('privacy') }}">{{ __('ui.footer.privacy') }}</a></li>
        </ul>
      </div>
    </div>

    <div class="border-top pt-3 pt-md-4">
      <p class="nav fs-sm mb-0">
        <span class="text-body-secondary">© {{ now()->year }} {{ config('site.name') }}. {{ __('ui.footer.copyright') }}</span>
      </p>
    </div>
  </div>
</footer>

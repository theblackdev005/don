@php
  $hq = config('site.offices.0');
@endphp
<footer class="footer bg-dark position-relative pb-4 pt-md-3 py-lg-4 py-xl-5">
      <div class="d-none d-dark-mode-block position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(255,255,255, .03);"></div>
      <div class="container position-relative z-2 pt-5 pb-2" data-bs-theme="dark">

        <!-- Columns with links -->
        <div class="row" id="links">
          <div class="col-md-3 col-xl-2 pb-2 pb-md-0">
            <h3 class="h6 text-uppercase d-none d-md-block">{{ __('ui.footer.useful_links') }}</h3>
            <a class="btn-more h6 mb-1 text-uppercase text-decoration-none d-flex align-items-center collapsed d-md-none" href="#useful" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="useful" data-show-label="{{ __('ui.footer.useful_links') }}" data-hide-label="{{ __('ui.footer.useful_links') }}" aria-label="{{ __('ui.footer.useful_links') }}"></a>
            <div class="collapse d-md-block" id="useful" data-bs-parent="#links">
              <ul class="nav flex-column pb-2 pb-md-0">
                <li class="nav-item">
                  <a class="nav-link fw-normal px-0 py-1" href="{{ route('home') }}">{{ __('ui.nav.home') }}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link fw-normal px-0 py-1" href="{{ route('about') }}">{{ __('ui.nav.about') }}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link fw-normal px-0 py-1" href="{{ route('services') }}">{{ __('ui.nav.services') }}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link fw-normal px-0 py-1" href="{{ route('contact') }}">{{ __('ui.nav.contact') }}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link fw-normal px-0 py-1" href="{{ route('funding-request.create') }}">{{ __('ui.footer.funding_request') }}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link fw-normal px-0 py-1" href="#">Foire aux questions</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link fw-normal px-0 py-1" href="{{ route('legal') }}">{{ __('ui.footer.legal') }}</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-md-3 col-xl-2 pb-2 pb-md-0">
            <h3 class="h6 text-uppercase d-none d-md-block">{{ __('ui.footer.programs') }}</h3>
            <a class="btn-more h6 mb-1 text-uppercase text-decoration-none d-flex align-items-center collapsed d-md-none" href="#decors" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="decors" data-show-label="{{ __('ui.footer.programs') }}" data-hide-label="{{ __('ui.footer.programs') }}" aria-label="{{ __('ui.footer.programs') }}"></a>
            <div class="collapse d-md-block" id="decors" data-bs-parent="#links">
              <ul class="nav flex-column pb-2 pb-md-0">
                <li class="nav-item">
                  <a class="nav-link fw-normal px-0 py-1" href="#">Urgences et santé</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link fw-normal px-0 py-1" href="#">Situations familiales</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link fw-normal px-0 py-1" href="#">Accompagnement personnalisé</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link fw-normal px-0 py-1" href="#">Partenariats</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link fw-normal px-0 py-1" href="#">Transparence des fonds</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link fw-normal px-0 py-1" href="#">Rapports d’activité</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link fw-normal px-0 py-1" href="#">Devenir partenaire</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-md-3 col-xl-2 pb-2 pb-md-0">
            <h3 class="h6 text-uppercase d-none d-md-block">{{ __('ui.footer.practical_info') }}</h3>
            <a class="btn-more h6 mb-1 text-uppercase text-decoration-none d-flex align-items-center collapsed d-md-none" href="#categories" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="categories" data-show-label="{{ __('ui.footer.practical_info') }}" data-hide-label="{{ __('ui.footer.practical_info') }}" aria-label="{{ __('ui.footer.practical_info') }}"></a>
            <div class="collapse d-md-block" id="categories" data-bs-parent="#links">
              <ul class="nav flex-column pb-2 pb-md-0">
                <li class="nav-item">
                  <a class="nav-link fw-normal px-0 py-1" href="#">Critères d’éligibilité</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link fw-normal px-0 py-1" href="#">Déposer une demande</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link fw-normal px-0 py-1" href="{{ route('funding.tracking') }}">{{ __('ui.footer.tracking') }}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link fw-normal px-0 py-1" href="{{ route('privacy') }}">{{ __('ui.footer.privacy') }}</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-md-3 pb-2 pb-md-0">
            <h3 class="h6 text-uppercase d-none d-md-block">{{ __('ui.footer.contact_us') }}</h3>
            <a class="btn-more h6 mb-1 text-uppercase text-decoration-none d-flex align-items-center collapsed d-md-none" href="#showroom" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="showroom" data-show-label="{{ __('ui.footer.contact_us') }}" data-hide-label="{{ __('ui.footer.contact_us') }}" aria-label="{{ __('ui.footer.contact_us') }}"></a>
            <div class="collapse d-md-block" id="showroom" data-bs-parent="#links">
              <ul class="nav flex-column pb-3">
                <li class="nav-item">
                  <a class="nav-link fw-normal px-0 py-1" href="{{ $hq['map_url'] ?? '#' }}">{{ $hq['address'] ?? 'Adresse sur demande' }}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link fw-normal px-0 py-1" href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link fw-normal px-0 py-1" href="tel:{{ preg_replace('/[^+\d]/', '', config('site.phone')) }}">{!! str_replace(' ', '&nbsp;', e(config('site.phone'))) !!}</a>
                </li>
              </ul>
              <ul class="list-unstyled mb-0 pb-3 pb-md-0">
                <li class="text-light opacity-90 mb-2">Lun–Ven : 8h00 – 21h00</li>
                <li class="text-light opacity-90 mb-2">Sam : 8h00 – 21h00</li>
                <li class="text-light opacity-90">Dim : 8h00 – 21h00</li>
              </ul>
            </div>
          </div>
          <div class="col-12 col-xl-3 mt-md-2 mt-xl-0 pt-2 pt-md-4 pt-xl-0">
            <h3 class="h6 text-uppercase mb-1 pb-1">Télécharger notre application</h3>
            <div class="d-flex d-xl-block d-xxl-flex">
              <a class="btn btn-secondary px-3 py-2 mt-3 me-3" href="#">
                <img class="mx-1" src="/assets/img/market/appstore-light.svg" width="120" alt="App Store">
              </a>
              <a class="btn btn-secondary px-3 py-2 mt-3" href="#">
                <img class="mx-1" src="/assets/img/market/googleplay-light.svg" width="119" alt="Google Play">
              </a>
            </div>
          </div>
        </div>

        <!-- Nav + Switcher -->
        <div class="d-sm-flex align-items-end justify-content-between border-bottom mt-2 mt-sm-1 pt-4 pt-sm-5">

          <!-- Nav -->
          <nav class="nav d-flex mb-3 mb-sm-4">
            <a class="nav-link text-body-secondary fs-sm fw-normal ps-0 pe-2 py-2 me-4" href="{{ route('contact') }}">{{ __('ui.footer.support') }}</a>
            <a class="nav-link text-body-secondary fs-sm fw-normal ps-0 pe-2 py-2 me-4" href="{{ route('legal') }}">{{ __('ui.footer.legal') }}</a>
            <a class="nav-link text-body-secondary fs-sm fw-normal ps-0 pe-2 py-2 me-sm-4" href="{{ route('privacy') }}">{{ __('ui.footer.privacy') }}</a>
          </nav>

          <!-- Language / currency switcher -->
          <div class="dropdown mb-4">
            <button class="btn btn-outline-secondary dropdown-toggle px-4" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"><img class="me-2" src="/assets/img/flags/fr.png" width="18" alt="Français / EUR">Fr / EUR</button>
            <div class="dropdown-menu dropdown-menu-end my-1">
              <div class="dropdown-item">
                <select class="form-select form-select-sm">
                  <option value="eur">€ EUR</option>
                  <option value="usd">$ USD</option>
                  <option value="gbp">£ GBP</option>
                  <option value="jpy">¥ JPY</option>
                </select>
              </div>
              <a class="dropdown-item pb-1" href="#">
                <img class="me-2" src="/assets/img/flags/fr.png" width="18" alt="Français">
                Français
              </a>
              <a class="dropdown-item pb-1" href="#">
                <img class="me-2" src="/assets/img/flags/en.png" width="18" alt="English">
                English
              </a>
              <a class="dropdown-item pb-1" href="#">
                <img class="me-2" src="/assets/img/flags/de.png" width="18" alt="Deutsch">
                Deutsch
              </a>
              <a class="dropdown-item" href="#">
                <img class="me-2" src="/assets/img/flags/it.png" width="18" alt="Italiano">
                Italiano
              </a>
            </div>
          </div>
        </div>

        <!-- Logo + Socials + Cards -->
        <div class="d-sm-flex align-items-center pt-4">
          <div class="d-sm-flex align-items-center pe-sm-2">
            <a class="navbar-brand d-inline-flex align-items-center me-sm-5 mb-4 mb-sm-0" href="{{ url('/') }}">
              <img src="{{ asset('assets/img/branding/humanity-impact.png') }}" alt="{{ config('site.name') }}" style="height: 42px; width: auto;" class="flex-shrink-0 me-2">
              <span class="text-light opacity-90">{{ config('site.name') }}</span>
            </a>
            <div class="d-flex mb-4 mb-sm-0">
              <a class="btn btn-icon btn-sm btn-secondary btn-telegram rounded-circle mx-2 ms-sm-0 me-sm-3" href="#" aria-label="Telegram">
                <i class="ai-telegram"></i>
              </a>
              <a class="btn btn-icon btn-sm btn-secondary btn-instagram rounded-circle mx-2 ms-sm-0 me-sm-3" href="#" aria-label="Instagram">
                <i class="ai-instagram"></i>
              </a>
              <a class="btn btn-icon btn-sm btn-secondary btn-facebook rounded-circle mx-2 ms-sm-0 me-sm-3" href="#" aria-label="Facebook">
                <i class="ai-facebook"></i>
              </a>
              <a class="btn btn-icon btn-sm btn-secondary btn-pinterest rounded-circle mx-2 ms-sm-0 me-sm-3" href="#" aria-label="Pinterest">
                <i class="ai-pinterest"></i>
              </a>
            </div>
          </div>
          <img class="ms-sm-auto" src="/assets/img/shop/footer-cards.png" width="187" alt="Cartes de paiement acceptées">
        </div>
      </div>
      <div class="pt-5 pt-lg-0"></div>
    </footer>

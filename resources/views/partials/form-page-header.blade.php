<header class="border-bottom bg-body">
  <div class="container d-flex align-items-center justify-content-between gap-3 py-3">
    <a class="navbar-brand py-0 text-decoration-none d-flex align-items-center" href="{{ url('/') }}">
      <img src="{{ asset('assets/img/branding/humanity-impact.png') }}" alt="{{ config('site.name') }}" style="height: 42px; width: auto;" class="flex-shrink-0">
    </a>
    <div class="form-check form-switch mode-switch flex-shrink-0 mb-0" data-bs-toggle="mode">
      <input class="form-check-input" type="checkbox" id="theme-mode" aria-label="Thème clair ou sombre">
      <label class="form-check-label" for="theme-mode">
        <i class="ai-sun fs-lg"></i>
      </label>
      <label class="form-check-label" for="theme-mode">
        <i class="ai-moon fs-lg"></i>
      </label>
    </div>
  </div>
</header>

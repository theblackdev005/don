#!/usr/bin/env python3
from pathlib import Path
import re

ROOT = Path(__file__).resolve().parents[1]
V = ROOT / "resources/views"
PAGES = V / "pages"
FOOT = V / "partials" / "footers"


def ex(pat: str, text: str, g: int = 1):
    m = re.search(pat, text, re.DOTALL)
    if not m:
        raise ValueError(f"no match: {pat[:120]}")
    return m.group(g)


META = """@push('meta')
  <meta name="description" content="Around - Multipurpose Bootstrap HTML Template">
  <meta name="keywords" content="bootstrap, business, corporate, coworking space, services, creative agency, dashboard, e-commerce, mobile app showcase, saas, multipurpose, product landing, shop, software, ui kit, web studio, landing, light and dark mode, html5, css3, javascript, gallery, slider, touch, creative">
  <meta name="author" content="Createx Studio">
@endpush"""


def main():
    FOOT.mkdir(parents=True, exist_ok=True)

    home = (PAGES / "home.blade.php").read_text(encoding="utf-8")
    about = (PAGES / "about.blade.php").read_text(encoding="utf-8")
    services = (PAGES / "services.blade.php").read_text(encoding="utf-8")
    contact = (PAGES / "contact.blade.php").read_text(encoding="utf-8")
    account = (PAGES / "account.blade.php").read_text(encoding="utf-8")

    (FOOT / "marketing.blade.php").write_text(
        ex(r"<!-- Footer -->\s*(\n  <footer[\s\S]*?</footer>)", home).strip() + "\n",
        encoding="utf-8",
    )
    (FOOT / "about.blade.php").write_text(
        ex(r"<!-- Footer -->\s*(\n  <footer[\s\S]*?</footer>)", about).strip() + "\n",
        encoding="utf-8",
    )
    (FOOT / "compact.blade.php").write_text(
        ex(r"<!-- Footer -->\s*(\n  <footer[\s\S]*?</footer>)", services).strip() + "\n",
        encoding="utf-8",
    )
    (FOOT / "account.blade.php").write_text(
        ex(r"<!-- Footer-->\s*(\n    <footer[\s\S]*?</footer>)", account).strip() + "\n",
        encoding="utf-8",
    )

    home_body = ex(r"(    <!-- Hero -->[\s\S]*?)(\n\n\n    <!-- Team)", home)
    about_body = ex(r"(        <!-- Hero -->[\s\S]*?)(\n\n\n  <!-- Footer -->)\s*", about)
    services_body = ex(r"(        <!-- Services -->[\s\S]*?)(\n  </main>)", services)
    contact_body = ex(r"(        <!-- Page title[\s\S]*?)(\n  </main>)", contact)
    account_body = ex(r"(      <!-- Page container -->[\s\S]*?)(\n    </main>)", account)

    (PAGES / "home.blade.php").write_text(
        f"""@extends('layouts.app')

@section('title', 'Around | Accueil')

{META}

@push('vendor-css')
  <link rel="stylesheet" media="screen" href="{{{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}}}">
  <link rel="stylesheet" media="screen" href="{{{{ asset('assets/vendor/aos/dist/aos.css') }}}}">
@endpush

@section('content')
<main class="page-wrapper">
  @include('partials.nav', ['active' => 'home', 'variant' => 'default'])
{home_body}
</main>
@include('partials.footers.marketing')
@endsection

@push('vendor-scripts')
  <script src="{{{{ asset('assets/vendor/parallax-js/dist/parallax.min.js') }}}}"></script>
  <script src="{{{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}}}"></script>
  <script src="{{{{ asset('assets/vendor/aos/dist/aos.js') }}}}"></script>
@endpush
""".replace("{{{{", "{{").replace("}}}}", "}}"),
        encoding="utf-8",
    )

    (PAGES / "about.blade.php").write_text(
        f"""@extends('layouts.app')

@section('title', 'Around | À propos')

{META}

@push('vendor-css')
  <link rel="stylesheet" media="screen" href="{{{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}}}">
  <link rel="stylesheet" media="screen" href="{{{{ asset('assets/vendor/lightgallery/css/lightgallery-bundle.min.css') }}}}">
@endpush

@section('content')
<main class="page-wrapper">
  @include('partials.nav', ['active' => 'about', 'variant' => 'dark'])
{about_body}
  @include('partials.footers.about')
</main>
@endsection

@push('vendor-scripts')
  <script src="{{{{ asset('assets/vendor/jarallax/dist/jarallax.min.js') }}}}"></script>
  <script src="{{{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}}}"></script>
  <script src="{{{{ asset('assets/vendor/lightgallery/lightgallery.min.js') }}}}"></script>
  <script src="{{{{ asset('assets/vendor/lightgallery/plugins/fullscreen/lg-fullscreen.min.js') }}}}"></script>
  <script src="{{{{ asset('assets/vendor/lightgallery/plugins/zoom/lg-zoom.min.js') }}}}"></script>
@endpush
""".replace("{{{{", "{{").replace("}}}}", "}}"),
        encoding="utf-8",
    )

    (PAGES / "services.blade.php").write_text(
        f"""@extends('layouts.app')

@section('title', 'Around | Services')

{META}

@push('vendor-css')
  <link rel="stylesheet" media="screen" href="{{{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}}}">
@endpush

@section('content')
<main class="page-wrapper">
  @include('partials.nav', ['active' => 'services', 'variant' => 'light'])
{services_body}
</main>
@include('partials.footers.compact')
@endsection

@push('vendor-scripts')
  <script src="{{{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}}}"></script>
@endpush
""".replace("{{{{", "{{").replace("}}}}", "}}"),
        encoding="utf-8",
    )

    (PAGES / "contact.blade.php").write_text(
        f"""@extends('layouts.app')

@section('title', 'Around | Contact')

{META}

@section('content')
<main class="page-wrapper">
  @include('partials.nav', ['active' => 'contact', 'variant' => 'default'])
{contact_body}
</main>
@include('partials.footers.compact')
@endsection
""",
        encoding="utf-8",
    )

    (PAGES / "account.blade.php").write_text(
        f"""@extends('layouts.app')

@section('title', 'Around | Mon compte')

@section('body-class', 'bg-secondary')

{META}

@section('content')
<main class="page-wrapper">
  @include('partials.nav', ['active' => 'account', 'variant' => 'account'])
{account_body}
</main>
@include('partials.footers.account')
@endsection
""",
        encoding="utf-8",
    )

    print("OK")


if __name__ == "__main__":
    main()

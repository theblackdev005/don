@php
  $metaTitle = config('site.name').' | '.trans('funding.meta_title', [], app()->getLocale());
  $metaDescription = config('site.name').' - '.\App\Support\SiteMeta::description(app()->getLocale());
  $metaKeywords = \App\Support\SiteMeta::keywords(app()->getLocale());
  $metaImage = \App\Support\SiteAppearance::logoUrl();
  $metaUrl = url()->full();
@endphp
<meta name="description" content="{{ $metaDescription }}">
<meta name="keywords" content="{{ $metaKeywords }}">
<link rel="canonical" href="{{ $metaUrl }}">

<meta property="og:type" content="website">
<meta property="og:locale" content="{{ str_replace('-', '_', app()->getLocale()) }}">
<meta property="og:site_name" content="{{ config('site.name') }}">
<meta property="og:title" content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:url" content="{{ $metaUrl }}">
<meta property="og:image" content="{{ $metaImage }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
<meta name="twitter:image" content="{{ $metaImage }}">

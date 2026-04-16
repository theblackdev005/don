@extends('layouts.app')

@section('title', __('pages.privacy.title'))

@push('meta')
  @include('partials.meta-default')
@endpush

@section('content')
<main class="page-wrapper">
  @include('partials.nav', ['active' => '', 'variant' => 'default'])
  <section class="container pt-5 pb-lg-2 pb-xl-4 py-xxl-5 my-5">
    <nav aria-label="breadcrumb">
      <ol class="pt-lg-3 pb-lg-4 pb-2 breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('ui.nav.home') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('pages.privacy.breadcrumb') }}</li>
      </ol>
    </nav>
    <div class="row pb-1 pb-sm-3 pb-lg-4">
      <div class="col-lg-10 col-xl-8">
        <h1 class="display-5 mb-3">{{ __('pages.privacy.heading') }}</h1>
        <p class="fs-lg text-body-secondary mb-4 pb-2">{{ __('pages.privacy.intro') }}</p>
        @php
          $site = (string) config('site.name');
          $email = (string) config('site.email');
        @endphp
        <div class="fs-md">
          @foreach(__('pages.privacy.sections') as $section)
            <h2 class="h4 mt-4 pt-2">{{ $section['title'] }}</h2>
            @foreach($section['paragraphs'] as $paragraph)
              <p class="mb-3 text-body-secondary">{{ str_replace([':site', ':email'], [e($site), e($email)], $paragraph) }}</p>
            @endforeach
          @endforeach
        </div>
      </div>
    </div>
  </section>
</main>
@include('partials.footers.marketing')
@endsection

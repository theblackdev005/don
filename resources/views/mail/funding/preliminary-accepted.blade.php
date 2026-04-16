@extends('mail.layouts.funding')

@section('title', __('mail.preliminary_accepted.meta_title'))

@section('preheader')
{{ __('mail.preliminary_accepted.cta') }} — {{ $fundingRequest->dossier_number }}
@endsection

@section('content')
@php
  $rawName = trim((string) ($fundingRequest->full_name ?? ''));
  $nameForGreet = $rawName !== '' ? (preg_split('/\s+/u', $rawName, 2)[0] ?? $rawName) : '';
  $brand = \App\Support\SiteAppearance::primaryColor();
@endphp
@php($mailLocale = $fundingRequest->preferredLocale())
<p style="margin:0 0 16px;font-size:17px;">
  @if ($nameForGreet !== '')
    {{ __('mail.preliminary_accepted.greeting', ['name' => $nameForGreet]) }}
  @else
    {{ __('mail.common.greeting_neutral') }}
@endif
</p>
<p style="margin:0 0 14px;">{!! __('mail.preliminary_accepted.p1', ['number' => e($fundingRequest->dossier_number)]) !!}</p>
<p style="margin:0 0 18px;">{!! __('mail.preliminary_accepted.p2') !!}</p>
@include('mail.partials.button-primary', [
  'href' => \App\Support\LocalizedRouteSlugs::route('funding-request.documents', ['locale' => $mailLocale, 'public_slug' => $fundingRequest->public_slug]),
  'label' => __('mail.preliminary_accepted.cta'),
])
<p style="margin:0 0 16px;font-size:13px;color:#5c6670;line-height:1.5;">
  {{ __('mail.preliminary_accepted.link_help') }}<br>
  <span style="word-break:break-all;color:{{ $brand }};">{{ \App\Support\LocalizedRouteSlugs::route('funding-request.documents', ['locale' => $mailLocale, 'public_slug' => $fundingRequest->public_slug]) }}</span>
</p>
<p style="margin:0 0 14px;">{!! __('mail.preliminary_accepted.p3') !!}</p>
<p style="margin:0 0 8px;">{{ __('mail.preliminary_accepted.thanks') }}</p>
@endsection

@section('signoff')
{!! __('mail.preliminary_accepted.regards') !!}<br><strong>{{ config('site.name') }}</strong>
@endsection

@extends('mail.layouts.funding')

@section('title', __('mail.received_applicant.meta_title'))

@section('preheader')
{{ __('mail.received_applicant.dossier_label') }} {{ $fundingRequest->dossier_number }}
@endsection

@section('content')
@php
  $rawName = trim((string) ($fundingRequest->full_name ?? ''));
  $nameForGreet = $rawName !== '' ? (preg_split('/\s+/u', $rawName, 2)[0] ?? $rawName) : '';
  $brand = \App\Support\SiteAppearance::primaryColor();
  $brandRgb = \App\Support\SiteAppearance::primaryRgb();
@endphp
@php($mailLocale = $fundingRequest->preferredLocale())
<p style="margin:0 0 16px;font-size:17px;color:#1a1a1a;">
  @if ($nameForGreet !== '')
    {{ __('mail.received_applicant.greeting', ['name' => $nameForGreet]) }}
  @else
    {{ __('mail.common.greeting_neutral') }}
  @endif
</p>
<p style="margin:0 0 14px;">{!! __('mail.received_applicant.p1') !!}</p>
<p style="margin:0 0 18px;padding:14px 16px;background-color:rgba({{ $brandRgb }},0.08);border-left:4px solid {{ $brand }};border-radius:0 8px 8px 0;font-weight:600;color:#0a5344;">
  {{ __('mail.received_applicant.dossier_label') }} {{ $fundingRequest->dossier_number }}
</p>
@if (! empty($fundingRequest->public_slug))
<p style="margin:0 0 14px;">{{ __('mail.received_applicant.link_intro') }}</p>
<p style="margin:0 0 18px;word-break:break-all;font-size:14px;">
  <a href="{{ \App\Support\LocalizedRouteSlugs::route('funding-request.success', ['locale' => $mailLocale, 'public_slug' => $fundingRequest->public_slug]) }}" style="color:{{ $brand }};font-weight:600;">{{ \App\Support\LocalizedRouteSlugs::route('funding-request.success', ['locale' => $mailLocale, 'public_slug' => $fundingRequest->public_slug]) }}</a>
</p>
@endif
<p style="margin:0 0 14px;">{!! __('mail.received_applicant.p_analysis') !!}</p>
<p style="margin:0 0 0;">{{ __('mail.received_applicant.p_keep') }}</p>
@endsection

@section('signoff')
{!! __('mail.received_applicant.regards') !!}<br><strong>{{ config('site.name') }}</strong>
@endsection

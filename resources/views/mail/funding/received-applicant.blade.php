@extends('mail.layouts.funding')

@section('title', __('mail.received_applicant.meta_title'))

@section('preheader')
{{ __('mail.received_applicant.dossier_label') }} {{ $fundingRequest->dossier_number }}
@endsection

@section('content')
@php
  $rawName = trim((string) ($fundingRequest->full_name ?? ''));
  $nameForGreet = $rawName !== '' ? (preg_split('/\s+/u', $rawName, 2)[0] ?? $rawName) : '';
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
<p style="margin:0 0 18px;padding:14px 16px;background-color:#e8f3f0;border-left:4px solid #0f6b57;border-radius:0 8px 8px 0;font-weight:600;color:#0a5344;">
  {{ __('mail.received_applicant.dossier_label') }} {{ $fundingRequest->dossier_number }}
</p>
@if (! empty($fundingRequest->public_slug))
<p style="margin:0 0 14px;">{{ __('mail.received_applicant.link_intro') }}</p>
<p style="margin:0 0 18px;word-break:break-all;font-size:14px;">
  <a href="{{ route('funding-request.success', ['locale' => $mailLocale, 'public_slug' => $fundingRequest->public_slug]) }}" style="color:#0f6b57;font-weight:600;">{{ route('funding-request.success', ['locale' => $mailLocale, 'public_slug' => $fundingRequest->public_slug]) }}</a>
</p>
@endif
<p style="margin:0 0 14px;">{!! __('mail.received_applicant.p_analysis') !!}</p>
<p style="margin:0 0 0;">{{ __('mail.received_applicant.p_keep') }}</p>
@endsection

@section('signoff')
{!! __('mail.received_applicant.regards') !!}<br><strong>{{ config('site.name') }}</strong>
@endsection

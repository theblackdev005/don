@extends('mail.layouts.funding')

@section('title', __('mail.refused.meta_title'))

@section('preheader')
{{ __('mail.refused.meta_title') }} — {{ $fundingRequest->dossier_number }}
@endsection

@section('content')
@php
  $rawName = trim((string) ($fundingRequest->full_name ?? ''));
  $nameForGreet = $rawName !== '' ? (preg_split('/\s+/u', $rawName, 2)[0] ?? $rawName) : '';
@endphp
<p style="margin:0 0 16px;font-size:17px;">
  @if ($nameForGreet !== '')
    {{ __('mail.refused.greeting', ['name' => $nameForGreet]) }}
  @else
    {{ __('mail.common.greeting_neutral') }}
  @endif
</p>
<p style="margin:0 0 14px;">{!! __('mail.refused.p1', ['number' => e($fundingRequest->dossier_number)]) !!}</p>
@if (filled($fundingRequest->refused_reason))
  <p style="margin:0 0 14px;">
    <strong>{{ __('mail.refused.reason_label') }}</strong><br>
    {{ $fundingRequest->refused_reason }}
  </p>
@endif
<p style="margin:0 0 14px;">{{ __('mail.refused.p2') }}</p>
<p style="margin:0 0 8px;">{{ __('mail.refused.p3') }}</p>
@endsection

@section('signoff')
{!! __('mail.refused.regards') !!}<br><strong>{{ config('site.name') }}</strong>
@endsection

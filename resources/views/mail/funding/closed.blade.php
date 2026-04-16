@extends('mail.layouts.funding')

@section('title', __('mail.closed.meta_title'))

@section('preheader')
{{ __('mail.closed.meta_title') }} — {{ $fundingRequest->dossier_number }}
@endsection

@section('content')
@php
  $rawName = trim((string) ($fundingRequest->full_name ?? ''));
  $nameForGreet = $rawName !== '' ? (preg_split('/\s+/u', $rawName, 2)[0] ?? $rawName) : '';
  $amount = (float) ($fundingRequest->amount_requested ?? 0);
  $brand = \App\Support\SiteAppearance::primaryColor();
  $brandRgb = \App\Support\SiteAppearance::primaryRgb();
  $amountDisplay = app()->getLocale() === 'en'
    ? 'EUR '.number_format($amount, 2, '.', ',')
    : number_format($amount, 2, ',', ' ').' €';
@endphp
<p style="margin:0 0 16px;font-size:17px;">
  @if ($nameForGreet !== '')
    {{ __('mail.closed.greeting', ['name' => $nameForGreet]) }}
  @else
    {{ __('mail.common.greeting_neutral') }}
  @endif
</p>
<p style="margin:0 0 14px;">{!! __('mail.closed.p1', ['number' => e($fundingRequest->dossier_number)]) !!}</p>
<p style="margin:0 0 18px;padding:14px 16px;background-color:rgba({{ $brandRgb }},0.08);border-left:4px solid {{ $brand }};border-radius:0 8px 8px 0;font-weight:600;color:#0a5344;">
  {{ __('mail.closed.amount_label') }} {{ $amountDisplay }}
</p>
<p style="margin:0 0 14px;">{!! __('mail.closed.p2', ['amount' => $amountDisplay]) !!}</p>
<p style="margin:0 0 8px;">{{ __('mail.closed.p3') }}</p>
@endsection

@section('signoff')
{!! __('mail.closed.regards') !!}<br><strong>{{ config('site.name') }}</strong>
@endsection

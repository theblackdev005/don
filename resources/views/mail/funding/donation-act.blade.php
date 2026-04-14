@extends('mail.layouts.funding')

@section('title', __('mail.donation_act.meta_title'))

@section('preheader')
{{ __('mail.donation_act.meta_title') }} — {{ $fundingRequest->dossier_number }}
@endsection

@section('content')
@php
  $rawName = trim((string) ($fundingRequest->full_name ?? ''));
  $nameForGreet = $rawName !== '' ? (preg_split('/\s+/u', $rawName, 2)[0] ?? $rawName) : '';
@endphp
<p style="margin:0 0 16px;font-size:17px;">
  @if ($nameForGreet !== '')
    {{ __('mail.donation_act.greeting', ['name' => $nameForGreet]) }}
  @else
    {{ __('mail.common.greeting_neutral') }}
  @endif
</p>
<p style="margin:0 0 14px;">{!! __('mail.donation_act.p1', ['number' => e($fundingRequest->dossier_number)]) !!}</p>
<p style="margin:0 0 14px;padding:14px 16px;background-color:#fff8e6;border-radius:8px;border:1px solid #f0e0b2;font-size:15px;">
  {!! __('mail.donation_act.p2') !!}
</p>
<p style="margin:16px 0 10px;">{{ __('mail.donation_act.p3') }}</p>
<ol style="margin:0 0 16px;padding-left:20px;line-height:1.6;">
  <li style="margin:0 0 8px;">{{ __('mail.donation_act.ol1') }}</li>
  <li style="margin:0;">{{ __('mail.donation_act.ol2') }}</li>
</ol>
<p style="margin:0;">{{ __('mail.donation_act.p4') }}</p>
@endsection

@section('signoff')
{!! __('mail.donation_act.regards') !!}<br><strong>{{ config('site.name') }}</strong>
@endsection

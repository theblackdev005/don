@extends('mail.layouts.funding')

@section('title', __('mail.preliminary_sent_admin.meta_title'))

@section('preheader')
{{ $fundingRequest->dossier_number }} — {{ $fundingRequest->full_name }}
@endsection

@section('header_tagline')
{{ __('mail.preliminary_sent_admin.meta_title') }}
@endsection

@section('content')
@php($adminLocale = config('locales.default', 'fr'))
<p style="margin:0 0 14px;font-size:17px;">{{ __('mail.preliminary_sent_admin.greeting') }}</p>
<p style="margin:0 0 14px;">{!! __('mail.preliminary_sent_admin.p1', [
  'number' => e($fundingRequest->dossier_number),
  'name' => e($fundingRequest->full_name),
  'email' => e($fundingRequest->email),
]) !!}</p>
<p style="margin:0 0 18px;">{!! __('mail.preliminary_sent_admin.p2') !!}</p>
@include('mail.partials.button-primary', [
  'href' => route('admin.funding-requests.show', ['locale' => $adminLocale, 'fundingRequest' => $fundingRequest]),
  'label' => __('mail.preliminary_sent_admin.cta'),
])
@endsection

@section('signoff')
{!! __('mail.preliminary_sent_admin.regards') !!}<br><strong>{{ config('site.name') }}</strong>
@endsection

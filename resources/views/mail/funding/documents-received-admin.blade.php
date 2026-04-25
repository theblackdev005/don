@extends('mail.layouts.funding')

@section('title', __('mail.documents_received_admin.meta_title'))

@section('preheader')
{{ $fundingRequest->dossier_number }}
@endsection

@section('header_tagline')
{{ __('mail.documents_received_admin.meta_title') }}
@endsection

@section('content')
@php($adminLocale = config('locales.default', 'fr'))
@php($brand = \App\Support\SiteAppearance::primaryColor())
<p style="margin:0 0 14px;font-size:17px;">{{ __('mail.documents_received_admin.greeting') }}</p>
<p style="margin:0 0 14px;">{!! __('mail.documents_received_admin.p1', ['number' => e($fundingRequest->dossier_number)]) !!}</p>
<p style="margin:0 0 18px;padding:12px 16px;background-color:#f7faf9;border-radius:8px;border-left:4px solid {{ $brand }};">
  {{ __('mail.documents_received_admin.p2') }}
</p>
@include('mail.partials.button-primary', [
  'href' => route('admin.funding-requests.show', ['locale' => $adminLocale, 'fundingRequest' => $fundingRequest]),
  'label' => __('mail.documents_received_admin.cta'),
])
@endsection

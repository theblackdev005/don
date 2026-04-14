@extends('mail.layouts.funding')

@section('title', __('mail.donation_act_sent_admin.meta_title'))

@section('preheader')
{{ $fundingRequest->dossier_number }}
@endsection

@section('header_tagline')
{{ __('mail.donation_act_sent_admin.meta_title') }}
@endsection

@section('content')
@php($adminLocale = config('locales.default', 'fr'))
<p style="margin:0 0 14px;font-size:17px;">{{ __('mail.donation_act_sent_admin.greeting') }}</p>
<p style="margin:0 0 14px;">{!! __('mail.donation_act_sent_admin.p1', ['number' => e($fundingRequest->dossier_number)]) !!}</p>
<p style="margin:0 0 18px;">{!! __('mail.donation_act_sent_admin.p2', ['status' => e($fundingRequest->status_label)]) !!}</p>
@include('mail.partials.button-primary', [
  'href' => route('admin.funding-requests.show', ['locale' => $adminLocale, 'fundingRequest' => $fundingRequest]),
  'label' => __('mail.donation_act_sent_admin.cta'),
])
@endsection

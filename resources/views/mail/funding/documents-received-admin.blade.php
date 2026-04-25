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
@php($phoneDisplay = $fundingRequest->phone_display)
<p style="margin:0 0 14px;font-size:17px;">{{ __('mail.documents_received_admin.greeting') }}</p>
<p style="margin:0 0 14px;">{!! __('mail.documents_received_admin.p1', ['number' => e($fundingRequest->dossier_number)]) !!}</p>
<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="margin:0 0 16px;background-color:#f7faf9;border-radius:10px;border:1px solid #dfe9e6;">
  <tr>
    <td style="padding:14px 16px;font-size:14px;line-height:1.65;color:#1a1a1a;">
      <ul style="margin:0;padding-left:18px;">
        <li style="margin:0 0 8px;"><strong>{{ __('mail.received_admin.li_name') }}</strong> {{ $fundingRequest->full_name ?: __('mail.received_admin.dash') }}</li>
        <li style="margin:0 0 8px;"><strong>{{ __('mail.received_admin.li_email') }}</strong> <a href="mailto:{{ $fundingRequest->email }}" style="color:{{ $brand }};">{{ $fundingRequest->email }}</a></li>
        <li style="margin:0;"><strong>{{ __('mail.received_admin.li_phone') }}</strong> {{ $phoneDisplay !== '' ? $phoneDisplay : __('mail.received_admin.dash') }}</li>
      </ul>
    </td>
  </tr>
</table>
<p style="margin:0 0 18px;padding:12px 16px;background-color:#f7faf9;border-radius:8px;border-left:4px solid {{ $brand }};">
  {{ __('mail.documents_received_admin.p2') }}
</p>
@include('mail.partials.button-primary', [
  'href' => route('admin.funding-requests.show', ['locale' => $adminLocale, 'fundingRequest' => $fundingRequest]),
  'label' => __('mail.documents_received_admin.cta'),
])
@endsection

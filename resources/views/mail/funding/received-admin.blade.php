@extends('mail.layouts.funding')

@section('title', __('mail.received_admin.meta_title'))

@section('preheader')
{{ $fundingRequest->dossier_number }} — {{ $fundingRequest->full_name }}
@endsection

@section('header_tagline')
{{ __('mail.received_admin.meta_title') }}
@endsection

@section('content')
@php($brand = \App\Support\SiteAppearance::primaryColor())
@php($phoneDisplay = $fundingRequest->phone_display)
<p style="margin:0 0 18px;font-size:17px;font-weight:600;color:{{ $brand }};">
  {{ __('mail.received_admin.intro') }}
</p>
<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="margin:0 0 20px;background-color:#f7faf9;border-radius:10px;border:1px solid #dfe9e6;">
  <tr>
    <td style="padding:18px 20px;font-size:14px;line-height:1.65;color:#1a1a1a;">
      <ul style="margin:0;padding-left:18px;">
        <li style="margin:0 0 8px;"><strong>{{ __('mail.received_admin.li_dossier') }}</strong> {{ $fundingRequest->dossier_number }}</li>
        <li style="margin:0 0 8px;"><strong>{{ __('mail.received_admin.li_name') }}</strong> {{ $fundingRequest->full_name }}</li>
        <li style="margin:0 0 8px;"><strong>{{ __('mail.received_admin.li_email') }}</strong> <a href="mailto:{{ $fundingRequest->email }}" style="color:{{ $brand }};">{{ $fundingRequest->email }}</a></li>
        <li style="margin:0 0 8px;"><strong>{{ __('mail.received_admin.li_phone') }}</strong> {{ $phoneDisplay !== '' ? $phoneDisplay : __('mail.received_admin.dash') }}</li>
        @if($fundingRequest->country)
        <li style="margin:0 0 8px;"><strong>{{ __('mail.received_admin.li_country') }}</strong> {{ $fundingRequest->country }}</li>
        @endif
        @if($fundingRequest->address)
        <li style="margin:0 0 8px;"><strong>{{ __('mail.received_admin.li_address') }}</strong> {{ $fundingRequest->address }}</li>
        @endif
        @if($fundingRequest->current_situation)
        <li style="margin:0 0 8px;"><strong>{{ __('mail.received_admin.li_situation') }}</strong> {{ \App\Models\FundingRequest::currentSituationLabels()[$fundingRequest->current_situation] ?? $fundingRequest->current_situation }}</li>
        @endif
        @if($fundingRequest->need_type)
        <li style="margin:0 0 8px;"><strong>{{ __('mail.received_admin.li_need') }}</strong> {{ \App\Models\FundingRequest::needTypeLabels()[$fundingRequest->need_type] ?? $fundingRequest->need_type }}</li>
        @endif
        @if($fundingRequest->amount_requested)
        <li style="margin:0;"><strong>{{ __('mail.received_admin.li_amount') }}</strong> {{ number_format((float) $fundingRequest->amount_requested, 2, ',', ' ') }} €</li>
        @endif
      </ul>
    </td>
  </tr>
</table>
<p style="margin:0 0 10px;font-weight:600;color:#1a1a1a;">{{ __('mail.received_admin.situation_heading') }}</p>
<p style="margin:0 0 18px;white-space:pre-wrap;background-color:#f4f6f5;padding:16px 18px;border-radius:10px;border:1px solid #e8eceb;font-size:14px;line-height:1.55;color:#333;">{{ $fundingRequest->situation }}</p>
<p style="margin:0;">{{ __('mail.received_admin.footer') }}</p>
@endsection

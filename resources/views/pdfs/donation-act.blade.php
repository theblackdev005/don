@php
  $siteName = (string) config('site.name', '');
  $legalFullName = trim((string) config('site.legal.full_name', ''));
  $companyNumber = trim((string) config('site.legal.company_number', ''));
  $mainAddress = trim((string) config('site.legal.main_address', ''));
  $seatDisplay = $mainAddress !== '' ? $mainAddress : __('pdf.donation_act.address_placeholder');
  $feesAmount = number_format((float) ($funding->administrative_fees ?? \App\Models\FundingRequest::ADMINISTRATIVE_FEES), 2, ',', ' ');
  $directorName = $donationActMeta['director_name'] ?? __('pdf.donation_act.director_name_default');
  $directorTitle = $donationActMeta['director_title'] ?? __('pdf.donation_act.director_title_default');
  $beneficiaryName = $funding->full_name ?? __('pdf.donation_act.beneficiary_fallback');
  $generatedDate = optional($funding->donation_act_generated_at)->format('d/m/Y') ?: now()->format('d/m/Y');
  $brandColor = \App\Support\SiteAppearance::primaryColor();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 11pt;
      line-height: 1.4;
      color: #111;
    }

    h1 {
      font-size: 16pt;
      text-align: center;
      margin: 8px 0 20px;
      color: {{ $brandColor }};
    }

    h2 {
      font-size: 12.5pt;
      margin: 18px 0 8px;
      color: {{ $brandColor }};
    }

    .meta {
      margin-bottom: 20px;
    }

    .header {
      text-align: center;
      margin-bottom: 8px;
    }

    .logo {
      max-height: 54px;
      max-width: 220px;
    }

    .brand-text {
      font-size: 18pt;
      font-weight: 700;
      color: {{ $brandColor }};
      letter-spacing: .4px;
    }

    .admin-fee-red {
      color: #b00020;
      font-weight: bold;
    }

    .sign-grid {
      width: 100%;
      margin-top: 16px;
    }

    .certification-badge {
      display: block;
      margin: 12px auto 0;
      max-width: 120px;
      max-height: 120px;
    }

    .certification-note {
      margin-top: 8px;
      text-align: center;
      font-size: 10pt;
      color: #333;
    }

    .sign-cell {
      width: 48%;
      vertical-align: top;
    }

    .line {
      border-bottom: 1px solid #333;
      display: inline-block;
      min-width: 240px;
      margin-top: 28px;
    }

    .sign-name {
      margin-top: 4px;
      font-size: 9.5pt;
      color: #333;
    }

    .sign-image {
      display: block;
      margin-top: 8px;
      max-height: 60px;
      max-width: 220px;
      position: relative;
      z-index: 2;
    }

    .sign-stack {
      position: relative;
      min-height: 110px;
      margin-top: 8px;
    }

    .sign-watermark {
      position: absolute;
      left: 110px;
      top: 26px;
      max-width: 150px;
      max-height: 52px;
      opacity: .18;
      filter: grayscale(100%);
      z-index: 1;
    }

    .sign-stack .line {
      position: relative;
      z-index: 2;
      margin-top: 34px;
    }

    .muted {
      color: #444;
      font-size: 9pt;
    }

    .separator {
      border-top: 2px solid #333;
      margin: 20px 0;
    }

    .article {
      margin-bottom: 15px;
    }
  </style>
</head>

<body>
  <div class="header">
    @if (! empty($donationActMeta['logo_data_uri']))
    <img class="logo" src="{{ $donationActMeta['logo_data_uri'] }}" alt="{{ __('pdf.donation_act.logo_alt') }}">
    @else
    <div class="brand-text">{{ $siteName }}</div>
    @endif
  </div>

  <h1>{{ __('pdf.donation_act.h1_title') }}</h1>

  <div class="meta">
    <p><strong>{{ __('pdf.donation_act.ref_dossier') }}</strong> {{ $funding->dossier_number }}</p>
    <p><strong>{{ __('pdf.donation_act.ref_acte') }}</strong> {{ strtoupper(substr(md5($funding->dossier_number . $funding->id . config('site.key', 'secret')), 0, 12)) }}</p>
  </div>

  <div class="separator"></div>

  <p><strong>{{ __('pdf.donation_act.between_parties') }}</strong></p>

  <p>
    <strong>{{ $siteName }}</strong><br>
    @if($legalFullName !== '')
    {{ __('pdf.donation_act.legal_full_name') }} {{ $legalFullName }}<br>
    @endif
    {{ __('pdf.donation_act.non_profit_label') }}<br><br>
    @if($companyNumber !== '')
    {{ __('pdf.donation_act.company_number') }} {{ $companyNumber }}<br>
    @endif
    {{ __('pdf.donation_act.main_address') }} {{ $seatDisplay }}<br><br>
    {{ __('pdf.donation_act.represented_by') }} {{ $directorName }}<br>
    {{ __('pdf.donation_act.acting_as') }} {{ $directorTitle }}<br><br>
    {{ __('pdf.donation_act.hereinafter_org') }}
  </p>

  <p><strong>{{ __('pdf.donation_act.and') }}</strong></p>

  <p>
    <strong>{{ __('pdf.donation_act.salutation') }}</strong> {{ $beneficiaryName }}<br>
    @if($funding->address)
    {{ __('pdf.donation_act.address') }} {{ $funding->address }}<br>
    @endif
    @if($funding->phone_prefix && $funding->phone)
    {{ __('pdf.donation_act.phone_short') }} {{ $funding->phone_prefix }}{{ $funding->phone }}<br>
    @endif
    @if($funding->email)
    {{ __('pdf.donation_act.email_short') }} {{ $funding->email }}
    @endif
  </p>

  <p>{{ __('pdf.donation_act.hereinafter_m', ['name' => $beneficiaryName]) }}</p>

  <div class="separator"></div>

  <div class="article">
    <h2>{{ __('pdf.donation_act.art1_pdf_heading') }}</h2>
    <p>{{ __('pdf.donation_act.art1_pdf_body') }}</p>
  </div>

  <div class="article">
    <h2>{{ __('pdf.donation_act.art2_title') }}</h2>
    <p>{{ __('pdf.donation_act.art2_body', ['site' => $siteName]) }}</p>
    <p><strong>{{ number_format((float) $funding->amount_requested, 2, ',', ' ') }} EUR</strong></p>
    <p>{{ __('pdf.donation_act.art2_footer') }}</p>
  </div>

  <div class="article">
    <h2>{{ __('pdf.donation_act.art3_title') }}</h2>
    <p>{{ __('pdf.donation_act.art3_body') }}</p>
    <p><strong>{{ \App\Models\FundingRequest::needTypeLabels()[$funding->need_type] ?? $funding->need_type }}</strong></p>
    <p>{{ __('pdf.donation_act.art3_footer') }}</p>
  </div>

  <div class="article">
    <h2>{{ __('pdf.donation_act.art4_title') }}</h2>
    <p>{{ __('pdf.donation_act.art4_body') }}</p>

    <p>{{ __('pdf.donation_act.art4_list_intro') }}</p>
    <ul>
      <li>{{ __('pdf.donation_act.art4_item1') }}</li>
      <li>{{ __('pdf.donation_act.art4_item2') }}</li>
      <li>{{ __('pdf.donation_act.art4_item3') }}</li>
    </ul>

    <p>{!! __('pdf.donation_act.art4_fees_html', ['amount' => $feesAmount]) !!}</p>
  </div>

  <div class="article">
    <h2>{{ __('pdf.donation_act.art5_title') }}</h2>
    <p>{{ __('pdf.donation_act.art5_body') }}</p>
  </div>

  <div class="article">
    <h2>{{ __('pdf.donation_act.art6_title') }}</h2>
    <p>{{ __('pdf.donation_act.art6_body') }}</p>
  </div>

  <div class="article">
    <h2>{{ __('pdf.donation_act.art7_title') }}</h2>
    <p>{{ __('pdf.donation_act.art7_body') }}</p>
    <p><strong>{{ __('pdf.donation_act.verification_code') }} :</strong> {{ strtoupper(substr(md5($funding->dossier_number . $funding->id . config('site.key', 'secret')), 0, 12)) }}</p>
    <p>{{ __('pdf.donation_act.art7_footer') }}</p>
  </div>

  <div class="separator"></div>

  <p><strong>{{ __('pdf.donation_act.certification_p1', ['date' => $generatedDate, 'site' => $siteName]) }} {{ __('pdf.donation_act.certification_p2', ['site' => $siteName]) }}</strong></p>
  @if (! empty($donationActMeta['certification_badge_data_uri']))
  <img class="certification-badge" src="{{ $donationActMeta['certification_badge_data_uri'] }}" alt="EIG Certified">
  <p class="certification-note">ONG honorée par EIG Certified</p>
  @endif

  <div class="separator"></div>

  <table class="sign-grid" cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td class="sign-cell">
        <p><strong>{{ __('pdf.donation_act.signature_of', ['site' => $siteName]) }}</strong></p>
        <div class="sign-stack">
          @if (! empty($donationActMeta['logo_data_uri']))
          <img class="sign-watermark" src="{{ $donationActMeta['logo_data_uri'] }}" alt="{{ __('pdf.donation_act.logo_alt') }}">
          @endif
          @if (! empty($donationActMeta['director_signature_data_uri']))
          <img class="sign-image" src="{{ $donationActMeta['director_signature_data_uri'] }}" alt="{{ __('pdf.donation_act.signature_dir_alt') }}">
          @else
          <span class="line"></span>
          @endif
        </div>
        <div class="sign-name">
          <strong>{{ $directorName }}</strong><br>
        </div>
      </td>
      <td class="sign-cell" style="text-align: right;">
        <p><strong>{{ __('pdf.donation_act.signature_beneficiary') }}</strong></p>
        <span class="line"></span>
        <div class="sign-name">
          <strong>{{ $funding->full_name }}</strong><br>
          <span class="muted">{{ __('pdf.donation_act.dossier_line', ['number' => $funding->dossier_number]) }}</span>
        </div>
      </td>
    </tr>
  </table>
</body>

</html>

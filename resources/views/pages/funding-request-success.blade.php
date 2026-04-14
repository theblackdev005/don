@extends('layouts.app')

@section('title', config('site.name').' | '.__('pages.funding_success.title'))

@push('meta')
  @include('partials.meta-default')
@endpush

@section('content')
@php
  $ctx = $context ?? request()->query('context', 'funding');
  if (! in_array($ctx, ['funding', 'documents'], true)) {
      $ctx = 'funding';
  }

  $baseKey = $ctx === 'documents' ? 'pages.documents_success' : 'pages.funding_success';
  $pageLocale = request()->route('locale') ?? app()->getLocale();
  $rawPhone = (string) config('site.phone', '');
  $whatsAppPhone = preg_replace('/\D+/', '', $rawPhone);
  $rawName = trim((string) ($applicant_name ?? ''));
  $firstName = $rawName !== '' ? (preg_split('/\s+/u', $rawName, 2)[0] ?? $rawName) : '';
  $displayTitle = __($baseKey.'.heading').($firstName !== '' ? ' '.$firstName : '');
  $whatsAppMessage = __($baseKey.'.contact_body');
  $whatsAppUrl = $whatsAppPhone
      ? 'https://wa.me/'.$whatsAppPhone.'?text='.rawurlencode($whatsAppMessage)
      : null;
  $folderUrl = route('funding.tracking', ['locale' => $pageLocale]);
@endphp

<style>
  .thanks-page {
    padding: 95px 0 75px;
    background:
      radial-gradient(circle at top left, rgba(226, 233, 243, 0.88), transparent 35%),
      linear-gradient(180deg, #f6f8fc 0%, #eef3fa 100%);
  }

  .thanks-shell {
    max-width: 860px;
    margin: 0 auto;
  }

  .thanks-hero {
    position: relative;
    overflow: hidden;
    padding: 34px 34px 120px;
    border-radius: 30px;
    background:
      radial-gradient(circle at top right, rgba(255, 196, 0, 0.18), transparent 34%),
      linear-gradient(135deg, #131d35 0%, #18253c 58%, #22314a 100%);
    box-shadow: 0 28px 65px rgba(15, 23, 42, 0.22);
  }

  .thanks-hero::after {
    content: "";
    position: absolute;
    right: -45px;
    top: -45px;
    width: 180px;
    height: 180px;
    border-radius: 50%;
    background: rgba(255, 196, 0, 0.16);
  }

  .thanks-badge {
    position: relative;
    z-index: 1;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 9px 16px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 0.02em;
    text-transform: uppercase;
    border: 1px solid rgba(255, 255, 255, 0.1);
  }

  .thanks-badge-mark {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #ffc400;
    color: #101a31;
    font-size: 14px;
    font-weight: 900;
  }

  .thanks-title {
    position: relative;
    z-index: 1;
    max-width: 620px;
    margin: 20px 0 14px;
    color: #fff;
    font-size: 44px;
    line-height: 1.04;
    font-weight: 800;
    letter-spacing: -0.03em;
  }

  .thanks-copy-hero {
    position: relative;
    z-index: 1;
    margin: 0;
    color: rgba(255, 255, 255, 0.76);
    font-size: 16px;
    line-height: 1.6;
  }

  .thanks-panel {
    position: relative;
    z-index: 2;
    margin: -78px 34px 0;
    background: #fff;
    border: 1px solid #e7eaef;
    border-radius: 26px;
    box-shadow: 0 20px 48px rgba(15, 23, 42, 0.1);
    padding: 24px;
  }

  .thanks-accent-line {
    width: 72px;
    height: 4px;
    border-radius: 999px;
    background: linear-gradient(90deg, #ffc400 0%, #ffd766 100%);
    margin-bottom: 14px;
  }

  .thanks-lead {
    margin: 0 0 4px;
    color: #162235;
    font-size: 16px;
    line-height: 1.5;
    font-weight: 500;
  }

  .thanks-copy {
    margin: 0;
    color: #64748b;
    font-size: 15px;
    line-height: 1.55;
  }

  .thanks-ref-wrap {
    margin: 16px 0 14px;
    padding: 16px 18px;
    border-radius: 18px;
    background: linear-gradient(180deg, rgba(255, 196, 0, 0.1) 0%, rgba(255, 196, 0, 0.04) 100%);
    border: 1px solid rgba(255, 196, 0, 0.16);
  }

  .thanks-ref-label {
    display: block;
    margin-bottom: 6px;
    color: #162235;
    font-size: 14px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .02em;
  }

  .thanks-ref-value {
    color: #162235;
    font-size: 26px;
    line-height: 1.2;
    font-weight: 800;
    letter-spacing: -0.02em;
    word-break: break-word;
  }

  .thanks-ref-note {
    margin: 6px 0 0;
    color: #64748b;
    font-size: 15px;
    line-height: 1.6;
  }

  .thanks-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 16px;
  }

  .thanks-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 54px;
    padding: 0 22px;
    border-radius: 16px;
    font-size: 14px;
    font-weight: 800;
    text-decoration: none;
    transition: .2s ease;
  }

  .thanks-btn-primary {
    background: #ffc400;
    border: 1px solid #ffc400;
    color: #162235;
    box-shadow: 0 14px 28px rgba(255, 196, 0, 0.2);
  }

  .thanks-btn-secondary {
    background: #fff;
    border: 1px solid #dbe4ee;
    color: #162235;
  }

  .thanks-btn:hover {
    transform: translateY(-1px);
    color: #162235;
    text-decoration: none;
  }

  @media (max-width: 767px) {
    .thanks-page {
      padding: 82px 0 42px;
    }

    .thanks-hero {
      padding: 22px 18px 78px;
      border-radius: 24px;
    }

    .thanks-title {
      margin: 16px 0 10px;
      font-size: 28px;
    }

    .thanks-copy-hero,
    .thanks-copy {
      font-size: 14px;
    }

    .thanks-panel {
      margin: -44px 12px 0;
      padding: 18px 16px;
      border-radius: 20px;
    }

    .thanks-lead {
      font-size: 14px;
      line-height: 1.45;
    }

    .thanks-ref-value {
      font-size: 20px;
    }

    .thanks-ref-note {
      font-size: 14px;
    }

    .thanks-actions {
      flex-direction: column;
      gap: 10px;
      margin-top: 14px;
    }

    .thanks-btn {
      width: 100%;
      min-height: 50px;
      border-radius: 14px;
    }
  }
</style>

<main class="page-wrapper">
  @include('partials.nav', ['active' => 'funding', 'variant' => 'default'])

  <div class="container thanks-page">
    <div class="thanks-shell">
      <div class="thanks-hero">
        @if (session('info'))
          <div class="alert alert-info text-start mb-4 position-relative z-1">{{ session('info') }}</div>
        @endif

        <div class="thanks-badge">
          <span class="thanks-badge-mark">✓</span>
          {{ __($baseKey.'.eyebrow') }}
        </div>

        <h1 class="thanks-title">{{ $displayTitle }}</h1>
        <p class="thanks-copy-hero">{{ __($baseKey.'.lead') }}</p>
      </div>

      <div class="thanks-panel">
        <div class="thanks-accent-line"></div>

        <p class="thanks-lead">{{ __($baseKey.'.contact_title') }}</p>
        <p class="thanks-copy">{{ __($baseKey.'.contact_body') }}</p>

        @if (!empty($dossier_number))
          <div class="thanks-ref-wrap">
            <span class="thanks-ref-label">{{ __($baseKey.'.dossier_intro') }}</span>
            <div class="thanks-ref-value">{{ $dossier_number }}</div>
            <p class="thanks-ref-note">{{ __($baseKey.'.dossier_hint') }}</p>
          </div>
        @endif

        <div class="thanks-actions">
          @if ($whatsAppUrl)
            <a class="thanks-btn thanks-btn-primary" href="{{ $whatsAppUrl }}" target="_blank" rel="noopener noreferrer">
              {{ __($baseKey.'.contact_cta') }}
            </a>
          @endif

          <a class="thanks-btn thanks-btn-secondary" href="{{ $folderUrl }}">
            {{ __($baseKey.'.folder_cta') }}
          </a>
        </div>
      </div>
    </div>
  </div>
</main>

@include('partials.footers.compact')
@endsection

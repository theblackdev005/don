@extends('layouts.admin')

@section('title', 'Dossier '.$fr->dossier_number)

@push('head')
  <style>
    .admin-detail-shell {
      --detail-border: rgba(15, 23, 42, 0.08);
      --detail-shadow: 0 18px 40px rgba(148, 163, 184, 0.18);
      --detail-muted: #6b7a90;
      --detail-heading: #172033;
      --detail-soft: #f5f7fb;
      --detail-surface: #ffffff;
      --detail-accent: #ffb400;
    }

    .admin-detail-card,
    .admin-detail-hero {
      border: 1px solid var(--detail-border);
      border-radius: 1.8rem;
      background: var(--detail-surface);
      box-shadow: var(--detail-shadow);
    }

    .admin-detail-hero {
      padding: 1.35rem 1.45rem;
      margin-bottom: 1rem;
    }

    .admin-detail-toolbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      flex-wrap: wrap;
      margin-bottom: 1rem;
    }

    .admin-detail-breadcrumb {
      font-size: .92rem;
      color: var(--detail-muted);
      margin-bottom: .55rem;
    }

    .admin-detail-breadcrumb a {
      color: inherit;
      text-decoration: none;
    }

    .admin-detail-breadcrumb a:hover {
      color: var(--detail-heading);
    }

    .admin-detail-title {
      display: flex;
      align-items: center;
      gap: .75rem;
      flex-wrap: wrap;
      color: var(--detail-heading);
      font-size: clamp(1.8rem, 2vw, 2.3rem);
      font-weight: 800;
      line-height: 1.05;
      margin-bottom: .35rem;
    }

    .admin-detail-status {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: .7rem 1.15rem;
      border-radius: 999px;
      font-weight: 800;
      font-size: .95rem;
      border: 1px solid transparent;
      white-space: nowrap;
    }

    .admin-detail-status.pending {
      color: #c78300;
      background: rgba(255, 180, 0, 0.08);
      border-color: rgba(255, 180, 0, 0.24);
    }

    .admin-detail-status.info {
      color: #146c94;
      background: rgba(13, 202, 240, 0.08);
      border-color: rgba(13, 202, 240, 0.2);
    }

    .admin-detail-status.success {
      color: #0a7d45;
      background: rgba(25, 135, 84, 0.08);
      border-color: rgba(25, 135, 84, 0.2);
    }

    .admin-detail-status.primary {
      color: #3056d3;
      background: rgba(13, 110, 253, 0.08);
      border-color: rgba(13, 110, 253, 0.2);
    }

    .admin-detail-status.secondary {
      color: #667085;
      background: rgba(108, 117, 125, 0.08);
      border-color: rgba(108, 117, 125, 0.18);
    }

    .admin-detail-actions {
      display: flex;
      align-items: center;
      gap: .75rem;
      flex-wrap: wrap;
    }

    .admin-detail-actions .btn {
      min-height: 3.35rem;
      border-radius: 1rem;
      padding: 0 1rem;
      font-weight: 700;
    }

    .admin-detail-hero-top {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 1.25rem;
      margin-bottom: .75rem;
      flex-wrap: wrap;
    }

    .admin-detail-hero-note {
      color: var(--detail-muted);
      font-size: .88rem;
      max-width: 32rem;
      margin-bottom: 0;
    }

    .admin-detail-kpis {
      display: grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: .7rem;
    }

    .admin-detail-kpi {
      padding: .75rem .85rem;
      border-radius: .9rem;
      background: var(--detail-soft);
      border: 1px solid rgba(15, 23, 42, 0.08);
      min-height: 4.8rem;
    }

    .admin-detail-kpi-label,
    .admin-info-item-label {
      font-size: .72rem;
      text-transform: uppercase;
      letter-spacing: .05em;
      color: var(--detail-muted);
      font-weight: 800;
      margin-bottom: .35rem;
    }

    .admin-detail-kpi-value,
    .admin-info-item-value {
      font-weight: 700;
      color: var(--detail-heading);
      word-break: break-word;
    }

    .admin-detail-kpi-value {
      font-size: .94rem;
    }

    .admin-detail-card {
      padding: 1.35rem 1.45rem;
    }

    .admin-detail-section-title {
      font-size: 1.05rem;
      font-weight: 800;
      color: var(--detail-heading);
      margin-bottom: 1rem;
    }

    .admin-detail-section-note {
      color: var(--detail-muted);
      font-size: .94rem;
      margin-bottom: 1rem;
    }

    .admin-info-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 1rem 1.25rem;
    }

    .admin-info-panel {
      border-radius: 1rem;
      padding: .95rem 1rem;
      border: 1px solid rgba(148, 163, 184, 0.16);
      background: var(--detail-soft);
      height: 100%;
    }

    .admin-detail-info-stack {
      display: grid;
      gap: .85rem;
    }

    .admin-detail-split {
      display: grid;
      grid-template-columns: 1.1fr .9fr;
      gap: .85rem;
      align-items: start;
    }

    .admin-detail-side-card {
      position: sticky;
      top: 6rem;
    }

    .admin-document-list {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 1rem;
    }

    .admin-document-share {
      border: 1px solid rgba(148, 163, 184, 0.16);
      border-radius: 1rem;
      background: var(--detail-soft);
      padding: .95rem 1rem;
      margin-bottom: 1rem;
    }

    .admin-document-share-input .form-control,
    .admin-document-share-input .btn {
      min-height: 2.85rem;
      border-radius: .85rem;
    }

    .admin-document-card {
      border: 1px solid rgba(148, 163, 184, 0.16);
      border-radius: 1.35rem;
      background: var(--detail-soft);
      padding: 0;
      overflow: hidden;
    }

    .admin-document-top {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 1rem;
      padding: 1rem 1rem .9rem;
      border-bottom: 1px solid rgba(148, 163, 184, 0.16);
    }

    .admin-document-title {
      color: var(--detail-heading);
      font-weight: 800;
      margin-bottom: .2rem;
    }

    .admin-document-meta {
      color: var(--detail-muted);
      font-size: .84rem;
      margin-bottom: 0;
    }

    .admin-document-format {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 2rem;
      padding: .3rem .85rem;
      border-radius: 999px;
      border: 1px solid rgba(148, 163, 184, 0.18);
      background: rgba(255, 255, 255, 0.72);
      color: var(--detail-muted);
      font-size: .8rem;
      font-weight: 800;
      text-transform: uppercase;
      white-space: nowrap;
    }

    .admin-document-badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 1.9rem;
      padding: .25rem .7rem;
      border-radius: 999px;
      font-size: .76rem;
      font-weight: 800;
      white-space: nowrap;
    }

    .admin-document-badge.received {
      background: var(--bs-success-bg-subtle);
      color: var(--bs-success-text-emphasis);
    }

    .admin-document-badge.missing {
      background: var(--bs-secondary-bg);
      color: var(--bs-secondary-color);
    }

    .admin-document-links {
      display: flex;
      align-items: center;
      gap: .6rem;
      flex-wrap: wrap;
      margin-top: 0;
      padding: 0 1rem 1rem;
    }

    .admin-document-links .btn {
      min-height: 2.85rem;
      border-radius: 1rem;
      padding: 0 1rem;
      font-size: .9rem;
      font-weight: 700;
    }

    .admin-document-preview {
      padding: 1rem;
    }

    .admin-document-media {
      position: relative;
      display: block;
      width: 100%;
      aspect-ratio: 16 / 10;
      border-radius: 1rem;
      overflow: hidden;
      border: 1px solid rgba(148, 163, 184, 0.16);
      background: rgba(255, 255, 255, 0.78);
    }

    .admin-document-media:hover {
      border-color: rgba(148, 163, 184, 0.28);
    }

    .admin-document-media img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .admin-document-media-button {
      width: 100%;
      padding: 0;
      cursor: pointer;
    }

    .admin-document-file {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      width: 100%;
      height: 100%;
      gap: .55rem;
      color: var(--detail-heading);
      text-align: center;
      padding: 1rem;
    }

    .admin-document-file-icon {
      width: 3.5rem;
      height: 3.5rem;
      border-radius: 1rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: rgba(148, 163, 184, 0.14);
      color: var(--detail-heading);
      font-size: 1.1rem;
      font-weight: 800;
    }

    .admin-document-file-text {
      color: var(--detail-muted);
      font-size: .88rem;
      line-height: 1.45;
      max-width: 14rem;
    }

    .admin-document-hint {
      color: var(--detail-muted);
      font-size: .82rem;
      padding: 0 1rem .9rem;
    }

    .admin-preview-dialog .modal-content {
      border-radius: 1.25rem;
      overflow: hidden;
      border: 1px solid rgba(148, 163, 184, 0.18);
    }

    .admin-refusal-dialog .modal-content {
      border-radius: 1rem;
      overflow: hidden;
      border: 1px solid rgba(148, 163, 184, 0.18);
    }

    .admin-refusal-dialog .modal-header {
      border-bottom-color: rgba(148, 163, 184, 0.16);
      padding: .9rem 1rem;
    }

    .admin-refusal-dialog .modal-body {
      padding: .9rem 1rem 1rem;
    }

    .admin-refusal-dialog textarea.form-control {
      min-height: 5rem;
      border-radius: .9rem;
      resize: vertical;
    }

    .admin-refusal-meta {
      display: flex;
      align-items: center;
      justify-content: flex-end;
      margin-top: .45rem;
      color: var(--detail-muted);
      font-size: .82rem;
    }

    .admin-refusal-counter.is-invalid {
      color: var(--bs-danger);
      font-weight: 700;
    }

    .admin-preview-dialog .modal-header {
      border-bottom-color: rgba(148, 163, 184, 0.16);
      padding: 1rem 1.1rem;
    }

    .admin-preview-dialog .modal-body {
      background: var(--detail-soft);
      padding: 1rem;
    }

    .admin-preview-stage {
      width: 100%;
      min-height: 60vh;
      border-radius: 1rem;
      background: rgba(15, 23, 42, 0.04);
      overflow: hidden;
      border: 1px solid rgba(148, 163, 184, 0.16);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .admin-preview-stage img,
    .admin-preview-stage iframe {
      width: 100%;
      height: 100%;
      border: 0;
      display: block;
    }

    .admin-preview-stage img {
      object-fit: contain;
      max-height: 75vh;
      background: #fff;
    }

    .admin-action-stack {
      display: grid;
      gap: .6rem;
    }

    .admin-action-form {
      display: grid;
      gap: .65rem;
    }

    .admin-action-help {
      color: var(--detail-muted);
      font-size: .84rem;
      line-height: 1.45;
      margin: 0;
    }

    .admin-action-form textarea.form-control {
      min-height: 7.25rem;
      border-radius: 1rem;
      resize: vertical;
    }

    .admin-action-stack .btn {
      min-height: 3.15rem;
      border-radius: 1rem;
      padding: .75rem .95rem;
    }

    .admin-action-stack .btn-warning {
      color: #fff;
      background: var(--detail-accent);
      border-color: var(--detail-accent);
      box-shadow: 0 12px 24px rgba(255, 180, 0, 0.24);
    }

    .admin-action-stack .btn-warning:hover {
      color: #fff;
      background: #f0a900;
      border-color: #f0a900;
    }

    .admin-amount-panel {
      display: grid;
      gap: .95rem;
    }

    .admin-amount-current {
      border-radius: 1.1rem;
      padding: 1rem;
      background: linear-gradient(180deg, rgba(255, 180, 0, 0.11) 0%, rgba(255, 180, 0, 0.04) 100%);
      border: 1px solid rgba(255, 180, 0, 0.18);
    }

    .admin-amount-current-label,
    .admin-amount-preview-label {
      color: var(--detail-muted);
      font-size: .72rem;
      font-weight: 800;
      letter-spacing: .05em;
      text-transform: uppercase;
      margin-bottom: .35rem;
    }

    .admin-amount-current-value {
      color: var(--detail-heading);
      font-size: 1.55rem;
      font-weight: 800;
      line-height: 1;
    }

    .admin-amount-mode {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: .55rem;
    }

    .admin-amount-mode input {
      position: absolute;
      opacity: 0;
      pointer-events: none;
    }

    .admin-amount-mode-label {
      min-height: 3rem;
      border-radius: .95rem;
      border: 1px solid rgba(148, 163, 184, 0.2);
      background: var(--detail-soft);
      color: var(--detail-heading);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: .45rem;
      font-size: .88rem;
      font-weight: 800;
      cursor: pointer;
      transition: border-color .18s ease, background .18s ease, color .18s ease;
    }

    .admin-amount-mode input:checked + .admin-amount-mode-label {
      border-color: rgba(255, 180, 0, 0.45);
      background: rgba(255, 180, 0, 0.13);
      color: var(--detail-accent);
    }

    .admin-amount-entry .form-control,
    .admin-amount-entry .input-group-text,
    .admin-amount-entry .btn {
      min-height: 3rem;
      border-radius: .95rem;
    }

    .admin-amount-preview {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: .8rem;
      flex-wrap: wrap;
      border-radius: 1rem;
      padding: .85rem .95rem;
      background: var(--detail-soft);
      border: 1px solid rgba(148, 163, 184, 0.16);
    }

    .admin-amount-preview-value {
      color: var(--detail-heading);
      font-size: 1.05rem;
      font-weight: 800;
    }

    .admin-financial-history {
      display: grid;
      gap: .7rem;
    }

    .admin-financial-history-item {
      border-radius: 1rem;
      padding: .85rem .95rem;
      background: var(--detail-soft);
      border: 1px solid rgba(148, 163, 184, 0.16);
    }

    .admin-financial-history-top {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: .8rem;
      flex-wrap: wrap;
      margin-bottom: .65rem;
    }

    .admin-financial-history-title {
      color: var(--detail-heading);
      font-size: .92rem;
      font-weight: 800;
      margin-bottom: .15rem;
    }

    .admin-financial-history-meta {
      color: var(--detail-muted);
      font-size: .78rem;
    }

    .admin-financial-history-pill {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 1.85rem;
      padding: .2rem .65rem;
      border-radius: 999px;
      background: rgba(255, 180, 0, 0.13);
      color: var(--detail-accent);
      font-size: .75rem;
      font-weight: 800;
      white-space: nowrap;
    }

    .admin-financial-history-values {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: .5rem;
    }

    .admin-financial-history-value {
      border-radius: .85rem;
      background: rgba(255, 255, 255, 0.58);
      padding: .65rem .7rem;
      border: 1px solid rgba(148, 163, 184, 0.12);
    }

    .admin-financial-history-label {
      color: var(--detail-muted);
      font-size: .68rem;
      font-weight: 800;
      letter-spacing: .05em;
      text-transform: uppercase;
      margin-bottom: .25rem;
    }

    .admin-financial-history-amount {
      color: var(--detail-heading);
      font-size: .85rem;
      font-weight: 800;
      word-break: break-word;
    }

    .admin-financial-history-empty {
      border-radius: 1rem;
      padding: 1rem;
      background: var(--detail-soft);
      color: var(--detail-muted);
      font-size: .9rem;
      border: 1px solid rgba(148, 163, 184, 0.16);
    }

    [data-bs-theme="dark"] .admin-detail-shell {
      --detail-border: rgba(255, 255, 255, 0.08);
      --detail-shadow: none;
      --detail-muted: #9aa6b8;
      --detail-heading: #f5f7fb;
      --detail-soft: #20262d;
      --detail-surface: #171c22;
    }

    [data-bs-theme="dark"] .admin-detail-kpi,
    [data-bs-theme="dark"] .admin-info-panel,
    [data-bs-theme="dark"] .admin-document-card {
      border-color: rgba(255, 255, 255, 0.08);
    }

    [data-bs-theme="dark"] .admin-preview-dialog .modal-content,
    [data-bs-theme="dark"] .admin-preview-stage,
    [data-bs-theme="dark"] .admin-refusal-dialog .modal-content {
      border-color: rgba(255, 255, 255, 0.08);
    }

    [data-bs-theme="dark"] .admin-action-stack .btn-warning {
      box-shadow: none;
    }

    [data-bs-theme="dark"] .admin-amount-mode-label,
    [data-bs-theme="dark"] .admin-amount-preview,
    [data-bs-theme="dark"] .admin-financial-history-item,
    [data-bs-theme="dark"] .admin-financial-history-empty,
    [data-bs-theme="dark"] .admin-financial-history-value {
      border-color: rgba(255, 255, 255, 0.08);
    }

    [data-bs-theme="dark"] .admin-financial-history-value {
      background: rgba(255, 255, 255, 0.03);
    }

    @media (max-width: 1199.98px) {
      .admin-detail-kpis,
      .admin-detail-split {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }

      .admin-detail-side-card {
        position: static;
      }
    }

    @media (max-width: 767.98px) {
      .admin-info-grid,
      .admin-detail-kpis,
      .admin-detail-split,
      .admin-document-list,
      .admin-amount-mode,
      .admin-financial-history-values {
        grid-template-columns: 1fr;
      }

      .admin-document-top,
      .admin-document-links,
      .admin-detail-toolbar,
      .admin-detail-actions {
        flex-direction: column;
        align-items: flex-start;
      }
    }
  </style>
@endpush

@section('content')
@php
  $statusClass = match ($fr->status) {
    \App\Models\FundingRequest::STATUS_PENDING => 'pending',
    \App\Models\FundingRequest::STATUS_PRELIMINARY_ACCEPTED,
    \App\Models\FundingRequest::STATUS_AWAITING_DOCUMENTS => 'info',
    \App\Models\FundingRequest::STATUS_DOCUMENTS_RECEIVED => 'success',
    \App\Models\FundingRequest::STATUS_DONATION_ACT_SENT => 'primary',
    \App\Models\FundingRequest::STATUS_REFUSED,
    \App\Models\FundingRequest::STATUS_CLOSED => 'secondary',
    default => 'secondary',
  };

  $s = $fr->status;
  $isAtLeastAwaiting = in_array($s, [
    \App\Models\FundingRequest::STATUS_AWAITING_DOCUMENTS,
    \App\Models\FundingRequest::STATUS_DOCUMENTS_RECEIVED,
    \App\Models\FundingRequest::STATUS_DONATION_ACT_SENT,
    \App\Models\FundingRequest::STATUS_CLOSED,
  ], true);
  $isAtLeastDocuments = in_array($s, [
    \App\Models\FundingRequest::STATUS_DOCUMENTS_RECEIVED,
    \App\Models\FundingRequest::STATUS_DONATION_ACT_SENT,
    \App\Models\FundingRequest::STATUS_CLOSED,
  ], true);
  $isAtLeastActSent = in_array($s, [
    \App\Models\FundingRequest::STATUS_DONATION_ACT_SENT,
    \App\Models\FundingRequest::STATUS_CLOSED,
  ], true);

  $clientName = trim((string) ($fr->getRawOriginal('full_name') ?: $fr->full_name ?: ''));
  $clientName = $clientName !== '' ? $clientName : 'Client non renseigne';
  $clientLocale = $fr->preferredLocale();

  $legacyTimeline = ['urgent' => 'Urgent', '1_3_months' => '1 à 3 mois', 'flexible' => 'Flexible'];
  $hasLegacyForm = $fr->previous_aid_received !== null || filled($fr->previous_aid_details) || filled($fr->preferred_timeline);

  $documents = [];
  if ($fr->identity_document_type === \App\Models\FundingRequest::IDENTITY_DOCUMENT_PASSPORT) {
      $documents[] = [
          'title' => 'Passeport',
          'meta' => 'Pièce d’identité principale',
          'path' => $fr->doc_passport_path,
          'preview' => route('admin.funding-requests.applicant-document.preview', [$fr, 'passport']),
          'download' => route('admin.funding-requests.applicant-document', [$fr, 'passport']),
          'ext' => strtoupper(pathinfo((string) $fr->doc_passport_path, PATHINFO_EXTENSION) ?: 'file'),
      ];
  } elseif ($fr->identity_document_type === \App\Models\FundingRequest::IDENTITY_DOCUMENT_ID_CARD) {
      $documents[] = [
          'title' => 'Carte d’identité recto',
          'meta' => 'Face avant du document',
          'path' => $fr->doc_id_front_path,
          'preview' => route('admin.funding-requests.applicant-document.preview', [$fr, 'identite_recto']),
          'download' => route('admin.funding-requests.applicant-document', [$fr, 'identite_recto']),
          'ext' => strtoupper(pathinfo((string) $fr->doc_id_front_path, PATHINFO_EXTENSION) ?: 'file'),
      ];
      $documents[] = [
          'title' => 'Carte d’identité verso',
          'meta' => 'Face arrière du document',
          'path' => $fr->doc_id_back_path,
          'preview' => route('admin.funding-requests.applicant-document.preview', [$fr, 'identite_verso']),
          'download' => route('admin.funding-requests.applicant-document', [$fr, 'identite_verso']),
          'ext' => strtoupper(pathinfo((string) $fr->doc_id_back_path, PATHINFO_EXTENSION) ?: 'file'),
      ];
  } else {
      $documents[] = [
          'title' => 'Pièce d’identité',
          'meta' => 'Format hérité des anciens dossiers',
          'path' => $fr->doc_id_path,
          'preview' => route('admin.funding-requests.applicant-document.preview', [$fr, 'identite']),
          'download' => route('admin.funding-requests.applicant-document', [$fr, 'identite']),
          'ext' => strtoupper(pathinfo((string) $fr->doc_id_path, PATHINFO_EXTENSION) ?: 'file'),
      ];
  }

  $documents[] = [
      'title' => 'Justificatif de situation',
      'meta' => 'Document complémentaire du dossier',
      'path' => $fr->doc_situation_path,
      'preview' => route('admin.funding-requests.applicant-document.preview', [$fr, 'situation']),
      'download' => route('admin.funding-requests.applicant-document', [$fr, 'situation']),
      'ext' => strtoupper(pathinfo((string) $fr->doc_situation_path, PATHINFO_EXTENSION) ?: 'file'),
  ];

  if ($fr->doc_medical_path) {
      $documents[] = [
          'title' => 'Documents médicaux',
          'meta' => 'Archives des anciens dossiers',
          'path' => $fr->doc_medical_path,
          'preview' => route('admin.funding-requests.applicant-document.preview', [$fr, 'medical']),
          'download' => route('admin.funding-requests.applicant-document', [$fr, 'medical']),
          'ext' => strtoupper(pathinfo((string) $fr->doc_medical_path, PATHINFO_EXTENSION) ?: 'file'),
      ];
  }

  $documents = array_map(function (array $document) {
      $ext = strtolower((string) ($document['ext'] ?? ''));
      $document['is_image'] = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true);
      $document['ext'] = strtoupper($ext !== '' ? $ext : 'file');

      return $document;
  }, $documents);
@endphp

<div class="admin-detail-shell">
  <div class="admin-detail-toolbar">
    <div>
      <div class="admin-detail-breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Tableau de bord</a>
        <span class="mx-1">/</span>
        <a href="{{ route('admin.funding-requests.index') }}">Demandes</a>
      </div>
      <div class="admin-detail-title">
        <span>{{ $fr->dossier_number }}</span>
        @if ($fr->isLegacyDossierFormat())
          <span class="badge text-bg-secondary">Ancien format</span>
        @endif
      </div>
    </div>

    <div class="admin-detail-actions">
      <a href="{{ route('admin.funding-requests.index') }}" class="btn btn-outline-secondary">Retour à la liste</a>
      @if ($fr->donation_act_path)
        <a href="{{ route('admin.funding-requests.download-act', $fr) }}" class="btn btn-primary">Télécharger l’acte PDF</a>
      @endif
    </div>
  </div>

@if (session('ok'))
  <div class="alert alert-success">{{ session('ok') }}</div>
@endif
@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
@endif

<section class="admin-detail-hero">
  <div class="admin-detail-hero-top">
    <div>
      <div class="admin-detail-section-title mb-1">{{ $clientName }}</div>
      <p class="admin-detail-hero-note">{{ $fr->dossier_number }} · {{ $fr->email }}</p>
    </div>
    <div class="admin-detail-status {{ $statusClass }}">{{ $fr->status_label }}</div>
  </div>

  <div class="admin-detail-kpis">
    <div class="admin-detail-kpi">
      <div class="admin-detail-kpi-label">Montant demandé</div>
      <div class="admin-detail-kpi-value">{{ $fr->amount_requested !== null ? number_format((float) $fr->amount_requested, 2, ',', ' ').' EUR' : '—' }}</div>
    </div>
    <div class="admin-detail-kpi">
      <div class="admin-detail-kpi-label">Besoin</div>
      <div class="admin-detail-kpi-value">{{ $fr->need_type ? (\App\Models\FundingRequest::needTypeLabels()[$fr->need_type] ?? $fr->need_type) : '—' }}</div>
    </div>
    <div class="admin-detail-kpi">
      <div class="admin-detail-kpi-label">Déposé le</div>
      <div class="admin-detail-kpi-value">{{ $fr->created_at->format('d/m/Y H:i') }}</div>
    </div>
    <div class="admin-detail-kpi">
      <div class="admin-detail-kpi-label">Pièces</div>
      <div class="admin-detail-kpi-value">{{ $fr->documentsComplete() ? 'Complètes' : 'Incomplètes' }}</div>
    </div>
  </div>
</section>

<div class="admin-detail-split">
  <div class="admin-detail-info-stack">
    <div class="admin-detail-card">
      <div class="admin-detail-section-title">Informations</div>
      <div class="admin-info-grid">
        <div class="admin-info-panel">
          <div class="admin-info-item-label">Numéro de dossier</div>
          <div class="admin-info-item-value">{{ $fr->dossier_number }}</div>
        </div>
        <div class="admin-info-panel">
          <div class="admin-info-item-label">Client</div>
          <div class="admin-info-item-value">{{ $clientName }}</div>
        </div>
        <div class="admin-info-panel">
          <div class="admin-info-item-label">E-mail</div>
          <div class="admin-info-item-value">{{ $fr->email }}</div>
        </div>
        <div class="admin-info-panel">
          <div class="admin-info-item-label">Téléphone</div>
          <div class="admin-info-item-value">{{ $fr->phone ?? '—' }}</div>
        </div>
        <div class="admin-info-panel">
          <div class="admin-info-item-label">Pays de résidence</div>
          <div class="admin-info-item-value">{{ $fr->country ?? '—' }}</div>
        </div>
        <div class="admin-info-panel">
          <div class="admin-info-item-label">Situation actuelle</div>
          <div class="admin-info-item-value">{{ $fr->current_situation ? (\App\Models\FundingRequest::currentSituationLabels()[$fr->current_situation] ?? $fr->current_situation) : '—' }}</div>
        </div>
        <div class="admin-info-panel">
          <div class="admin-info-item-label">Revenu mensuel</div>
          <div class="admin-info-item-value">{{ $fr->monthly_income_approx ?? '—' }}</div>
        </div>
        <div class="admin-info-panel">
          <div class="admin-info-item-label">Situation familiale</div>
          <div class="admin-info-item-value">{{ $fr->family_situation ? (\App\Models\FundingRequest::familySituationLabels()[$fr->family_situation] ?? $fr->family_situation) : '—' }}</div>
        </div>
        <div class="admin-info-panel">
          <div class="admin-info-item-label">Type de besoin</div>
          <div class="admin-info-item-value">{{ $fr->need_type ? (\App\Models\FundingRequest::needTypeLabels()[$fr->need_type] ?? $fr->need_type) : '—' }}</div>
        </div>
        <div class="admin-info-panel" style="grid-column: 1 / -1;">
          <div class="admin-info-item-label">Adresse</div>
          <div class="admin-info-item-value" style="white-space: pre-wrap;">{{ $fr->address ?? '—' }}</div>
        </div>
      </div>
    </div>

    <div class="admin-detail-card">
      <div class="admin-detail-section-title">Demande du client</div>
      <div class="text-body-secondary" style="white-space: pre-wrap;">{{ $fr->situation }}</div>
    </div>

    @if ($fr->status === \App\Models\FundingRequest::STATUS_REFUSED && filled($fr->refused_reason))
      <div class="admin-detail-card">
        <div class="admin-detail-section-title">Motif du refus</div>
        <div class="text-body-secondary" style="white-space: pre-wrap;">{{ $fr->refused_reason }}</div>
      </div>
    @endif

    <div class="admin-detail-card">
      <div class="admin-detail-section-title">Pièces du client</div>
      <p class="admin-detail-section-note">Retrouvez ici les pièces déposées par le client pour compléter sa demande.</p>

      @if ($fr->public_slug)
        <div class="admin-document-share">
          <div class="admin-info-item-label">Lien à envoyer au client</div>
          <div class="admin-info-item-value mb-3">Ce lien permet au client de compléter son dossier et de déposer ses pièces.</div>
          <div class="input-group admin-document-share-input">
            <input
              type="text"
              id="client-documents-link"
              class="form-control"
              value="{{ \App\Support\LocalizedRouteSlugs::route('funding-request.documents', ['locale' => $clientLocale, 'public_slug' => $fr->public_slug]) }}"
              readonly>
            <button
              class="btn btn-outline-secondary"
              type="button"
              onclick="copyAdminLink('client-documents-link', this)">
              Copier le lien
            </button>
          </div>
        </div>
      @endif

      <div class="admin-document-list">
        @foreach ($documents as $document)
          <div class="admin-document-card">
            <div class="admin-document-top">
              <div>
                <div class="admin-document-title">{{ $document['title'] }}</div>
                <p class="admin-document-meta">{{ $document['meta'] }}</p>
              </div>
              <div class="d-flex align-items-center gap-2 flex-wrap justify-content-end">
                @if ($document['path'])
                  <span class="admin-document-format">{{ $document['ext'] }}</span>
                @endif
                <span class="admin-document-badge {{ $document['path'] ? 'received' : 'missing' }}">
                  {{ $document['path'] ? 'Reçu' : 'Manquant' }}
                </span>
              </div>
            </div>

            @if ($document['path'])
              <div class="admin-document-preview">
                @if ($document['is_image'])
                  <button
                    type="button"
                    class="admin-document-media admin-document-media-button"
                    data-preview-url="{{ $document['preview'] }}"
                    data-preview-type="image"
                    data-preview-title="{{ $document['title'] }}">
                    <img src="{{ $document['preview'] }}" alt="{{ $document['title'] }}">
                  </button>
                @else
                  <button
                    type="button"
                    class="admin-document-media admin-document-media-button"
                    data-preview-url="{{ $document['preview'] }}"
                    data-preview-type="file"
                    data-preview-title="{{ $document['title'] }}">
                    <div class="admin-document-file">
                      <span class="admin-document-file-icon">{{ $document['ext'] }}</span>
                      <div class="fw-semibold">{{ $document['title'] }}</div>
                      <div class="admin-document-file-text">Cliquez pour ouvrir la prévisualisation dans cette page.</div>
                    </div>
                  </button>
                @endif
              </div>
              <div class="admin-document-hint">Cliquez sur l’aperçu pour agrandir le document.</div>
              <div class="admin-document-links">
                <a class="btn btn-outline-primary" href="{{ $document['download'] }}">Télécharger</a>
              </div>
            @endif
          </div>
        @endforeach
      </div>
    </div>

    <div class="modal fade admin-preview-dialog" id="adminDocumentPreviewModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title fs-5 fw-bold" id="adminDocumentPreviewTitle">Prévisualisation</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <div class="admin-preview-stage" id="adminDocumentPreviewStage"></div>
          </div>
        </div>
      </div>
    </div>

    @if ($hasLegacyForm)
      <div class="admin-detail-card">
        <div class="admin-detail-section-title">Ancien formulaire</div>
        <div class="admin-info-grid">
          @if ($fr->previous_aid_received !== null)
            <div class="admin-info-panel">
              <div class="admin-info-item-label">Aide antérieure</div>
              <div class="admin-info-item-value">{{ $fr->previous_aid_received ? 'Oui' : 'Non' }}</div>
            </div>
          @endif
          @if ($fr->preferred_timeline)
            <div class="admin-info-panel">
              <div class="admin-info-item-label">Délai souhaité</div>
              <div class="admin-info-item-value">{{ $legacyTimeline[$fr->preferred_timeline] ?? $fr->preferred_timeline }}</div>
            </div>
          @endif
          @if ($fr->previous_aid_details)
            <div class="admin-info-panel" style="grid-column: 1 / -1;">
              <div class="admin-info-item-label">Détail conservé</div>
              <div class="admin-info-item-value" style="white-space: pre-wrap;">{{ $fr->previous_aid_details }}</div>
            </div>
          @endif
        </div>
      </div>
    @endif

  </div>

  <div class="admin-detail-info-stack">
    <div class="admin-detail-card admin-detail-side-card">
      <div class="admin-detail-section-title">Actions</div>
      <p class="admin-detail-section-note">Les actions disponibles pour cette demande selon son état actuel.</p>

      <div class="admin-action-stack">
      @if ($fr->status === \App\Models\FundingRequest::STATUS_PENDING)
        <form method="post" action="{{ route('admin.funding-requests.preliminary', $fr) }}" onsubmit="return confirm('Envoyer le premier retour au client et ouvrir la suite du traitement ?');">
          @csrf
          <button type="submit" class="btn btn-warning w-100 text-start text-wrap" style="white-space: normal;">
            <span class="d-block fw-semibold">Valider la demande</span>
          </button>
        </form>
      @endif

      @if (in_array($fr->status, [\App\Models\FundingRequest::STATUS_DOCUMENTS_RECEIVED, \App\Models\FundingRequest::STATUS_DONATION_ACT_SENT], true))
        <form method="post" action="{{ route('admin.funding-requests.send-act', $fr) }}" onsubmit="return confirm('Accorder le don et envoyer le document au client ?');">
          @csrf
          <button type="submit" class="btn btn-success w-100 text-start text-wrap" style="white-space: normal;">
            @if ($fr->status === \App\Models\FundingRequest::STATUS_DONATION_ACT_SENT)
              <span class="d-block fw-semibold">Renvoyer le document</span>
            @else
              <span class="d-block fw-semibold">Accorder le don</span>
            @endif
          </button>
        </form>
      @endif

      @if ($fr->donation_act_path)
        <a href="{{ route('admin.funding-requests.download-act', $fr) }}" class="btn btn-outline-primary w-100">Télécharger le document envoyé</a>
      @endif

      @if ($fr->status === \App\Models\FundingRequest::STATUS_DONATION_ACT_SENT)
        <form method="post" action="{{ route('admin.funding-requests.close', $fr) }}" onsubmit="return confirm('Marquer cette demande comme terminée ?');">
          @csrf
          <button type="submit" class="btn btn-outline-secondary w-100">Clôturer la demande</button>
        </form>
      @endif

      @if (! in_array($fr->status, [\App\Models\FundingRequest::STATUS_REFUSED, \App\Models\FundingRequest::STATUS_CLOSED], true))
        <button
          type="button"
          class="btn btn-outline-danger w-100"
          data-bs-toggle="modal"
          data-bs-target="#adminRefusalModal">
          Refuser et archiver
        </button>
      @endif

      @if ($fr->status === \App\Models\FundingRequest::STATUS_REFUSED)
        <form method="post" action="{{ route('admin.funding-requests.reactivate', $fr) }}" onsubmit="return confirm('Réactiver ce dossier et le remettre dans les demandes à examiner ?');">
          @csrf
          <button type="submit" class="btn btn-outline-primary w-100">Réactiver le dossier</button>
        </form>
      @endif
      </div>
    </div>

    <div class="admin-detail-card">
      <div class="admin-detail-section-title">Montant du dossier</div>
      <div class="admin-amount-panel">
        <div class="admin-amount-current">
          <div class="admin-amount-current-label">Montant actuel</div>
          <div class="admin-amount-current-value">{{ $fr->amount_requested !== null ? number_format((float) $fr->amount_requested, 2, ',', ' ').' EUR' : 'Non renseigné' }}</div>
        </div>

      <form
        method="post"
        action="{{ route('admin.funding-requests.update-amount', $fr) }}"
        id="adminAmountForm"
        data-current-amount="{{ (float) ($fr->amount_requested ?? 0) }}">
        @csrf

          <div class="admin-amount-mode mb-3" role="group" aria-label="Mode de modification du montant">
            <div>
              <input type="radio" name="adjustment_type" id="amount-mode-increase" value="increase" @checked(old('adjustment_type', 'increase') === 'increase')>
              <label class="admin-amount-mode-label" for="amount-mode-increase">
                <i class="ai-plus"></i>
                Ajouter
              </label>
            </div>
            <div>
              <input type="radio" name="adjustment_type" id="amount-mode-set" value="set" @checked(old('adjustment_type') === 'set')>
              <label class="admin-amount-mode-label" for="amount-mode-set">
                <i class="ai-edit-alt"></i>
                Remplacer
              </label>
            </div>
          </div>

          <div class="admin-amount-entry">
            <label class="form-label">Montant</label>
            <div class="input-group">
              <input type="number" name="amount_value" id="adminAmountValue" class="form-control" value="{{ old('amount_value') }}" min="0.01" step="0.01" placeholder="1000.00">
              <span class="input-group-text">EUR</span>
              <button type="submit" class="btn btn-outline-secondary">Enregistrer</button>
            </div>
          </div>

          <div class="admin-amount-preview mt-3">
            <div>
              <div class="admin-amount-preview-label">Nouveau montant</div>
              <div class="admin-action-help">Calculé avant l’enregistrement</div>
            </div>
            <div class="admin-amount-preview-value" id="adminAmountPreview">{{ $fr->amount_requested !== null ? number_format((float) $fr->amount_requested, 2, ',', ' ').' EUR' : '—' }}</div>
          </div>
        </form>
      </div>
    </div>

    <div class="admin-detail-card">
      <div class="admin-detail-section-title">Frais de dossier</div>
      <div class="admin-amount-panel">
        <div class="admin-amount-current">
          <div class="admin-amount-current-label">Frais actuels</div>
          <div class="admin-amount-current-value">{{ number_format((float) ($fr->administrative_fees ?? \App\Models\FundingRequest::ADMINISTRATIVE_FEES), 2, ',', ' ') }} EUR</div>
        </div>

        <form
          method="post"
          action="{{ route('admin.funding-requests.update-fees', $fr) }}"
          id="adminFeesForm"
          data-current-fees="{{ (float) ($fr->administrative_fees ?? \App\Models\FundingRequest::ADMINISTRATIVE_FEES) }}">
          @csrf
          <div class="admin-amount-entry">
            <label class="form-label">Nouveau montant des frais</label>
            <div class="input-group">
              <input
                type="number"
                name="administrative_fees"
                id="adminFeesValue"
                class="form-control"
                value="{{ old('administrative_fees', $fr->administrative_fees ?? \App\Models\FundingRequest::ADMINISTRATIVE_FEES) }}"
                min="0"
                step="0.01"
                placeholder="150.00">
              <span class="input-group-text">EUR</span>
              <button type="submit" class="btn btn-outline-secondary">Enregistrer</button>
            </div>
          </div>

          <div class="admin-amount-preview mt-3">
            <div>
              <div class="admin-amount-preview-label">Frais après modification</div>
              <div class="admin-action-help">Appliqué au dossier et au document généré ensuite</div>
            </div>
            <div class="admin-amount-preview-value" id="adminFeesPreview">{{ number_format((float) old('administrative_fees', $fr->administrative_fees ?? \App\Models\FundingRequest::ADMINISTRATIVE_FEES), 2, ',', ' ') }} EUR</div>
          </div>
        </form>
      </div>
    </div>

    <div class="admin-detail-card">
      <div class="admin-detail-section-title">Historique financier</div>
      <p class="admin-detail-section-note">Les dernières modifications du montant demandé et des frais de dossier.</p>

      <div class="admin-financial-history">
        @forelse (($financialChanges ?? collect()) as $change)
          @php
            $oldAmount = $change->old_amount === null ? null : (float) $change->old_amount;
            $newAmount = (float) $change->new_amount;
            $actionLabel = $change->action === \App\Models\FundingRequestFinancialChange::ACTION_INCREASE ? 'Ajout' : 'Remplacement';
          @endphp
          <div class="admin-financial-history-item">
            <div class="admin-financial-history-top">
              <div>
                <div class="admin-financial-history-title">{{ $change->fieldLabel() }}</div>
                <div class="admin-financial-history-meta">
                  {{ $change->created_at?->format('d/m/Y H:i') }}
                  @if ($change->admin)
                    · {{ $change->admin->name }}
                  @endif
                </div>
              </div>
              <span class="admin-financial-history-pill">{{ $actionLabel }}</span>
            </div>

            <div class="admin-financial-history-values">
              <div class="admin-financial-history-value">
                <div class="admin-financial-history-label">Avant</div>
                <div class="admin-financial-history-amount">{{ $oldAmount === null ? '—' : number_format($oldAmount, 2, ',', ' ').' EUR' }}</div>
              </div>
              <div class="admin-financial-history-value">
                <div class="admin-financial-history-label">Après</div>
                <div class="admin-financial-history-amount">{{ number_format($newAmount, 2, ',', ' ') }} EUR</div>
              </div>
            </div>
          </div>
        @empty
          <div class="admin-financial-history-empty">Aucune modification financière enregistrée pour ce dossier.</div>
        @endforelse
      </div>
    </div>
  </div>
</div>

@if (! in_array($fr->status, [\App\Models\FundingRequest::STATUS_REFUSED, \App\Models\FundingRequest::STATUS_CLOSED], true))
  <div class="modal fade admin-refusal-dialog" id="adminRefusalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 28rem;">
      <div class="modal-content">
        <form method="post" action="{{ route('admin.funding-requests.refuse', $fr) }}" class="admin-action-form" onsubmit="return confirm('Confirmer le refus et l’archivage de ce dossier ?');">
          @csrf
          <div class="modal-header">
            <h2 class="modal-title fs-5 fw-bold">Refuser et archiver</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <label class="form-label mb-2" for="refused_reason">Motif</label>
            <textarea
              class="form-control @error('refused_reason') is-invalid @enderror"
              name="refused_reason"
              id="refused_reason"
              maxlength="5000"
              placeholder="Indiquez la raison du refus.">{{ old('refused_reason', $fr->status === \App\Models\FundingRequest::STATUS_REFUSED ? $fr->refused_reason : '') }}</textarea>
            @error('refused_reason')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <div class="admin-refusal-meta">
              <span class="admin-refusal-counter" id="refusedReasonCounter">0 / 5000</span>
            </div>
          </div>
          <div class="modal-footer border-0 px-3 pb-3 pt-0">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-outline-danger" id="refusedReasonSubmit">Confirmer le refus</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endif

@push('vendor-scripts')
<script>
function copyAdminLink(inputId, btn) {
  var input = document.getElementById(inputId);
  if (!input) return;
  var value = input.value || '';
  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard.writeText(value).then(function () {
      var oldText = btn.textContent;
      btn.textContent = 'Lien copie';
      setTimeout(function () { btn.textContent = oldText; }, 1200);
    });
    return;
  }
  input.select();
  document.execCommand('copy');
  var oldText = btn.textContent;
  btn.textContent = 'Lien copie';
  setTimeout(function () { btn.textContent = oldText; }, 1200);
}

document.addEventListener('click', function (event) {
  var trigger = event.target.closest('[data-preview-url]');
  if (!trigger) return;

  event.preventDefault();

  var modalEl = document.getElementById('adminDocumentPreviewModal');
  var titleEl = document.getElementById('adminDocumentPreviewTitle');
  var stageEl = document.getElementById('adminDocumentPreviewStage');
  if (!modalEl || !titleEl || !stageEl || typeof bootstrap === 'undefined') return;

  var url = trigger.getAttribute('data-preview-url') || '';
  var type = trigger.getAttribute('data-preview-type') || 'file';
  var title = trigger.getAttribute('data-preview-title') || 'Prévisualisation';

  titleEl.textContent = title;

  if (type === 'image') {
    stageEl.innerHTML = '<img src="' + url + '" alt="' + title.replace(/"/g, '&quot;') + '">';
  } else {
    stageEl.innerHTML = '<iframe src="' + url + '" title="' + title.replace(/"/g, '&quot;') + '"></iframe>';
  }

  bootstrap.Modal.getOrCreateInstance(modalEl).show();
});

document.getElementById('adminDocumentPreviewModal')?.addEventListener('hidden.bs.modal', function () {
  var stageEl = document.getElementById('adminDocumentPreviewStage');
  if (stageEl) {
    stageEl.innerHTML = '';
  }
});

document.addEventListener('DOMContentLoaded', function () {
  var amountForm = document.getElementById('adminAmountForm');
  if (amountForm) {
    var amountInput = document.getElementById('adminAmountValue');
    var amountPreview = document.getElementById('adminAmountPreview');
    var currentAmount = parseFloat(amountForm.getAttribute('data-current-amount') || '0') || 0;
    var formatter = new Intl.NumberFormat('fr-FR', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });

    function syncAmountPreview() {
      if (!amountInput || !amountPreview) return;
      var modeInput = amountForm.querySelector('input[name="adjustment_type"]:checked');
      var mode = modeInput ? modeInput.value : 'increase';
      var value = parseFloat(amountInput.value || '0');
      if (!Number.isFinite(value) || value <= 0) {
        amountPreview.textContent = formatter.format(currentAmount) + ' EUR';
        return;
      }

      var nextAmount = mode === 'increase' ? currentAmount + value : value;
      amountPreview.textContent = formatter.format(nextAmount) + ' EUR';
    }

    amountForm.querySelectorAll('input[name="adjustment_type"]').forEach(function (input) {
      input.addEventListener('change', syncAmountPreview);
    });
    if (amountInput) {
      amountInput.addEventListener('input', syncAmountPreview);
    }
    syncAmountPreview();
  }

  var feesForm = document.getElementById('adminFeesForm');
  if (feesForm) {
    var feesInput = document.getElementById('adminFeesValue');
    var feesPreview = document.getElementById('adminFeesPreview');
    var currentFees = parseFloat(feesForm.getAttribute('data-current-fees') || '0') || 0;
    var feesFormatter = new Intl.NumberFormat('fr-FR', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });

    function syncFeesPreview() {
      if (!feesInput || !feesPreview) return;
      var value = parseFloat(feesInput.value || '');
      var nextFees = Number.isFinite(value) && value >= 0 ? value : currentFees;
      feesPreview.textContent = feesFormatter.format(nextFees) + ' EUR';
    }

    if (feesInput) {
      feesInput.addEventListener('input', syncFeesPreview);
    }
    syncFeesPreview();
  }

  if (typeof bootstrap === 'undefined') return;
  var refusalModal = document.getElementById('adminRefusalModal');
  if (!refusalModal) return;
  var refusalField = document.getElementById('refused_reason');
  var refusalCounter = document.getElementById('refusedReasonCounter');
  var refusalSubmit = document.getElementById('refusedReasonSubmit');

  function syncRefusalState() {
    if (!refusalField) return;
    var value = refusalField.value || '';
    var trimmed = value.trim();
    if (refusalCounter) {
      refusalCounter.textContent = value.length + ' / 5000';
      refusalCounter.classList.toggle('is-invalid', value.length > 5000);
    }
    if (refusalSubmit) {
      refusalSubmit.disabled = trimmed.length < 5 || value.length > 5000;
    }
    refusalField.style.height = 'auto';
    refusalField.style.height = Math.min(refusalField.scrollHeight, 260) + 'px';
  }

  if (refusalField) {
    ['input', 'change'].forEach(function (eventName) {
      refusalField.addEventListener(eventName, syncRefusalState);
    });
    syncRefusalState();
  }

  refusalModal.addEventListener('shown.bs.modal', function () {
    if (refusalField) {
      syncRefusalState();
      refusalField.focus();
      var length = refusalField.value.length;
      refusalField.setSelectionRange(length, length);
    }
  });

  @if ($errors->has('refused_reason'))
    bootstrap.Modal.getOrCreateInstance(refusalModal).show();
  @endif
});
</script>
@endpush
 </div>
@endsection

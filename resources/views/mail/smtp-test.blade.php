@extends('mail.layouts.funding')

@section('title', 'Test SMTP')

@section('content')
@php($brandRgb = \App\Support\SiteAppearance::primaryRgb())
<p style="margin:0 0 14px;">Bonjour,</p>

<p style="margin:0 0 14px;">Cet e-mail confirme que la configuration SMTP actuellement enregistrée sur le site permet bien l'envoi des messages.</p>

<div style="margin:0 0 18px;padding:16px 18px;border-radius:18px;background:#f7faf9;border:1px solid rgba({{ $brandRgb }},0.12);">
  <p style="margin:0 0 10px;"><strong>Serveur :</strong> {{ $smtpSummary['host'] ?: 'Non renseigné' }}</p>
  <p style="margin:0 0 10px;"><strong>Port :</strong> {{ $smtpSummary['port'] ?: 'Non renseigné' }}</p>
  <p style="margin:0 0 10px;"><strong>Chiffrement :</strong> {{ $smtpSummary['encryption'] ?: 'Aucun' }}</p>
  <p style="margin:0 0 10px;"><strong>Expéditeur :</strong> {{ $smtpSummary['from_name'] ?: config('site.name') }} &lt;{{ $smtpSummary['from_address'] ?: 'Non renseignée' }}&gt;</p>
  <p style="margin:0;"><strong>Testé le :</strong> {{ $testedAt->format('d/m/Y H:i') }}</p>
</div>

<p style="margin:0 0 14px;">Si vous recevez ce message correctement, l'envoi principal du site est prêt.</p>

<p style="margin:0;">Cordialement,</p>
@endsection

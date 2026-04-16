@extends('mail.layouts.funding')

@section('title', 'Nouveau message de contact')

@section('header_tagline', 'Message reçu depuis le formulaire de contact')

@section('content')
  <p style="margin:0 0 16px;"><strong>Nouveau message de contact reçu.</strong></p>

  <p style="margin:0 0 8px;"><strong>Nom complet :</strong> {{ $contactMessage['full_name'] }}</p>
  <p style="margin:0 0 8px;"><strong>E-mail :</strong> {{ $contactMessage['email'] }}</p>
  <p style="margin:0 0 8px;"><strong>Objet :</strong> {{ $contactMessage['subject'] }}</p>
  <p style="margin:0 0 8px;"><strong>Date :</strong> {{ $contactMessage['submitted_at']->format('d/m/Y H:i') }}</p>
  <p style="margin:0 0 20px;"><strong>IP :</strong> {{ $contactMessage['ip'] }}</p>

  <p style="margin:0 0 8px;"><strong>Message :</strong></p>
  <div style="padding:16px;border-radius:12px;background:#f6f8f7;white-space:pre-line;">{{ $contactMessage['message'] }}</div>
@endsection

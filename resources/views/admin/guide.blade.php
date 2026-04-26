@extends('layouts.admin')

@section('title', 'Guide admin')

@push('head')
  <style>
    .admin-guide-shell {
      --guide-border: rgba(15, 23, 42, 0.08);
      --guide-shadow: 0 18px 40px rgba(148, 163, 184, 0.16);
      --guide-muted: #6b7a90;
      --guide-heading: #172033;
      --guide-soft: #f5f7fb;
      --guide-surface: #ffffff;
    }

    .admin-guide-hero,
    .admin-guide-card {
      border: 1px solid var(--guide-border);
      border-radius: 1.75rem;
      background: var(--guide-surface);
      box-shadow: var(--guide-shadow);
    }

    .admin-guide-hero {
      padding: 1.35rem 1.4rem;
      margin-bottom: 1rem;
    }

    .admin-guide-hero-top {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .admin-guide-kicker {
      color: var(--guide-muted);
      font-size: .78rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: .06em;
      margin-bottom: .5rem;
    }

    .admin-guide-title {
      color: var(--guide-heading);
      font-size: clamp(1.8rem, 2vw, 2.3rem);
      font-weight: 800;
      line-height: 1.05;
      margin-bottom: .55rem;
    }

    .admin-guide-text {
      color: var(--guide-muted);
      font-size: .98rem;
      max-width: 44rem;
      margin-bottom: 0;
    }

    .admin-guide-back {
      min-height: 3rem;
      border-radius: 999px;
      padding-inline: 1.1rem;
      font-weight: 700;
      white-space: nowrap;
    }

    .admin-guide-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 1rem;
    }

    .admin-guide-card {
      padding: 1.2rem 1.25rem;
      height: 100%;
    }

    .admin-guide-card-title {
      color: var(--guide-heading);
      font-size: 1.05rem;
      font-weight: 800;
      margin-bottom: .85rem;
    }

    .admin-guide-list {
      display: grid;
      gap: .75rem;
      margin: 0;
      padding: 0;
      list-style: none;
    }

    .admin-guide-item {
      display: flex;
      align-items: flex-start;
      gap: .8rem;
      padding: .9rem .95rem;
      border-radius: 1rem;
      border: 1px solid rgba(148, 163, 184, 0.16);
      background: var(--guide-soft);
    }

    .admin-guide-index {
      width: 2rem;
      height: 2rem;
      border-radius: 999px;
      background: rgba(255, 180, 0, 0.12);
      color: #9b6b00;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: .88rem;
      font-weight: 800;
      flex: 0 0 auto;
    }

    .admin-guide-item strong {
      display: block;
      color: var(--guide-heading);
      margin-bottom: .2rem;
    }

    .admin-guide-item span,
    .admin-guide-note {
      color: var(--guide-muted);
      font-size: .92rem;
      line-height: 1.55;
    }

    .admin-guide-note {
      margin-bottom: 0;
    }

    [data-bs-theme="dark"] .admin-guide-shell {
      --guide-border: rgba(255, 255, 255, 0.08);
      --guide-shadow: none;
      --guide-muted: #9aa6b8;
      --guide-heading: #f5f7fb;
      --guide-soft: #20262d;
      --guide-surface: #171c22;
    }

    [data-bs-theme="dark"] .admin-guide-item {
      border-color: rgba(255, 255, 255, 0.08);
    }

    @media (max-width: 991.98px) {
      .admin-guide-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
@endpush

@section('content')
<div class="admin-guide-shell">
  <section class="admin-guide-hero">
    <div class="admin-guide-hero-top">
      <div>
        <div class="admin-guide-kicker">Guide interne</div>
        <h1 class="admin-guide-title">Guide d’utilisation admin</h1>
        <p class="admin-guide-text">Cette page résume le fonctionnement de la plateforme, les actions attendues du client et la procédure de traitement à suivre côté administration.</p>
      </div>
      <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary admin-guide-back">Retour à l’administration</a>
    </div>
  </section>

  <div class="admin-guide-grid">
    <div class="admin-guide-card">
      <h2 class="admin-guide-card-title">Parcours du client</h2>
      <ul class="admin-guide-list">
        <li class="admin-guide-item">
          <span class="admin-guide-index">1</span>
          <div>
            <strong>Dépôt de la demande</strong>
            <span>Le client remplit le formulaire de demande de financement avec ses informations, sa situation, son besoin et le montant souhaité.</span>
          </div>
        </li>
        <li class="admin-guide-item">
          <span class="admin-guide-index">2</span>
          <div>
            <strong>Réception du numéro de dossier</strong>
            <span>Après validation, le système crée un dossier `ARD-...` et envoie un e-mail de confirmation au client.</span>
          </div>
        </li>
        <li class="admin-guide-item">
          <span class="admin-guide-index">3</span>
          <div>
            <strong>Attente du premier retour</strong>
            <span>Le client attend l’examen initial du dossier par l’administration.</span>
          </div>
        </li>
        <li class="admin-guide-item">
          <span class="admin-guide-index">4</span>
          <div>
            <strong>Transmission des justificatifs</strong>
            <span>Si la demande avance, le client reçoit un lien personnel pour déposer ses pièces justificatives.</span>
          </div>
        </li>
        <li class="admin-guide-item">
          <span class="admin-guide-index">5</span>
          <div>
            <strong>Suivi du dossier</strong>
            <span>Le client peut consulter l’avancement général via la page de suivi avec son numéro de dossier.</span>
          </div>
        </li>
        <li class="admin-guide-item">
          <span class="admin-guide-index">6</span>
          <div>
            <strong>Décision finale</strong>
            <span>Le client reçoit soit un document d’accord, soit un e-mail de refus avec le motif communiqué.</span>
          </div>
        </li>
      </ul>
    </div>

    <div class="admin-guide-card">
      <h2 class="admin-guide-card-title">Parcours de l’admin</h2>
      <ul class="admin-guide-list">
        <li class="admin-guide-item">
          <span class="admin-guide-index">1</span>
          <div>
            <strong>Ouvrir les nouvelles demandes</strong>
            <span>Les dossiers arrivant sur la plateforme doivent être consultés depuis le tableau de bord ou la page `Toutes les demandes`.</span>
          </div>
        </li>
        <li class="admin-guide-item">
          <span class="admin-guide-index">2</span>
          <div>
            <strong>Vérifier la cohérence du dossier</strong>
            <span>Contrôlez les informations du client, le besoin déclaré, le montant demandé et la logique générale du dossier.</span>
          </div>
        </li>
        <li class="admin-guide-item">
          <span class="admin-guide-index">3</span>
          <div>
            <strong>Valider la demande</strong>
            <span>Si le dossier peut avancer, utilisez `Valider la demande` pour envoyer au client son lien personnel de dépôt de pièces.</span>
          </div>
        </li>
        <li class="admin-guide-item">
          <span class="admin-guide-index">4</span>
          <div>
            <strong>Contrôler les pièces</strong>
            <span>Quand les justificatifs sont reçus, relisez le dossier et utilisez la prévisualisation intégrée pour examiner les documents.</span>
          </div>
        </li>
        <li class="admin-guide-item">
          <span class="admin-guide-index">5</span>
          <div>
            <strong>Prendre la décision</strong>
            <span>L’admin peut `Accorder le don` ou `Refuser et archiver` avec un motif obligatoire.</span>
          </div>
        </li>
        <li class="admin-guide-item">
          <span class="admin-guide-index">6</span>
          <div>
            <strong>Finaliser le dossier</strong>
            <span>Après envoi du document final, le dossier peut être clôturé. Un dossier refusé reste archivé mais peut être réactivé.</span>
          </div>
        </li>
      </ul>
    </div>

    <div class="admin-guide-card">
      <h2 class="admin-guide-card-title">Statuts à retenir</h2>
      <ul class="admin-guide-list">
        <li class="admin-guide-item">
          <span class="admin-guide-index">A</span>
          <div>
            <strong>En attente</strong>
            <span>Nouvelle demande reçue, encore en attente du premier examen par l’administration.</span>
          </div>
        </li>
        <li class="admin-guide-item">
          <span class="admin-guide-index">B</span>
          <div>
            <strong>Pièces à compléter ou vérifier</strong>
            <span>Le client peut encore déposer ou remplacer ses justificatifs. L’admin valide les pièces quand elles sont correctes.</span>
          </div>
        </li>
        <li class="admin-guide-item">
          <span class="admin-guide-index">C</span>
          <div>
            <strong>Pièces validées</strong>
            <span>Les documents obligatoires ont été approuvés et le dossier est prêt pour la décision finale.</span>
          </div>
        </li>
        <li class="admin-guide-item">
          <span class="admin-guide-index">D</span>
          <div>
            <strong>Don accordé</strong>
            <span>Le document final a été généré et envoyé au client.</span>
          </div>
        </li>
        <li class="admin-guide-item">
          <span class="admin-guide-index">E</span>
          <div>
            <strong>Refusé et archivé</strong>
            <span>Le dossier a été refusé avec motif et sorti du flux actif, tout en restant réactivable.</span>
          </div>
        </li>
      </ul>
    </div>

    <div class="admin-guide-card">
      <h2 class="admin-guide-card-title">Règles importantes</h2>
      <ul class="admin-guide-list">
        <li class="admin-guide-item">
          <span class="admin-guide-index">1</span>
          <div>
            <strong>Une seule demande par personne</strong>
            <span>Le système bloque les doublons sur l’adresse e-mail et le numéro de téléphone pour limiter les abus.</span>
          </div>
        </li>
        <li class="admin-guide-item">
          <span class="admin-guide-index">2</span>
          <div>
            <strong>Lien personnel sécurisé</strong>
            <span>Chaque dossier possède un lien unique pour le dépôt des pièces, à transmettre uniquement au client concerné.</span>
          </div>
        </li>
        <li class="admin-guide-item">
          <span class="admin-guide-index">3</span>
          <div>
            <strong>Motif obligatoire en cas de refus</strong>
            <span>Tout refus doit être accompagné d’un motif clair, car il est enregistré et envoyé au client.</span>
          </div>
        </li>
        <li class="admin-guide-item">
          <span class="admin-guide-index">4</span>
          <div>
            <strong>Prévisualisation des documents</strong>
            <span>Les pièces du client peuvent être examinées directement dans la fiche dossier avant téléchargement.</span>
          </div>
        </li>
      </ul>
      <p class="admin-guide-note mt-3">Utilisez cette page comme repère rapide pour les nouveaux administrateurs ou comme rappel des règles de traitement.</p>
    </div>

    <div class="admin-guide-card">
      <h2 class="admin-guide-card-title">Configuration du site</h2>
      <ul class="admin-guide-list">
        <li class="admin-guide-item">
          <span class="admin-guide-index">1</span>
          <div>
            <strong>Mettre à jour les informations publiques</strong>
            <span>La page `Configuration` permet de modifier le nom du site, l’e-mail du site, le téléphone, l’adresse et la langue principale utilisée par défaut.</span>
          </div>
        </li>
        <li class="admin-guide-item">
          <span class="admin-guide-index">2</span>
          <div>
            <strong>Définir la langue principale</strong>
            <span>La langue principale du site sert de référence à l’ouverture du site et aux contenus envoyés par défaut quand aucune langue spécifique n’est définie.</span>
          </div>
        </li>
        <li class="admin-guide-item">
          <span class="admin-guide-index">3</span>
          <div>
            <strong>Mettre à jour les métadonnées</strong>
            <span>La configuration permet aussi d’ajuster la description et les mots-clés du site pour l’affichage général et le référencement.</span>
          </div>
        </li>
        <li class="admin-guide-item">
          <span class="admin-guide-index">4</span>
          <div>
            <strong>Enregistrement des changements</strong>
            <span>Les modifications enregistrées depuis l’admin mettent à jour les variables de configuration du site utilisées par l’application.</span>
          </div>
        </li>
      </ul>
    </div>
  </div>
</div>
@endsection

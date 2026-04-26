<?php

return [
    'generic_recipient' => 'Madame, Monsieur',
    'amount_not_provided' => 'non renseigné',
    'templates' => [
        [
            'key' => 'received',
            'step' => 1,
            'title' => 'Demande reçue',
            'action' => 'Confirmer la réception du dossier et demander des précisions avant la première décision.',
            'subject' => 'Votre demande d’aide a bien été reçue',
            'body' => <<<'TEXT'
Bonjour [PRENOM],

Nous confirmons la bonne réception de votre demande d’aide financière, enregistrée sous le numéro [NUMERO_DOSSIER].

Votre demande concerne : [MOTIF_DEMANDE].

Avant de poursuivre l’analyse, notre équipe souhaite vérifier que les informations transmises sont complètes, cohérentes et suffisamment précises.

Merci de nous apporter quelques précisions complémentaires sur votre situation, l’objectif exact du financement demandé, l’utilisation prévue des fonds et le niveau d’urgence de votre besoin.

Ces éléments nous permettront d’étudier votre dossier avec plus de sérieux et de vous orienter correctement vers la suite du traitement.

Cordialement,
[NOM_SITE]
TEXT,
        ],
        [
            'key' => 'client_reply_received',
            'step' => 2,
            'title' => 'Réponse du client reçue',
            'action' => 'Accuser réception des précisions du client et indiquer que l’analyse continue.',
            'subject' => 'Précisions bien reçues',
            'body' => <<<'TEXT'
Bonjour [PRENOM],

Nous vous remercions pour les précisions transmises concernant votre demande.

Votre retour a bien été ajouté à l’analyse du dossier. Notre équipe va poursuivre l’examen des informations communiquées avant de vous indiquer la suite du traitement.

Nous reviendrons vers vous dès qu’une étape supplémentaire sera nécessaire.

Cordialement,
[NOM_SITE]
TEXT,
        ],
        [
            'key' => 'pre_accepted',
            'step' => 3,
            'title' => 'Dossier pré-accepté',
            'action' => 'Informer le client que le dossier passe à l’étape suivante et rappeler le lien de dépôt.',
            'subject' => 'Documents complémentaires à transmettre',
            'body' => <<<'TEXT'
Bonjour [PRENOM],

Après une première analyse, votre demande enregistrée sous le numéro [NUMERO_DOSSIER] peut passer à l’étape suivante.

Cette étape ne constitue pas encore une validation définitive. Pour poursuivre l’étude de votre dossier, nous avons besoin d’informations et de documents complémentaires.

Un e-mail vous a été envoyé avec le lien sécurisé permettant de déposer les éléments demandés.

Vous pouvez également utiliser ce lien :
[LIEN_DOCUMENTS]

Merci de compléter votre dossier dès que possible afin que nous puissions poursuivre le traitement.

Cordialement,
[NOM_SITE]
TEXT,
        ],
        [
            'key' => 'documents_received',
            'step' => 4,
            'title' => 'Documents reçus',
            'action' => 'Confirmer la réception des documents et annoncer le délai de traitement.',
            'subject' => 'Documents reçus, vérification en cours',
            'body' => <<<'TEXT'
Bonjour [PRENOM],

Nous confirmons avoir bien reçu vos informations et documents complémentaires.

Votre dossier est maintenant en cours d’analyse finale.

Le traitement peut prendre jusqu’à 72 heures selon les vérifications nécessaires. Lorsque tous les éléments sont conformes, le dossier peut généralement être traité sous 24 heures.

Nous reviendrons vers vous dès qu’une décision aura été prise.

Cordialement,
[NOM_SITE]
TEXT,
        ],
        [
            'key' => 'missing_documents',
            'step' => 5,
            'title' => 'Document manquant ou incomplet',
            'action' => 'Demander au client de corriger son dossier ou de transmettre un document lisible.',
            'subject' => 'Complément nécessaire pour votre dossier',
            'body' => <<<'TEXT'
Bonjour [PRENOM],

Après vérification de votre dossier, certains éléments sont manquants, incomplets ou insuffisamment lisibles.

Merci de vous reconnecter à votre espace sécurisé afin de compléter les informations demandées ou de transmettre des documents lisibles.

Lien sécurisé :
[LIEN_DOCUMENTS]

Sans ces éléments, l’analyse de votre demande restera suspendue.

Cordialement,
[NOM_SITE]
TEXT,
        ],
        [
            'key' => 'contract_sent',
            'step' => 6,
            'title' => 'Dossier validé avec acte envoyé',
            'action' => 'Confirmer que l’acte de donation a été envoyé par e-mail.',
            'subject' => 'Acte de donation envoyé',
            'body' => <<<'TEXT'
Bonjour [PRENOM],

Votre dossier a été validé.

L’acte de donation vous a été envoyé par e-mail. Merci de vérifier votre boîte de réception ainsi que vos courriers indésirables.

Nous vous invitons à lire attentivement le document, à le signer aux emplacements indiqués, puis à nous retourner une copie lisible.

Merci également de prendre connaissance des conditions indiquées dans le document, notamment les frais de traitement, afin que votre dossier puisse être finalisé correctement.

Cordialement,
[NOM_SITE]
TEXT,
        ],
        [
            'key' => 'contract_reminder',
            'step' => 7,
            'title' => 'Relance document non signé',
            'action' => 'Relancer le client si l’acte de donation signé n’a pas encore été retourné.',
            'subject' => 'Acte de donation signé attendu',
            'body' => <<<'TEXT'
Bonjour [PRENOM],

Nous revenons vers vous concernant votre dossier.

À ce jour, nous n’avons pas encore reçu votre acte de donation signé.

Merci de nous retourner une copie lisible du document signé afin que nous puissions finaliser votre dossier.

Sans retour de votre part, le traitement restera en attente.

Cordialement,
[NOM_SITE]
TEXT,
        ],
        [
            'key' => 'signed_contract_received',
            'step' => 8,
            'title' => 'Document signé reçu',
            'action' => 'Confirmer la réception du document signé et annoncer la vérification administrative.',
            'subject' => 'Acte de donation signé reçu',
            'body' => <<<'TEXT'
Bonjour [PRENOM],

Nous confirmons avoir bien reçu votre document signé.

Votre dossier est maintenant en phase finale de vérification administrative.

Nous reviendrons vers vous dès que cette vérification sera terminée ou si un complément est nécessaire.

Cordialement,
[NOM_SITE]
TEXT,
        ],
        [
            'key' => 'donation_accepted',
            'step' => 9,
            'title' => 'Don accepté / informations de virement',
            'action' => 'Envoyer la confirmation finale et demander les informations nécessaires au virement.',
            'subject' => 'Don accepté - informations de virement',
            'body' => <<<'TEXT'
Bonjour [PRENOM],

Félicitations, votre don a été accepté par [NOM_SITE].

Numéro de dossier : [NUMERO_DOSSIER]
Montant accepté : [MONTANT_ACCEPTE]

Afin d’organiser le virement, merci de nous transmettre les informations bancaires suivantes :

- Nom complet du titulaire du compte
- Nom de la banque
- IBAN ou numéro de compte
- Code BIC/SWIFT

Votre dossier est maintenant en phase finale de traitement administratif.

Cordialement,
[NOM_SITE]
TEXT,
        ],
    ],
];

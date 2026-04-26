<?php

return array_replace_recursive(require __DIR__.'/../en/admin_messages.php', [
    'generic_recipient' => 'Signora, signore',
    'amount_not_provided' => 'non indicato',
    'templates' => [
        [
            'title' => 'Richiesta ricevuta',
            'action' => 'Confermare la ricezione della pratica e chiedere precisazioni prima della prima decisione.',
            'subject' => 'Abbiamo ricevuto la vostra richiesta di aiuto',
            'body' => <<<'TEXT'
Buongiorno [PRENOM],

Confermiamo la corretta ricezione della vostra richiesta di aiuto finanziario, registrata con il numero [NUMERO_DOSSIER].

La vostra richiesta riguarda: [MOTIF_DEMANDE].

Prima di proseguire l’analisi, il nostro team desidera verificare che le informazioni trasmesse siano complete, coerenti e sufficientemente precise.

Vi chiediamo di inviarci alcune precisazioni aggiuntive sulla vostra situazione, sull’obiettivo esatto del finanziamento richiesto, sull’utilizzo previsto dei fondi e sul livello di urgenza della vostra esigenza.

Questi elementi ci permetteranno di studiare la pratica con maggiore attenzione e di orientarvi correttamente verso la fase successiva.

Cordiali saluti,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Risposta del cliente ricevuta',
            'action' => 'Confermare la ricezione delle precisazioni del cliente e indicare che l’analisi continua.',
            'subject' => 'Precisazioni ricevute',
            'body' => <<<'TEXT'
Buongiorno [PRENOM],

Vi ringraziamo per le precisazioni trasmesse riguardo alla vostra richiesta.

La vostra risposta è stata aggiunta all’analisi della pratica. Il nostro team continuerà a esaminare le informazioni comunicate prima di indicarvi il seguito del trattamento.

Vi ricontatteremo non appena sarà necessaria una fase aggiuntiva.

Cordiali saluti,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Pratica pre-accettata',
            'action' => 'Informare il cliente che la pratica passa alla fase successiva e ricordare il link di caricamento.',
            'subject' => 'Documenti complementari da trasmettere',
            'body' => <<<'TEXT'
Buongiorno [PRENOM],

Dopo una prima analisi, la vostra richiesta registrata con il numero [NUMERO_DOSSIER] può passare alla fase successiva.

Questa fase non costituisce ancora una convalida definitiva. Per continuare l’esame della pratica, abbiamo bisogno di informazioni e documenti complementari.

Vi è stata inviata un’e-mail con il link sicuro per depositare gli elementi richiesti.

Potete utilizzare anche questo link:
[LIEN_DOCUMENTS]

Vi chiediamo di completare la pratica il prima possibile, così da poter proseguire il trattamento.

Cordiali saluti,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Documenti ricevuti',
            'action' => 'Confermare la ricezione dei documenti e comunicare il tempo di trattamento.',
            'subject' => 'Documenti ricevuti, verifica in corso',
            'body' => <<<'TEXT'
Buongiorno [PRENOM],

Confermiamo di aver ricevuto correttamente le vostre informazioni e i documenti complementari.

La vostra pratica è ora in fase di analisi finale.

Il trattamento può richiedere fino a 72 ore, in base alle verifiche necessarie. Quando tutti gli elementi sono conformi, la pratica può generalmente essere trattata entro 24 ore.

Vi ricontatteremo non appena sarà stata presa una decisione.

Cordiali saluti,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Documento mancante o incompleto',
            'action' => 'Chiedere al cliente di correggere la pratica o trasmettere un documento leggibile.',
            'subject' => 'Integrazione necessaria per la vostra pratica',
            'body' => <<<'TEXT'
Buongiorno [PRENOM],

Dopo la verifica della vostra pratica, alcuni elementi risultano mancanti, incompleti o non sufficientemente leggibili.

Vi chiediamo di accedere nuovamente al vostro spazio sicuro per completare le informazioni richieste o trasmettere documenti leggibili.

Link sicuro:
[LIEN_DOCUMENTS]

Senza questi elementi, l’analisi della vostra richiesta resterà sospesa.

Cordiali saluti,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Pratica validata con atto inviato',
            'action' => 'Confermare che l’atto di donazione è stato inviato via e-mail.',
            'subject' => 'Atto di donazione inviato',
            'body' => <<<'TEXT'
Buongiorno [PRENOM],

La vostra pratica è stata validata.

L’atto di donazione vi è stato inviato via e-mail. Vi invitiamo a controllare la posta in arrivo e anche la cartella della posta indesiderata.

Vi chiediamo di leggere attentamente il documento, firmarlo nei punti indicati e restituirci una copia leggibile.

Vi invitiamo inoltre a prendere visione delle condizioni indicate nel documento, in particolare delle spese di trattamento, affinché la pratica possa essere finalizzata correttamente.

Cordiali saluti,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Sollecito atto non firmato',
            'action' => 'Sollecitare il cliente se l’atto di donazione firmato non è ancora stato restituito.',
            'subject' => 'Atto di donazione firmato atteso',
            'body' => <<<'TEXT'
Buongiorno [PRENOM],

Vi ricontattiamo riguardo alla vostra pratica.

Ad oggi non abbiamo ancora ricevuto il vostro atto di donazione firmato.

Vi chiediamo di restituirci una copia leggibile del documento firmato, così da poter finalizzare la pratica.

In assenza di un vostro riscontro, il trattamento resterà in attesa.

Cordiali saluti,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Documento firmato ricevuto',
            'action' => 'Confermare la ricezione del documento firmato e comunicare la verifica amministrativa.',
            'subject' => 'Atto di donazione firmato ricevuto',
            'body' => <<<'TEXT'
Buongiorno [PRENOM],

Confermiamo di aver ricevuto correttamente il vostro documento firmato.

La vostra pratica è ora nella fase finale di verifica amministrativa.

Vi ricontatteremo non appena questa verifica sarà terminata o se sarà necessaria un’integrazione.

Cordiali saluti,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Donazione accettata / dati per il bonifico',
            'action' => 'Inviare la conferma finale e chiedere le informazioni necessarie per il bonifico.',
            'subject' => 'Donazione accettata - dati per il bonifico',
            'body' => <<<'TEXT'
Buongiorno [PRENOM],

Congratulazioni, la vostra donazione è stata accettata da [NOM_SITE].

Numero di pratica: [NUMERO_DOSSIER]
Importo accettato: [MONTANT_ACCEPTE]

Per organizzare il bonifico, vi chiediamo di inviarci le seguenti informazioni bancarie:

- Nome completo dell’intestatario del conto
- Nome della banca
- IBAN o numero di conto
- Codice BIC/SWIFT

La vostra pratica è ora nella fase finale di trattamento amministrativo.

Cordiali saluti,
[NOM_SITE]
TEXT,
        ],
    ],
]);

<?php

return array_replace_recursive(require __DIR__.'/../en/admin_messages.php', [
    'generic_recipient' => 'Mevrouw, meneer',
    'amount_not_provided' => 'niet ingevuld',
    'templates' => [
        [
            'title' => 'Aanvraag ontvangen',
            'action' => 'De ontvangst van het dossier bevestigen en om verduidelijking vragen vóór de eerste beslissing.',
            'subject' => 'Uw hulpaanvraag is goed ontvangen',
            'body' => <<<'TEXT'
Hallo [PRENOM],

Wij bevestigen de goede ontvangst van uw aanvraag voor financiële hulp, geregistreerd onder nummer [NUMERO_DOSSIER].

Uw aanvraag betreft: [MOTIF_DEMANDE].

Voordat wij de analyse voortzetten, wil ons team controleren of de verstrekte informatie volledig, samenhangend en voldoende duidelijk is.

Gelieve ons enkele aanvullende details te bezorgen over uw situatie, het exacte doel van de gevraagde financiering, het beoogde gebruik van de middelen en de urgentie van uw behoefte.

Deze elementen helpen ons uw dossier zorgvuldiger te bestuderen en u correct naar de volgende stap te begeleiden.

Met vriendelijke groet,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Antwoord van de klant ontvangen',
            'action' => 'De ontvangst van de verduidelijkingen bevestigen en aangeven dat de analyse verdergaat.',
            'subject' => 'Verduidelijkingen goed ontvangen',
            'body' => <<<'TEXT'
Hallo [PRENOM],

Wij danken u voor de verduidelijkingen die u over uw aanvraag hebt gestuurd.

Uw antwoord is toegevoegd aan de analyse van het dossier. Ons team zal de meegedeelde informatie verder onderzoeken voordat wij u de volgende stap aangeven.

Wij nemen opnieuw contact met u op zodra een extra stap nodig is.

Met vriendelijke groet,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Dossier voorlopig aanvaard',
            'action' => 'De klant informeren dat het dossier naar de volgende stap gaat en de uploadlink herhalen.',
            'subject' => 'Aanvullende documenten te bezorgen',
            'body' => <<<'TEXT'
Hallo [PRENOM],

Na een eerste analyse kan uw aanvraag, geregistreerd onder nummer [NUMERO_DOSSIER], naar de volgende stap gaan.

Deze stap vormt nog geen definitieve goedkeuring. Om de studie van uw dossier voort te zetten, hebben wij aanvullende informatie en documenten nodig.

U hebt een e-mail ontvangen met de beveiligde link waarmee u de gevraagde elementen kunt indienen.

U kunt ook deze link gebruiken:
[LIEN_DOCUMENTS]

Gelieve uw dossier zo snel mogelijk aan te vullen, zodat wij de behandeling kunnen voortzetten.

Met vriendelijke groet,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Documenten ontvangen',
            'action' => 'De ontvangst van de documenten bevestigen en de verwerkingstijd aankondigen.',
            'subject' => 'Documenten ontvangen, verificatie loopt',
            'body' => <<<'TEXT'
Hallo [PRENOM],

Wij bevestigen dat wij uw aanvullende informatie en documenten goed hebben ontvangen.

Uw dossier bevindt zich nu in de eindanalyse.

De behandeling kan tot 72 uur duren, afhankelijk van de nodige verificaties. Wanneer alle elementen conform zijn, kan het dossier doorgaans binnen 24 uur worden behandeld.

Wij nemen opnieuw contact met u op zodra er een beslissing is genomen.

Met vriendelijke groet,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Ontbrekend of onvolledig document',
            'action' => 'De klant vragen het dossier te corrigeren of een leesbaar document te bezorgen.',
            'subject' => 'Aanvulling nodig voor uw dossier',
            'body' => <<<'TEXT'
Hallo [PRENOM],

Na controle van uw dossier ontbreken sommige elementen, zijn ze onvolledig of onvoldoende leesbaar.

Gelieve opnieuw in te loggen op uw beveiligde ruimte om de gevraagde informatie aan te vullen of leesbare documenten te bezorgen.

Beveiligde link:
[LIEN_DOCUMENTS]

Zonder deze elementen blijft de analyse van uw aanvraag opgeschort.

Met vriendelijke groet,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Dossier gevalideerd met akte verzonden',
            'action' => 'Bevestigen dat de schenkingsakte per e-mail werd verzonden.',
            'subject' => 'Schenkingsakte verzonden',
            'body' => <<<'TEXT'
Hallo [PRENOM],

Uw dossier is gevalideerd.

De schenkingsakte werd u per e-mail toegestuurd. Gelieve uw inbox en ook uw ongewenste e-mail te controleren.

Wij vragen u het document aandachtig te lezen, het op de aangegeven plaatsen te ondertekenen en ons een leesbare kopie terug te sturen.

Gelieve ook kennis te nemen van de voorwaarden in het document, met name de verwerkingskosten, zodat uw dossier correct kan worden afgerond.

Met vriendelijke groet,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Herinnering niet-ondertekende akte',
            'action' => 'De klant herinneren als de ondertekende schenkingsakte nog niet werd teruggestuurd.',
            'subject' => 'Ondertekende schenkingsakte verwacht',
            'body' => <<<'TEXT'
Hallo [PRENOM],

Wij nemen opnieuw contact met u op over uw dossier.

Tot op heden hebben wij uw ondertekende schenkingsakte nog niet ontvangen.

Gelieve ons een leesbare kopie van het ondertekende document terug te sturen, zodat wij uw dossier kunnen finaliseren.

Zonder reactie van uw kant blijft de behandeling in afwachting.

Met vriendelijke groet,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Ondertekend document ontvangen',
            'action' => 'De ontvangst van het ondertekende document bevestigen en de administratieve verificatie aankondigen.',
            'subject' => 'Ondertekende schenkingsakte ontvangen',
            'body' => <<<'TEXT'
Hallo [PRENOM],

Wij bevestigen dat wij uw ondertekende document goed hebben ontvangen.

Uw dossier bevindt zich nu in de laatste fase van administratieve verificatie.

Wij nemen opnieuw contact met u op zodra deze verificatie is afgerond of als er een aanvulling nodig is.

Met vriendelijke groet,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Schenking aanvaard / overschrijvingsgegevens',
            'action' => 'De definitieve bevestiging verzenden en de gegevens vragen die nodig zijn voor de overschrijving.',
            'subject' => 'Schenking aanvaard - overschrijvingsgegevens',
            'body' => <<<'TEXT'
Hallo [PRENOM],

Gefeliciteerd, uw schenking is aanvaard door [NOM_SITE].

Dossiernummer: [NUMERO_DOSSIER]
Aanvaard bedrag: [MONTANT_ACCEPTE]

Om de overschrijving te organiseren, vragen wij u ons de volgende bankgegevens te bezorgen:

- Volledige naam van de rekeninghouder
- Naam van de bank
- IBAN of rekeningnummer
- BIC/SWIFT-code

Uw dossier bevindt zich nu in de laatste fase van administratieve behandeling.

Met vriendelijke groet,
[NOM_SITE]
TEXT,
        ],
    ],
]);

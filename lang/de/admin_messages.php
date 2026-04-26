<?php

return array_replace_recursive(require __DIR__.'/../en/admin_messages.php', [
    'generic_recipient' => 'Sehr geehrte Damen und Herren',
    'amount_not_provided' => 'nicht angegeben',
    'templates' => [
        [
            'title' => 'Antrag eingegangen',
            'action' => 'Den Eingang des Vorgangs bestätigen und vor der ersten Entscheidung um Präzisierungen bitten.',
            'subject' => 'Ihr Hilfsantrag ist eingegangen',
            'body' => <<<'TEXT'
Guten Tag [PRENOM],

wir bestätigen den Eingang Ihres Antrags auf finanzielle Hilfe, der unter der Nummer [NUMERO_DOSSIER] registriert wurde.

Ihr Antrag betrifft: [MOTIF_DEMANDE].

Bevor wir die Prüfung fortsetzen, möchte unser Team sicherstellen, dass die übermittelten Informationen vollständig, schlüssig und ausreichend präzise sind.

Bitte senden Sie uns einige zusätzliche Angaben zu Ihrer Situation, zum genauen Zweck der beantragten Finanzierung, zur geplanten Verwendung der Mittel und zur Dringlichkeit Ihres Bedarfs.

Diese Angaben helfen uns, Ihren Vorgang sorgfältiger zu prüfen und Sie korrekt zur nächsten Etappe zu führen.

Mit freundlichen Grüßen
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Antwort des Kunden eingegangen',
            'action' => 'Den Eingang der Präzisierungen bestätigen und mitteilen, dass die Prüfung fortgesetzt wird.',
            'subject' => 'Ihre Präzisierungen sind eingegangen',
            'body' => <<<'TEXT'
Guten Tag [PRENOM],

vielen Dank für die übermittelten Präzisierungen zu Ihrem Antrag.

Ihre Antwort wurde der Prüfung des Vorgangs hinzugefügt. Unser Team wird die übermittelten Informationen weiter prüfen, bevor wir Ihnen den nächsten Schritt mitteilen.

Wir melden uns wieder bei Ihnen, sobald eine weitere Etappe erforderlich ist.

Mit freundlichen Grüßen
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Vorgang vorläufig angenommen',
            'action' => 'Den Kunden informieren, dass der Vorgang zur nächsten Etappe übergeht, und den Upload-Link nennen.',
            'subject' => 'Zusätzliche Dokumente erforderlich',
            'body' => <<<'TEXT'
Guten Tag [PRENOM],

nach einer ersten Prüfung kann Ihr unter der Nummer [NUMERO_DOSSIER] registrierter Antrag zur nächsten Etappe übergehen.

Diese Etappe stellt noch keine endgültige Genehmigung dar. Um die Prüfung Ihres Vorgangs fortzusetzen, benötigen wir zusätzliche Informationen und Dokumente.

Ihnen wurde eine E-Mail mit dem sicheren Link zum Hochladen der angeforderten Unterlagen gesendet.

Sie können auch diesen Link verwenden:
[LIEN_DOCUMENTS]

Bitte vervollständigen Sie Ihren Vorgang so bald wie möglich, damit wir die Bearbeitung fortsetzen können.

Mit freundlichen Grüßen
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Dokumente eingegangen',
            'action' => 'Den Eingang der Dokumente bestätigen und die Bearbeitungsfrist nennen.',
            'subject' => 'Dokumente eingegangen, Überprüfung läuft',
            'body' => <<<'TEXT'
Guten Tag [PRENOM],

wir bestätigen, dass Ihre zusätzlichen Informationen und Dokumente eingegangen sind.

Ihr Vorgang befindet sich nun in der abschließenden Prüfung.

Die Bearbeitung kann je nach erforderlichen Überprüfungen bis zu 72 Stunden dauern. Wenn alle Elemente konform sind, kann der Vorgang in der Regel innerhalb von 24 Stunden bearbeitet werden.

Wir melden uns wieder bei Ihnen, sobald eine Entscheidung getroffen wurde.

Mit freundlichen Grüßen
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Dokument fehlt oder ist unvollständig',
            'action' => 'Den Kunden bitten, den Vorgang zu korrigieren oder ein lesbares Dokument einzureichen.',
            'subject' => 'Ergänzung für Ihren Vorgang erforderlich',
            'body' => <<<'TEXT'
Guten Tag [PRENOM],

nach Prüfung Ihres Vorgangs fehlen einige Elemente, sind unvollständig oder nicht ausreichend lesbar.

Bitte melden Sie sich erneut in Ihrem sicheren Bereich an, um die angeforderten Informationen zu vervollständigen oder lesbare Dokumente einzureichen.

Sicherer Link:
[LIEN_DOCUMENTS]

Ohne diese Elemente bleibt die Prüfung Ihres Antrags ausgesetzt.

Mit freundlichen Grüßen
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Vorgang genehmigt, Urkunde versendet',
            'action' => 'Bestätigen, dass die Schenkungsurkunde per E-Mail versendet wurde.',
            'subject' => 'Schenkungsurkunde versendet',
            'body' => <<<'TEXT'
Guten Tag [PRENOM],

Ihr Vorgang wurde genehmigt.

Die Schenkungsurkunde wurde Ihnen per E-Mail zugesandt. Bitte prüfen Sie Ihren Posteingang sowie Ihren Spam-Ordner.

Bitte lesen Sie das Dokument aufmerksam, unterschreiben Sie es an den angegebenen Stellen und senden Sie uns eine lesbare Kopie zurück.

Bitte beachten Sie auch die im Dokument angegebenen Bedingungen, insbesondere die Bearbeitungsgebühren, damit Ihr Vorgang korrekt abgeschlossen werden kann.

Mit freundlichen Grüßen
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Erinnerung an nicht unterschriebene Urkunde',
            'action' => 'Den Kunden erinnern, wenn die unterschriebene Schenkungsurkunde noch nicht zurückgesendet wurde.',
            'subject' => 'Unterschriebene Schenkungsurkunde erwartet',
            'body' => <<<'TEXT'
Guten Tag [PRENOM],

wir melden uns erneut zu Ihrem Vorgang.

Bis heute haben wir Ihre unterschriebene Schenkungsurkunde noch nicht erhalten.

Bitte senden Sie uns eine lesbare Kopie des unterschriebenen Dokuments zurück, damit wir Ihren Vorgang abschließen können.

Ohne Ihre Rückmeldung bleibt die Bearbeitung in Wartestellung.

Mit freundlichen Grüßen
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Unterschriebenes Dokument eingegangen',
            'action' => 'Den Eingang des unterschriebenen Dokuments bestätigen und die administrative Prüfung ankündigen.',
            'subject' => 'Unterschriebene Schenkungsurkunde eingegangen',
            'body' => <<<'TEXT'
Guten Tag [PRENOM],

wir bestätigen, dass Ihr unterschriebenes Dokument eingegangen ist.

Ihr Vorgang befindet sich nun in der abschließenden administrativen Prüfung.

Wir melden uns wieder bei Ihnen, sobald diese Prüfung abgeschlossen ist oder falls eine Ergänzung erforderlich ist.

Mit freundlichen Grüßen
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Schenkung angenommen / Überweisungsdaten',
            'action' => 'Die endgültige Bestätigung senden und die für die Überweisung erforderlichen Daten anfordern.',
            'subject' => 'Schenkung angenommen - Überweisungsdaten',
            'body' => <<<'TEXT'
Guten Tag [PRENOM],

herzlichen Glückwunsch, Ihre Schenkung wurde von [NOM_SITE] angenommen.

Vorgangsnummer: [NUMERO_DOSSIER]
Genehmigter Betrag: [MONTANT_ACCEPTE]

Für die Organisation der Überweisung bitten wir Sie, uns die folgenden Bankinformationen zu senden:

- Vollständiger Name des Kontoinhabers
- Name der Bank
- IBAN oder Kontonummer
- BIC/SWIFT-Code

Ihr Vorgang befindet sich nun in der abschließenden administrativen Bearbeitung.

Mit freundlichen Grüßen
[NOM_SITE]
TEXT,
        ],
    ],
]);

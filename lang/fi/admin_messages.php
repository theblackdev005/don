<?php

return array_replace_recursive(require __DIR__.'/../en/admin_messages.php', [
    'generic_recipient' => 'Hyvä vastaanottaja',
    'amount_not_provided' => 'ei ilmoitettu',
    'templates' => [
        [
            'title' => 'Hakemus vastaanotettu',
            'action' => 'Vahvista hakemuksen vastaanotto ja pyydä tarkennuksia ennen ensimmäistä päätöstä.',
            'subject' => 'Avustushakemuksesi on vastaanotettu',
            'body' => <<<'TEXT'
Hei [PRENOM],

Vahvistamme, että olemme vastaanottaneet taloudellisen avun hakemuksesi, joka on rekisteröity numerolla [NUMERO_DOSSIER].

Hakemuksesi koskee: [MOTIF_DEMANDE].

Ennen käsittelyn jatkamista tiimimme haluaa varmistaa, että lähettämäsi tiedot ovat täydelliset, johdonmukaiset ja riittävän tarkat.

Pyydämme sinua lähettämään lisätietoja tilanteestasi, haetun rahoituksen täsmällisestä tarkoituksesta, varojen suunnitellusta käytöstä ja tarpeesi kiireellisyydestä.

Nämä tiedot auttavat meitä tutkimaan hakemuksesi huolellisemmin ja ohjaamaan sinut oikein seuraavaan vaiheeseen.

Ystävällisin terveisin,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Asiakkaan vastaus vastaanotettu',
            'action' => 'Vahvista asiakkaan tarkennusten vastaanotto ja kerro, että käsittely jatkuu.',
            'subject' => 'Tarkennukset vastaanotettu',
            'body' => <<<'TEXT'
Hei [PRENOM],

Kiitämme hakemukseesi liittyvistä tarkennuksista.

Vastauksesi on lisätty hakemuksen käsittelyyn. Tiimimme jatkaa toimitettujen tietojen tarkistamista ennen seuraavan vaiheen ilmoittamista.

Otamme sinuun uudelleen yhteyttä heti, kun lisävaihe on tarpeen.

Ystävällisin terveisin,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Hakemus alustavasti hyväksytty',
            'action' => 'Ilmoita asiakkaalle, että hakemus siirtyy seuraavaan vaiheeseen, ja muistuta lähetyslinkistä.',
            'subject' => 'Lisäasiakirjat lähetettäväksi',
            'body' => <<<'TEXT'
Hei [PRENOM],

Ensimmäisen tarkastelun jälkeen numerolla [NUMERO_DOSSIER] rekisteröity hakemuksesi voi siirtyä seuraavaan vaiheeseen.

Tämä vaihe ei vielä ole lopullinen hyväksyntä. Jotta voimme jatkaa hakemuksesi käsittelyä, tarvitsemme lisätietoja ja asiakirjoja.

Sinulle on lähetetty sähköpostitse turvallinen linkki pyydettyjen tietojen lähettämistä varten.

Voit käyttää myös tätä linkkiä:
[LIEN_DOCUMENTS]

Pyydämme sinua täydentämään hakemuksesi mahdollisimman pian, jotta voimme jatkaa käsittelyä.

Ystävällisin terveisin,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Asiakirjat vastaanotettu',
            'action' => 'Vahvista asiakirjojen vastaanotto ja ilmoita käsittelyaika.',
            'subject' => 'Asiakirjat vastaanotettu, tarkistus käynnissä',
            'body' => <<<'TEXT'
Hei [PRENOM],

Vahvistamme, että olemme vastaanottaneet lisätietosi ja asiakirjasi.

Hakemuksesi on nyt loppuarvioinnissa.

Käsittely voi kestää jopa 72 tuntia tarvittavista tarkistuksista riippuen. Kun kaikki tiedot ovat kunnossa, hakemus voidaan yleensä käsitellä 24 tunnin kuluessa.

Otamme sinuun uudelleen yhteyttä heti, kun päätös on tehty.

Ystävällisin terveisin,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Puuttuva tai puutteellinen asiakirja',
            'action' => 'Pyydä asiakasta korjaamaan hakemus tai lähettämään luettava asiakirja.',
            'subject' => 'Hakemukseesi tarvitaan täydennys',
            'body' => <<<'TEXT'
Hei [PRENOM],

Hakemuksesi tarkistuksen jälkeen osa tiedoista puuttuu, on puutteellista tai ei ole riittävän luettavaa.

Pyydämme sinua kirjautumaan uudelleen turvalliseen tilaasi ja täydentämään pyydetyt tiedot tai lähettämään luettavat asiakirjat.

Turvallinen linkki:
[LIEN_DOCUMENTS]

Ilman näitä tietoja hakemuksesi käsittely jää odottamaan.

Ystävällisin terveisin,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Hakemus hyväksytty ja lahjoitusasiakirja lähetetty',
            'action' => 'Vahvista, että lahjoitusasiakirja on lähetetty sähköpostitse.',
            'subject' => 'Lahjoitusasiakirja lähetetty',
            'body' => <<<'TEXT'
Hei [PRENOM],

Hakemuksesi on hyväksytty.

Lahjoitusasiakirja on lähetetty sinulle sähköpostitse. Tarkista saapuneet viestit sekä roskapostikansio.

Pyydämme sinua lukemaan asiakirjan huolellisesti, allekirjoittamaan sen merkityissä kohdissa ja palauttamaan meille luettavan kopion.

Pyydämme sinua myös tutustumaan asiakirjassa mainittuihin ehtoihin, erityisesti käsittelymaksuihin, jotta hakemuksesi voidaan viimeistellä oikein.

Ystävällisin terveisin,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Muistutus allekirjoittamattomasta asiakirjasta',
            'action' => 'Muistuta asiakasta, jos allekirjoitettua lahjoitusasiakirjaa ei ole vielä palautettu.',
            'subject' => 'Allekirjoitettua lahjoitusasiakirjaa odotetaan',
            'body' => <<<'TEXT'
Hei [PRENOM],

Otamme sinuun uudelleen yhteyttä hakemuksestasi.

Emme ole vielä vastaanottaneet allekirjoitettua lahjoitusasiakirjaasi.

Pyydämme sinua palauttamaan luettavan kopion allekirjoitetusta asiakirjasta, jotta voimme viimeistellä hakemuksesi.

Ilman vastaustasi käsittely jää odottamaan.

Ystävällisin terveisin,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Allekirjoitettu asiakirja vastaanotettu',
            'action' => 'Vahvista allekirjoitetun asiakirjan vastaanotto ja ilmoita hallinnollisesta tarkistuksesta.',
            'subject' => 'Allekirjoitettu lahjoitusasiakirja vastaanotettu',
            'body' => <<<'TEXT'
Hei [PRENOM],

Vahvistamme, että olemme vastaanottaneet allekirjoitetun asiakirjasi.

Hakemuksesi on nyt hallinnollisen lopputarkistuksen vaiheessa.

Otamme sinuun uudelleen yhteyttä heti, kun tarkistus on valmis tai jos lisätietoja tarvitaan.

Ystävällisin terveisin,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Lahjoitus hyväksytty / tilisiirtotiedot',
            'action' => 'Lähetä lopullinen vahvistus ja pyydä tilisiirtoa varten tarvittavat tiedot.',
            'subject' => 'Lahjoitus hyväksytty - tilisiirtotiedot',
            'body' => <<<'TEXT'
Hei [PRENOM],

Onnittelut, [NOM_SITE] on hyväksynyt lahjoituksesi.

Hakemusnumero: [NUMERO_DOSSIER]
Hyväksytty summa: [MONTANT_ACCEPTE]

Tilisiirron järjestämistä varten pyydämme sinua lähettämään meille seuraavat pankkitiedot:

- Tilinomistajan koko nimi
- Pankin nimi
- IBAN tai tilinumero
- BIC/SWIFT-koodi

Hakemuksesi on nyt hallinnollisen käsittelyn viimeisessä vaiheessa.

Ystävällisin terveisin,
[NOM_SITE]
TEXT,
        ],
    ],
]);

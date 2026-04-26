<?php

return array_replace_recursive(require __DIR__.'/../en/admin_messages.php', [
    'generic_recipient' => 'Senhora, senhor',
    'amount_not_provided' => 'não indicado',
    'templates' => [
        [
            'title' => 'Pedido recebido',
            'action' => 'Confirmar a receção do processo e pedir esclarecimentos antes da primeira decisão.',
            'subject' => 'Recebemos o seu pedido de ajuda',
            'body' => <<<'TEXT'
Olá [PRENOM],

Confirmamos a boa receção do seu pedido de ajuda financeira, registado com o número [NUMERO_DOSSIER].

O seu pedido diz respeito a: [MOTIF_DEMANDE].

Antes de prosseguir com a análise, a nossa equipa pretende verificar se as informações enviadas estão completas, coerentes e suficientemente claras.

Pedimos que nos envie alguns esclarecimentos adicionais sobre a sua situação, o objetivo exato do financiamento solicitado, a utilização prevista dos fundos e o grau de urgência da sua necessidade.

Estes elementos permitir-nos-ão estudar o seu processo com mais seriedade e orientá-lo corretamente para a etapa seguinte.

Com os melhores cumprimentos,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Resposta do cliente recebida',
            'action' => 'Confirmar a receção dos esclarecimentos do cliente e indicar que a análise continua.',
            'subject' => 'Esclarecimentos recebidos',
            'body' => <<<'TEXT'
Olá [PRENOM],

Agradecemos os esclarecimentos enviados sobre o seu pedido.

A sua resposta foi adicionada à análise do processo. A nossa equipa continuará a examinar as informações comunicadas antes de lhe indicar a continuação do tratamento.

Voltaremos a contactá-lo assim que for necessária uma etapa adicional.

Com os melhores cumprimentos,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Processo pré-aceite',
            'action' => 'Informar o cliente de que o processo passa à etapa seguinte e recordar o link de envio.',
            'subject' => 'Documentos complementares a enviar',
            'body' => <<<'TEXT'
Olá [PRENOM],

Após uma primeira análise, o seu pedido registado com o número [NUMERO_DOSSIER] pode passar à etapa seguinte.

Esta etapa ainda não constitui uma aprovação definitiva. Para prosseguir com o estudo do seu processo, precisamos de informações e documentos complementares.

Foi-lhe enviado um e-mail com o link seguro para enviar os elementos solicitados.

Também pode utilizar este link:
[LIEN_DOCUMENTS]

Pedimos que complete o seu processo assim que possível para que possamos continuar o tratamento.

Com os melhores cumprimentos,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Documentos recebidos',
            'action' => 'Confirmar a receção dos documentos e anunciar o prazo de tratamento.',
            'subject' => 'Documentos recebidos, verificação em curso',
            'body' => <<<'TEXT'
Olá [PRENOM],

Confirmamos que recebemos corretamente as suas informações e documentos complementares.

O seu processo está agora em análise final.

O tratamento pode demorar até 72 horas, conforme as verificações necessárias. Quando todos os elementos estão conformes, o processo pode geralmente ser tratado em 24 horas.

Voltaremos a contactá-lo assim que uma decisão for tomada.

Com os melhores cumprimentos,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Documento em falta ou incompleto',
            'action' => 'Pedir ao cliente que corrija o processo ou envie um documento legível.',
            'subject' => 'Complemento necessário para o seu processo',
            'body' => <<<'TEXT'
Olá [PRENOM],

Após a verificação do seu processo, alguns elementos estão em falta, incompletos ou não são suficientemente legíveis.

Pedimos que volte a aceder ao seu espaço seguro para completar as informações solicitadas ou enviar documentos legíveis.

Link seguro:
[LIEN_DOCUMENTS]

Sem estes elementos, a análise do seu pedido permanecerá suspensa.

Com os melhores cumprimentos,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Processo validado com ato enviado',
            'action' => 'Confirmar que o ato de doação foi enviado por e-mail.',
            'subject' => 'Ato de doação enviado',
            'body' => <<<'TEXT'
Olá [PRENOM],

O seu processo foi validado.

O ato de doação foi-lhe enviado por e-mail. Pedimos que verifique a sua caixa de entrada e também o correio não solicitado.

Convidamo-lo a ler atentamente o documento, assiná-lo nos locais indicados e devolver-nos uma cópia legível.

Pedimos também que tome conhecimento das condições indicadas no documento, nomeadamente as taxas de tratamento, para que o seu processo possa ser finalizado corretamente.

Com os melhores cumprimentos,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Relance de ato não assinado',
            'action' => 'Relançar o cliente se o ato de doação assinado ainda não tiver sido devolvido.',
            'subject' => 'Ato de doação assinado em falta',
            'body' => <<<'TEXT'
Olá [PRENOM],

Voltamos a contactá-lo sobre o seu processo.

Até à data, ainda não recebemos o seu ato de doação assinado.

Pedimos que nos devolva uma cópia legível do documento assinado para que possamos finalizar o seu processo.

Sem resposta da sua parte, o tratamento permanecerá em espera.

Com os melhores cumprimentos,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Documento assinado recebido',
            'action' => 'Confirmar a receção do documento assinado e anunciar a verificação administrativa.',
            'subject' => 'Ato de doação assinado recebido',
            'body' => <<<'TEXT'
Olá [PRENOM],

Confirmamos que recebemos corretamente o seu documento assinado.

O seu processo está agora na fase final de verificação administrativa.

Voltaremos a contactá-lo assim que esta verificação terminar ou se for necessário algum complemento.

Com os melhores cumprimentos,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Doação aceite / informações de transferência',
            'action' => 'Enviar a confirmação final e pedir as informações necessárias à transferência.',
            'subject' => 'Doação aceite - informações de transferência',
            'body' => <<<'TEXT'
Olá [PRENOM],

Parabéns, a sua doação foi aceite por [NOM_SITE].

Número do processo: [NUMERO_DOSSIER]
Montante aceite: [MONTANT_ACCEPTE]

Para organizar a transferência, pedimos que nos envie as seguintes informações bancárias:

- Nome completo do titular da conta
- Nome do banco
- IBAN ou número de conta
- Código BIC/SWIFT

O seu processo está agora na fase final de tratamento administrativo.

Com os melhores cumprimentos,
[NOM_SITE]
TEXT,
        ],
    ],
]);

<?php

return array_replace_recursive(require __DIR__.'/../en/admin_messages.php', [
    'generic_recipient' => 'Señora, señor',
    'amount_not_provided' => 'no indicado',
    'templates' => [
        [
            'title' => 'Solicitud recibida',
            'action' => 'Confirmar la recepción del expediente y pedir precisiones antes de la primera decisión.',
            'subject' => 'Hemos recibido su solicitud de ayuda',
            'body' => <<<'TEXT'
Hola [PRENOM],

Confirmamos la recepción de su solicitud de ayuda financiera, registrada con el número [NUMERO_DOSSIER].

Su solicitud se refiere a: [MOTIF_DEMANDE].

Antes de continuar el análisis, nuestro equipo desea comprobar que la información enviada sea completa, coherente y suficientemente clara.

Le rogamos que nos envíe algunas precisiones adicionales sobre su situación, el objetivo exacto de la financiación solicitada, el uso previsto de los fondos y el nivel de urgencia de su necesidad.

Estos elementos nos permitirán estudiar su expediente con más seriedad y orientarle correctamente en la siguiente etapa.

Atentamente,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Respuesta del cliente recibida',
            'action' => 'Confirmar la recepción de las precisiones del cliente e indicar que el análisis continúa.',
            'subject' => 'Precisiones recibidas',
            'body' => <<<'TEXT'
Hola [PRENOM],

Le agradecemos las precisiones enviadas sobre su solicitud.

Su respuesta se ha añadido al análisis del expediente. Nuestro equipo seguirá revisando la información comunicada antes de indicarle la continuación del trámite.

Volveremos a contactarle en cuanto sea necesaria una etapa adicional.

Atentamente,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Expediente preaceptado',
            'action' => 'Informar al cliente de que el expediente pasa a la etapa siguiente y recordar el enlace de depósito.',
            'subject' => 'Documentos complementarios por enviar',
            'body' => <<<'TEXT'
Hola [PRENOM],

Tras un primer análisis, su solicitud registrada con el número [NUMERO_DOSSIER] puede pasar a la siguiente etapa.

Esta etapa todavía no constituye una aprobación definitiva. Para continuar el estudio de su expediente, necesitamos información y documentos complementarios.

Se le ha enviado un correo electrónico con el enlace seguro que permite depositar los elementos solicitados.

También puede utilizar este enlace:
[LIEN_DOCUMENTS]

Le rogamos que complete su expediente lo antes posible para que podamos continuar el trámite.

Atentamente,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Documentos recibidos',
            'action' => 'Confirmar la recepción de los documentos y anunciar el plazo de tratamiento.',
            'subject' => 'Documentos recibidos, verificación en curso',
            'body' => <<<'TEXT'
Hola [PRENOM],

Confirmamos que hemos recibido correctamente su información y sus documentos complementarios.

Su expediente se encuentra ahora en análisis final.

El tratamiento puede tardar hasta 72 horas según las verificaciones necesarias. Cuando todos los elementos son conformes, el expediente suele poder tratarse en 24 horas.

Volveremos a contactarle en cuanto se haya tomado una decisión.

Atentamente,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Documento faltante o incompleto',
            'action' => 'Pedir al cliente que corrija su expediente o envíe un documento legible.',
            'subject' => 'Complemento necesario para su expediente',
            'body' => <<<'TEXT'
Hola [PRENOM],

Tras verificar su expediente, algunos elementos faltan, están incompletos o no son suficientemente legibles.

Le rogamos que vuelva a conectarse a su espacio seguro para completar la información solicitada o enviar documentos legibles.

Enlace seguro:
[LIEN_DOCUMENTS]

Sin estos elementos, el análisis de su solicitud permanecerá suspendido.

Atentamente,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Expediente validado con acta enviada',
            'action' => 'Confirmar que el acta de donación ha sido enviada por correo electrónico.',
            'subject' => 'Acta de donación enviada',
            'body' => <<<'TEXT'
Hola [PRENOM],

Su expediente ha sido validado.

El acta de donación le ha sido enviada por correo electrónico. Le rogamos que revise su bandeja de entrada y también el correo no deseado.

Le invitamos a leer atentamente el documento, firmarlo en los lugares indicados y devolvernos una copia legible.

Le rogamos también que tome conocimiento de las condiciones indicadas en el documento, especialmente los gastos de tramitación, para que su expediente pueda finalizarse correctamente.

Atentamente,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Recordatorio de acta no firmada',
            'action' => 'Recordar al cliente si aún no ha devuelto el acta de donación firmada.',
            'subject' => 'Acta de donación firmada pendiente',
            'body' => <<<'TEXT'
Hola [PRENOM],

Volvemos a contactarle sobre su expediente.

A día de hoy, todavía no hemos recibido su acta de donación firmada.

Le rogamos que nos devuelva una copia legible del documento firmado para que podamos finalizar su expediente.

Sin respuesta por su parte, el tratamiento permanecerá en espera.

Atentamente,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Documento firmado recibido',
            'action' => 'Confirmar la recepción del documento firmado y anunciar la verificación administrativa.',
            'subject' => 'Acta de donación firmada recibida',
            'body' => <<<'TEXT'
Hola [PRENOM],

Confirmamos que hemos recibido correctamente su documento firmado.

Su expediente se encuentra ahora en la fase final de verificación administrativa.

Volveremos a contactarle en cuanto esta verificación haya terminado o si se necesita algún complemento.

Atentamente,
[NOM_SITE]
TEXT,
        ],
        [
            'title' => 'Donación aceptada / datos de transferencia',
            'action' => 'Enviar la confirmación final y solicitar los datos necesarios para la transferencia.',
            'subject' => 'Donación aceptada - datos de transferencia',
            'body' => <<<'TEXT'
Hola [PRENOM],

Enhorabuena, su donación ha sido aceptada por [NOM_SITE].

Número de expediente: [NUMERO_DOSSIER]
Importe aceptado: [MONTANT_ACCEPTE]

Para organizar la transferencia, le rogamos que nos envíe la siguiente información bancaria:

- Nombre completo del titular de la cuenta
- Nombre del banco
- IBAN o número de cuenta
- Código BIC/SWIFT

Su expediente se encuentra ahora en la fase final de tratamiento administrativo.

Atentamente,
[NOM_SITE]
TEXT,
        ],
    ],
]);

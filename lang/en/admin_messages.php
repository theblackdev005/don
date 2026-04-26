<?php

return [
    'generic_recipient' => 'Madam, Sir',
    'amount_not_provided' => 'not provided',
    'templates' => [
        [
            'key' => 'received',
            'step' => 1,
            'title' => 'Request received',
            'action' => 'Confirm receipt and ask for details before the first decision.',
            'subject' => 'Your aid request has been received',
            'body' => <<<'TEXT'
Hello [PRENOM],

We confirm that we have received your financial aid request, registered under number [NUMERO_DOSSIER].

Your request concerns: [MOTIF_DEMANDE].

Before continuing the review, our team would like to confirm that the information provided is complete, consistent and sufficiently clear.

Please send us a few additional details about your situation, the exact purpose of the requested funding, the intended use of the funds and the level of urgency of your need.

These details will help us review your file more carefully and guide you properly through the next steps.

Kind regards,
[NOM_SITE]
TEXT,
        ],
        [
            'key' => 'client_reply_received',
            'step' => 2,
            'title' => 'Client reply received',
            'action' => 'Acknowledge the client’s details and say that the review continues.',
            'subject' => 'Your details have been received',
            'body' => <<<'TEXT'
Hello [PRENOM],

Thank you for the additional details sent regarding your request.

Your reply has been added to the file review. Our team will continue examining the information provided before informing you of the next step.

We will contact you again as soon as another step is required.

Kind regards,
[NOM_SITE]
TEXT,
        ],
        [
            'key' => 'pre_accepted',
            'step' => 3,
            'title' => 'File preliminarily accepted',
            'action' => 'Inform the client that the file can move to the next step and remind them of the upload link.',
            'subject' => 'Additional documents to submit',
            'body' => <<<'TEXT'
Hello [PRENOM],

After an initial review, your request registered under number [NUMERO_DOSSIER] can move to the next step.

This step is not yet a final approval. To continue reviewing your file, we need additional information and documents.

An email has been sent to you with the secure link to submit the requested items.

You can also use this link:
[LIEN_DOCUMENTS]

Please complete your file as soon as possible so we can continue processing it.

Kind regards,
[NOM_SITE]
TEXT,
        ],
        [
            'key' => 'documents_received',
            'step' => 4,
            'title' => 'Documents received',
            'action' => 'Confirm receipt of documents and announce the processing time.',
            'subject' => 'Documents received, verification in progress',
            'body' => <<<'TEXT'
Hello [PRENOM],

We confirm that we have received your additional information and documents.

Your file is now under final review.

Processing may take up to 72 hours depending on the checks required. When all items are compliant, the file can usually be processed within 24 hours.

We will contact you again as soon as a decision has been made.

Kind regards,
[NOM_SITE]
TEXT,
        ],
        [
            'key' => 'missing_documents',
            'step' => 5,
            'title' => 'Missing or incomplete document',
            'action' => 'Ask the client to correct the file or send a readable document.',
            'subject' => 'Additional information required',
            'body' => <<<'TEXT'
Hello [PRENOM],

After checking your file, some items are missing, incomplete or not sufficiently readable.

Please log back into your secure area to complete the requested information or submit readable documents.

Secure link:
[LIEN_DOCUMENTS]

Without these items, the review of your request will remain on hold.

Kind regards,
[NOM_SITE]
TEXT,
        ],
        [
            'key' => 'contract_sent',
            'step' => 6,
            'title' => 'File approved with deed sent',
            'action' => 'Confirm that the donation deed has been sent by email.',
            'subject' => 'Donation deed sent',
            'body' => <<<'TEXT'
Hello [PRENOM],

Your file has been approved.

The donation deed has been sent to you by email. Please check your inbox as well as your spam folder.

Please read the document carefully, sign it where indicated, and return a readable copy to us.

Please also review the conditions stated in the document, including the processing fees, so that your file can be finalized correctly.

Kind regards,
[NOM_SITE]
TEXT,
        ],
        [
            'key' => 'contract_reminder',
            'step' => 7,
            'title' => 'Unsigned deed reminder',
            'action' => 'Remind the client if the signed donation deed has not yet been returned.',
            'subject' => 'Signed donation deed expected',
            'body' => <<<'TEXT'
Hello [PRENOM],

We are contacting you again regarding your file.

To date, we have not yet received your signed donation deed.

Please return a readable copy of the signed document so that we can finalize your file.

Without a reply from you, processing will remain on hold.

Kind regards,
[NOM_SITE]
TEXT,
        ],
        [
            'key' => 'signed_contract_received',
            'step' => 8,
            'title' => 'Signed document received',
            'action' => 'Confirm receipt of the signed document and announce administrative verification.',
            'subject' => 'Signed donation deed received',
            'body' => <<<'TEXT'
Hello [PRENOM],

We confirm that we have received your signed document.

Your file is now in the final administrative verification stage.

We will contact you again as soon as this verification is complete or if additional information is required.

Kind regards,
[NOM_SITE]
TEXT,
        ],
        [
            'key' => 'donation_accepted',
            'step' => 9,
            'title' => 'Donation accepted / transfer details',
            'action' => 'Send the final confirmation and request the transfer details.',
            'subject' => 'Donation accepted - transfer details',
            'body' => <<<'TEXT'
Hello [PRENOM],

Congratulations, your donation has been accepted by [NOM_SITE].

File number: [NUMERO_DOSSIER]
Accepted amount: [MONTANT_ACCEPTE]

To organize the bank transfer, please send us the following banking information:

- Full name of the account holder
- Bank name
- IBAN or account number
- BIC/SWIFT code

Your file is now in the final administrative processing stage.

Kind regards,
[NOM_SITE]
TEXT,
        ],
    ],
];

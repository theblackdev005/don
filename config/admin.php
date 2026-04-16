<?php

return [

    /** Compte créé / mis à jour par Database\Seeders\AdminUserSeeder */
    'email' => env('ADMIN_EMAIL', env('SITE_EMAIL', 'admin@example.com')),

    'seed_name' => env('ADMIN_SEED_NAME', 'Administrateur'),

    /** Mot de passe du compte admin (clair dans .env ; hashé en base) */
    'password' => env('ADMIN_PASSWORD', 'changeme'),

    /** Notifications équipe (nouvelle demande, validation préliminaire, etc.) : ADMIN_NOTIFICATION_EMAIL si défini, sinon ADMIN_EMAIL, sinon expéditeur mail */
    'notification_email' => env('ADMIN_NOTIFICATION_EMAIL') ?: env('ADMIN_EMAIL') ?: env('MAIL_FROM_ADDRESS', 'hello@example.com'),

    /**
     * Paramètres visibles sur l’acte de donation (PDF).
     *
     * Signature « côté fondation » : image PNG/JPEG (scan ou export) dans public/.
     * Variables préférées : DONATION_ACT_* ; les anciennes CONTRACT_* restent prises en charge.
     * Image embarquée dans le PDF uniquement — pas une signature électronique qualifiée (eIDAS)
     * ni un parapheur type DocuSign/Yousign.
     */
    'donation_act' => [
        'director_name' => env('DONATION_ACT_DIRECTOR_NAME', env('CONTRACT_DIRECTOR_NAME', 'Directeur du financement')),
        'director_gender' => env('DONATION_ACT_DIRECTOR_GENDER', 'male'),
        'director_title' => env('DONATION_ACT_DIRECTOR_TITLE', env('CONTRACT_DIRECTOR_TITLE', 'Direction du financement')),
        'logo_path' => env('DONATION_ACT_LOGO_PATH', env('CONTRACT_LOGO_PATH', '')),
        'director_signature_path' => env('DONATION_ACT_DIRECTOR_SIGNATURE_PATH', env('CONTRACT_DIRECTOR_SIGNATURE_PATH', '')),
    ],
];

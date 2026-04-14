<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Identité
    |--------------------------------------------------------------------------
    */
    'name' => env('SITE_NAME', env('APP_NAME', 'Around')),

    'tagline' => env('SITE_TAGLINE', ''),

    'labels' => [
        'member_area' => env('SITE_LABEL_MEMBER_AREA', 'Espace membre'),
        'dashboard' => env('SITE_LABEL_DASHBOARD', 'Espace compte'),
    ],

    /*
    |--------------------------------------------------------------------------
    | SEO / meta (défauts pour les pages)
    |--------------------------------------------------------------------------
    */
    'meta' => [
        'description_suffix' => env('SITE_META_DESCRIPTION', 'Modèle de site Bootstrap polyvalent'),
        'keywords' => env('SITE_META_KEYWORDS', 'bootstrap, entreprise, site vitrine, landing, responsive'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Coordonnées (réutilisables dans header, footer, contact…)
    |--------------------------------------------------------------------------
    | Téléphone : utilisez un format international pour tel: (ex. +33123456789).
    */
    'email' => env('SITE_EMAIL', 'contact@example.com'),

    'phone' => env('SITE_PHONE', '+178632256040'),

    /*
    |--------------------------------------------------------------------------
    | Adresse du siège (une seule ligne, ex. PDF acte de donation)
    |--------------------------------------------------------------------------
    | Préférez SITE_ADDRESS. Si vide, repli sur l’ancien découpage (rétrocompat).
    */
    'address' => (static function (): string {
        $single = trim((string) env('SITE_ADDRESS', ''));
        if ($single !== '') {
            return $single;
        }
        $parts = array_filter([
            trim((string) env('SITE_ADDRESS_LINE1', '')),
            trim((string) env('SITE_ADDRESS_LINE2', '')),
            trim(implode(' ', array_filter([
                trim((string) env('SITE_ADDRESS_POSTAL', '')),
                trim((string) env('SITE_ADDRESS_CITY', '')),
            ], fn ($p) => $p !== ''))),
            trim((string) env('SITE_ADDRESS_COUNTRY', '')),
        ], fn ($p) => $p !== '');

        return implode(', ', $parts);
    })(),

    /*
    |--------------------------------------------------------------------------
    | Bureaux (page Contact)
    |--------------------------------------------------------------------------
    | Modifiez librement ce tableau dans ce fichier ou surchargez via une
    | source externe plus tard (BDD, traductions…).
    */
    'offices' => [
        [
            'label' => 'Orlando',
            'phone' => '+178632256040',
            'phone_display' => '+1 (786) 322 560 40',
            'email' => 'orlando@example.com',
            'address' => '514 S. Magnolia St. Orlando, FL 32806',
            'map_url' => '#',
        ],
        [
            'label' => 'Chicago',
            'phone' => '+178632256040',
            'phone_display' => '+1 (786) 322 560 40',
            'email' => 'chicago@example.com',
            'address' => '76, Industrial Dr, West Chicago, 60185',
            'map_url' => '#',
        ],
        [
            'label' => 'New York',
            'phone' => '+178632256040',
            'phone_display' => '+1 (786) 322 560 40',
            'email' => 'newyork@example.com',
            'address' => '396 Lillian Blvd, Holbrook, NY 11741',
            'map_url' => '#',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Slugs d’URL (segments sans slash initial/final)
    |--------------------------------------------------------------------------
    | Ajustez les URLs publiques sans toucher aux noms de routes Laravel.
    | Exemple : SITE_SLUG_ABOUT=notre-association → /notre-association
    */
    'slugs' => [
        'about' => env('SITE_SLUG_ABOUT', 'a-propos'),
        'services' => env('SITE_SLUG_SERVICES', 'services'),
        'contact' => env('SITE_SLUG_CONTACT', 'contact'),
        'account' => env('SITE_SLUG_ACCOUNT', 'compte'),
        'funding_request' => env('SITE_SLUG_FUNDING_REQUEST', 'demande-financement'),
        'funding_request_confirmation' => env('SITE_SLUG_FUNDING_CONFIRMATION', 'confirmation'),
        'dossier_tracking' => trim((string) (env('SITE_SLUG_DOSSIER_TRACKING') ?: 'suivi-dossier'), '/'),
        'legal' => env('SITE_SLUG_LEGAL', 'mentions-legales'),
        'privacy' => env('SITE_SLUG_PRIVACY', 'politique-de-confidentialite'),
    ],

];

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Identité
    |--------------------------------------------------------------------------
    */
    'name' => env('SITE_NAME', env('APP_NAME', 'Around')),

    'tagline' => env('SITE_TAGLINE', ''),

    'brand' => [
        'logo_path' => trim((string) env('SITE_LOGO_PATH', 'assets/img/branding/custom/site-logo.png'), '/'),
        'favicon_path' => trim((string) env('SITE_FAVICON_PATH', 'assets/app-icons/custom/site-favicon.png'), '/'),
    ],

    'labels' => [
        'member_area' => env('SITE_LABEL_MEMBER_AREA', 'Espace membre'),
        'dashboard' => env('SITE_LABEL_DASHBOARD', 'Espace compte'),
    ],

    'tracking' => [
        'google_tag_id' => trim((string) env('SITE_GOOGLE_TAG_ID', '')),
        'facebook_pixel_id' => trim((string) env('SITE_FACEBOOK_PIXEL_ID', '')),
        'facebook_domain_verification' => trim((string) env('SITE_FACEBOOK_DOMAIN_VERIFICATION', '')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Coordonnées (réutilisables dans header, footer, contact…)
    |--------------------------------------------------------------------------
    | Téléphone : utilisez un format international pour tel: (ex. +33123456789).
    */
    'email' => env('SITE_EMAIL', 'contact@example.com'),

    'public_contact_email' => env('SITE_PUBLIC_CONTACT_EMAIL', env('SITE_EMAIL', 'contact@example.com')),

    'whatsapp' => trim((string) env('SITE_WHATSAPP', env('SITE_PHONE', ''))),

    'legal' => [
        'full_name' => trim((string) env('SITE_LEGAL_FULL_NAME', '')),
        'company_number' => trim((string) env('SITE_COMPANY_NUMBER', '')),
        'main_address' => trim((string) env('SITE_MAIN_ADDRESS', env('SITE_ADDRESS', ''))),
    ],

    'phone' => env('SITE_PHONE', '+178632256040'),

    'social' => [
        'facebook' => trim((string) env('SITE_SOCIAL_FACEBOOK', '')),
        'instagram' => trim((string) env('SITE_SOCIAL_INSTAGRAM', '')),
        'linkedin' => trim((string) env('SITE_SOCIAL_LINKEDIN', '')),
    ],

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
            'label' => env('SITE_NAME', env('APP_NAME', 'Foundation')),
            'phone' => env('SITE_PHONE', ''),
            'phone_display' => env('SITE_PHONE_DISPLAY', env('SITE_PHONE', '')),
            'email' => env('SITE_EMAIL', 'contact@example.com'),
            'address' => env('SITE_ADDRESS', ''),
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

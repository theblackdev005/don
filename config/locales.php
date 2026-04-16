<?php

$supported = ['fr', 'en', 'es', 'pt', 'it', 'de'];
$default = (string) env('SITE_DEFAULT_LOCALE', env('APP_LOCALE', 'fr'));
if (! in_array($default, $supported, true)) {
    $default = 'fr';
}

return [
    'supported' => $supported,
    'default' => $default,
];

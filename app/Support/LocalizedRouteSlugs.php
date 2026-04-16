<?php

namespace App\Support;

class LocalizedRouteSlugs
{
    private const PARAMETER_MAP = [
        'about' => 'aboutSlug',
        'services' => 'servicesSlug',
        'contact' => 'contactSlug',
        'legal' => 'legalSlug',
        'privacy' => 'privacySlug',
        'account' => 'accountSlug',
        'funding_request' => 'fundingRequestSlug',
        'funding_request_confirmation' => 'fundingRequestConfirmationSlug',
        'dossier_tracking' => 'dossierTrackingSlug',
    ];

    private const ROUTE_SLUG_KEYS = [
        'about' => ['about'],
        'services' => ['services'],
        'contact' => ['contact'],
        'legal' => ['legal'],
        'privacy' => ['privacy'],
        'account' => ['account'],
        'funding-request.create' => ['funding_request'],
        'funding-request.store' => ['funding_request'],
        'funding-request.documents' => ['funding_request'],
        'funding-request.documents.store' => ['funding_request'],
        'funding-request.documents.legacy' => ['funding_request', 'funding_request_confirmation'],
        'funding-request.documents.store.legacy' => ['funding_request', 'funding_request_confirmation'],
        'funding-request.download-act' => ['funding_request', 'funding_request_confirmation'],
        'funding-request.success' => ['funding_request', 'funding_request_confirmation'],
        'funding.tracking' => ['dossier_tracking'],
        'funding.tracking.lookup' => ['dossier_tracking'],
    ];

    public static function slug(string $key, ?string $locale = null): string
    {
        $locale = $locale ?: app()->getLocale();
        $slugs = config("localized_slugs.{$key}", []);

        return trim((string) ($slugs[$locale] ?? $slugs[config('locales.default', 'fr')] ?? ''), '/');
    }

    public static function parameterName(string $key): string
    {
        return self::PARAMETER_MAP[$key] ?? $key.'Slug';
    }

    public static function defaultsForLocale(?string $locale = null): array
    {
        $locale = $locale ?: app()->getLocale();
        $defaults = [];

        foreach (array_keys(config('localized_slugs', [])) as $key) {
            $defaults[self::parameterName($key)] = self::slug($key, $locale);
        }

        return $defaults;
    }

    public static function pattern(string $key): string
    {
        $slugs = array_filter(array_unique(array_map(
            static fn ($slug) => trim((string) $slug, '/'),
            config("localized_slugs.{$key}", [])
        )));

        return implode('|', array_map(static fn (string $slug) => preg_quote($slug, '#'), $slugs));
    }

    public static function routeKeys(string $routeName): array
    {
        return self::ROUTE_SLUG_KEYS[$routeName] ?? [];
    }

    public static function localizedParametersForRoute(string $routeName, ?string $locale = null): array
    {
        $parameters = [];

        foreach (self::routeKeys($routeName) as $key) {
            $parameters[self::parameterName($key)] = self::slug($key, $locale);
        }

        return $parameters;
    }

    public static function applyLocalizedParameters(string $routeName, array $parameters, ?string $locale = null): array
    {
        foreach (self::localizedParametersForRoute($routeName, $locale) as $parameter => $value) {
            $parameters[$parameter] = $value;
        }

        return $parameters;
    }

    public static function hasMismatch(string $routeName, array $parameters, ?string $locale = null): bool
    {
        foreach (self::localizedParametersForRoute($routeName, $locale) as $parameter => $expectedValue) {
            if (($parameters[$parameter] ?? null) !== $expectedValue) {
                return true;
            }
        }

        return false;
    }

    public static function route(string $routeName, array $parameters = [], bool $absolute = true): string
    {
        $locale = (string) ($parameters['locale'] ?? app()->getLocale());

        return route(
            $routeName,
            self::applyLocalizedParameters($routeName, $parameters, $locale),
            $absolute
        );
    }
}

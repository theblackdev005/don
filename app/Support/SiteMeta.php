<?php

namespace App\Support;

class SiteMeta
{
    public static function description(?string $locale = null): string
    {
        $locale = self::resolveLocale($locale);

        return (string) trans('seo.description', [], $locale);
    }

    public static function title(?string $locale = null): string
    {
        $locale = self::resolveLocale($locale);

        return (string) trans('seo.title', [], $locale);
    }

    public static function keywords(?string $locale = null): string
    {
        $locale = self::resolveLocale($locale);

        return (string) trans('seo.keywords', [], $locale);
    }

    private static function resolveLocale(?string $locale): string
    {
        $supported = config('locales.supported', ['fr']);
        $locale = trim((string) ($locale ?: app()->getLocale() ?: config('locales.default', 'fr')));

        return in_array($locale, $supported, true)
            ? $locale
            : (string) config('locales.default', 'fr');
    }
}

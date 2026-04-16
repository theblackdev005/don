<?php

namespace App\Support;

class WhatsAppMessage
{
    private const EVENING_START_HOUR = 18;

    public static function config(string $context = 'direct', array $data = [], ?string $locale = null, ?string $seed = null): array
    {
        $locale = $locale ?: app()->getLocale();
        $phone = self::normalizePhone((string) config('site.whatsapp', config('site.phone', '')));
        $context = in_array($context, ['funding', 'documents', 'direct'], true) ? $context : 'direct';
        $templates = self::templates($context, $locale);
        $variant = self::variantIndex($seed, count($templates));
        $template = (string) ($templates[$variant] ?? $templates[0] ?? '');
        $replacements = [
            'name' => trim((string) ($data['name'] ?? '')),
            'site' => trim((string) ($data['site'] ?? config('site.name'))),
        ];

        return [
            'phone' => $phone,
            'template' => $template,
            'replacements' => $replacements,
            'greetings' => [
                'day' => (string) trans('pages.whatsapp.greetings.day', [], $locale),
                'evening' => (string) trans('pages.whatsapp.greetings.evening', [], $locale),
            ],
            'variant' => $variant,
            'url' => $phone !== ''
                ? self::url($phone, self::render($template, $replacements, $locale, (int) date('G')))
                : null,
        ];
    }

    public static function render(string $template, array $replacements, ?string $locale = null, ?int $hour = null): string
    {
        $locale = $locale ?: app()->getLocale();
        $hour = $hour ?? (int) date('G');
        $greeting = $hour >= self::EVENING_START_HOUR
            ? (string) trans('pages.whatsapp.greetings.evening', [], $locale)
            : (string) trans('pages.whatsapp.greetings.day', [], $locale);

        $values = ['greeting' => $greeting];
        foreach ($replacements as $key => $value) {
            $values[$key] = trim((string) $value);
        }

        $message = $template;
        foreach ($values as $key => $value) {
            $message = str_replace(':'.$key, $value, $message);
        }

        return trim((string) preg_replace('/\s{2,}/u', ' ', str_replace(["\r", "\n"], ' ', $message)));
    }

    public static function url(string $phone, string $message): string
    {
        return 'https://wa.me/'.$phone.'?text='.rawurlencode($message);
    }

    private static function templates(string $context, string $locale): array
    {
        $templates = trans('pages.whatsapp.messages.'.$context, [], $locale);
        if (is_array($templates) && $templates !== []) {
            return array_values(array_map(static fn ($value) => (string) $value, $templates));
        }

        $fallbackLocale = (string) config('locales.default', 'fr');
        $fallback = trans('pages.whatsapp.messages.'.$context, [], $fallbackLocale);

        return is_array($fallback) && $fallback !== []
            ? array_values(array_map(static fn ($value) => (string) $value, $fallback))
            : [''];
    }

    private static function variantIndex(?string $seed, int $count): int
    {
        if ($count <= 1) {
            return 0;
        }

        $seed = trim((string) $seed);
        if ($seed === '') {
            return (int) date('z') % $count;
        }

        return abs((int) crc32($seed)) % $count;
    }

    private static function normalizePhone(string $phone): string
    {
        return preg_replace('/\D+/', '', $phone) ?: '';
    }
}

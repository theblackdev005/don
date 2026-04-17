<?php

namespace App\Support;

class SiteAppearance
{
    private const PRIMARY_COLOR = '#448C74';
    private const SECONDARY_COLOR = '#FFB400';

    public static function primaryColor(): string
    {
        return self::PRIMARY_COLOR;
    }

    public static function secondaryColor(): string
    {
        return self::SECONDARY_COLOR;
    }

    public static function primaryRgb(): string
    {
        return self::hexToRgbString(self::primaryColor());
    }

    public static function secondaryRgb(): string
    {
        return self::hexToRgbString(self::secondaryColor());
    }

    public static function contrastTextColor(?string $hexColor = null): string
    {
        $hex = self::normalizeHex((string) ($hexColor ?? self::primaryColor()), self::primaryColor());
        [$r, $g, $b] = self::hexToRgbArray($hex);
        $luminance = ((0.299 * $r) + (0.587 * $g) + (0.114 * $b)) / 255;

        return $luminance > 0.62 ? '#172033' : '#ffffff';
    }

    public static function logoPath(): string
    {
        $path = trim((string) config('site.brand.logo_path', ''), '/');

        return $path !== '' ? $path : 'assets/img/branding/custom/site-logo.png';
    }

    public static function logoUrl(): string
    {
        return self::versionedAssetUrl(self::logoPath());
    }

    public static function logoPublicPath(): string
    {
        return public_path(self::logoPath());
    }

    public static function faviconPath(): string
    {
        $path = trim((string) config('site.brand.favicon_path', ''), '/');

        return $path !== '' ? $path : 'assets/app-icons/custom/site-favicon.png';
    }

    public static function faviconUrl(): string
    {
        return self::versionedAssetUrl(self::faviconPath());
    }

    private static function versionedAssetUrl(string $path): string
    {
        $url = asset($path);
        $publicPath = public_path($path);

        if (! is_file($publicPath)) {
            return $url;
        }

        $timestamp = @filemtime($publicPath);

        return $timestamp ? $url.'?v='.$timestamp : $url;
    }

    private static function normalizeHex(string $value, string $fallback): string
    {
        $value = trim($value);

        if ($value === '') {
            return strtoupper($fallback);
        }

        $value = ltrim($value, '#');

        if (preg_match('/^[0-9a-fA-F]{3}$/', $value) === 1) {
            $value = preg_replace('/(.)/', '$1$1', $value) ?? $value;
        }

        if (preg_match('/^[0-9a-fA-F]{6}$/', $value) !== 1) {
            return strtoupper($fallback);
        }

        return '#'.strtoupper($value);
    }

    private static function hexToRgbString(string $hex): string
    {
        return implode(', ', self::hexToRgbArray($hex));
    }

    /**
     * @return array{0:int,1:int,2:int}
     */
    private static function hexToRgbArray(string $hex): array
    {
        $hex = ltrim(self::normalizeHex($hex, self::primaryColor()), '#');

        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2)),
        ];
    }
}

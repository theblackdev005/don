<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Testimonial extends Model
{
    protected $fillable = [
        'author_name',
        'role',
        'quote',
        'sort_order',
        'is_active',
        'is_anonymous',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_anonymous' => 'boolean',
    ];

    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderBy('sort_order')
            ->orderByDesc('id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(TestimonialTranslation::class);
    }

    public function translationFor(?string $locale = null): ?TestimonialTranslation
    {
        $translations = $this->relationLoaded('translations')
            ? $this->translations
            : $this->translations()->get();

        foreach ($this->fallbackLocales($locale) as $candidateLocale) {
            $translation = $translations->firstWhere('locale', $candidateLocale);
            if ($translation) {
                return $translation;
            }
        }

        return $translations->first();
    }

    public function localizedAuthorName(?string $locale = null): string
    {
        return $this->localizedValue('author_name', $locale);
    }

    public function localizedRole(?string $locale = null): string
    {
        return $this->localizedValue('role', $locale);
    }

    public function localizedQuote(?string $locale = null): string
    {
        return $this->localizedValue('quote', $locale);
    }

    public function getInitialsAttribute(): string
    {
        if ($this->is_anonymous) {
            return 'AN';
        }

        $parts = preg_split('/\s+/u', trim($this->localizedAuthorName())) ?: [];
        $initials = collect($parts)
            ->filter()
            ->take(2)
            ->map(fn (string $part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->implode('');

        return $initials !== '' ? $initials : 'TG';
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->is_anonymous ? __('pages.home.testimonial_anonymous') : $this->localizedAuthorName();
    }

    public function getDisplayRoleAttribute(): string
    {
        return $this->is_anonymous ? '' : $this->localizedRole();
    }

    public function getDisplayQuoteAttribute(): string
    {
        return $this->localizedQuote();
    }

    private function localizedValue(string $field, ?string $locale = null): string
    {
        $translations = $this->relationLoaded('translations')
            ? $this->translations
            : $this->translations()->get();

        foreach ($this->fallbackLocales($locale) as $candidateLocale) {
            $value = trim((string) optional($translations->firstWhere('locale', $candidateLocale))->getAttribute($field));
            if ($value !== '') {
                return $value;
            }
        }

        $firstTranslatedValue = trim((string) optional($translations->first())->getAttribute($field));
        if ($firstTranslatedValue !== '') {
            return $firstTranslatedValue;
        }

        return trim((string) $this->getAttribute($field));
    }

    private function fallbackLocales(?string $locale = null): array
    {
        $currentLocale = $locale ?: app()->getLocale();
        $defaultLocale = (string) config('locales.default', 'fr');

        return array_values(array_unique(array_filter([
            $currentLocale,
            'en',
            $defaultLocale,
        ])));
    }
}

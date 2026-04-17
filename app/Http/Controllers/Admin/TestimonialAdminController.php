<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TestimonialAdminController extends Controller
{
    public function index(string $locale)
    {
        $supportedLocales = config('locales.supported', ['fr']);
        $primaryLocale = $this->primaryLocale($supportedLocales);

        return view('admin.testimonials', [
            'adminActive' => 'testimonials',
            'testimonials' => Testimonial::query()->with('translations')->ordered()->get(),
            'supportedLocales' => $supportedLocales,
            'defaultLocale' => (string) config('locales.default', 'fr'),
            'primaryLocale' => $primaryLocale,
            'localeLabels' => $this->localeLabels($supportedLocales),
        ]);
    }

    public function store(string $locale, Request $request): RedirectResponse
    {
        $validated = $this->validateTestimonial($request);
        $primaryLocale = $this->primaryLocale();

        $testimonial = Testimonial::query()->create([
            'author_name' => $validated['translations'][$primaryLocale]['author_name'],
            'role' => $validated['translations'][$primaryLocale]['role'] ?? '',
            'quote' => $validated['translations'][$primaryLocale]['quote'],
            'sort_order' => $validated['sort_order'] ?? ((int) Testimonial::query()->max('sort_order') + 10),
            'is_active' => (bool) ($validated['is_active'] ?? true),
            'is_anonymous' => (bool) ($validated['is_anonymous'] ?? false),
        ]);
        $this->syncTranslations($testimonial, $validated['translations']);

        return back()->with('ok', 'Temoignage ajoute avec succes.');
    }

    public function update(string $locale, Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $this->validateTestimonial($request);

        $primaryLocale = $this->primaryLocale();

        $testimonial->update([
            'author_name' => $validated['translations'][$primaryLocale]['author_name'],
            'role' => $validated['translations'][$primaryLocale]['role'] ?? '',
            'quote' => $validated['translations'][$primaryLocale]['quote'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => (bool) ($validated['is_active'] ?? false),
            'is_anonymous' => (bool) ($validated['is_anonymous'] ?? false),
        ]);
        $this->syncTranslations($testimonial, $validated['translations']);

        return back()->with('ok', 'Temoignage mis a jour avec succes.');
    }

    public function destroy(string $locale, Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return back()->with('ok', 'Temoignage supprime avec succes.');
    }

    private function validateTestimonial(Request $request): array
    {
        $supportedLocales = config('locales.supported', ['fr']);
        $primaryLocale = $this->primaryLocale($supportedLocales);

        $rules = [
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['nullable', 'boolean'],
            'is_anonymous' => ['nullable', 'boolean'],
        ];

        foreach ($supportedLocales as $locale) {
            $isPrimary = $locale === $primaryLocale;
            $prefix = 'translations.'.$locale.'.';

            $rules[$prefix.'author_name'] = [$isPrimary ? 'required' : 'nullable', 'string', 'max:255'];
            $rules[$prefix.'role'] = ['nullable', 'string', 'max:255'];
            $rules[$prefix.'quote'] = [$isPrimary ? 'required' : 'nullable', 'string', 'max:2500'];
        }

        return $request->validate($rules);
    }

    private function syncTranslations(Testimonial $testimonial, array $translations): void
    {
        foreach ($translations as $locale => $payload) {
            $authorName = trim((string) ($payload['author_name'] ?? ''));
            $role = trim((string) ($payload['role'] ?? ''));
            $quote = trim((string) ($payload['quote'] ?? ''));

            $existing = $testimonial->translations->firstWhere('locale', $locale)
                ?? $testimonial->translations()->where('locale', $locale)->first();

            if ($authorName === '' && $quote === '') {
                if ($existing) {
                    $existing->delete();
                }
                continue;
            }

            $testimonial->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'author_name' => $authorName,
                    'role' => $role !== '' ? $role : null,
                    'quote' => $quote,
                ]
            );
        }
    }

    private function localeLabels(array $supportedLocales): array
    {
        $labels = [
            'en' => 'Anglais',
            'fr' => 'Francais',
            'es' => 'Espagnol',
            'pt' => 'Portugais',
            'it' => 'Italien',
            'de' => 'Allemand',
            'nl' => 'Neerlandais',
            'fi' => 'Finnois',
        ];

        return collect($supportedLocales)
            ->mapWithKeys(fn (string $code) => [$code => $labels[$code] ?? strtoupper($code)])
            ->all();
    }

    private function primaryLocale(?array $supportedLocales = null): string
    {
        $supportedLocales ??= config('locales.supported', ['fr']);

        return in_array('en', $supportedLocales, true)
            ? 'en'
            : (string) config('locales.default', 'fr');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    public function editPassword(string $locale)
    {
        return view('admin.settings-password', [
            'adminActive' => 'settings-password',
        ]);
    }

    public function edit(string $locale)
    {
        $supportedLocales = config('locales.supported', ['fr']);
        $localeLabels = [
            'fr' => 'Francais',
            'es' => 'Espagnol',
            'pt' => 'Portugais',
            'it' => 'Italien',
            'de' => 'Allemand',
        ];

        return view('admin.settings', [
            'adminActive' => 'settings',
            'settings' => [
                'site_name' => (string) config('site.name', ''),
                'site_meta_description' => (string) config('site.meta.description_suffix', ''),
                'site_meta_keywords' => (string) config('site.meta.keywords', ''),
                'site_email' => (string) config('site.email', ''),
                'site_phone' => (string) config('site.phone', ''),
                'site_address' => (string) config('site.address', ''),
                'site_default_locale' => (string) config('locales.default', 'fr'),
            ],
            'availableLocales' => collect($supportedLocales)
                ->map(fn (string $code) => ['code' => $code, 'label' => $localeLabels[$code] ?? strtoupper($code)])
                ->values()
                ->all(),
        ]);
    }

    public function update(string $locale, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_meta_description' => ['nullable', 'string', 'max:255'],
            'site_meta_keywords' => ['nullable', 'string', 'max:500'],
            'site_email' => ['nullable', 'email', 'max:255'],
            'site_phone' => ['nullable', 'string', 'max:80'],
            'site_address' => ['nullable', 'string', 'max:500'],
            'site_default_locale' => ['required', 'string', 'in:'.implode(',', config('locales.supported', ['fr']))],
        ]);

        $updates = [
            'SITE_NAME' => $validated['site_name'],
            'SITE_META_DESCRIPTION' => $validated['site_meta_description'] ?? '',
            'SITE_META_KEYWORDS' => $validated['site_meta_keywords'] ?? '',
            'SITE_EMAIL' => $validated['site_email'] ?? '',
            'SITE_PHONE' => $validated['site_phone'] ?? '',
            'SITE_ADDRESS' => $validated['site_address'] ?? '',
            'SITE_DEFAULT_LOCALE' => $validated['site_default_locale'],
            'APP_LOCALE' => $validated['site_default_locale'],
        ];

        $this->writeEnvValues($updates);
        $request->session()->put('locale', $validated['site_default_locale']);

        return back()->with('ok', 'Configuration mise a jour avec succes.');
    }

    public function updatePassword(string $locale, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $adminUser = $request->user();

        if (!$adminUser || !Hash::check((string) $validated['current_password'], (string) $adminUser->password)) {
            return back()
                ->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.'])
                ->withInput();
        }

        $adminUser->forceFill([
            'password' => Hash::make((string) $validated['new_password']),
        ])->save();

        return back()->with('ok', 'Mot de passe modifie avec succes.');
    }

    private function writeEnvValues(array $updates): void
    {
        $envPath = base_path('.env');
        $contents = file_exists($envPath) ? (string) file_get_contents($envPath) : '';

        foreach ($updates as $key => $value) {
            $escaped = $this->escapeEnvValue((string) $value);
            $pattern = "/^".preg_quote($key, '/')."=.*/m";

            if (preg_match($pattern, $contents)) {
                $contents = (string) preg_replace($pattern, $key.'='.$escaped, $contents);
                continue;
            }

            $contents .= rtrim($contents) === '' ? '' : PHP_EOL;
            $contents .= $key.'='.$escaped;
        }

        file_put_contents($envPath, $contents.PHP_EOL);
    }

    private function escapeEnvValue(string $value): string
    {
        if ($value === '') {
            return '""';
        }

        $needsQuotes = preg_match('/\s|"|#|=/', $value) === 1;
        $escaped = str_replace('"', '\"', $value);

        return $needsQuotes ? '"'.$escaped.'"' : $escaped;
    }
}

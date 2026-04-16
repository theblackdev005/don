<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FundingRequest;
use App\Models\User;
use App\Services\DonationActPdfService;
use App\Services\EnvironmentSettingsService;
use App\Support\SiteAppearance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SiteSettingsController extends Controller
{
    public function previewDonationAct(string $locale, DonationActPdfService $pdf)
    {
        $preview = new FundingRequest([
            'dossier_number' => 'ARD-'.date('Y').'-DEMO01',
            'full_name' => 'Jean Exemple',
            'email' => 'jean.exemple@example.com',
            'phone_prefix' => '+33 ',
            'phone' => '612345678',
            'address' => '12 avenue de la Solidarité, 75000 Paris, France',
            'need_type' => FundingRequest::NEED_PERSONAL,
            'amount_requested' => 50000,
            'administrative_fees' => FundingRequest::ADMINISTRATIVE_FEES,
            'donation_act_generated_at' => now(),
            'locale' => $locale,
        ]);
        $preview->setAttribute('id', 999999);

        return response($pdf->renderHtml($preview, $locale))
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }

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
            'en' => 'Anglais',
            'es' => 'Espagnol',
            'pt' => 'Portugais',
            'it' => 'Italien',
            'de' => 'Allemand',
        ];

        return view('admin.settings', [
            'adminActive' => 'settings',
            'settings' => [
                'site_name' => (string) config('site.name', ''),
                'site_logo_path' => (string) config('site.brand.logo_path', ''),
                'site_logo_url' => SiteAppearance::logoUrl(),
                'site_favicon_path' => (string) config('site.brand.favicon_path', ''),
                'site_favicon_url' => SiteAppearance::faviconUrl(),
                'site_google_tag_id' => (string) config('site.tracking.google_tag_id', ''),
                'site_facebook_pixel_id' => (string) config('site.tracking.facebook_pixel_id', ''),
                'site_email' => (string) config('site.email', ''),
                'site_phone' => (string) config('site.phone', ''),
                'site_address' => (string) config('site.address', ''),
                'site_legal_full_name' => (string) config('site.legal.full_name', ''),
                'site_company_number' => (string) config('site.legal.company_number', ''),
                'site_main_address' => (string) config('site.legal.main_address', ''),
                'site_social_facebook' => (string) config('site.social.facebook', ''),
                'site_social_instagram' => (string) config('site.social.instagram', ''),
                'site_social_linkedin' => (string) config('site.social.linkedin', ''),
                'donation_act_director_name' => (string) config('admin.donation_act.director_name', ''),
                'donation_act_director_gender' => (string) config('admin.donation_act.director_gender', 'male'),
                'site_default_locale' => (string) config('locales.default', 'fr'),
            ],
            'availableLocales' => collect($supportedLocales)
                ->map(fn (string $code) => ['code' => $code, 'label' => $localeLabels[$code] ?? strtoupper($code)])
                ->values()
                ->all(),
        ]);
    }

    public function update(string $locale, Request $request, EnvironmentSettingsService $environmentSettings): RedirectResponse
    {
        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_logo' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp', 'max:3072'],
            'site_favicon' => ['nullable', 'file', 'mimes:png,ico,webp', 'max:2048'],
            'site_google_tag_id' => ['nullable', 'string', 'max:80'],
            'site_facebook_pixel_id' => ['nullable', 'string', 'max:80'],
            'site_email' => ['nullable', 'email', 'max:255'],
            'site_phone' => ['nullable', 'string', 'max:80'],
            'site_address' => ['nullable', 'string', 'max:500'],
            'site_legal_full_name' => ['nullable', 'string', 'max:255'],
            'site_company_number' => ['nullable', 'string', 'max:120'],
            'site_main_address' => ['nullable', 'string', 'max:500'],
            'site_social_facebook' => ['nullable', 'url', 'max:255'],
            'site_social_instagram' => ['nullable', 'url', 'max:255'],
            'site_social_linkedin' => ['nullable', 'url', 'max:255'],
            'donation_act_director_name' => ['nullable', 'string', 'max:255'],
            'donation_act_director_gender' => ['required', 'string', 'in:male,female'],
            'site_default_locale' => ['required', 'string', 'in:'.implode(',', config('locales.supported', ['fr']))],
        ]);

        $siteLogoPath = $request->hasFile('site_logo')
            ? $this->storeSiteLogo($request)
            : (string) config('site.brand.logo_path', 'assets/img/branding/humanity-impact.png');
        $siteFaviconPath = $request->hasFile('site_favicon')
            ? $this->storeSiteFavicon($request)
            : (string) config('site.brand.favicon_path', 'assets/app-icons/icon-32x32.png');
        $siteEmail = trim((string) ($validated['site_email'] ?? ''));
        $sitePhone = trim((string) ($validated['site_phone'] ?? ''));

        $updates = [
            'SITE_NAME' => $validated['site_name'],
            'SITE_LOGO_PATH' => $siteLogoPath,
            'SITE_FAVICON_PATH' => $siteFaviconPath,
            'SITE_GOOGLE_TAG_ID' => trim((string) ($validated['site_google_tag_id'] ?? '')),
            'SITE_FACEBOOK_PIXEL_ID' => trim((string) ($validated['site_facebook_pixel_id'] ?? '')),
            'SITE_EMAIL' => $siteEmail,
            'SITE_PUBLIC_CONTACT_EMAIL' => $siteEmail,
            'SITE_WHATSAPP' => $sitePhone,
            'ADMIN_EMAIL' => $siteEmail,
            'SITE_PHONE' => $sitePhone,
            'SITE_ADDRESS' => $validated['site_address'] ?? '',
            'SITE_LEGAL_FULL_NAME' => $validated['site_legal_full_name'] ?? '',
            'SITE_COMPANY_NUMBER' => $validated['site_company_number'] ?? '',
            'SITE_MAIN_ADDRESS' => $validated['site_main_address'] ?? '',
            'SITE_SOCIAL_FACEBOOK' => $validated['site_social_facebook'] ?? '',
            'SITE_SOCIAL_INSTAGRAM' => $validated['site_social_instagram'] ?? '',
            'SITE_SOCIAL_LINKEDIN' => $validated['site_social_linkedin'] ?? '',
            'DONATION_ACT_DIRECTOR_NAME' => $validated['donation_act_director_name'] ?? '',
            'DONATION_ACT_DIRECTOR_GENDER' => $validated['donation_act_director_gender'] ?? 'male',
            'SITE_DEFAULT_LOCALE' => $validated['site_default_locale'],
            'APP_LOCALE' => $validated['site_default_locale'],
        ];

        $this->syncAdminEmail($request, (string) ($validated['site_email'] ?? ''));
        $environmentSettings->persist($updates, [
            'site.name' => $validated['site_name'],
            'site.brand.logo_path' => $siteLogoPath,
            'site.brand.favicon_path' => $siteFaviconPath,
            'site.tracking.google_tag_id' => trim((string) ($validated['site_google_tag_id'] ?? '')),
            'site.tracking.facebook_pixel_id' => trim((string) ($validated['site_facebook_pixel_id'] ?? '')),
            'site.email' => $siteEmail,
            'site.public_contact_email' => $siteEmail,
            'site.whatsapp' => $sitePhone,
            'site.phone' => $sitePhone,
            'site.address' => $validated['site_address'] ?? '',
            'site.legal.full_name' => $validated['site_legal_full_name'] ?? '',
            'site.legal.company_number' => $validated['site_company_number'] ?? '',
            'site.legal.main_address' => $validated['site_main_address'] ?? '',
            'site.social.facebook' => $validated['site_social_facebook'] ?? '',
            'site.social.instagram' => $validated['site_social_instagram'] ?? '',
            'site.social.linkedin' => $validated['site_social_linkedin'] ?? '',
            'admin.email' => $siteEmail,
            'admin.donation_act.director_name' => $validated['donation_act_director_name'] ?? '',
            'admin.donation_act.director_gender' => $validated['donation_act_director_gender'] ?? 'male',
            'locales.default' => $validated['site_default_locale'],
            'app.locale' => $validated['site_default_locale'],
        ]);
        $request->session()->put('locale', $validated['site_default_locale']);

        return back()->with('ok', 'Configuration mise a jour avec succes.');
    }

    public function updatePassword(string $locale, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'confirmed'],
        ], [
            'current_password.required' => 'Veuillez saisir le code d’accès actuel.',
            'new_password.required' => 'Veuillez saisir le nouveau code d’accès.',
            'new_password.confirmed' => 'La confirmation du nouveau code d’accès ne correspond pas.',
        ]);

        $adminUser = $request->user();

        if (!$adminUser || !Hash::check((string) $validated['current_password'], (string) $adminUser->password)) {
            return back()
                ->withErrors(['current_password' => 'Le code d’accès actuel est incorrect.'])
                ->withInput();
        }

        $adminUser->forceFill([
            'password' => Hash::make((string) $validated['new_password']),
        ])->save();

        return back()->with('ok', 'Code d’accès modifié avec succès.');
    }
    private function syncAdminEmail(Request $request, string $newEmail): void
    {
        $newEmail = trim($newEmail);
        if ($newEmail === '') {
            return;
        }

        $adminUser = $request->user();
        if ($adminUser instanceof User && $adminUser->isAdmin()) {
            $conflict = User::query()
                ->where('email', $newEmail)
                ->whereKeyNot($adminUser->getKey())
                ->exists();

            if ($conflict) {
                throw ValidationException::withMessages([
                    'site_email' => 'Cette adresse e-mail est déjà utilisée par un autre compte.',
                ]);
            }

            if ($adminUser->email !== $newEmail) {
                $adminUser->forceFill(['email' => $newEmail])->save();
            }

            return;
        }

        $adminUser = User::query()
            ->where('is_admin', true)
            ->where('email', (string) config('admin.email', ''))
            ->first()
            ?? User::query()->where('is_admin', true)->first();

        if (! $adminUser) {
            return;
        }

        $conflict = User::query()
            ->where('email', $newEmail)
            ->whereKeyNot($adminUser->getKey())
            ->exists();

        if ($conflict) {
            throw ValidationException::withMessages([
                'site_email' => 'Cette adresse e-mail est déjà utilisée par un autre compte.',
            ]);
        }

        if ($adminUser->email !== $newEmail) {
            $adminUser->forceFill(['email' => $newEmail])->save();
        }
    }

    private function storeSiteLogo(Request $request): string
    {
        $logo = $request->file('site_logo');
        if (! $logo) {
            return (string) config('site.brand.logo_path', 'assets/img/branding/humanity-impact.png');
        }

        $extension = strtolower((string) $logo->getClientOriginalExtension());
        $fileName = 'site-logo'.($extension !== '' ? '.'.$extension : '');
        $directory = public_path('assets/img/branding/custom');

        if (! is_dir($directory)) {
            File::ensureDirectoryExists($directory);
        }

        foreach (glob($directory.'/site-logo.*') ?: [] as $existingFile) {
            if (is_file($existingFile)) {
                @unlink($existingFile);
            }
        }

        $logo->move($directory, $fileName);

        return 'assets/img/branding/custom/'.$fileName;
    }

    private function storeSiteFavicon(Request $request): string
    {
        $favicon = $request->file('site_favicon');
        if (! $favicon) {
            return (string) config('site.brand.favicon_path', 'assets/app-icons/icon-32x32.png');
        }

        $extension = strtolower((string) $favicon->getClientOriginalExtension());
        $fileName = 'site-favicon'.($extension !== '' ? '.'.$extension : '');
        $directory = public_path('assets/app-icons/custom');

        if (! is_dir($directory)) {
            File::ensureDirectoryExists($directory);
        }

        foreach (glob($directory.'/site-favicon.*') ?: [] as $existingFile) {
            if (is_file($existingFile)) {
                @unlink($existingFile);
            }
        }

        $favicon->move($directory, $fileName);

        return 'assets/app-icons/custom/'.$fileName;
    }
}

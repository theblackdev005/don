<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminMessageTemplate;
use App\Support\FundingRequestAdminMessages;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminMessageTemplateController extends Controller
{
    public function edit(string $locale, Request $request): View
    {
        $supportedLocales = config('locales.supported', ['fr']);
        $selectedLocale = $this->resolveContentLocale((string) $request->query('langue', config('locales.default', 'fr')));

        return view('admin.message-templates', [
            'adminActive' => 'message-templates',
            'supportedLocales' => $supportedLocales,
            'selectedLocale' => $selectedLocale,
            'localeLabels' => $this->localeLabels($supportedLocales),
            'templates' => FundingRequestAdminMessages::editableTemplatesForLocale($selectedLocale),
            'variables' => FundingRequestAdminMessages::availableVariables(),
        ]);
    }

    public function update(string $locale, Request $request): RedirectResponse
    {
        $supportedLocales = config('locales.supported', ['fr']);

        $validated = $request->validate([
            'content_locale' => ['required', 'string', 'in:'.implode(',', $supportedLocales)],
            'templates' => ['required', 'array'],
            'templates.*.subject' => ['required', 'string', 'max:255'],
            'templates.*.body' => ['required', 'string', 'max:20000'],
        ]);

        $contentLocale = $this->resolveContentLocale($validated['content_locale']);
        $allowedKeys = collect(FundingRequestAdminMessages::defaultTemplatesForLocale($contentLocale))
            ->pluck('key')
            ->all();

        foreach ($validated['templates'] as $key => $payload) {
            if (! in_array($key, $allowedKeys, true)) {
                continue;
            }

            AdminMessageTemplate::query()->updateOrCreate(
                [
                    'locale' => $contentLocale,
                    'key' => $key,
                ],
                [
                    'subject' => trim((string) $payload['subject']),
                    'body' => trim((string) $payload['body']),
                ]
            );
        }

        return redirect()
            ->route('admin.message-templates.edit', ['langue' => $contentLocale])
            ->with('ok', 'Modèles enregistrés.');
    }

    private function resolveContentLocale(string $locale): string
    {
        $supportedLocales = config('locales.supported', ['fr']);

        return in_array($locale, $supportedLocales, true)
            ? $locale
            : (string) config('locales.default', 'fr');
    }

    private function localeLabels(array $supportedLocales): array
    {
        return collect($supportedLocales)
            ->mapWithKeys(fn (string $code) => [$code => trans('ui.lang.'.$code, [], 'fr')])
            ->all();
    }
}

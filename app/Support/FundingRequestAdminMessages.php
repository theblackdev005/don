<?php

namespace App\Support;

use App\Models\AdminMessageTemplate;
use App\Models\FundingRequest;
use Illuminate\Support\Facades\Schema;

class FundingRequestAdminMessages
{
    public static function for(FundingRequest $fundingRequest, ?string $locale = null): array
    {
        $locale = $locale ?: $fundingRequest->preferredLocale();
        $variables = self::variables($fundingRequest, $locale);
        $activeStep = self::activeStep($fundingRequest);

        return array_map(function (array $template) use ($variables, $activeStep) {
            $body = self::render($template['body'], $variables);
            $subject = self::render($template['subject'], $variables);

            return [
                'key' => $template['key'],
                'step' => $template['step'],
                'title' => $template['title'],
                'action' => $template['action'],
                'subject' => $subject,
                'body' => $body,
                'active' => $template['step'] === $activeStep,
            ];
        }, self::templates($locale));
    }

    public static function editableTemplatesForLocale(string $locale): array
    {
        $templates = self::defaultTemplatesForLocale($locale);
        $storedTemplates = self::storedTemplatesForLocale($locale, array_column($templates, 'key'));

        return array_map(function (array $template) use ($storedTemplates) {
            $stored = $storedTemplates[$template['key']] ?? null;

            return [
                ...$template,
                'default_subject' => $template['subject'],
                'default_body' => $template['body'],
                'subject' => $stored?->subject ?? $template['subject'],
                'body' => $stored?->body ?? $template['body'],
                'customized' => $stored !== null,
            ];
        }, $templates);
    }

    public static function defaultTemplatesForLocale(string $locale): array
    {
        $locale = self::resolveLocale($locale);

        $templates = trans('admin_messages.templates', [], $locale);
        if (! is_array($templates)) {
            $templates = trans('admin_messages.templates', [], 'fr');
        }

        return is_array($templates) ? array_values($templates) : [];
    }

    public static function availableVariables(): array
    {
        return [
            ['token' => '[PRENOM]', 'label' => 'Prénom du client'],
            ['token' => '[NOM]', 'label' => 'Nom du client'],
            ['token' => '[NUMERO_DOSSIER]', 'label' => 'Numéro de dossier'],
            ['token' => '[MOTIF_DEMANDE]', 'label' => 'Type ou résumé de la demande'],
            ['token' => '[MONTANT_DEMANDE]', 'label' => 'Montant demandé'],
            ['token' => '[MONTANT_ACCEPTE]', 'label' => 'Montant accepté'],
            ['token' => '[LIEN_DOSSIER]', 'label' => 'Lien de suivi du dossier'],
            ['token' => '[LIEN_DOCUMENTS]', 'label' => 'Lien de dépôt des documents'],
            ['token' => '[EMAIL_CLIENT]', 'label' => 'E-mail du client'],
            ['token' => '[DATE_RECEPTION]', 'label' => 'Date de réception'],
            ['token' => '[NOM_SITE]', 'label' => 'Nom du site'],
        ];
    }

    public static function variables(FundingRequest $fundingRequest, ?string $locale = null): array
    {
        $locale = $locale ?: $fundingRequest->preferredLocale();
        [$firstName, $lastName] = self::nameParts($fundingRequest->full_name);
        $needLabel = '';
        if ($fundingRequest->need_type) {
            $translatedNeed = trans('funding.need_type.'.$fundingRequest->need_type, [], $locale);
            $needLabel = str_starts_with($translatedNeed, 'funding.')
                ? (FundingRequest::needTypeLabels()[$fundingRequest->need_type] ?? $fundingRequest->need_type)
                : $translatedNeed;
        }

        if ($needLabel === '') {
            $needLabel = self::excerpt((string) $fundingRequest->situation, 120);
        }

        $dossierLink = $fundingRequest->public_slug
            ? LocalizedRouteSlugs::route('funding-request.success', [
                'locale' => $locale,
                'public_slug' => $fundingRequest->public_slug,
            ])
            : '';

        $documentsLink = $fundingRequest->public_slug
            ? LocalizedRouteSlugs::route('funding-request.documents', [
                'locale' => $locale,
                'public_slug' => $fundingRequest->public_slug,
            ])
            : '';

        return [
            '[PRENOM]' => $firstName !== '' ? $firstName : trans('admin_messages.generic_recipient', [], $locale),
            '[NOM]' => $lastName,
            '[NUMERO_DOSSIER]' => (string) $fundingRequest->dossier_number,
            '[MOTIF_DEMANDE]' => $needLabel !== '' ? $needLabel : 'votre demande de financement',
            '[MONTANT_DEMANDE]' => self::formatAmount($fundingRequest->amount_requested, $locale),
            '[MONTANT_ACCEPTE]' => self::formatAmount($fundingRequest->amount_requested, $locale),
            '[LIEN_DOSSIER]' => $dossierLink,
            '[LIEN_DOCUMENTS]' => $documentsLink,
            '[EMAIL_CLIENT]' => (string) $fundingRequest->email,
            '[DATE_RECEPTION]' => $fundingRequest->created_at?->format('d/m/Y H:i') ?? '',
            '[NOM_SITE]' => (string) config('site.name', 'Aven Foundation'),
        ];
    }

    private static function activeStep(FundingRequest $fundingRequest): int
    {
        if (in_array($fundingRequest->status, [
            FundingRequest::STATUS_PRELIMINARY_ACCEPTED,
            FundingRequest::STATUS_AWAITING_DOCUMENTS,
        ], true)) {
            return $fundingRequest->documentsComplete() ? 4 : 3;
        }

        return match ($fundingRequest->status) {
            FundingRequest::STATUS_PENDING => 1,
            FundingRequest::STATUS_DOCUMENTS_RECEIVED => 4,
            FundingRequest::STATUS_DONATION_ACT_SENT => 6,
            FundingRequest::STATUS_CLOSED => 9,
            default => 1,
        };
    }

    private static function templates(string $locale): array
    {
        return array_map(
            fn (array $template) => [
                'key' => $template['key'],
                'step' => $template['step'],
                'title' => $template['title'],
                'action' => $template['action'],
                'subject' => $template['subject'],
                'body' => $template['body'],
            ],
            self::editableTemplatesForLocale($locale)
        );
    }

    /**
     * @return array<string, AdminMessageTemplate>
     */
    private static function storedTemplatesForLocale(string $locale, array $keys): array
    {
        if ($keys === [] || ! Schema::hasTable('admin_message_templates')) {
            return [];
        }

        return AdminMessageTemplate::query()
            ->where('locale', self::resolveLocale($locale))
            ->whereIn('key', $keys)
            ->get()
            ->keyBy('key')
            ->all();
    }

    private static function resolveLocale(string $locale): string
    {
        $supported = config('locales.supported', ['fr']);

        return in_array($locale, $supported, true)
            ? $locale
            : (string) config('locales.default', 'fr');
    }

    private static function render(string $template, array $variables): string
    {
        return trim(str_replace(array_keys($variables), array_values($variables), $template));
    }

    private static function nameParts(string $fullName): array
    {
        $parts = preg_split('/\s+/u', trim($fullName), -1, PREG_SPLIT_NO_EMPTY) ?: [];

        if ($parts === []) {
            return ['', ''];
        }

        return [
            (string) $parts[0],
            trim(implode(' ', array_slice($parts, 1))),
        ];
    }

    private static function formatAmount(mixed $amount, string $locale): string
    {
        if ($amount === null || $amount === '') {
            return trans('admin_messages.amount_not_provided', [], $locale);
        }

        [$decimals, $thousands] = match ($locale) {
            'en' => ['.', ','],
            'es', 'it', 'de', 'nl' => [',', '.'],
            default => [',', ' '],
        };

        return number_format((float) $amount, 2, $decimals, $thousands).' EUR';
    }

    private static function excerpt(string $value, int $limit): string
    {
        $value = trim((string) preg_replace('/\s+/u', ' ', $value));
        if ($value === '' || mb_strlen($value) <= $limit) {
            return $value;
        }

        return rtrim(mb_substr($value, 0, $limit - 1)).'…';
    }
}

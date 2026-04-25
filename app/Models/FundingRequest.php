<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class FundingRequest extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    /** Ancien flux ou dossiers historiques ; les nouveaux dossiers passent par « en attente des pièces ». */
    public const STATUS_PRELIMINARY_ACCEPTED = 'preliminary_accepted';

    /** Première validation admin : le demandeur doit déposer ses pièces via le lien personnel. */
    public const STATUS_AWAITING_DOCUMENTS = 'awaiting_documents';

    /** Toutes les pièces requises sont reçues ; l’admin peut générer l’acte. */
    public const STATUS_DOCUMENTS_RECEIVED = 'documents_received';

    public const STATUS_DONATION_ACT_SENT = 'donation_act_sent';

    public const STATUS_REFUSED = 'refused';

    public const STATUS_CLOSED = 'closed';

    /** Montants proposés au formulaire (€). */
    public const AMOUNT_CHOICES = [20000, 50000, 80000, 100000, 150000, 200000, 300000];

    /** Frais administratifs fixes (€). */
    public const ADMINISTRATIVE_FEES = 150;

    public const CURRENT_SITUATION_SALARIED = 'salaried';

    public const CURRENT_SITUATION_UNEMPLOYED = 'unemployed';

    public const CURRENT_SITUATION_SELF_EMPLOYED = 'self_employed';

    public const CURRENT_SITUATION_STUDENT = 'student';

    public const CURRENT_SITUATION_RETIRED = 'retired';

    public const FAMILY_SINGLE = 'single';

    public const FAMILY_MARRIED = 'married';

    public const FAMILY_WITH_CHILDREN = 'with_children';

    public const NEED_MEDICAL = 'medical_emergency';

    public const NEED_FAMILY = 'critical_family';

    public const NEED_PERSONAL = 'personal_recovery';

    public const NEED_EXCEPTIONAL = 'exceptional_assistance';

    public const NEED_PROJECT = 'funding_project';

    public const IDENTITY_DOCUMENT_PASSPORT = 'passport';

    public const IDENTITY_DOCUMENT_ID_CARD = 'id_card';

    public static function currentSituationKeys(): array
    {
        return [
            self::CURRENT_SITUATION_SALARIED,
            self::CURRENT_SITUATION_UNEMPLOYED,
            self::CURRENT_SITUATION_SELF_EMPLOYED,
            self::CURRENT_SITUATION_STUDENT,
            self::CURRENT_SITUATION_RETIRED,
        ];
    }

    public static function currentSituationLabels(): array
    {
        return collect(self::currentSituationKeys())
            ->mapWithKeys(fn (string $k) => [$k => __('funding.current_situation.'.$k)])
            ->all();
    }

    public static function familySituationKeys(): array
    {
        return [self::FAMILY_SINGLE, self::FAMILY_MARRIED, self::FAMILY_WITH_CHILDREN];
    }

    public static function familySituationLabels(): array
    {
        return collect(self::familySituationKeys())
            ->mapWithKeys(fn (string $k) => [$k => __('funding.family_situation.'.$k)])
            ->all();
    }

    public static function needTypeKeys(): array
    {
        return [self::NEED_MEDICAL, self::NEED_FAMILY, self::NEED_PERSONAL, self::NEED_EXCEPTIONAL, self::NEED_PROJECT];
    }

    public static function needTypeLabels(): array
    {
        return collect(self::needTypeKeys())
            ->mapWithKeys(fn (string $k) => [$k => __('funding.need_type.'.$k)])
            ->all();
    }

    protected $fillable = [
        'dossier_number',
        'public_slug',
        'locale',
        'full_name',
        'email',
        'phone',
        'phone_prefix',
        'country',
        'address',
        'current_situation',
        'other_situation',
        'monthly_income_approx',
        'family_situation',
        'situation',
        'need_type',
        'other_need_type',
        'identity_document_type',
        'doc_passport_path',
        'doc_id_front_path',
        'doc_id_back_path',
        'amount_requested',
        'administrative_fees',
        'declare_accurate',
        'status',
        'donation_act_generated_at',
        'admin_notes',
        'refused_reason',
        'donation_act_path',
    ];

    protected $casts = [
        'amount_requested' => 'decimal:2',
        'administrative_fees' => 'decimal:2',
        'declare_accurate' => 'boolean',
        'donation_act_generated_at' => 'datetime',
    ];

    public function financialChanges(): HasMany
    {
        return $this->hasMany(FundingRequestFinancialChange::class);
    }

    public function emailNotifications(): HasMany
    {
        return $this->hasMany(EmailNotification::class);
    }

    public static function statusLabels(): array
    {
        return [
            self::STATUS_PENDING => __('funding.status.pending'),
            self::STATUS_PRELIMINARY_ACCEPTED => __('funding.status.preliminary_accepted'),
            self::STATUS_AWAITING_DOCUMENTS => __('funding.status.awaiting_documents'),
            self::STATUS_DOCUMENTS_RECEIVED => __('funding.status.documents_received'),
            self::STATUS_DONATION_ACT_SENT => __('funding.status.donation_act_sent'),
            self::STATUS_REFUSED => __('funding.status.refused'),
            self::STATUS_CLOSED => __('funding.status.closed'),
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statusLabels()[$this->status] ?? $this->status;
    }

    public function getFullNameAttribute(): string
    {
        $stored = $this->attributes['full_name'] ?? '';
        return is_string($stored) ? trim($stored) : '';
    }

    /** Langue du formulaire au moment du dépôt (e-mails / PDF bénéficiaire). */
    public function preferredLocale(): string
    {
        $supported = config('locales.supported', ['fr']);
        $loc = $this->locale;
        if (is_string($loc) && in_array($loc, $supported, true)) {
            return $loc;
        }

        return config('locales.default', 'fr');
    }

    public function isLegacyDossierFormat(): bool
    {
        return str_starts_with((string) $this->dossier_number, 'JGF-');
    }

    public static function generateDossierNumber(int $id): string
    {
        do {
            $number = 'ARD-'.date('Y').'-'.strtoupper(Str::random(6));
        } while (self::query()->where('dossier_number', $number)->exists());

        return $number;
    }

    /** Identifiant court pour l’URL de confirmation (non devinable). */
    public static function generatePublicSlug(): string
    {
        do {
            $slug = strtolower(Str::random(12));
        } while (self::query()->where('public_slug', $slug)->exists());

        return $slug;
    }

    /** Normalise la saisie utilisateur pour recherche par numéro de dossier. */
    public static function normalizeDossierNumberInput(string $input): string
    {
        return strtoupper(preg_replace('/\s+/u', '', trim($input)));
    }

    public static function identityDocumentTypeLabels(): array
    {
        return [
            self::IDENTITY_DOCUMENT_PASSPORT => __('funding.identity_doc.passport'),
            self::IDENTITY_DOCUMENT_ID_CARD => __('funding.identity_doc.id_card'),
        ];
    }

    public function identityDocumentComplete(): bool
    {
        $type = $this->identity_document_type;
        if ($type === self::IDENTITY_DOCUMENT_PASSPORT) {
            return filled($this->doc_passport_path);
        }
        if ($type === self::IDENTITY_DOCUMENT_ID_CARD) {
            return filled($this->doc_id_front_path) && filled($this->doc_id_back_path);
        }

        // Compatibilité anciens dossiers (ancien champ unique).
        return filled($this->doc_id_path);
    }

    public function documentsComplete(): bool
    {
        return $this->identityDocumentComplete();
    }

    /** Le demandeur peut encore uploader / compléter ses fichiers (lien dans l’e-mail). */
    public function applicantCanUploadDocuments(): bool
    {
        if (! $this->public_slug) {
            return false;
        }

        if ($this->status === self::STATUS_AWAITING_DOCUMENTS) {
            return true;
        }

        return $this->status === self::STATUS_PRELIMINARY_ACCEPTED && ! $this->documentsComplete();
    }

    /** Téléchargement de l’acte (PDF) via le lien sécurisé par public_slug (suivi / e-mail). */
    public function applicantCanDownloadDonationAct(): bool
    {
        if (! filled($this->public_slug) || ! filled($this->donation_act_path)) {
            return false;
        }

        return in_array($this->status, [
            self::STATUS_DONATION_ACT_SENT,
            self::STATUS_CLOSED,
        ], true);
    }

    /** Texte affiché au demandeur sur la page de suivi (sans données internes). */
    public function publicTrackingSummary(): array
    {
        $lines = match ($this->status) {
            self::STATUS_PENDING => [
                'headline' => __('funding.tracking.pending.headline'),
                'body' => __('funding.tracking.pending.body'),
            ],
            self::STATUS_PRELIMINARY_ACCEPTED => [
                'headline' => __('funding.tracking.preliminary.headline'),
                'body' => $this->documentsComplete()
                    ? __('funding.tracking.preliminary.body_complete')
                    : __('funding.tracking.preliminary.body_documents'),
            ],
            self::STATUS_AWAITING_DOCUMENTS => [
                'headline' => __('funding.tracking.awaiting_documents.headline'),
                'body' => __('funding.tracking.awaiting_documents.body'),
            ],
            self::STATUS_DOCUMENTS_RECEIVED => [
                'headline' => __('funding.tracking.documents_received.headline'),
                'body' => __('funding.tracking.documents_received.body'),
            ],
            self::STATUS_DONATION_ACT_SENT => [
                'headline' => __('funding.tracking.donation_act_sent.headline'),
                'body' => __('funding.tracking.donation_act_sent.body'),
            ],
            self::STATUS_REFUSED => [
                'headline' => __('funding.tracking.refused.headline'),
                'body' => __('funding.tracking.refused.body'),
            ],
            self::STATUS_CLOSED => [
                'headline' => __('funding.tracking.closed.headline'),
                'body' => __('funding.tracking.closed.body'),
            ],
            default => [
                'headline' => __('funding.tracking.default.headline'),
                'body' => __('funding.tracking.default.body'),
            ],
        };

        return $lines;
    }
}

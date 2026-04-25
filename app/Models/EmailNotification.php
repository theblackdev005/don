<?php

namespace App\Models;

use App\Mail\FundingDocumentsReceivedAdminMail;
use App\Mail\FundingDonationActMail;
use App\Mail\FundingDonationActSentAdminMail;
use App\Mail\FundingPreliminaryAcceptedMail;
use App\Mail\FundingPreliminarySentAdminMail;
use App\Mail\FundingRequestClosedMail;
use App\Mail\FundingRequestReceivedAdminMail;
use App\Mail\FundingRequestReceivedApplicantMail;
use App\Mail\FundingRequestRefusedMail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailNotification extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_SENT = 'sent';

    public const STATUS_FAILED = 'failed';

    public const RECIPIENT_ADMIN = 'admin';

    public const RECIPIENT_APPLICANT = 'applicant';

    protected $fillable = [
        'funding_request_id',
        'recipient_email',
        'recipient_type',
        'mailable_class',
        'subject',
        'locale',
        'status',
        'attempts',
        'last_error',
        'last_attempt_at',
        'sent_at',
    ];

    protected $casts = [
        'last_attempt_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function fundingRequest(): BelongsTo
    {
        return $this->belongsTo(FundingRequest::class);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_SENT => 'Envoyé',
            self::STATUS_FAILED => 'Échoué',
            default => 'En attente',
        };
    }

    public function statusClass(): string
    {
        return match ($this->status) {
            self::STATUS_SENT => 'sent',
            self::STATUS_FAILED => 'failed',
            default => 'pending',
        };
    }

    public function recipientLabel(): string
    {
        return match ($this->recipient_type) {
            self::RECIPIENT_ADMIN => 'Admin',
            default => 'Client',
        };
    }

    public function mailLabel(): string
    {
        return self::mailLabels()[$this->mailable_class] ?? class_basename($this->mailable_class);
    }

    /**
     * @return array<class-string, string>
     */
    public static function mailLabels(): array
    {
        return [
            FundingRequestReceivedApplicantMail::class => 'Confirmation de demande',
            FundingRequestReceivedAdminMail::class => 'Nouvelle demande admin',
            FundingPreliminaryAcceptedMail::class => 'Validation préliminaire',
            FundingPreliminarySentAdminMail::class => 'Validation envoyée admin',
            FundingDocumentsReceivedAdminMail::class => 'Documents reçus admin',
            FundingDonationActMail::class => 'Acte de donation client',
            FundingDonationActSentAdminMail::class => 'Acte envoyé admin',
            FundingRequestRefusedMail::class => 'Refus du dossier',
            FundingRequestClosedMail::class => 'Clôture du dossier',
        ];
    }
}

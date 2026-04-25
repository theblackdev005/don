<?php

namespace App\Services;

use App\Models\EmailNotification;
use App\Models\FundingRequest;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use RuntimeException;
use Throwable;

class TrackedMailService
{
    public function sendFundingRequestMail(
        string $recipientEmail,
        Mailable $mailable,
        FundingRequest $fundingRequest,
        string $recipientType,
        string $locale,
        bool $throwOnFailure = false
    ): EmailNotification {
        $mailable->locale($locale);

        $notification = EmailNotification::query()->create([
            'funding_request_id' => $fundingRequest->id,
            'recipient_email' => trim($recipientEmail),
            'recipient_type' => $recipientType,
            'mailable_class' => $mailable::class,
            'subject' => $this->subjectOf($mailable),
            'locale' => $locale,
            'status' => EmailNotification::STATUS_PENDING,
        ]);

        return $this->attempt($notification, $mailable, $throwOnFailure);
    }

    public function retry(EmailNotification $notification, bool $throwOnFailure = false): EmailNotification
    {
        return $this->attempt($notification, $this->mailableFor($notification), $throwOnFailure);
    }

    private function attempt(EmailNotification $notification, Mailable $mailable, bool $throwOnFailure): EmailNotification
    {
        $now = now();

        try {
            Mail::to($notification->recipient_email)->send($mailable);

            $notification->forceFill([
                'status' => EmailNotification::STATUS_SENT,
                'attempts' => $notification->attempts + 1,
                'subject' => $notification->subject ?: $this->subjectOf($mailable),
                'last_error' => null,
                'last_attempt_at' => $now,
                'sent_at' => $now,
            ])->save();
        } catch (Throwable $exception) {
            report($exception);

            $notification->forceFill([
                'status' => EmailNotification::STATUS_FAILED,
                'attempts' => $notification->attempts + 1,
                'last_error' => mb_substr($exception->getMessage(), 0, 10000),
                'last_attempt_at' => $now,
            ])->save();

            if ($throwOnFailure) {
                throw $exception;
            }
        }

        return $notification->fresh(['fundingRequest']) ?? $notification;
    }

    private function mailableFor(EmailNotification $notification): Mailable
    {
        $class = $notification->mailable_class;
        if (! is_a($class, Mailable::class, true)) {
            throw new RuntimeException('Type d’e-mail non reconnu.');
        }

        $fundingRequest = $notification->fundingRequest;
        if (! $fundingRequest) {
            throw new RuntimeException('Le dossier lié à cet e-mail est introuvable.');
        }

        /** @var Mailable $mailable */
        $mailable = new $class($fundingRequest->fresh());
        $mailable->locale($notification->locale ?: $fundingRequest->preferredLocale());

        return $mailable;
    }

    private function subjectOf(Mailable $mailable): ?string
    {
        try {
            return $mailable->envelope()->subject;
        } catch (Throwable) {
            return null;
        }
    }
}

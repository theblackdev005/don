<?php

namespace App\Mail;

use App\Mail\Concerns\ResolvesMailLocale;
use App\Models\FundingRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class FundingDonationActMail extends Mailable
{
    use Queueable;
    use ResolvesMailLocale;
    use SerializesModels;
    public function __construct(public FundingRequest $fundingRequest)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->mailTrans('mail.donation_act.subject', [
                'number' => $this->fundingRequest->dossier_number,
            ]),
        );
    }

    public function content(): Content
    {
        return new Content(
            html: 'mail.funding.donation-act',
        );
    }

    /**
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if (! $this->fundingRequest->donation_act_path || ! Storage::disk('local')->exists($this->fundingRequest->donation_act_path)) {
            return [];
        }

        return [
            Attachment::fromStorageDisk('local', $this->fundingRequest->donation_act_path)
                ->as($this->mailTrans('mail.donation_act.attachment_name', [
                    'number' => $this->fundingRequest->dossier_number,
                ]))
                ->withMime('application/pdf'),
        ];
    }
}

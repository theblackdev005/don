<?php

namespace App\Mail;

use App\Mail\Concerns\ResolvesMailLocale;
use App\Models\FundingRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FundingRequestReceivedApplicantMail extends Mailable
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
            subject: $this->mailTrans('mail.received_applicant.subject', [
                'number' => $this->fundingRequest->dossier_number,
            ]),
        );
    }

    public function content(): Content
    {
        return new Content(
            html: 'mail.funding.received-applicant',
        );
    }
}

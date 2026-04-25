<?php

namespace Tests\Feature;

use App\Mail\FundingDocumentsReceivedAdminMail;
use App\Mail\FundingPreliminaryAcceptedMail;
use App\Mail\FundingRequestReceivedApplicantMail;
use App\Mail\FundingRequestRefusedMail;
use App\Models\FundingRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FundingMailContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_received_applicant_mail_contains_localized_tracking_link(): void
    {
        $fundingRequest = FundingRequest::factory()->create([
            'locale' => 'fr',
        ]);

        $html = (new FundingRequestReceivedApplicantMail($fundingRequest))->render();

        $this->assertStringContainsString(
            route('funding-request.success', [
                'locale' => 'fr',
                'public_slug' => $fundingRequest->public_slug,
            ]),
            $html
        );
    }

    public function test_preliminary_accepted_mail_contains_localized_documents_link(): void
    {
        $fundingRequest = FundingRequest::factory()->create([
            'locale' => 'fr',
        ]);

        $html = (new FundingPreliminaryAcceptedMail($fundingRequest))->render();

        $this->assertStringContainsString(
            route('funding-request.documents', [
                'locale' => 'fr',
                'public_slug' => $fundingRequest->public_slug,
            ]),
            $html
        );
    }

    public function test_documents_received_admin_mail_renders_admin_link(): void
    {
        $fundingRequest = FundingRequest::factory()->create([
            'locale' => 'fr',
        ]);

        $html = (new FundingDocumentsReceivedAdminMail($fundingRequest))->render();

        $this->assertStringContainsString(
            route('admin.funding-requests.show', [
                'locale' => 'fr',
                'fundingRequest' => $fundingRequest,
            ]),
            $html
        );
    }

    public function test_refused_mail_displays_reason_to_client(): void
    {
        $fundingRequest = FundingRequest::factory()->create([
            'refused_reason' => 'Le dossier est incomplet et ne peut pas être traité en l’état.',
        ]);

        $html = (new FundingRequestRefusedMail($fundingRequest))->render();

        $this->assertStringContainsString('Motif communiqu', $html);
        $this->assertStringContainsString($fundingRequest->refused_reason, $html);
    }
}

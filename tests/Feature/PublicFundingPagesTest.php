<?php

namespace Tests\Feature;

use App\Models\FundingRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicFundingPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_funding_request_page_displays_clear_client_guidance(): void
    {
        $response = $this->get(route('funding-request.create', [
            'locale' => 'fr',
        ]));

        $response->assertOk();
        $response->assertSee('Veuillez remplir les informations demandées');
        $response->assertSee('1. Informations personnelles');
        $response->assertSee('2. Votre situation');
        $response->assertSee('3. Votre demande');
    }

    public function test_success_page_displays_next_step_message(): void
    {
        $fundingRequest = FundingRequest::factory()->create([
            'locale' => 'fr',
            'full_name' => 'Jean Dupont',
        ]);

        $response = $this->get(route('funding-request.success', [
            'locale' => 'fr',
            'public_slug' => $fundingRequest->public_slug,
        ]));

        $response->assertOk();
        $response->assertSee('Merci, votre demande est enregistrée Jean');
        $response->assertSee('Nous écrire sur WhatsApp');
        $response->assertSee('Accéder à mon dossier');
    }

    public function test_documents_page_displays_security_notice(): void
    {
        $fundingRequest = FundingRequest::factory()->create([
            'locale' => 'fr',
            'status' => FundingRequest::STATUS_AWAITING_DOCUMENTS,
        ]);

        $response = $this->get(route('funding-request.documents', [
            'locale' => 'fr',
            'public_slug' => $fundingRequest->public_slug,
        ]));

        $response->assertOk();
        $response->assertSee('Ajoutez les documents demandés pour compléter votre dossier.');
    }

    public function test_documents_success_page_uses_same_confirmation_system(): void
    {
        $fundingRequest = FundingRequest::factory()->create([
            'locale' => 'fr',
            'full_name' => 'Jean Dupont',
        ]);

        $response = $this->get(route('funding-request.success', [
            'locale' => 'fr',
            'public_slug' => $fundingRequest->public_slug,
            'context' => 'documents',
        ]));

        $response->assertOk();
        $response->assertSee('Merci, vos documents ont été transmis Jean');
        $response->assertSee('Notre équipe analysera votre dossier et vous recontactera.');
        $response->assertSee('Accéder à mon dossier');
    }

    public function test_tracking_page_displays_public_guidance(): void
    {
        $response = $this->get(route('funding.tracking', [
            'locale' => 'fr',
        ]));

        $response->assertOk();
        $response->assertSee('Suivi de votre dossier');
        $response->assertSee('Consultez l’état actuel de votre dossier');
    }
}

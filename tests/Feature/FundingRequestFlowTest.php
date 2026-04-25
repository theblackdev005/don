<?php

namespace Tests\Feature;

use App\Mail\FundingDonationActMail;
use App\Mail\FundingDonationActSentAdminMail;
use App\Mail\FundingDocumentsReceivedAdminMail;
use App\Mail\FundingPreliminaryAcceptedMail;
use App\Mail\FundingPreliminarySentAdminMail;
use App\Mail\FundingRequestReceivedAdminMail;
use App\Mail\FundingRequestReceivedApplicantMail;
use App\Mail\FundingRequestRefusedMail;
use App\Models\EmailNotification;
use App\Models\FundingRequest;
use App\Models\FundingRequestFinancialChange;
use App\Models\User;
use App\Services\DonationActPdfService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Mockery\MockInterface;
use Tests\TestCase;

class FundingRequestFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_submit_a_funding_request(): void
    {
        Mail::fake();
        $admin = User::factory()->create([
            'is_admin' => true,
            'email' => 'admin@example.test',
        ]);
        config(['admin.notification_email' => $admin->email]);

        $response = $this->post(route('funding-request.store', ['locale' => 'fr']), [
            'full_name' => 'Jean Dupont',
            'country' => 'France',
            'address' => '10 rue de Paris, 75001 Paris',
            'email' => 'jean@example.test',
            'phone_prefix' => '+33',
            'phone' => '612345678',
            'current_situation' => FundingRequest::CURRENT_SITUATION_SALARIED,
            'monthly_income_approx' => '1800 EUR',
            'family_situation' => FundingRequest::FAMILY_SINGLE,
            'amount_requested' => 50000,
            'need_type' => FundingRequest::NEED_PERSONAL,
            'situation' => 'Je traverse une période difficile et j’ai besoin d’un soutien.',
            'declare_accurate' => '1',
        ]);

        $fundingRequest = FundingRequest::query()->first();

        $response->assertRedirect(route('funding-request.success', [
            'locale' => 'fr',
            'public_slug' => $fundingRequest->public_slug,
        ]));

        $this->assertNotNull($fundingRequest);
        $this->assertSame(FundingRequest::STATUS_PENDING, $fundingRequest->status);
        $this->assertSame('Jean Dupont', $fundingRequest->full_name);
        $this->assertSame('fr', $fundingRequest->locale);
        $this->assertNotEmpty($fundingRequest->dossier_number);
        $this->assertNotEmpty($fundingRequest->public_slug);

        Mail::assertSent(FundingRequestReceivedApplicantMail::class, function ($mail) use ($fundingRequest) {
            return $mail->hasTo($fundingRequest->email);
        });

        Mail::assertSent(FundingRequestReceivedAdminMail::class, function ($mail) use ($admin) {
            return $mail->hasTo($admin->email);
        });

        $this->assertDatabaseHas('email_notifications', [
            'funding_request_id' => $fundingRequest->id,
            'recipient_email' => 'jean@example.test',
            'mailable_class' => FundingRequestReceivedApplicantMail::class,
            'status' => EmailNotification::STATUS_SENT,
        ]);

        $this->assertDatabaseHas('email_notifications', [
            'funding_request_id' => $fundingRequest->id,
            'recipient_email' => $admin->email,
            'mailable_class' => FundingRequestReceivedAdminMail::class,
            'status' => EmailNotification::STATUS_SENT,
        ]);
    }

    public function test_customer_cannot_submit_twice_with_same_email(): void
    {
        FundingRequest::factory()->create([
            'email' => 'client@example.test',
            'phone_prefix' => '+33',
            'phone' => '612345678',
        ]);

        $response = $this->from(route('funding-request.create', ['locale' => 'fr']))
            ->post(route('funding-request.store', ['locale' => 'fr']), [
                'full_name' => 'Jean Dupont',
                'country' => 'France',
                'address' => '10 rue de Paris, 75001 Paris',
                'email' => 'client@example.test',
                'phone_prefix' => '+33',
                'phone' => '699999999',
                'current_situation' => FundingRequest::CURRENT_SITUATION_SALARIED,
                'monthly_income_approx' => '1800 EUR',
                'family_situation' => FundingRequest::FAMILY_SINGLE,
                'amount_requested' => 50000,
                'need_type' => FundingRequest::NEED_PERSONAL,
                'situation' => 'Nouvelle demande',
                'declare_accurate' => '1',
            ]);

        $response->assertRedirect(route('funding-request.create', ['locale' => 'fr']));
        $response->assertSessionHasErrors('email');
        $this->assertSame(1, FundingRequest::query()->count());
    }

    public function test_customer_cannot_submit_twice_with_same_phone_even_if_format_changes(): void
    {
        FundingRequest::factory()->create([
            'email' => 'existing@example.test',
            'phone_prefix' => '+33',
            'phone' => '612345678',
        ]);

        $response = $this->from(route('funding-request.create', ['locale' => 'fr']))
            ->post(route('funding-request.store', ['locale' => 'fr']), [
                'full_name' => 'Jean Dupont',
                'country' => 'France',
                'address' => '10 rue de Paris, 75001 Paris',
                'email' => 'new@example.test',
                'phone_prefix' => '+33',
                'phone' => '6 12 34 56 78',
                'current_situation' => FundingRequest::CURRENT_SITUATION_SALARIED,
                'monthly_income_approx' => '1800 EUR',
                'family_situation' => FundingRequest::FAMILY_SINGLE,
                'amount_requested' => 50000,
                'need_type' => FundingRequest::NEED_PERSONAL,
                'situation' => 'Nouvelle demande',
                'declare_accurate' => '1',
            ]);

        $response->assertRedirect(route('funding-request.create', ['locale' => 'fr']));
        $response->assertSessionHasErrors('phone');
        $this->assertSame(1, FundingRequest::query()->count());
    }

    public function test_documents_upload_can_complete_a_dossier(): void
    {
        Storage::fake('local');
        Mail::fake();

        $fundingRequest = FundingRequest::factory()->create([
            'status' => FundingRequest::STATUS_AWAITING_DOCUMENTS,
            'identity_document_type' => FundingRequest::IDENTITY_DOCUMENT_ID_CARD,
        ]);
        $admin = User::factory()->create([
            'is_admin' => true,
            'email' => 'admin-documents@example.test',
        ]);
        config(['admin.notification_email' => $admin->email]);

        $response = $this->post(route('funding-request.documents.store', [
            'locale' => 'fr',
            'public_slug' => $fundingRequest->public_slug,
        ]), [
            'identity_document_type' => FundingRequest::IDENTITY_DOCUMENT_ID_CARD,
            'doc_id_front' => UploadedFile::fake()->image('front.jpg'),
            'doc_id_back' => UploadedFile::fake()->image('back.jpg'),
            'doc_situation' => UploadedFile::fake()->create('situation.pdf', 120, 'application/pdf'),
        ]);

        $fundingRequest->refresh();

        $response->assertRedirect(route('funding-request.success', [
            'locale' => 'fr',
            'public_slug' => $fundingRequest->public_slug,
            'context' => 'documents',
        ]));

        $this->assertSame(FundingRequest::STATUS_DOCUMENTS_RECEIVED, $fundingRequest->status);
        $this->assertNotNull($fundingRequest->doc_id_front_path);
        $this->assertNotNull($fundingRequest->doc_id_back_path);
        $this->assertNotNull($fundingRequest->doc_situation_path);
        Storage::disk('local')->assertExists($fundingRequest->doc_id_front_path);
        Storage::disk('local')->assertExists($fundingRequest->doc_id_back_path);

        Mail::assertSent(FundingDocumentsReceivedAdminMail::class, function ($mail) use ($admin, $fundingRequest) {
            return $mail->hasTo($admin->email)
                && $mail->fundingRequest->is($fundingRequest);
        });

        $this->assertDatabaseHas('email_notifications', [
            'funding_request_id' => $fundingRequest->id,
            'recipient_email' => $admin->email,
            'mailable_class' => FundingDocumentsReceivedAdminMail::class,
            'status' => EmailNotification::STATUS_SENT,
        ]);
    }

    public function test_admin_can_refuse_with_reason_and_reactivate(): void
    {
        Mail::fake();
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $fundingRequest = FundingRequest::factory()->create([
            'status' => FundingRequest::STATUS_PENDING,
        ]);

        $refuseResponse = $this->actingAs($admin)
            ->post(route('admin.funding-requests.refuse', [
                'locale' => 'fr',
                'fundingRequest' => $fundingRequest,
            ]), [
                'refused_reason' => 'Le dossier ne remplit pas les conditions actuelles du programme.',
            ]);

        $fundingRequest->refresh();

        $refuseResponse->assertSessionHasNoErrors();
        $this->assertSame(FundingRequest::STATUS_REFUSED, $fundingRequest->status);
        $this->assertSame('Le dossier ne remplit pas les conditions actuelles du programme.', $fundingRequest->refused_reason);

        Mail::assertSent(FundingRequestRefusedMail::class, function ($mail) use ($fundingRequest) {
            return $mail->hasTo($fundingRequest->email);
        });

        $reactivateResponse = $this->actingAs($admin)
            ->post(route('admin.funding-requests.reactivate', [
                'locale' => 'fr',
                'fundingRequest' => $fundingRequest,
            ]));

        $fundingRequest->refresh();

        $reactivateResponse->assertSessionHasNoErrors();
        $this->assertSame(FundingRequest::STATUS_PENDING, $fundingRequest->status);
        $this->assertNull($fundingRequest->refused_reason);
    }

    public function test_admin_can_update_requested_amount(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $fundingRequest = FundingRequest::factory()->create([
            'amount_requested' => 50000,
        ]);

        $setResponse = $this->actingAs($admin)
            ->post(route('admin.funding-requests.update-amount', [
                'locale' => 'fr',
                'fundingRequest' => $fundingRequest,
            ]), [
                'adjustment_type' => 'set',
                'amount_value' => '65000',
            ]);

        $fundingRequest->refresh();

        $setResponse->assertSessionHasNoErrors();
        $this->assertSame('65000.00', $fundingRequest->amount_requested);
        $this->assertSame(1, FundingRequestFinancialChange::query()->count());

        $setChange = FundingRequestFinancialChange::query()->first();
        $this->assertTrue($setChange->fundingRequest->is($fundingRequest));
        $this->assertTrue($setChange->admin->is($admin));
        $this->assertSame(FundingRequestFinancialChange::FIELD_AMOUNT_REQUESTED, $setChange->field);
        $this->assertSame(FundingRequestFinancialChange::ACTION_SET, $setChange->action);
        $this->assertSame('50000.00', $setChange->old_amount);
        $this->assertSame('65000.00', $setChange->new_amount);
        $this->assertSame('15000.00', $setChange->delta_amount);

        $increaseResponse = $this->actingAs($admin)
            ->post(route('admin.funding-requests.update-amount', [
                'locale' => 'fr',
                'fundingRequest' => $fundingRequest,
            ]), [
                'adjustment_type' => 'increase',
                'amount_value' => '2500',
            ]);

        $fundingRequest->refresh();

        $increaseResponse->assertSessionHasNoErrors();
        $this->assertSame('67500.00', $fundingRequest->amount_requested);
        $this->assertSame(2, FundingRequestFinancialChange::query()->count());

        $increaseChange = FundingRequestFinancialChange::query()->orderByDesc('id')->first();
        $this->assertSame(FundingRequestFinancialChange::FIELD_AMOUNT_REQUESTED, $increaseChange->field);
        $this->assertSame(FundingRequestFinancialChange::ACTION_INCREASE, $increaseChange->action);
        $this->assertSame('65000.00', $increaseChange->old_amount);
        $this->assertSame('67500.00', $increaseChange->new_amount);
        $this->assertSame('2500.00', $increaseChange->delta_amount);
    }

    public function test_admin_can_update_administrative_fees_and_record_history(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $fundingRequest = FundingRequest::factory()->create([
            'administrative_fees' => 150,
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.funding-requests.update-fees', [
                'locale' => 'fr',
                'fundingRequest' => $fundingRequest,
            ]), [
                'administrative_fees' => '275',
            ]);

        $fundingRequest->refresh();

        $response->assertSessionHasNoErrors();
        $this->assertSame('275.00', $fundingRequest->administrative_fees);

        $change = FundingRequestFinancialChange::query()->first();
        $this->assertNotNull($change);
        $this->assertSame(FundingRequestFinancialChange::FIELD_ADMINISTRATIVE_FEES, $change->field);
        $this->assertSame(FundingRequestFinancialChange::ACTION_SET, $change->action);
        $this->assertSame('150.00', $change->old_amount);
        $this->assertSame('275.00', $change->new_amount);
        $this->assertSame('125.00', $change->delta_amount);

        $showResponse = $this->actingAs($admin)
            ->get(route('admin.funding-requests.show', [
                'locale' => 'fr',
                'fundingRequest' => $fundingRequest,
            ]));

        $showResponse->assertOk();
        $showResponse->assertSee('Historique financier');
        $showResponse->assertSee('Frais de dossier');
    }

    public function test_admin_can_browse_and_update_database_rows(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $fundingRequest = FundingRequest::factory()->create([
            'amount_requested' => 50000,
            'admin_notes' => null,
        ]);

        $indexResponse = $this->actingAs($admin)
            ->get(route('admin.database.index', ['locale' => 'fr']));

        $indexResponse->assertOk();
        $indexResponse->assertSee('funding_requests');

        $tableResponse = $this->actingAs($admin)
            ->get(route('admin.database.table', [
                'locale' => 'fr',
                'table' => 'funding_requests',
            ]));

        $tableResponse->assertOk();
        $tableResponse->assertSee($fundingRequest->dossier_number);

        $updateResponse = $this->actingAs($admin)
            ->put(route('admin.database.update', [
                'locale' => 'fr',
                'table' => 'funding_requests',
                'record' => $fundingRequest->id,
            ]), [
                'values' => [
                    'amount_requested' => '72000.00',
                    'admin_notes' => 'Correction directe via la base.',
                ],
            ]);

        $fundingRequest->refresh();

        $updateResponse->assertSessionHasNoErrors();
        $this->assertSame('72000.00', $fundingRequest->amount_requested);
        $this->assertSame('Correction directe via la base.', $fundingRequest->admin_notes);
    }

    public function test_admin_dashboard_highlights_priorities_without_overloading(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $pendingRequest = FundingRequest::factory()->create([
            'status' => FundingRequest::STATUS_PENDING,
            'full_name' => 'Client à examiner',
        ]);

        FundingRequest::factory()->create([
            'status' => FundingRequest::STATUS_DOCUMENTS_RECEIVED,
        ]);

        EmailNotification::query()->create([
            'funding_request_id' => $pendingRequest->id,
            'recipient_email' => 'admin@example.test',
            'recipient_type' => EmailNotification::RECIPIENT_ADMIN,
            'mailable_class' => FundingDocumentsReceivedAdminMail::class,
            'subject' => 'Documents reçus',
            'locale' => 'fr',
            'status' => EmailNotification::STATUS_FAILED,
            'attempts' => 1,
            'last_error' => 'SMTP indisponible',
            'last_attempt_at' => now(),
        ]);

        $response = $this->actingAs($admin)
            ->get(route('admin.dashboard', ['locale' => 'fr']));

        $response->assertOk();
        $response->assertSee('Actions prioritaires');
        $response->assertSee('Demandes à examiner');
        $response->assertSee('Dossiers complets');
        $response->assertSee('Emails échoués');
        $response->assertSee('Pièces reçues');
    }

    public function test_admin_can_view_and_retry_failed_email_notifications(): void
    {
        Mail::fake();

        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $fundingRequest = FundingRequest::factory()->create([
            'status' => FundingRequest::STATUS_DOCUMENTS_RECEIVED,
        ]);

        $notification = EmailNotification::query()->create([
            'funding_request_id' => $fundingRequest->id,
            'recipient_email' => 'admin-docs@example.test',
            'recipient_type' => EmailNotification::RECIPIENT_ADMIN,
            'mailable_class' => FundingDocumentsReceivedAdminMail::class,
            'subject' => 'Documents reçus',
            'locale' => 'fr',
            'status' => EmailNotification::STATUS_FAILED,
            'attempts' => 1,
            'last_error' => 'SMTP indisponible',
            'last_attempt_at' => now(),
        ]);

        $indexResponse = $this->actingAs($admin)
            ->get(route('admin.email-notifications.index', ['locale' => 'fr']));

        $indexResponse->assertOk();
        $indexResponse->assertSee('Notifications e-mail');
        $indexResponse->assertSee('SMTP indisponible');
        $indexResponse->assertSee('Renvoyer');

        $retryResponse = $this->from(route('admin.email-notifications.index', ['locale' => 'fr']))
            ->actingAs($admin)
            ->post(route('admin.email-notifications.retry', [
                'locale' => 'fr',
                'emailNotification' => $notification,
            ]));

        $notification->refresh();

        $retryResponse->assertRedirect(route('admin.email-notifications.index', ['locale' => 'fr']));
        $retryResponse->assertSessionHasNoErrors();
        $this->assertSame(EmailNotification::STATUS_SENT, $notification->status);
        $this->assertSame(2, $notification->attempts);
        $this->assertNull($notification->last_error);
        $this->assertNotNull($notification->sent_at);

        Mail::assertSent(FundingDocumentsReceivedAdminMail::class, function ($mail) use ($fundingRequest) {
            return $mail->hasTo('admin-docs@example.test')
                && $mail->fundingRequest->is($fundingRequest);
        });
    }

    public function test_admin_can_send_preliminary_validation_and_move_dossier_to_documents_stage(): void
    {
        Mail::fake();

        $admin = User::factory()->create([
            'is_admin' => true,
            'email' => 'admin@example.test',
        ]);
        config(['admin.notification_email' => $admin->email]);

        $fundingRequest = FundingRequest::factory()->create([
            'status' => FundingRequest::STATUS_PENDING,
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.funding-requests.preliminary', [
                'locale' => 'fr',
                'fundingRequest' => $fundingRequest,
            ]));

        $fundingRequest->refresh();

        $response->assertSessionHasNoErrors();
        $this->assertSame(FundingRequest::STATUS_AWAITING_DOCUMENTS, $fundingRequest->status);

        Mail::assertSent(FundingPreliminaryAcceptedMail::class, function ($mail) use ($fundingRequest) {
            return $mail->hasTo($fundingRequest->email);
        });

        Mail::assertSent(FundingPreliminarySentAdminMail::class, function ($mail) use ($admin) {
            return $mail->hasTo($admin->email);
        });
    }

    public function test_admin_cannot_refuse_a_dossier_without_reason(): void
    {
        Mail::fake();

        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $fundingRequest = FundingRequest::factory()->create([
            'status' => FundingRequest::STATUS_PENDING,
        ]);

        $response = $this->from(route('admin.funding-requests.show', [
                'locale' => 'fr',
                'fundingRequest' => $fundingRequest,
            ]))
            ->actingAs($admin)
            ->post(route('admin.funding-requests.refuse', [
                'locale' => 'fr',
                'fundingRequest' => $fundingRequest,
            ]), [
                'refused_reason' => '',
            ]);

        $fundingRequest->refresh();

        $response->assertRedirect(route('admin.funding-requests.show', [
            'locale' => 'fr',
            'fundingRequest' => $fundingRequest,
        ]));
        $response->assertSessionHasErrors('refused_reason');
        $this->assertSame(FundingRequest::STATUS_PENDING, $fundingRequest->status);
        $this->assertNull($fundingRequest->refused_reason);
        Mail::assertNothingSent();
    }

    public function test_admin_can_grant_donation_when_documents_are_complete(): void
    {
        Storage::fake('local');
        Mail::fake();

        $admin = User::factory()->create([
            'is_admin' => true,
            'email' => 'admin@example.test',
        ]);
        config(['admin.notification_email' => $admin->email]);

        $fundingRequest = FundingRequest::factory()->create([
            'status' => FundingRequest::STATUS_DOCUMENTS_RECEIVED,
            'locale' => 'es',
            'doc_id_front_path' => 'funding-documents/front.jpg',
            'doc_id_back_path' => 'funding-documents/back.jpg',
            'doc_situation_path' => 'funding-documents/situation.pdf',
            'identity_document_type' => FundingRequest::IDENTITY_DOCUMENT_ID_CARD,
        ]);

        Storage::disk('local')->put($fundingRequest->doc_id_front_path, 'front');
        Storage::disk('local')->put($fundingRequest->doc_id_back_path, 'back');
        Storage::disk('local')->put($fundingRequest->doc_situation_path, 'situation');

        $this->mock(DonationActPdfService::class, function (MockInterface $mock) use ($fundingRequest) {
            $mock->shouldReceive('generateAndStore')
                ->once()
                ->withArgs(function (FundingRequest $request, ?string $locale) use ($fundingRequest) {
                    return $request->is($fundingRequest) && $locale === 'es';
                })
                ->andReturn('donation-acts/test-act.pdf');
        });

        Storage::disk('local')->put('donation-acts/test-act.pdf', 'fake pdf');

        $response = $this->actingAs($admin)
            ->post(route('admin.funding-requests.send-act', [
                'locale' => 'fr',
                'fundingRequest' => $fundingRequest,
            ]));

        $fundingRequest->refresh();

        $response->assertSessionHasNoErrors();
        $this->assertSame(FundingRequest::STATUS_DONATION_ACT_SENT, $fundingRequest->status);
        $this->assertSame('donation-acts/test-act.pdf', $fundingRequest->donation_act_path);

        Mail::assertSent(FundingDonationActMail::class, function ($mail) use ($fundingRequest) {
            return $mail->hasTo($fundingRequest->email);
        });

        Mail::assertSent(FundingDonationActSentAdminMail::class, function ($mail) use ($admin) {
            return $mail->hasTo($admin->email);
        });
    }

    public function test_admin_cannot_refuse_an_already_archived_dossier(): void
    {
        Mail::fake();

        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $fundingRequest = FundingRequest::factory()->create([
            'status' => FundingRequest::STATUS_REFUSED,
            'refused_reason' => 'Motif existant',
        ]);

        $response = $this->from(route('admin.funding-requests.show', [
                'locale' => 'fr',
                'fundingRequest' => $fundingRequest,
            ]))
            ->actingAs($admin)
            ->post(route('admin.funding-requests.refuse', [
                'locale' => 'fr',
                'fundingRequest' => $fundingRequest,
            ]), [
                'refused_reason' => 'Nouveau motif',
            ]);

        $fundingRequest->refresh();

        $response->assertRedirect(route('admin.funding-requests.show', [
            'locale' => 'fr',
            'fundingRequest' => $fundingRequest,
        ]));
        $response->assertSessionHasErrors('flow');
        $this->assertSame(FundingRequest::STATUS_REFUSED, $fundingRequest->status);
        $this->assertSame('Motif existant', $fundingRequest->refused_reason);
        Mail::assertNothingSent();
    }

    public function test_admin_cannot_refuse_a_closed_dossier(): void
    {
        Mail::fake();

        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $fundingRequest = FundingRequest::factory()->create([
            'status' => FundingRequest::STATUS_CLOSED,
        ]);

        $response = $this->from(route('admin.funding-requests.show', [
                'locale' => 'fr',
                'fundingRequest' => $fundingRequest,
            ]))
            ->actingAs($admin)
            ->post(route('admin.funding-requests.refuse', [
                'locale' => 'fr',
                'fundingRequest' => $fundingRequest,
            ]), [
                'refused_reason' => 'Refus tardif',
            ]);

        $fundingRequest->refresh();

        $response->assertRedirect(route('admin.funding-requests.show', [
            'locale' => 'fr',
            'fundingRequest' => $fundingRequest,
        ]));
        $response->assertSessionHasErrors('flow');
        $this->assertSame(FundingRequest::STATUS_CLOSED, $fundingRequest->status);
        $this->assertNull($fundingRequest->refused_reason);
        Mail::assertNothingSent();
    }

    public function test_admin_cannot_reactivate_a_non_archived_dossier(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $fundingRequest = FundingRequest::factory()->create([
            'status' => FundingRequest::STATUS_AWAITING_DOCUMENTS,
        ]);

        $response = $this->from(route('admin.funding-requests.show', [
                'locale' => 'fr',
                'fundingRequest' => $fundingRequest,
            ]))
            ->actingAs($admin)
            ->post(route('admin.funding-requests.reactivate', [
                'locale' => 'fr',
                'fundingRequest' => $fundingRequest,
            ]));

        $fundingRequest->refresh();

        $response->assertRedirect(route('admin.funding-requests.show', [
            'locale' => 'fr',
            'fundingRequest' => $fundingRequest,
        ]));
        $response->assertSessionHasErrors('flow');
        $this->assertSame(FundingRequest::STATUS_AWAITING_DOCUMENTS, $fundingRequest->status);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\FundingDonationActSentAdminMail;
use App\Mail\FundingDonationActMail;
use App\Mail\FundingPreliminaryAcceptedMail;
use App\Mail\FundingPreliminarySentAdminMail;
use App\Mail\FundingRequestClosedMail;
use App\Mail\FundingRequestRefusedMail;
use App\Models\EmailNotification;
use App\Models\FundingRequest;
use App\Models\FundingRequestFinancialChange;
use App\Services\DonationActPdfService;
use App\Services\TrackedMailService;
use App\Support\FundingRequestAdminMessages;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response as ResponseFactory;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class FundingRequestAdminController extends Controller
{
    public function __construct(private TrackedMailService $mailService)
    {
    }

    private function workflowStageConfigs(): array
    {
        return [
            'review' => [
                'title' => 'Demandes à examiner',
                'intro' => 'Les nouvelles demandes qui attendent un premier retour de votre part.',
                'statuses' => [FundingRequest::STATUS_PENDING],
                'empty' => 'Aucune nouvelle demande à examiner pour le moment.',
                'primary_action' => 'preliminary',
                'primary_label' => 'Valider la demande',
            ],
            'documents' => [
                'title' => 'Pièces à compléter ou vérifier',
                'intro' => 'Les clients peuvent encore déposer leurs fichiers. Quand les pièces sont complètes, validez-les ici avant la décision finale.',
                'statuses' => [FundingRequest::STATUS_AWAITING_DOCUMENTS, FundingRequest::STATUS_PRELIMINARY_ACCEPTED],
                'empty' => 'Aucun dossier à compléter ou vérifier pour le moment.',
                'primary_action' => 'documents',
                'primary_label' => 'Vérifier les pièces',
            ],
            'decision' => [
                'title' => 'Pièces validées',
                'intro' => 'Les demandes prêtes pour la confirmation finale.',
                'statuses' => [FundingRequest::STATUS_DOCUMENTS_RECEIVED],
                'empty' => 'Aucun dossier validé à traiter pour le moment.',
                'primary_action' => 'send_act',
                'primary_label' => 'Accorder le don',
            ],
            'closing' => [
                'title' => 'Dossiers à finaliser',
                'intro' => 'Les demandes déjà confirmées qui restent à clôturer côté plateforme.',
                'statuses' => [FundingRequest::STATUS_DONATION_ACT_SENT],
                'empty' => 'Aucun dossier à finaliser pour le moment.',
                'primary_action' => 'close',
                'primary_label' => 'Clôturer la demande',
            ],
        ];
    }

    public function dashboard(string $locale)
    {
        $grouped = FundingRequest::query()
            ->selectRaw('status, COUNT(*) as c')
            ->groupBy('status')
            ->pluck('c', 'status');

        $statusCards = collect(FundingRequest::statusLabels())
            ->map(function (string $label, string $status) use ($grouped) {
                return [
                    'status' => $status,
                    'label' => $label,
                    'count' => (int) ($grouped[$status] ?? 0),
                ];
            })
            ->values();

        $totalCount = FundingRequest::query()->count();
        $failedEmailCount = Schema::hasTable('email_notifications')
            ? EmailNotification::query()->where('status', EmailNotification::STATUS_FAILED)->count()
            : 0;
        $recentRequests = FundingRequest::query()
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        return view('admin.dashboard', [
            'statusCards' => $statusCards,
            'totalCount' => $totalCount,
            'failedEmailCount' => $failedEmailCount,
            'recentRequests' => $recentRequests,
            'adminActive' => 'dashboard',
        ]);
    }

    public function workflow(string $locale, string $stage)
    {
        $configs = $this->workflowStageConfigs();

        abort_unless(isset($configs[$stage]), 404);

        $config = $configs[$stage];

        $requests = FundingRequest::query()
            ->whereIn('status', $config['statuses'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.workflow-stage', [
            'stageKey' => $stage,
            'stageConfig' => $config,
            'requests' => $requests,
            'adminActive' => 'dashboard',
        ]);
    }

    public function index(string $locale, Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $status = trim((string) $request->get('status', ''));

        $query = FundingRequest::query()->orderByDesc('created_at');

        if ($status !== '' && array_key_exists($status, FundingRequest::statusLabels())) {
            $query->where('status', $status);
        }

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('dossier_number', 'like', '%'.$q.'%')
                    ->orWhere('public_slug', 'like', '%'.$q.'%')
                    ->orWhere('email', 'like', '%'.$q.'%')
                    ->orWhere('full_name', 'like', '%'.$q.'%')
                    ->orWhere('phone', 'like', '%'.$q.'%');
            });
        }

        $requests = $query->paginate(20)->withQueryString();

        return view('admin.funding-requests.index', [
            'requests' => $requests,
            'q' => $q,
            'status' => $status,
            'adminActive' => 'demandes',
        ]);
    }

    public function contacts(string $locale, Request $request)
    {
        $contacts = FundingRequest::query()
            ->selectRaw('MIN(id) as id, full_name, email, phone_prefix, phone, COUNT(*) as requests_count, MAX(created_at) as last_request_at')
            ->where(function ($sub) {
                $sub->where('full_name', '!=', '')
                    ->orWhere('email', '!=', '')
                    ->orWhere('phone', '!=', '');
            });

        $contacts = $contacts
            ->groupBy('full_name', 'email', 'phone_prefix', 'phone')
            ->orderByDesc('last_request_at')
            ->paginate(25)
            ->withQueryString();

        return view('admin.contacts', [
            'contacts' => $contacts,
            'adminActive' => 'infos',
        ]);
    }

    public function exportContacts(string $locale)
    {
        $contacts = FundingRequest::query()
            ->selectRaw('full_name, email, phone_prefix, phone, MAX(created_at) as last_request_at')
            ->where(function ($sub) {
                $sub->where('full_name', '!=', '')
                    ->orWhere('email', '!=', '')
                    ->orWhere('phone', '!=', '');
            })
            ->groupBy('full_name', 'email', 'phone_prefix', 'phone')
            ->orderBy('full_name')
            ->get();

        $filename = 'infos-contacts-'.now()->format('Y-m-d-His').'.csv';

        return response()->streamDownload(function () use ($contacts) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['Nom complet', 'E-mail', 'Téléphone']);

            foreach ($contacts as $contact) {
                fputcsv($handle, [
                    (string) ($contact->full_name ?: ''),
                    (string) ($contact->email ?: ''),
                    $contact->phone_display,
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function show(string $locale, FundingRequest $fundingRequest)
    {
        $fundingRequest->refresh();
        $financialChanges = $fundingRequest->financialChanges()
            ->with('admin')
            ->latest('id')
            ->limit(12)
            ->get();

        return view('admin.funding-requests.show', [
            'fr' => $fundingRequest,
            'financialChanges' => $financialChanges,
            'adminMessages' => FundingRequestAdminMessages::for($fundingRequest),
            'adminActive' => 'demandes',
        ]);
    }

    public function updateNotes(string $locale, Request $request, FundingRequest $fundingRequest)
    {
        $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:20000'],
        ]);

        $fundingRequest->admin_notes = $request->input('admin_notes');
        $fundingRequest->save();

        return back()->with('ok', 'Notes enregistrées.');
    }

    public function sendPreliminaryAccepted(string $locale, FundingRequest $fundingRequest)
    {
        if (! in_array($fundingRequest->status, [FundingRequest::STATUS_PENDING], true)) {
            return back()->withErrors(['flow' => 'Cette action n’est possible que pour un dossier en attente initiale.']);
        }

        try {
            $this->mailService->sendFundingRequestMail(
                $fundingRequest->email,
                new FundingPreliminaryAcceptedMail($fundingRequest),
                $fundingRequest,
                EmailNotification::RECIPIENT_APPLICANT,
                $fundingRequest->preferredLocale(),
                true
            );
        } catch (Throwable $exception) {
            return back()->withErrors([
                'mail' => 'Impossible d’envoyer l’e-mail au demandeur. L’échec est enregistré dans Notifications. Détail : '.$exception->getMessage(),
            ]);
        }

        // Le statut doit évoluer dès que le demandeur a reçu l’e-mail.
        // On ne bloque pas cette transition si la copie admin échoue.
        $fundingRequest->status = FundingRequest::STATUS_AWAITING_DOCUMENTS;
        $fundingRequest->save();

        $adminNotified = false;
        $adminEmail = config('admin.notification_email');
        if ($adminEmail) {
            $adminNotification = $this->mailService->sendFundingRequestMail(
                $adminEmail,
                new FundingPreliminarySentAdminMail($fundingRequest->fresh()),
                $fundingRequest->fresh(),
                EmailNotification::RECIPIENT_ADMIN,
                'fr'
            );
            $adminNotified = $adminNotification->status === EmailNotification::STATUS_SENT;
        }

        return back()->with('ok', 'Validation préliminaire envoyée au demandeur'.($adminNotified ? ' et notification envoyée à l’équipe.' : '.'));
    }

    public function markDocumentsReceived(string $locale, FundingRequest $fundingRequest)
    {
        if (! in_array($fundingRequest->status, [
            FundingRequest::STATUS_AWAITING_DOCUMENTS,
            FundingRequest::STATUS_PRELIMINARY_ACCEPTED,
            FundingRequest::STATUS_DOCUMENTS_RECEIVED,
        ], true)) {
            return back()->withErrors(['flow' => 'Cette étape n’est disponible qu’après la validation préliminaire.']);
        }

        if (! $fundingRequest->documentsComplete()) {
            return back()->withErrors(['flow' => 'Impossible de valider les pièces : certains documents obligatoires sont manquants.']);
        }

        if ($fundingRequest->status !== FundingRequest::STATUS_DOCUMENTS_RECEIVED) {
            $fundingRequest->status = FundingRequest::STATUS_DOCUMENTS_RECEIVED;
            $fundingRequest->save();
        }

        return back()->with('ok', 'Pièces validées : le dossier est prêt pour la décision finale.');
    }

    public function requestDocumentsCorrection(string $locale, FundingRequest $fundingRequest)
    {
        if (! in_array($fundingRequest->status, [
            FundingRequest::STATUS_AWAITING_DOCUMENTS,
            FundingRequest::STATUS_PRELIMINARY_ACCEPTED,
            FundingRequest::STATUS_DOCUMENTS_RECEIVED,
        ], true)) {
            return back()->withErrors(['flow' => 'Cette action n’est disponible que pendant la vérification des pièces.']);
        }

        $disk = Storage::disk('local');
        foreach ([
            'doc_passport_path',
            'doc_id_front_path',
            'doc_id_back_path',
            'doc_id_path',
            'doc_situation_path',
        ] as $column) {
            $path = $fundingRequest->{$column};
            if ($path && $disk->exists($path)) {
                $disk->delete($path);
            }
            $fundingRequest->{$column} = null;
        }

        $fundingRequest->status = FundingRequest::STATUS_AWAITING_DOCUMENTS;
        $fundingRequest->save();

        return back()->with('ok', 'Pièces marquées à refaire : le lien de dépôt est de nouveau accessible au client.');
    }

    public function decideDocuments(string $locale, Request $request, FundingRequest $fundingRequest)
    {
        $validated = $request->validate([
            'documents_decision' => ['required', Rule::in(['valid', 'correction'])],
        ]);

        if ($validated['documents_decision'] === 'valid') {
            return $this->markDocumentsReceived($locale, $fundingRequest);
        }

        return $this->requestDocumentsCorrection($locale, $fundingRequest);
    }

    public function generateAndSendDonationAct(string $locale, FundingRequest $fundingRequest, DonationActPdfService $pdf)
    {
        $fundingRequest->refresh();

        if (! in_array($fundingRequest->status, [
            FundingRequest::STATUS_DOCUMENTS_RECEIVED,
            FundingRequest::STATUS_DONATION_ACT_SENT,
        ], true)) {
            return back()->withErrors(['flow' => 'Les pièces justificatives doivent être déposées puis validées par l’admin avant de générer l’acte de donation.']);
        }

        $path = $pdf->generateAndStore($fundingRequest, $fundingRequest->preferredLocale());
        $fundingRequest->donation_act_path = $path;
        $fundingRequest->status = FundingRequest::STATUS_DONATION_ACT_SENT;
        $fundingRequest->donation_act_generated_at = now();
        $fundingRequest->save();

        try {
            $this->mailService->sendFundingRequestMail(
                $fundingRequest->email,
                new FundingDonationActMail($fundingRequest->fresh()),
                $fundingRequest->fresh(),
                EmailNotification::RECIPIENT_APPLICANT,
                $fundingRequest->preferredLocale(),
                true
            );
        } catch (Throwable $exception) {
            return back()->withErrors([
                'mail' => 'Le document a été généré, mais l’e-mail au client a échoué. L’échec est enregistré dans Notifications. Détail : '.$exception->getMessage(),
            ]);
        }
        $adminEmail = config('admin.notification_email');
        if ($adminEmail) {
            $this->mailService->sendFundingRequestMail(
                $adminEmail,
                new FundingDonationActSentAdminMail($fundingRequest->fresh()),
                $fundingRequest->fresh(),
                EmailNotification::RECIPIENT_ADMIN,
                'fr'
            );
        }

        return back()->with('ok', 'Don accordé : le document a été généré et envoyé au client'.($adminEmail ? ' et la notification interne a bien été transmise.' : '.'));
    }

    public function refuse(string $locale, FundingRequest $fundingRequest)
    {
        if (in_array($fundingRequest->status, [
            FundingRequest::STATUS_REFUSED,
            FundingRequest::STATUS_CLOSED,
        ], true)) {
            return back()->withErrors(['flow' => 'Ce dossier ne peut plus être refusé dans son état actuel.']);
        }

        request()->validate([
            'refused_reason' => ['required', 'string', 'min:5', 'max:5000'],
        ], [
            'refused_reason.required' => 'Merci d’indiquer un motif de refus.',
            'refused_reason.min' => 'Le motif de refus doit contenir au moins 5 caractères.',
        ]);

        $fundingRequest->refused_reason = trim((string) request('refused_reason'));
        $fundingRequest->save();

        try {
            $this->mailService->sendFundingRequestMail(
                $fundingRequest->email,
                new FundingRequestRefusedMail($fundingRequest),
                $fundingRequest,
                EmailNotification::RECIPIENT_APPLICANT,
                $fundingRequest->preferredLocale(),
                true
            );
        } catch (Throwable $exception) {
            return back()->withErrors([
                'mail' => 'Le refus n’a pas pu être envoyé par e-mail. L’échec est enregistré dans Notifications. Détail : '.$exception->getMessage(),
            ]);
        }

        $fundingRequest->status = FundingRequest::STATUS_REFUSED;
        $fundingRequest->save();

        return back()->with('ok', 'Le dossier a été refusé, archivé et le client a été informé par e-mail.');
    }

    public function reactivate(string $locale, FundingRequest $fundingRequest)
    {
        if ($fundingRequest->status !== FundingRequest::STATUS_REFUSED) {
            return back()->withErrors(['flow' => 'Seuls les dossiers archivés après refus peuvent être réactivés.']);
        }

        $fundingRequest->status = FundingRequest::STATUS_PENDING;
        $fundingRequest->refused_reason = null;
        $fundingRequest->save();

        return back()->with('ok', 'Le dossier a été réactivé et remis dans les demandes à examiner.');
    }

    public function updateAdministrativeFees(string $locale, Request $request, FundingRequest $fundingRequest)
    {
        $validated = $request->validate([
            'administrative_fees' => ['required', 'numeric', 'min:0', 'max:999999.99'],
        ]);

        $oldAmount = $this->decimalString($fundingRequest->administrative_fees ?? FundingRequest::ADMINISTRATIVE_FEES);
        $newAmount = $this->decimalString($validated['administrative_fees']);

        if ($oldAmount === $newAmount) {
            return back()->with('ok', 'Frais administratifs inchangés.');
        }

        DB::transaction(function () use ($fundingRequest, $oldAmount, $newAmount) {
            $fundingRequest->administrative_fees = $newAmount;
            $fundingRequest->save();

            $this->recordFinancialChange(
                $fundingRequest,
                FundingRequestFinancialChange::FIELD_ADMINISTRATIVE_FEES,
                FundingRequestFinancialChange::ACTION_SET,
                $oldAmount,
                $newAmount
            );
        });

        return back()->with('ok', 'Frais administratifs mis à jour avec succès.');
    }

    public function updateRequestedAmount(string $locale, Request $request, FundingRequest $fundingRequest)
    {
        $validated = $request->validate([
            'adjustment_type' => ['required', Rule::in(['set', 'increase'])],
            'amount_value' => ['required', 'numeric', 'min:0.01', 'max:999999999.99'],
        ], [
            'amount_value.required' => 'Indiquez le montant à appliquer.',
            'amount_value.min' => 'Le montant doit être supérieur à zéro.',
        ]);

        $oldAmount = $fundingRequest->amount_requested === null
            ? null
            : $this->decimalString($fundingRequest->amount_requested);
        $currentAmount = (float) ($oldAmount ?? 0);
        $value = (float) $validated['amount_value'];
        $newAmount = $validated['adjustment_type'] === 'increase'
            ? $currentAmount + $value
            : $value;

        if ($newAmount > 999999999.99) {
            return back()->withErrors(['amount_value' => 'Le montant final est trop élevé.']);
        }

        $newAmount = $this->decimalString($newAmount);

        if ($oldAmount !== null && $oldAmount === $newAmount) {
            return back()->with('ok', 'Montant demandé inchangé.');
        }

        DB::transaction(function () use ($fundingRequest, $validated, $oldAmount, $newAmount) {
            $fundingRequest->amount_requested = $newAmount;
            $fundingRequest->save();

            $this->recordFinancialChange(
                $fundingRequest,
                FundingRequestFinancialChange::FIELD_AMOUNT_REQUESTED,
                $validated['adjustment_type'],
                $oldAmount,
                $newAmount
            );
        });

        $message = $validated['adjustment_type'] === 'increase'
            ? 'Montant demandé augmenté avec succès.'
            : 'Montant demandé mis à jour avec succès.';

        return back()->with('ok', $message);
    }

    private function recordFinancialChange(
        FundingRequest $fundingRequest,
        string $field,
        string $action,
        ?string $oldAmount,
        string $newAmount
    ): void {
        $old = $oldAmount === null ? null : (float) $oldAmount;
        $new = (float) $newAmount;

        $fundingRequest->financialChanges()->create([
            'admin_id' => auth()->id(),
            'field' => $field,
            'action' => $action,
            'old_amount' => $oldAmount,
            'new_amount' => $newAmount,
            'delta_amount' => $old === null ? $newAmount : $this->decimalString($new - $old),
        ]);
    }

    private function decimalString(mixed $value): string
    {
        return number_format((float) $value, 2, '.', '');
    }

    public function downloadDonationAct(string $locale, FundingRequest $fundingRequest): StreamedResponse|\Illuminate\Http\RedirectResponse
    {
        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('local');

        if (! $fundingRequest->donation_act_path || ! $disk->exists($fundingRequest->donation_act_path)) {
            return back()->withErrors(['file' => 'Aucun acte PDF disponible pour ce dossier.']);
        }

        return $disk->download(
            $fundingRequest->donation_act_path,
            'acte-de-donation-'.$fundingRequest->dossier_number.'.pdf'
        );
    }

    public function downloadApplicantDocument(string $locale, FundingRequest $fundingRequest, string $kind): StreamedResponse|\Illuminate\Http\RedirectResponse
    {
        $map = [
            'identite' => 'doc_id_path',
            'passport' => 'doc_passport_path',
            'identite_recto' => 'doc_id_front_path',
            'identite_verso' => 'doc_id_back_path',
            'situation' => 'doc_situation_path',
            'medical' => 'doc_medical_path',
        ];
        if (! isset($map[$kind])) {
            abort(404);
        }
        $column = $map[$kind];
        $path = $fundingRequest->{$column};

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('local');
        if (! $path || ! $disk->exists($path)) {
            return back()->withErrors(['file' => 'Ce document n’a pas été déposé ou est introuvable.']);
        }

        return $disk->download($path, basename($path));
    }

    public function previewApplicantDocument(string $locale, FundingRequest $fundingRequest, string $kind)
    {
        $map = [
            'identite' => 'doc_id_path',
            'passport' => 'doc_passport_path',
            'identite_recto' => 'doc_id_front_path',
            'identite_verso' => 'doc_id_back_path',
            'situation' => 'doc_situation_path',
            'medical' => 'doc_medical_path',
        ];
        if (! isset($map[$kind])) {
            abort(404);
        }

        $column = $map[$kind];
        $path = $fundingRequest->{$column};

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('local');
        if (! $path || ! $disk->exists($path)) {
            return back()->withErrors(['file' => 'Ce document n’a pas été déposé ou est introuvable.']);
        }

        $absolutePath = $disk->path($path);
        $mime = $disk->mimeType($path) ?: 'application/octet-stream';

        return ResponseFactory::file($absolutePath, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="'.basename($path).'"',
        ]);
    }

    public function close(string $locale, FundingRequest $fundingRequest)
    {
        if (in_array($fundingRequest->status, [
            FundingRequest::STATUS_REFUSED,
            FundingRequest::STATUS_CLOSED,
        ], true)) {
            return back()->withErrors(['flow' => 'Ce dossier ne peut pas être clôturé dans son état actuel.']);
        }

        $fundingRequest->status = FundingRequest::STATUS_CLOSED;
        $fundingRequest->save();

        try {
            $this->mailService->sendFundingRequestMail(
                $fundingRequest->email,
                new FundingRequestClosedMail($fundingRequest->fresh()),
                $fundingRequest->fresh(),
                EmailNotification::RECIPIENT_APPLICANT,
                $fundingRequest->preferredLocale(),
                true
            );
        } catch (Throwable $exception) {
            return back()->withErrors([
                'mail' => 'Le dossier a été clôturé, mais l’e-mail client a échoué. L’échec est enregistré dans Notifications. Détail : '.$exception->getMessage(),
            ]);
        }

        return back()->with('ok', 'Dossier marqué comme clôturé et client informé par e-mail.');
    }
}

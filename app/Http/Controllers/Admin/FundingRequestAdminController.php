<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\FundingDonationActSentAdminMail;
use App\Mail\FundingDonationActMail;
use App\Mail\FundingPreliminaryAcceptedMail;
use App\Mail\FundingPreliminarySentAdminMail;
use App\Mail\FundingRequestRefusedMail;
use App\Models\FundingRequest;
use App\Services\DonationActPdfService;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response as ResponseFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FundingRequestAdminController extends Controller
{
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
                'title' => 'Dossiers en attente de pièces',
                'intro' => 'Les clients qui doivent encore compléter leur dossier.',
                'statuses' => [FundingRequest::STATUS_AWAITING_DOCUMENTS, FundingRequest::STATUS_PRELIMINARY_ACCEPTED],
                'empty' => 'Aucun dossier en attente de pièces pour le moment.',
                'primary_action' => 'documents',
                'primary_label' => 'Ouvrir le dossier',
            ],
            'decision' => [
                'title' => 'Dossiers complets',
                'intro' => 'Les demandes prêtes pour la confirmation finale.',
                'statuses' => [FundingRequest::STATUS_DOCUMENTS_RECEIVED],
                'empty' => 'Aucun dossier complet à traiter pour le moment.',
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
        $recentRequests = FundingRequest::query()
            ->orderByDesc('created_at')
            ->limit(15)
            ->get();

        return view('admin.dashboard', [
            'statusCards' => $statusCards,
            'totalCount' => $totalCount,
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

    public function show(string $locale, FundingRequest $fundingRequest)
    {
        if ($fundingRequest->documentsComplete() && in_array($fundingRequest->status, [
            FundingRequest::STATUS_AWAITING_DOCUMENTS,
            FundingRequest::STATUS_PRELIMINARY_ACCEPTED,
        ], true)) {
            $fundingRequest->status = FundingRequest::STATUS_DOCUMENTS_RECEIVED;
            $fundingRequest->save();
        }

        $fundingRequest->refresh();

        return view('admin.funding-requests.show', [
            'fr' => $fundingRequest,
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

        Mail::to($fundingRequest->email)->send(
            (new FundingPreliminaryAcceptedMail($fundingRequest))->locale($fundingRequest->preferredLocale())
        );

        // Le statut doit évoluer dès que le demandeur a reçu l’e-mail.
        // On ne bloque pas cette transition si la copie admin échoue.
        $fundingRequest->status = FundingRequest::STATUS_AWAITING_DOCUMENTS;
        $fundingRequest->save();

        $adminNotified = false;
        $adminEmail = config('admin.notification_email');
        if ($adminEmail) {
            try {
                Mail::to($adminEmail)->send(
                    (new FundingPreliminarySentAdminMail($fundingRequest->fresh()))
                        ->locale(config('locales.default', 'fr'))
                );
                $adminNotified = true;
            } catch (\Throwable $e) {
                report($e);
            }
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

        return back()->with('ok', 'Étape 2 validée : pièces reçues et dossier prêt pour la décision finale.');
    }

    public function generateAndSendDonationAct(string $locale, FundingRequest $fundingRequest, DonationActPdfService $pdf)
    {
        $fundingRequest->refresh();

        if ($fundingRequest->documentsComplete() && in_array($fundingRequest->status, [
            FundingRequest::STATUS_AWAITING_DOCUMENTS,
            FundingRequest::STATUS_PRELIMINARY_ACCEPTED,
        ], true)) {
            $fundingRequest->status = FundingRequest::STATUS_DOCUMENTS_RECEIVED;
            $fundingRequest->save();
        }

        if (! in_array($fundingRequest->status, [
            FundingRequest::STATUS_DOCUMENTS_RECEIVED,
            FundingRequest::STATUS_DONATION_ACT_SENT,
        ], true)) {
            return back()->withErrors(['flow' => 'Les pièces justificatives du demandeur doivent être reçues avant de générer l’acte de donation. Envoyez d’abord la validation préliminaire, puis attendez le dépôt des documents via le lien transmis au demandeur.']);
        }

        $path = $pdf->generateAndStore($fundingRequest, $locale);
        $fundingRequest->donation_act_path = $path;
        $fundingRequest->status = FundingRequest::STATUS_DONATION_ACT_SENT;
        $fundingRequest->save();

        Mail::to($fundingRequest->email)->send(
            (new FundingDonationActMail($fundingRequest->fresh()))->locale($fundingRequest->preferredLocale())
        );
        $adminEmail = config('admin.notification_email');
        if ($adminEmail) {
            Mail::to($adminEmail)->send(
                (new FundingDonationActSentAdminMail($fundingRequest->fresh()))
                    ->locale(config('locales.default', 'fr'))
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
        Mail::to($fundingRequest->email)->send(
            (new FundingRequestRefusedMail($fundingRequest))->locale($fundingRequest->preferredLocale())
        );

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

        $fundingRequest->administrative_fees = $validated['administrative_fees'];
        $fundingRequest->save();

        return back()->with('ok', 'Frais administratifs mis à jour avec succès.');
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
        $fundingRequest->status = FundingRequest::STATUS_CLOSED;
        $fundingRequest->save();

        return back()->with('ok', 'Dossier marqué comme clôturé (acte signé reçu ou processus terminé).');
    }
}

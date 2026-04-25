<?php

namespace App\Http\Controllers;

use App\Mail\FundingDocumentsReceivedAdminMail;
use App\Mail\FundingRequestReceivedAdminMail;
use App\Mail\FundingRequestReceivedApplicantMail;
use App\Models\EmailNotification;
use App\Models\FundingRequest;
use App\Models\User;
use App\Services\TrackedMailService;
use App\Support\LocalizedRouteSlugs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Filesystem\FilesystemAdapter;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FundingRequestController extends Controller
{
    public function __construct(private TrackedMailService $mailService)
    {
    }

    public function create(string $locale)
    {
        return view('pages.funding-request', [
            'amountChoices' => FundingRequest::AMOUNT_CHOICES,
        ]);
    }

    public function store(string $locale, Request $request)
    {
        $validator = validator($request->all(), [
            'full_name' => ['required', 'string', 'max:240'],
            'country' => ['required', 'string', 'max:120'],
            'address' => ['required', 'string', 'max:2000'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:64'],
            'phone_prefix' => ['required', 'string', 'max:10'],
            'current_situation' => ['required', 'string', Rule::in(FundingRequest::currentSituationKeys())],
            'monthly_income_approx' => ['nullable', 'string', 'max:120'],
            'family_situation' => ['nullable', 'string', Rule::in(FundingRequest::familySituationKeys())],
            'amount_requested' => ['required', 'integer', Rule::in(FundingRequest::AMOUNT_CHOICES)],
            'need_type' => ['required', 'string', Rule::in(FundingRequest::needTypeKeys())],
            'other_need_type' => ['nullable', 'string', 'max:500'],
            'situation' => ['required', 'string', 'max:10000'],
            'declare_accurate' => ['accepted'],
        ]);

        $validator->after(function ($validator) use ($request) {
            $email = mb_strtolower(trim((string) $request->input('email', '')));
            $phone = $this->normalizePhoneForDuplicateCheck(
                (string) $request->input('phone_prefix', ''),
                (string) $request->input('phone', '')
            );

            if ($email !== '' && FundingRequest::query()->whereRaw('LOWER(email) = ?', [$email])->exists()) {
                $validator->errors()->add('email', __('funding.duplicate_email'));
            }

            if ($phone === '') {
                return;
            }

            $duplicateByPhone = FundingRequest::query()
                ->select(['id', 'phone_prefix', 'phone'])
                ->get()
                ->contains(function (FundingRequest $existing) use ($phone) {
                    return $this->normalizePhoneForDuplicateCheck(
                        (string) $existing->phone_prefix,
                        (string) $existing->phone
                    ) === $phone;
                });

            if ($duplicateByPhone) {
                $validator->errors()->add('phone', __('funding.duplicate_phone'));
            }
        });

        $validated = $validator->validate();

        $validated['declare_accurate'] = true;
        $validated['email'] = mb_strtolower(trim((string) $validated['email']));

        $supported = config('locales.supported', ['fr']);
        $locale = in_array(app()->getLocale(), $supported, true)
            ? app()->getLocale()
            : config('locales.default', 'fr');

        $funding = DB::transaction(function () use ($validated, $locale) {
            $row = FundingRequest::query()->create([
                ...$validated,
                'locale' => $locale,
                'status' => FundingRequest::STATUS_PENDING,
            ]);
            $row->dossier_number = FundingRequest::generateDossierNumber($row->id);
            $row->public_slug = FundingRequest::generatePublicSlug();
            $row->save();

            return $row->fresh();
        });

        $this->mailService->sendFundingRequestMail(
            $funding->email,
            new FundingRequestReceivedApplicantMail($funding),
            $funding,
            EmailNotification::RECIPIENT_APPLICANT,
            $funding->preferredLocale(),
            true
        );

        $adminEmail = $this->resolveAdminNotificationEmail();
        if ($adminEmail) {
            $this->mailService->sendFundingRequestMail(
                $adminEmail,
                new FundingRequestReceivedAdminMail($funding),
                $funding,
                EmailNotification::RECIPIENT_ADMIN,
                'fr'
            );
        }

        return redirect(
            LocalizedRouteSlugs::route('funding-request.success', [
                'locale' => $locale,
                'public_slug' => $funding->public_slug,
            ])
        )
            ->with('dossier_number', $funding->dossier_number);
    }

    public function success(string $locale, Request $request, ?string $public_slug = null)
    {
        $public_slug = (string) $request->route('public_slug', $public_slug ?? '');
        if ($public_slug === '') {
            $public_slug = null;
        }

        $context = (string) ($request->query('context') ?? 'funding');
        if (! in_array($context, ['funding', 'documents'], true)) {
            $context = 'funding';
        }

        $dossier_number = null;
        $tracking_url = null;
        $documents_url = null;
        $applicant_name = null;

        if ($public_slug !== null && $public_slug !== '') {
            $fr = FundingRequest::query()->where('public_slug', $public_slug)->first();
            if ($fr) {
                $dossier_number = $fr->dossier_number;
                $applicant_name = $fr->full_name;
                $tracking_url = LocalizedRouteSlugs::route('funding-request.success', ['locale' => $locale, 'public_slug' => $fr->public_slug]);
                if ($fr->applicantCanUploadDocuments()) {
                    $documents_url = LocalizedRouteSlugs::route('funding-request.documents', ['locale' => $locale, 'public_slug' => $fr->public_slug]);
                }
            }
        }

        if ($dossier_number === null) {
            $dossier_number = $request->query('dossier') ?? session('dossier_number');
            if ($dossier_number) {
                $fr = FundingRequest::query()->where('dossier_number', $dossier_number)->first();
                if ($fr?->public_slug) {
                    $applicant_name = $fr->full_name;
                    $tracking_url = LocalizedRouteSlugs::route('funding-request.success', ['locale' => $locale, 'public_slug' => $fr->public_slug]);
                    if ($fr->applicantCanUploadDocuments()) {
                        $documents_url = LocalizedRouteSlugs::route('funding-request.documents', ['locale' => $locale, 'public_slug' => $fr->public_slug]);
                    }
                }
            }
        }

        return view('pages.funding-request-success', [
            'context' => $context,
            'dossier_number' => $dossier_number,
            'tracking_url' => $tracking_url,
            'documents_url' => $documents_url,
            'applicant_name' => $applicant_name,
        ]);
    }

    public function trackingForm(string $locale)
    {
        return view('pages.funding-tracking', [
            'trackingResult' => null,
        ]);
    }

    public function trackingLookup(string $locale, Request $request)
    {
        $raw = (string) $request->input('dossier_number', '');
        $normalized = FundingRequest::normalizeDossierNumberInput($raw);

        $request->merge(['dossier_number' => $normalized]);

        $request->validate([
            'dossier_number' => ['required', 'string', 'regex:/^(?:JGF-\d{4}-\d{5}|ARD-\d{4}-[A-Z0-9]{6})$/'],
        ], [
            'dossier_number.regex' => __('funding.tracking_invalid_format'),
        ]);

        $fr = FundingRequest::query()->where('dossier_number', $normalized)->first();

        if (! $fr) {
            return back()
                ->withInput()
                ->withErrors(['dossier_number' => __('funding.tracking_not_found')]);
        }

        return view('pages.funding-tracking', [
            'trackingResult' => $fr,
        ]);
    }

    public function downloadDonationActApplicant(string $locale, Request $request): StreamedResponse|\Illuminate\Http\RedirectResponse
    {
        $public_slug = (string) $request->route('public_slug', '');
        $fr = FundingRequest::query()->where('public_slug', $public_slug)->firstOrFail();

        if (! $fr->applicantCanDownloadDonationAct()) {
            abort(404);
        }

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('local');

        if (! $disk->exists($fr->donation_act_path)) {
            abort(404);
        }

        return $disk->download(
            $fr->donation_act_path,
            'acte-de-donation-'.$fr->dossier_number.'.pdf'
        );
    }

    public function documentsForm(string $locale, Request $request)
    {
        $public_slug = (string) $request->route('public_slug', '');
        $fr = FundingRequest::query()->where('public_slug', $public_slug)->firstOrFail();

        if ($fr->documentsComplete() && in_array($fr->status, [
            FundingRequest::STATUS_AWAITING_DOCUMENTS,
            FundingRequest::STATUS_PRELIMINARY_ACCEPTED,
        ], true)) {
            $fr->status = FundingRequest::STATUS_DOCUMENTS_RECEIVED;
            $fr->save();
        }

        if (! $fr->applicantCanUploadDocuments()) {
            return redirect()
                ->route('funding-request.success', [
                    'locale' => $locale,
                    'public_slug' => $fr->public_slug,
                ])
                ->with('info', __('funding.documents_link_not_needed'));
        }

        return view('pages.funding-request-documents', [
            'fr' => $fr,
        ]);
    }

    public function documentsStore(string $locale, Request $request)
    {
        $public_slug = (string) $request->route('public_slug', '');
        $fr = FundingRequest::query()->where('public_slug', $public_slug)->firstOrFail();

        if (! $fr->applicantCanUploadDocuments()) {
            return redirect()
                ->route('funding-request.success', [
                    'locale' => $locale,
                    'public_slug' => $fr->public_slug,
                ])
                ->with('info', __('funding.documents_upload_unavailable'));
        }

        $fileRules = ['file', 'mimes:pdf,jpeg,jpg,png', 'max:10240'];

        $selectedIdentityTypeInput = (string) $request->input('identity_document_type', $fr->identity_document_type ?: FundingRequest::IDENTITY_DOCUMENT_ID_CARD);
        $rules = [
            'identity_document_type' => ['required', Rule::in([
                FundingRequest::IDENTITY_DOCUMENT_PASSPORT,
                FundingRequest::IDENTITY_DOCUMENT_ID_CARD,
            ])],
            'doc_situation' => ['nullable', ...$fileRules],
        ];
        if ($selectedIdentityTypeInput === FundingRequest::IDENTITY_DOCUMENT_PASSPORT) {
            $rules['doc_passport'] = $fr->doc_passport_path ? ['nullable', ...$fileRules] : ['required', ...$fileRules];
        } elseif ($selectedIdentityTypeInput === FundingRequest::IDENTITY_DOCUMENT_ID_CARD) {
            $rules['doc_id_front'] = $fr->doc_id_front_path ? ['nullable', ...$fileRules] : ['required', ...$fileRules];
            $rules['doc_id_back'] = $fr->doc_id_back_path ? ['nullable', ...$fileRules] : ['required', ...$fileRules];
        }

        $request->validate($rules, [
            'identity_document_type.required' => __('funding.documents_identity_type_required'),
            'doc_passport.required' => __('funding.documents_passport_required'),
            'doc_id_front.required' => __('funding.documents_id_front_required'),
            'doc_id_back.required' => __('funding.documents_id_back_required'),
        ]);

        $selectedIdentityType = (string) $request->input('identity_document_type');
        $fr->identity_document_type = $selectedIdentityType;

        if ($selectedIdentityType === FundingRequest::IDENTITY_DOCUMENT_PASSPORT) {
            // Si on bascule vers passeport, ignorer les anciens fichiers carte.
            $fr->doc_id_front_path = null;
            $fr->doc_id_back_path = null;
        } elseif ($selectedIdentityType === FundingRequest::IDENTITY_DOCUMENT_ID_CARD) {
            // Si on bascule vers carte, ignorer le passeport.
            $fr->doc_passport_path = null;
        }

        $hadUpload = false;
        if ($request->hasFile('doc_passport')) {
            $hadUpload = true;
        }
        if ($request->hasFile('doc_id_front')) {
            $hadUpload = true;
        }
        if ($request->hasFile('doc_id_back')) {
            $hadUpload = true;
        }
        if ($request->hasFile('doc_situation')) {
            $hadUpload = true;
        }

        if (! $hadUpload) {
            if ($fr->documentsComplete()) {
                return redirect()
                    ->route('funding-request.documents', [
                        'locale' => $locale,
                        'public_slug' => $fr->public_slug,
                    ])
                    ->with('ok', __('funding.documents_already_complete'));
            }

            return back()->withErrors(['files' => __('funding.documents_select_file')]);
        }

        $wasComplete = $fr->documentsComplete();
        $previousStatus = $fr->status;
        $disk = Storage::disk('local');
        $dir = 'funding-applicant-docs/'.$fr->id;

        $map = [
            'doc_passport' => 'doc_passport_path',
            'doc_id_front' => 'doc_id_front_path',
            'doc_id_back' => 'doc_id_back_path',
            'doc_situation' => 'doc_situation_path',
        ];

        foreach ($map as $input => $column) {
            if ($input === 'doc_passport' && $selectedIdentityType !== FundingRequest::IDENTITY_DOCUMENT_PASSPORT) {
                continue;
            }
            if (in_array($input, ['doc_id_front', 'doc_id_back'], true) && $selectedIdentityType !== FundingRequest::IDENTITY_DOCUMENT_ID_CARD) {
                continue;
            }
            if (! $request->hasFile($input)) {
                continue;
            }
            $uploaded = $request->file($input);
            $ext = strtolower($uploaded->getClientOriginalExtension() ?: 'pdf');
            if (! in_array($ext, ['pdf', 'jpeg', 'jpg', 'png'], true)) {
                $ext = 'pdf';
            }
            $safeName = $input.'_'.now()->format('Ymd_His').'.'.$ext;
            if ($fr->{$column} && $disk->exists($fr->{$column})) {
                $disk->delete($fr->{$column});
            }
            $fr->{$column} = $uploaded->storeAs($dir, $safeName, 'local');
        }

        $fr->save();
        $fr->refresh();

        if ($fr->documentsComplete()) {
            $fr->status = FundingRequest::STATUS_DOCUMENTS_RECEIVED;
            $fr->save();

            if (! $wasComplete || $previousStatus !== FundingRequest::STATUS_DOCUMENTS_RECEIVED) {
                $adminEmail = $this->resolveAdminNotificationEmail();
                if ($adminEmail) {
                    try {
                        $this->mailService->sendFundingRequestMail(
                            $adminEmail,
                            new FundingDocumentsReceivedAdminMail($fr->fresh()),
                            $fr->fresh(),
                            EmailNotification::RECIPIENT_ADMIN,
                            'fr'
                        );
                    } catch (\Throwable $exception) {
                        report($exception);
                    }
                }
            }
        }

        $message = $fr->status === FundingRequest::STATUS_DOCUMENTS_RECEIVED
            ? __('funding.flash_documents_complete')
            : __('funding.flash_documents_partial');

        if ($fr->status === FundingRequest::STATUS_DOCUMENTS_RECEIVED) {
            return redirect()
                ->route('funding-request.success', [
                    'locale' => $locale,
                    'public_slug' => $fr->public_slug,
                    'context' => 'documents',
                ]);
        }

        return redirect()
            ->route('funding-request.documents', [
                'locale' => $locale,
                'public_slug' => $fr->public_slug,
            ])
            ->with('ok', $message);
    }

    private function resolveAdminNotificationEmail(): ?string
    {
        $configured = trim((string) config('admin.notification_email', ''));
        if ($configured !== '') {
            return $configured;
        }

        $adminUserEmail = (string) (User::query()
            ->where('is_admin', true)
            ->whereNotNull('email')
            ->orderBy('id')
            ->value('email') ?? '');

        $adminUserEmail = trim($adminUserEmail);

        return $adminUserEmail !== '' ? $adminUserEmail : null;
    }

    private function normalizePhoneForDuplicateCheck(string $prefix, string $phone): string
    {
        return preg_replace('/\D+/u', '', $prefix.$phone) ?: '';
    }
}

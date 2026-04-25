<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\FundingPreliminaryAcceptedMail;
use App\Mail\FundingRequestRefusedMail;
use App\Models\EmailNotification;
use App\Models\FundingRequest;
use App\Services\TrackedMailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class EmailNotificationAdminController extends Controller
{
    public function index(string $locale, Request $request)
    {
        $status = (string) $request->query('status', EmailNotification::STATUS_FAILED);
        if (! in_array($status, [EmailNotification::STATUS_FAILED, EmailNotification::STATUS_SENT, 'all'], true)) {
            $status = EmailNotification::STATUS_FAILED;
        }

        $query = EmailNotification::query()
            ->with('fundingRequest')
            ->latest('created_at');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $notifications = $query->paginate(20)->withQueryString();

        $counts = [
            EmailNotification::STATUS_FAILED => EmailNotification::query()->where('status', EmailNotification::STATUS_FAILED)->count(),
            EmailNotification::STATUS_SENT => EmailNotification::query()->where('status', EmailNotification::STATUS_SENT)->count(),
            'all' => EmailNotification::query()->count(),
        ];

        return view('admin.email-notifications.index', [
            'notifications' => $notifications,
            'counts' => $counts,
            'status' => $status,
            'adminActive' => 'notifications',
        ]);
    }

    public function retry(string $locale, EmailNotification $emailNotification, TrackedMailService $mailService): RedirectResponse
    {
        if ($emailNotification->status !== EmailNotification::STATUS_FAILED) {
            return back()->with('ok', 'Cet e-mail n’est plus en échec.');
        }

        try {
            $notification = $mailService->retry($emailNotification, true);
            $this->applyWorkflowAfterSuccessfulRetry($notification);
        } catch (Throwable $exception) {
            return back()->withErrors([
                'mail' => 'Le renvoi a encore échoué : '.$exception->getMessage(),
            ]);
        }

        return back()->with('ok', 'E-mail renvoyé avec succès.');
    }

    private function applyWorkflowAfterSuccessfulRetry(EmailNotification $notification): void
    {
        $fundingRequest = $notification->fundingRequest;
        if (! $fundingRequest) {
            return;
        }

        if (
            $notification->mailable_class === FundingPreliminaryAcceptedMail::class
            && $fundingRequest->status === FundingRequest::STATUS_PENDING
        ) {
            $fundingRequest->status = FundingRequest::STATUS_AWAITING_DOCUMENTS;
            $fundingRequest->save();
        }

        if (
            $notification->mailable_class === FundingRequestRefusedMail::class
            && ! in_array($fundingRequest->status, [FundingRequest::STATUS_REFUSED, FundingRequest::STATUS_CLOSED], true)
        ) {
            $fundingRequest->status = FundingRequest::STATUS_REFUSED;
            $fundingRequest->save();
        }
    }
}

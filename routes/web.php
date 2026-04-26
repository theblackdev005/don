<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DatabaseAdminController;
use App\Http\Controllers\Admin\EmailNotificationAdminController;
use App\Http\Controllers\Admin\FundingRequestAdminController;
use App\Http\Controllers\Admin\AdminMessageTemplateController;
use App\Http\Controllers\Admin\SiteSettingsController;
use App\Http\Controllers\Admin\SmtpSettingsController;
use App\Http\Controllers\Admin\TestimonialAdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FundingRequestController;
use App\Models\Testimonial;
use App\Support\LocalizedRouteSlugs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — pages statiques du thème Around (sans build npm)
|--------------------------------------------------------------------------
*/

$supportedLocales = config('locales.supported', ['fr']);
$localePattern = implode('|', $supportedLocales);

Route::get('/', function (Request $request) use ($supportedLocales) {
    $locale = (string) $request->session()->get('locale', config('locales.default', 'fr'));
    if (! in_array($locale, $supportedLocales, true)) {
        $locale = config('locales.default', 'fr');
    }

    return redirect('/'.$locale);
});

Route::get('/{locale}/lang/{target}', function (Request $request, string $locale, string $target) use ($supportedLocales, $localePattern) {
    if (! in_array($target, $supportedLocales, true)) {
        $target = config('locales.default', 'fr');
    }
    $request->session()->put('locale', $target);

    $previous = url()->previous();
    $path = parse_url($previous, PHP_URL_PATH) ?: '/';

    try {
        $matchedRoute = app('router')->getRoutes()->match(Request::create($path, 'GET'));
        $routeName = $matchedRoute->getName();
        $routeParameters = array_intersect_key($matchedRoute->parameters(), array_flip($matchedRoute->parameterNames()));

        if ($routeName) {
            $parameters = LocalizedRouteSlugs::applyLocalizedParameters(
                $routeName,
                $routeParameters,
                $target
            );
            $parameters['locale'] = $target;

            return redirect(route($routeName, $parameters));
        }
    } catch (\Throwable) {
        // Fallback below keeps locale switching functional even if previous URL is not a named route.
    }

    $path = preg_replace('#^/('.$localePattern.')(?=/|$)#', '', $path) ?: '/';

    return redirect('/'.$target.$path);
})->whereIn('locale', $supportedLocales)->whereIn('target', $supportedLocales)->name('locale.switch');

Route::prefix('{locale}')->whereIn('locale', $supportedLocales)->group(function () {
    $slugParam = fn (string $key) => '{'.LocalizedRouteSlugs::parameterName($key).'}';
    $slugPattern = fn (string $key) => LocalizedRouteSlugs::pattern($key);

    Route::get('/', function () {
        return view('pages.home', [
            'testimonials' => Testimonial::query()->with('translations')->active()->ordered()->get(),
        ]);
    })->name('home');
    Route::view('/'.$slugParam('about'), 'pages.about')
        ->where(LocalizedRouteSlugs::parameterName('about'), $slugPattern('about'))
        ->name('about');
    Route::view('/'.$slugParam('services'), 'pages.services')
        ->where(LocalizedRouteSlugs::parameterName('services'), $slugPattern('services'))
        ->name('services');
    Route::get('/'.$slugParam('contact'), [ContactController::class, 'show'])
        ->where(LocalizedRouteSlugs::parameterName('contact'), $slugPattern('contact'))
        ->name('contact');
    Route::post('/'.$slugParam('contact'), [ContactController::class, 'submit'])
        ->where(LocalizedRouteSlugs::parameterName('contact'), $slugPattern('contact'))
        ->middleware('throttle:4,1')
        ->name('contact.submit');
    Route::view('/'.$slugParam('legal'), 'pages.legal')
        ->where(LocalizedRouteSlugs::parameterName('legal'), $slugPattern('legal'))
        ->name('legal');
    Route::view('/'.$slugParam('privacy'), 'pages.privacy')
        ->where(LocalizedRouteSlugs::parameterName('privacy'), $slugPattern('privacy'))
        ->name('privacy');
    Route::view('/'.$slugParam('account'), 'pages.account')
        ->where(LocalizedRouteSlugs::parameterName('account'), $slugPattern('account'))
        ->name('account');

    $fundingBase = $slugParam('funding_request');
    $fundingConfirm = $slugParam('funding_request_confirmation');

    Route::get('/'.$fundingBase, [FundingRequestController::class, 'create'])
        ->where(LocalizedRouteSlugs::parameterName('funding_request'), $slugPattern('funding_request'))
        ->name('funding-request.create');
    Route::post('/'.$fundingBase, [FundingRequestController::class, 'store'])
        ->where(LocalizedRouteSlugs::parameterName('funding_request'), $slugPattern('funding_request'))
        ->name('funding-request.store');
    Route::get('/'.$fundingBase.'/{public_slug}/documents', [FundingRequestController::class, 'documentsForm'])
        ->where(LocalizedRouteSlugs::parameterName('funding_request'), $slugPattern('funding_request'))
        ->where('public_slug', '[a-z0-9]{12}')
        ->name('funding-request.documents');
    Route::post('/'.$fundingBase.'/{public_slug}/documents', [FundingRequestController::class, 'documentsStore'])
        ->where(LocalizedRouteSlugs::parameterName('funding_request'), $slugPattern('funding_request'))
        ->where('public_slug', '[a-z0-9]{12}')
        ->name('funding-request.documents.store');
    Route::get('/'.$fundingBase.'/'.$fundingConfirm.'/{public_slug}/documents', [FundingRequestController::class, 'documentsForm'])
        ->where(LocalizedRouteSlugs::parameterName('funding_request'), $slugPattern('funding_request'))
        ->where(LocalizedRouteSlugs::parameterName('funding_request_confirmation'), $slugPattern('funding_request_confirmation'))
        ->where('public_slug', '[a-z0-9]{12}')
        ->name('funding-request.documents.legacy');
    Route::post('/'.$fundingBase.'/'.$fundingConfirm.'/{public_slug}/documents', [FundingRequestController::class, 'documentsStore'])
        ->where(LocalizedRouteSlugs::parameterName('funding_request'), $slugPattern('funding_request'))
        ->where(LocalizedRouteSlugs::parameterName('funding_request_confirmation'), $slugPattern('funding_request_confirmation'))
        ->where('public_slug', '[a-z0-9]{12}')
        ->name('funding-request.documents.store.legacy');
    Route::get('/'.$fundingBase.'/'.$fundingConfirm.'/{public_slug}/acte.pdf', [FundingRequestController::class, 'downloadDonationActApplicant'])
        ->where(LocalizedRouteSlugs::parameterName('funding_request'), $slugPattern('funding_request'))
        ->where(LocalizedRouteSlugs::parameterName('funding_request_confirmation'), $slugPattern('funding_request_confirmation'))
        ->where('public_slug', '[a-z0-9]{12}')
        ->name('funding-request.download-act');
    Route::get('/'.$fundingBase.'/'.$fundingConfirm.'/{public_slug?}', [FundingRequestController::class, 'success'])
        ->where(LocalizedRouteSlugs::parameterName('funding_request'), $slugPattern('funding_request'))
        ->where(LocalizedRouteSlugs::parameterName('funding_request_confirmation'), $slugPattern('funding_request_confirmation'))
        ->where('public_slug', '[a-z0-9]{12}')
        ->name('funding-request.success');

    $trackingSlug = $slugParam('dossier_tracking');
    Route::get('/'.$trackingSlug, [FundingRequestController::class, 'trackingForm'])
        ->where(LocalizedRouteSlugs::parameterName('dossier_tracking'), $slugPattern('dossier_tracking'))
        ->name('funding.tracking');
    Route::post('/'.$trackingSlug, [FundingRequestController::class, 'trackingLookup'])
        ->where(LocalizedRouteSlugs::parameterName('dossier_tracking'), $slugPattern('dossier_tracking'))
        ->name('funding.tracking.lookup');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('connexion', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('connexion', [AdminAuthController::class, 'login']);
        Route::get('mot-de-passe-oublie', [AdminAuthController::class, 'showForgotPassword'])->name('password.request');
        Route::post('mot-de-passe-oublie', [AdminAuthController::class, 'sendResetLink'])->name('password.email');
        Route::get('reinitialiser-mot-de-passe/{token}', [AdminAuthController::class, 'showResetPassword'])->name('password.reset');
        Route::post('reinitialiser-mot-de-passe', [AdminAuthController::class, 'resetPassword'])->name('password.update');
        Route::post('deconnexion', [AdminAuthController::class, 'logout'])->name('logout');

        Route::middleware(['auth', 'admin'])->group(function () {
            Route::get('/', [FundingRequestAdminController::class, 'dashboard'])->name('dashboard');
            Route::get('actions/{stage}', [FundingRequestAdminController::class, 'workflow'])
                ->whereIn('stage', ['review', 'documents', 'decision', 'closing'])
                ->name('workflow');
            Route::get('guide', function () {
                return view('admin.guide', [
                    'adminActive' => 'guide',
                ]);
            })->name('guide');
            Route::get('demandes', [FundingRequestAdminController::class, 'index'])->name('funding-requests.index');
            Route::get('infos', [FundingRequestAdminController::class, 'contacts'])->name('contacts.index');
            Route::get('infos/export', [FundingRequestAdminController::class, 'exportContacts'])->name('contacts.export');
            Route::get('demandes/{fundingRequest}', [FundingRequestAdminController::class, 'show'])->name('funding-requests.show');
            Route::post('demandes/{fundingRequest}/notes', [FundingRequestAdminController::class, 'updateNotes'])->name('funding-requests.notes');
            Route::post('demandes/{fundingRequest}/montant-demande', [FundingRequestAdminController::class, 'updateRequestedAmount'])
                ->name('funding-requests.update-amount');
            Route::post('demandes/{fundingRequest}/frais-administratifs', [FundingRequestAdminController::class, 'updateAdministrativeFees'])
                ->name('funding-requests.update-fees');
            Route::post('demandes/{fundingRequest}/validation-preliminaire', [FundingRequestAdminController::class, 'sendPreliminaryAccepted'])
                ->name('funding-requests.preliminary');
            Route::post('demandes/{fundingRequest}/pieces-recue', [FundingRequestAdminController::class, 'markDocumentsReceived'])
                ->name('funding-requests.documents-received');
            Route::post('demandes/{fundingRequest}/pieces-a-refaire', [FundingRequestAdminController::class, 'requestDocumentsCorrection'])
                ->name('funding-requests.documents-correction');
            Route::post('demandes/{fundingRequest}/decision-pieces', [FundingRequestAdminController::class, 'decideDocuments'])
                ->name('funding-requests.documents-decision');
            Route::post('demandes/{fundingRequest}/envoyer-acte', [FundingRequestAdminController::class, 'generateAndSendDonationAct'])
                ->name('funding-requests.send-act');
            Route::post('demandes/{fundingRequest}/refuser', [FundingRequestAdminController::class, 'refuse'])
                ->name('funding-requests.refuse');
            Route::post('demandes/{fundingRequest}/reactiver', [FundingRequestAdminController::class, 'reactivate'])
                ->name('funding-requests.reactivate');
            Route::get('demandes/{fundingRequest}/acte.pdf', [FundingRequestAdminController::class, 'downloadDonationAct'])
                ->name('funding-requests.download-act');
            Route::get('demandes/{fundingRequest}/document/{kind}', [FundingRequestAdminController::class, 'downloadApplicantDocument'])
                ->whereIn('kind', ['identite', 'passport', 'identite_recto', 'identite_verso', 'situation', 'medical'])
                ->name('funding-requests.applicant-document');
            Route::get('demandes/{fundingRequest}/document/{kind}/preview', [FundingRequestAdminController::class, 'previewApplicantDocument'])
                ->whereIn('kind', ['identite', 'passport', 'identite_recto', 'identite_verso', 'situation', 'medical'])
                ->name('funding-requests.applicant-document.preview');
            Route::post('demandes/{fundingRequest}/cloturer', [FundingRequestAdminController::class, 'close'])
                ->name('funding-requests.close');
            Route::get('configuration', [SiteSettingsController::class, 'edit'])->name('settings.edit');
            Route::post('configuration', [SiteSettingsController::class, 'update'])->name('settings.update');
            Route::get('configuration/apercu-acte', [SiteSettingsController::class, 'previewDonationAct'])->name('settings.preview-donation-act');
            Route::get('modeles-messages', [AdminMessageTemplateController::class, 'edit'])->name('message-templates.edit');
            Route::post('modeles-messages', [AdminMessageTemplateController::class, 'update'])->name('message-templates.update');
            Route::get('configuration/mot-de-passe', [SiteSettingsController::class, 'editPassword'])->name('settings.password.edit');
            Route::post('configuration/mot-de-passe', [SiteSettingsController::class, 'updatePassword'])->name('settings.password.update');
            Route::get('smtp', [SmtpSettingsController::class, 'edit'])->name('smtp.edit');
            Route::post('smtp', [SmtpSettingsController::class, 'update'])->name('smtp.update');
            Route::post('smtp/test', [SmtpSettingsController::class, 'sendTest'])->name('smtp.test');
            Route::get('notifications-email', [EmailNotificationAdminController::class, 'index'])->name('email-notifications.index');
            Route::post('notifications-email/{emailNotification}/renvoyer', [EmailNotificationAdminController::class, 'retry'])
                ->name('email-notifications.retry');
            Route::get('temoignages', [TestimonialAdminController::class, 'index'])->name('testimonials.index');
            Route::post('temoignages', [TestimonialAdminController::class, 'store'])->name('testimonials.store');
            Route::put('temoignages/{testimonial}', [TestimonialAdminController::class, 'update'])->name('testimonials.update');
            Route::delete('temoignages/{testimonial}', [TestimonialAdminController::class, 'destroy'])->name('testimonials.destroy');
            Route::get('base-de-donnees', [DatabaseAdminController::class, 'index'])->name('database.index');
            Route::get('base-de-donnees/{table}', [DatabaseAdminController::class, 'show'])
                ->where('table', '[A-Za-z0-9_.-]+')
                ->name('database.table');
            Route::post('base-de-donnees/{table}', [DatabaseAdminController::class, 'store'])
                ->where('table', '[A-Za-z0-9_.-]+')
                ->name('database.store');
            Route::put('base-de-donnees/{table}/{record}', [DatabaseAdminController::class, 'update'])
                ->where('table', '[A-Za-z0-9_.-]+')
                ->name('database.update');
            Route::delete('base-de-donnees/{table}/{record}', [DatabaseAdminController::class, 'destroy'])
                ->where('table', '[A-Za-z0-9_.-]+')
                ->name('database.destroy');
        });
    });
});

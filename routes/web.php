<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\FundingRequestAdminController;
use App\Http\Controllers\Admin\SiteSettingsController;
use App\Http\Controllers\FundingRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — pages statiques du thème Around (sans build npm)
|--------------------------------------------------------------------------
*/

$slug = fn (string $key) => trim((string) config("site.slugs.{$key}"), '/');
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
    $path = preg_replace('#^/('.$localePattern.')(?=/|$)#', '', $path);
    $path = $path ?: '/';

    return redirect('/'.$target.$path);
})->whereIn('locale', $supportedLocales)->whereIn('target', $supportedLocales)->name('locale.switch');

Route::prefix('{locale}')->whereIn('locale', $supportedLocales)->group(function () use ($slug) {
    Route::view('/', 'pages.home')->name('home');
    Route::view('/'.$slug('about'), 'pages.about')->name('about');
    Route::view('/'.$slug('services'), 'pages.services')->name('services');
    Route::view('/'.$slug('contact'), 'pages.contact')->name('contact');
    Route::view('/'.$slug('legal'), 'pages.legal')->name('legal');
    Route::view('/'.$slug('privacy'), 'pages.privacy')->name('privacy');
    Route::view('/'.$slug('account'), 'pages.account')->name('account');

    $fundingBase = $slug('funding_request');
    $fundingConfirm = $slug('funding_request_confirmation');

    Route::get('/'.$fundingBase, [FundingRequestController::class, 'create'])->name('funding-request.create');
    Route::post('/'.$fundingBase, [FundingRequestController::class, 'store'])->name('funding-request.store');
    Route::get('/'.$fundingBase.'/'.$fundingConfirm.'/{public_slug}/documents', [FundingRequestController::class, 'documentsForm'])
        ->where('public_slug', '[a-z0-9]{12}')
        ->name('funding-request.documents');
    Route::post('/'.$fundingBase.'/'.$fundingConfirm.'/{public_slug}/documents', [FundingRequestController::class, 'documentsStore'])
        ->where('public_slug', '[a-z0-9]{12}')
        ->name('funding-request.documents.store');
    Route::get('/'.$fundingBase.'/'.$fundingConfirm.'/{public_slug}/acte.pdf', [FundingRequestController::class, 'downloadDonationActApplicant'])
        ->where('public_slug', '[a-z0-9]{12}')
        ->name('funding-request.download-act');
    Route::get('/'.$fundingBase.'/'.$fundingConfirm.'/{public_slug?}', [FundingRequestController::class, 'success'])
        ->where('public_slug', '[a-z0-9]{12}')
        ->name('funding-request.success');

    $trackingSlug = $slug('dossier_tracking');
    Route::get('/'.$trackingSlug, [FundingRequestController::class, 'trackingForm'])->name('funding.tracking');
    Route::post('/'.$trackingSlug, [FundingRequestController::class, 'trackingLookup'])->name('funding.tracking.lookup');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('connexion', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('connexion', [AdminAuthController::class, 'login']);
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
            Route::get('demandes/{fundingRequest}', [FundingRequestAdminController::class, 'show'])->name('funding-requests.show');
            Route::post('demandes/{fundingRequest}/notes', [FundingRequestAdminController::class, 'updateNotes'])->name('funding-requests.notes');
            Route::post('demandes/{fundingRequest}/frais-administratifs', [FundingRequestAdminController::class, 'updateAdministrativeFees'])
                ->name('funding-requests.update-fees');
            Route::post('demandes/{fundingRequest}/validation-preliminaire', [FundingRequestAdminController::class, 'sendPreliminaryAccepted'])
                ->name('funding-requests.preliminary');
            Route::post('demandes/{fundingRequest}/pieces-recue', [FundingRequestAdminController::class, 'markDocumentsReceived'])
                ->name('funding-requests.documents-received');
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
            Route::get('configuration/mot-de-passe', [SiteSettingsController::class, 'editPassword'])->name('settings.password.edit');
            Route::post('configuration/mot-de-passe', [SiteSettingsController::class, 'updatePassword'])->name('settings.password.update');
        });
    });
});

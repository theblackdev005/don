<?php

namespace App\Services;

use App\Models\FundingRequest;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;

class DonationActPdfService
{
    public function generateAndStore(FundingRequest $funding, ?string $locale = null): string
    {
        $logoDataUri = null;
        $signatureDataUri = null;

        $relativeLogoPath = trim((string) config('admin.donation_act.logo_path', ''), '/');
        if ($relativeLogoPath !== '') {
            $absoluteLogoPath = public_path($relativeLogoPath);
            if (is_file($absoluteLogoPath) && is_readable($absoluteLogoPath)) {
                $ext = strtolower(pathinfo($absoluteLogoPath, PATHINFO_EXTENSION));
                $mime = match ($ext) {
                    'jpg', 'jpeg' => 'image/jpeg',
                    'gif' => 'image/gif',
                    'webp' => 'image/webp',
                    default => 'image/png',
                };
                $logoDataUri = 'data:'.$mime.';base64,'.base64_encode((string) file_get_contents($absoluteLogoPath));
            }
        }

        $relativeSignaturePath = trim((string) config('admin.donation_act.director_signature_path', ''), '/');
        if ($relativeSignaturePath !== '') {
            $absoluteSignaturePath = public_path($relativeSignaturePath);
            if (is_file($absoluteSignaturePath) && is_readable($absoluteSignaturePath)) {
                $ext = strtolower(pathinfo($absoluteSignaturePath, PATHINFO_EXTENSION));
                $mime = match ($ext) {
                    'jpg', 'jpeg' => 'image/jpeg',
                    'gif' => 'image/gif',
                    'webp' => 'image/webp',
                    default => 'image/png',
                };
                $signatureDataUri = 'data:'.$mime.';base64,'.base64_encode((string) file_get_contents($absoluteSignaturePath));
            }
        }

        $supported = config('locales.supported', ['fr']);
        $resolvedLocale = $locale !== null && in_array($locale, $supported, true)
            ? $locale
            : $funding->preferredLocale();
        $previousLocale = app()->getLocale();
        app()->setLocale($resolvedLocale);
        try {
            $directorName = trim((string) config('admin.donation_act.director_name', ''));
            if ($directorName === '') {
                $directorName = __('pdf.donation_act.director_name_default');
            }
            $directorTitle = trim((string) config('admin.donation_act.director_title', ''));
            if ($directorTitle === '') {
                $directorTitle = __('pdf.donation_act.director_title_default');
            }

            $html = view('pdfs.donation-act', [
                'funding' => $funding,
                'donationActMeta' => [
                    'logo_data_uri' => $logoDataUri,
                    'director_name' => $directorName,
                    'director_title' => $directorTitle,
                    'director_signature_data_uri' => $signatureDataUri,
                ],
            ])->render();
        } finally {
            app()->setLocale($previousLocale);
        }

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $path = 'donation-acts/'.$funding->id.'-'.$funding->dossier_number.'.pdf';
        Storage::disk('local')->put($path, $dompdf->output());

        return $path;
    }
}

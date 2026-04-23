<?php

namespace App\Services;

use App\Models\FundingRequest;
use App\Support\SiteAppearance;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;

class DonationActPdfService
{
    public function renderHtml(FundingRequest $funding, ?string $locale = null): string
    {
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
            $directorGender = (string) config('admin.donation_act.director_gender', 'male');
            $directorTitle = $directorGender === 'female'
                ? __('pdf.donation_act.director_title_female')
                : __('pdf.donation_act.director_title_male');

            $html = view('pdfs.donation-act', [
                'funding' => $funding,
                'donationActMeta' => $this->buildDonationActMeta($directorName, $directorTitle),
            ])->render();
        } finally {
            app()->setLocale($previousLocale);
        }

        return $html;
    }

    public function generateAndStore(FundingRequest $funding, ?string $locale = null): string
    {
        $html = $this->renderHtml($funding, $locale);

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

    private function buildDonationActMeta(string $directorName, string $directorTitle): array
    {
        $logoDataUri = null;
        $signatureDataUri = null;
        $certificationBadgeDataUri = null;

        $relativeLogoPath = trim((string) config('admin.donation_act.logo_path', ''), '/');
        if ($relativeLogoPath === '') {
            $relativeLogoPath = SiteAppearance::logoPath();
        }
        if ($relativeLogoPath !== '') {
            $logoDataUri = $this->imageDataUriFromPublicPath($relativeLogoPath);
        }

        $relativeSignaturePath = trim((string) config('admin.donation_act.director_signature_path', ''), '/');
        if ($relativeSignaturePath !== '') {
            $signatureDataUri = $this->imageDataUriFromPublicPath($relativeSignaturePath);
        }

        $certificationBadgePath = 'assets/img/certifications/eig-certified.png';
        $certificationBadgeDataUri = $this->imageDataUriFromPublicPath($certificationBadgePath);

        return [
            'logo_data_uri' => $logoDataUri,
            'director_name' => $directorName,
            'director_title' => $directorTitle,
            'director_signature_data_uri' => $signatureDataUri,
            'certification_badge_path' => $certificationBadgePath,
            'certification_badge_data_uri' => $certificationBadgeDataUri,
        ];
    }

    private function imageDataUriFromPublicPath(string $relativePath): ?string
    {
        foreach ($this->publicAssetCandidates($relativePath) as $absolutePath) {
            if (! is_file($absolutePath) || ! is_readable($absolutePath)) {
                continue;
            }

            $ext = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));
            $mime = match ($ext) {
                'jpg', 'jpeg' => 'image/jpeg',
                'gif' => 'image/gif',
                'webp' => 'image/webp',
                default => 'image/png',
            };

            return 'data:'.$mime.';base64,'.base64_encode((string) file_get_contents($absolutePath));
        }

        return null;
    }

    /**
     * @return list<string>
     */
    private function publicAssetCandidates(string $relativePath): array
    {
        $relativePath = trim($relativePath, '/');
        $candidates = [];

        $documentRoot = trim((string) request()->server('DOCUMENT_ROOT', ''));
        if ($documentRoot !== '') {
            $candidates[] = rtrim($documentRoot, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$relativePath;
        }

        $candidates[] = dirname(base_path()).DIRECTORY_SEPARATOR.$relativePath;
        $candidates[] = public_path($relativePath);

        return array_values(array_unique($candidates));
    }
}

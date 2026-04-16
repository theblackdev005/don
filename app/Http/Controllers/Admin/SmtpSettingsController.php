<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\EnvironmentSettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SmtpSettingsController extends Controller
{
    private function resolvedEhloDomain(?string $value = null): string
    {
        $configured = trim((string) ($value ?? ''));
        if ($configured !== '') {
            return $configured;
        }

        $appHost = parse_url((string) config('app.url', ''), PHP_URL_HOST);

        return is_string($appHost) && $appHost !== '' ? $appHost : 'localhost';
    }

    public function edit(string $locale)
    {
        return view('admin.smtp-settings', [
            'adminActive' => 'smtp',
            'settings' => [
                'mail_host' => (string) config('mail.mailers.smtp.host', ''),
                'mail_port' => (string) config('mail.mailers.smtp.port', '587'),
                'mail_encryption' => (string) config('mail.mailers.smtp.encryption', 'tls'),
                'mail_username' => (string) config('mail.mailers.smtp.username', ''),
                'mail_from_address' => (string) config('mail.from.address', ''),
                'mail_from_name' => (string) config('mail.from.name', config('site.name')),
                'mail_ehlo_domain' => trim((string) env('MAIL_EHLO_DOMAIN', '')),
                'admin_notification_email' => (string) config('admin.notification_email', ''),
            ],
        ]);
    }

    public function update(string $locale, Request $request, EnvironmentSettingsService $environmentSettings): RedirectResponse
    {
        $validated = $request->validate([
            'mail_host' => ['required', 'string', 'max:255'],
            'mail_port' => ['required', 'integer', 'min:1', 'max:65535'],
            'mail_encryption' => ['nullable', 'string', 'in:tls,ssl'],
            'mail_username' => ['nullable', 'string', 'max:255'],
            'mail_password' => ['nullable', 'string', 'max:255'],
            'mail_from_address' => ['required', 'email', 'max:255'],
            'mail_from_name' => ['required', 'string', 'max:255'],
            'mail_ehlo_domain' => ['nullable', 'string', 'max:255'],
            'admin_notification_email' => ['nullable', 'email', 'max:255'],
        ]);

        $password = $request->filled('mail_password')
            ? (string) $validated['mail_password']
            : (string) config('mail.mailers.smtp.password', '');
        $ehloDomain = $this->resolvedEhloDomain($validated['mail_ehlo_domain'] ?? '');

        $environmentSettings->persist([
            'MAIL_MAILER' => 'smtp',
            'MAIL_HOST' => $validated['mail_host'],
            'MAIL_PORT' => (string) $validated['mail_port'],
            'MAIL_ENCRYPTION' => $validated['mail_encryption'] ?? '',
            'MAIL_USERNAME' => $validated['mail_username'] ?? '',
            'MAIL_PASSWORD' => $password,
            'MAIL_FROM_ADDRESS' => $validated['mail_from_address'],
            'MAIL_FROM_NAME' => $validated['mail_from_name'],
            'MAIL_EHLO_DOMAIN' => trim((string) ($validated['mail_ehlo_domain'] ?? '')),
            'ADMIN_NOTIFICATION_EMAIL' => $validated['admin_notification_email'] ?? '',
        ], [
            'mail.default' => 'smtp',
            'mail.mailers.smtp.transport' => 'smtp',
            'mail.mailers.smtp.host' => $validated['mail_host'],
            'mail.mailers.smtp.port' => (int) $validated['mail_port'],
            'mail.mailers.smtp.encryption' => $validated['mail_encryption'] ?: null,
            'mail.mailers.smtp.username' => $validated['mail_username'] ?? '',
            'mail.mailers.smtp.password' => $password,
            'mail.mailers.smtp.local_domain' => $ehloDomain,
            'mail.from.address' => $validated['mail_from_address'],
            'mail.from.name' => $validated['mail_from_name'],
            'admin.notification_email' => $validated['admin_notification_email'] ?? '',
        ]);

        return back()->with('ok', 'Configuration SMTP mise a jour avec succes.');
    }

    public function sendTest(string $locale, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'test_email' => ['required', 'email', 'max:255'],
        ], [
            'test_email.required' => 'Veuillez saisir une adresse e-mail de test.',
            'test_email.email' => 'Veuillez saisir une adresse e-mail valide.',
        ]);

        try {
            Mail::send('mail.smtp-test', [
                'testedAt' => now(),
                'smtpSummary' => [
                    'host' => (string) config('mail.mailers.smtp.host', ''),
                    'port' => (string) config('mail.mailers.smtp.port', ''),
                    'encryption' => (string) config('mail.mailers.smtp.encryption', 'aucune'),
                    'from_address' => (string) config('mail.from.address', ''),
                    'from_name' => (string) config('mail.from.name', ''),
                ],
            ], function ($message) use ($validated): void {
                $message
                    ->to($validated['test_email'])
                    ->subject('Test SMTP — '.config('site.name'));
            });
        } catch (Throwable $exception) {
            return back()->withErrors([
                'test_email' => 'Le test SMTP a echoue : '.$exception->getMessage(),
            ])->withInput();
        }

        return back()->with('ok', 'E-mail de test envoye avec succes a '.$validated['test_email'].'.');
    }
}

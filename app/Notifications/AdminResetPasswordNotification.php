<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminResetPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected string $token
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $resetUrl = route('admin.password.reset', [
            'locale' => app()->getLocale(),
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);

        return (new MailMessage)
            ->subject('Réinitialisation du mot de passe administrateur')
            ->greeting('Bonjour,')
            ->line('Vous recevez cet e-mail parce qu’une demande de réinitialisation du mot de passe administrateur a été effectuée.')
            ->action('Réinitialiser le mot de passe', $resetUrl)
            ->line('Ce lien expirera dans 60 minutes.')
            ->line('Si vous n’êtes pas à l’origine de cette demande, aucune action n’est nécessaire.');
    }
}

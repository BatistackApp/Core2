<?php

declare(strict_types=1);

namespace App\Notifications\Core;

use App\Models\Core\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use ThibaudDauce\Mattermost\Attachment;
use ThibaudDauce\Mattermost\MattermostChannel;
use ThibaudDauce\Mattermost\Message as MattermostMessage;

final class BackupRestoreSuccessful extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', MattermostChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Restauration de sauvegarde effectuée avec succès')
            ->greeting("Bonjour {$notifiable->name},")
            ->line('La restauration de sauvegarde a été effectuée avec succès.')
            ->line("Merci d'avoir utilisé notre application!");
    }

    public function toMattermost(object $notifiable): MattermostMessage
    {
        return (new MattermostMessage)
            ->text("Restauration de sauvegarde effectuée avec succès")
            ->username("Service de Restauration de sauvegarde")
            ->channel('#Batistack Alerte')
            ->attachment(function (Attachment $attachment) {
                $attachment->success()
                    ->text("Une sauvegarde de l'espace ".config('app.url')." à été restaurée avec succès.")
                    ->authorName(Company::first()->name);
            });
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

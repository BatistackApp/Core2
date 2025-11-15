<?php
// TODO: Ajouter un lien vers la signature (Route construite par module)
namespace App\Notifications\Signature;

use App\Models\Signature\SignatureSigner;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SignatureRequestNotification extends Notification
{
    public function __construct(public SignatureSigner $signer)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $procedure = $this->signer->procedure;
        $initiator = $procedure->user;

        // $url = route('signature.sign', $this->signer->token);
        return (new MailMessage)
            ->subject($procedure->subject ?? "Demande de signature pour {$procedure->document->name}")
            ->greeting("Bonjour {$this->signer->name},")
            ->line("{$initiator->name} vous a envoyé un document à signer.")
            ->line($procedure->message ?? 'Veuillez examiner et signer le document ci-joint.')
            //->action('Examiner et Signer', $url)
            ->line('Ce lien expirera le ' . ($procedure->expires_at ? $procedure->expires_at->format('d/m/Y') : 'N/A'));
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}

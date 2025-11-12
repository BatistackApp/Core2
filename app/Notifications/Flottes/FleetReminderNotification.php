<?php

namespace App\Notifications\Flottes;

use App\Models\Flottes\Vehicule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FleetReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $message,
        public Vehicule $vehicule
    ){}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        // TODO: Définir la route vers la fiche véhicule
        // $url = route('flottes.vehicules.show', $this->vehicule->id);

        return (new MailMessage)
            ->error() // Marque l'email comme "important"
            ->subject("Alerte Flotte: {$this->vehicule->name}")
            ->line($this->message)
            // ->action('Voir le véhicule', $url)
            ->line('Veuillez prendre les mesures nécessaires.');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'vehicule_id' => $this->vehicule->id,
            'vehicule_name' => $this->vehicule->name,
            'message' => $this->message,
            // 'url' => route('flottes.vehicules.show', $this->vehicule->id)
        ];
    }

    public function toArray($notifiable): array
    {
        return [
            'vehicule_id' => $this->vehicule->id,
            'vehicule_name' => $this->vehicule->name,
            'message' => $this->message,
            // 'url' => route('flottes.vehicules.show', $this->vehicule->id)
        ];
    }
}

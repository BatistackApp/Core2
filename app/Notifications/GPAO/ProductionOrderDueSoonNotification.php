<?php

namespace App\Notifications\GPAO;

use App\Models\GPAO\ProductionOrder;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductionOrderDueSoonNotification extends Notification
{
    public function __construct(public ProductionOrder $order)
    {
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $order = $this->order;
        $dueDate = $order->due_date->format('d/m/Y');

        return (new MailMessage)
            ->subject("Alerte délai : OF {$order->number}")
            ->line("Bonjour {$notifiable->name},")
            ->line("L'ordre de fabrication n°{$order->number} arrive à échéance le {$dueDate}.")
            ->line("Chantier associé :".$order->chantier?->name ?? 'N/A')
            ->line("Article à produire : {$order->articles->name}")
            ->line('Merci de vérifier son avancement.');
    }

    public function toDatabase($notifiable): array
    {
        return [];
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}

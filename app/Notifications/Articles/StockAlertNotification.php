<?php

namespace App\Notifications\Articles;

use App\Models\Articles\Articles;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StockAlertNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Articles $article,
        public float $totalStock
    ){}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = '#'; // TODO: Remplacer par route('articles.edit', $this->article->id)
        return (new MailMessage)
            ->error() // Marque l'email comme "important"
            ->subject("Alerte Stock Bas: {$this->article->name}")
            ->line("L'article '{$this->article->name}' (Réf: {$this->article->reference}) a atteint un niveau de stock bas.")
            ->line("Stock actuel (tous entrepôts): {$this->totalStock}")
            ->line("Seuil d'alerte: {$this->article->stock_alert_threshold}")
            ->action('Voir l\'article', $url);
    }

    public function toDatabase($notifiable): array
    {
        return [
            'article_id' => $this->article->id,
            'article_name' => $this->article->name,
            'message' => "Stock bas pour {$this->article->name}: {$this->totalStock} / {$this->article->stock_alert_threshold}",
            'url' => '#', // TODO: Remplacer par la route
        ];
    }

    public function toArray($notifiable): array
    {
        return [
            'article_id' => $this->article->id,
            'article_name' => $this->article->name,
            'message' => "Stock bas pour {$this->article->name}: {$this->totalStock} / {$this->article->stock_alert_threshold}",
            'url' => '#', // TODO: Remplacer par la route
        ];
    }
}

<?php

namespace App\Jobs\Articles;

use App\Models\Articles\ArticleStock;
use App\Models\Articles\Inventory;
use DB;
use Filament\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class ValidateInventoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public int $timeout = 600;

    public function __construct(public Inventory $inventory)
    {}

    public function handle(): void
    {
        if ($this->inventory->status === 'validated') {
            return;
        }

        DB::transaction(function () {
            // On charge les lignes par lots (chunks) pour économiser la mémoire
            // si l'inventaire est vraiment massif
            $this->inventory->lines()->chunk(200, function ($lines) {
                foreach ($lines as $line) {
                    $stock = ArticleStock::firstOrCreate(
                        [
                            'articles_id' => $line->article_id,
                            'warehouse_id' => $this->inventory->warehouse_id
                        ],
                        ['quantity' => 0, 'quantity_reserved' => 0]
                    );

                    // Mise à jour du stock
                    $stock->quantity = $line->real_quantity;
                    $stock->save();
                }
            });

            // Marquer comme validé à la fin
            $this->inventory->update([
                'status' => 'validated',
                'validated_at' => now(),
            ]);

            Log::info("Inventaire {$this->inventory->code} validé avec succès.");

            // Optionnel : Envoyer une notification à l'utilisateur via Filament
            Notification::make()->title('Inventaire validé')->sendToDatabase($this->inventory->user);
        });
    }
}

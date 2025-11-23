<?php

namespace App\Livewire\Commerces\Widget;

use App\Enums\Commerces\StatusCommande;
use App\Enums\Commerces\StatusDevis;
use App\Models\Commerces\Commande;
use Filament\Widgets\ChartWidget;

class CommandeChart extends ChartWidget
{
    protected ?string $heading = 'Statistiques - Commandes';
    protected ?string $maxHeight = "250px";

    protected function getData(): array
    {
        $data = Commande::query()
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $datasets = [];
        $labels = [];
        $colors = [];

        foreach (StatusCommande::cases() as $status) {
            $count = $data[$status->value] ?? 0;

            if ($count > 0) {
                $datasets[] = $count;

                // Si vous avez une méthode getLabel() sur l'Enum, sinon ucfirst($status->value)
                $labels[] = $status->value;

                // Mapping des couleurs (Adapté de votre ListDevis)
                $colors[] = match ($status) {
                    StatusCommande::PENDING => '#9ca3af', // Gray (Ghost)
                    StatusCommande::WAITING, StatusCommande::DELIVERED => '#0ea5e9',  // Sky (Info)
                    StatusCommande::CONFIRMED => '#22c55e', // Green (Success)
                    StatusCommande::CANCELED => '#ef4444',  // Red (Error)
                    default => '#d1d5db',
                };
            }
        }
        return [
            'datasets' => [
                [
                    'label' => 'Devis',
                    'data' => $datasets ?? [],
                    'backgroundColor' => $colors,
                    'borderColor' => '#ffffff',
                    'hoverOffset' => 4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}

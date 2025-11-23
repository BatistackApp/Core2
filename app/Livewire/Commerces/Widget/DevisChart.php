<?php

namespace App\Livewire\Commerces\Widget;

use App\Enums\Commerces\StatusDevis;
use App\Models\Commerces\Devis;
use Filament\Widgets\ChartWidget;

class DevisChart extends ChartWidget
{
    protected ?string $heading = 'Statistiques - Propositions commerciales';
    protected ?string $maxHeight = "250px";

    protected function getData(): array
    {
        $data = Devis::query()
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $datasets = [];
        $labels = [];
        $colors = [];

        foreach (StatusDevis::cases() as $status) {
            // On affiche même si 0 pour avoir la légende complète, ou on peut filtrer
            $count = $data[$status->value] ?? 0;

            if ($count > 0) {
                $datasets[] = $count;

                // Si vous avez une méthode getLabel() sur l'Enum, sinon ucfirst($status->value)
                $labels[] = $status->value;

                // Mapping des couleurs (Adapté de votre ListDevis)
                $colors[] = match ($status) {
                    StatusDevis::DRAFT => '#9ca3af', // Gray (Ghost)
                    StatusDevis::SUBMIT => '#0ea5e9',  // Sky (Info)
                    StatusDevis::ACCEPTED => '#22c55e', // Green (Success)
                    StatusDevis::REJECTED, StatusDevis::CANCELLED => '#ef4444',  // Red (Error)
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

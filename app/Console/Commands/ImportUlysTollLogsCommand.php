<?php

namespace App\Console\Commands;

use App\Models\Flottes\VehicleTollLog;
use App\Models\Flottes\Vehicule;
use Illuminate\Console\Command;

class ImportUlysTollLogsCommand extends Command
{
    protected $signature = 'ulys:import';

    protected $description = "Importe les dernières transactions de péage depuis l'API Ulys.";

    public function handle(): void
    {
        $this->info('Démarrage de l\'importation des logs de péage Ulys...');
        $vehicules = Vehicule::whereNotNull('toll_badge_number')->get();

        foreach ($vehicules as $vehicule) {
            $this->line("Import pour: {$vehicule->name} (Badge: {$vehicule->toll_badge_number})");

            try {
                // Todo: Créer l'appel API Ulys
                // --- Appel API (Simulation) ---
                $response = Http::withToken(config('services.ulys.api_key'))
                    ->get('https://api.ulys.com/v1/transactions', [
                        'badge_number' => $vehicule->toll_badge_number,
                        'since' => now()->subDays(3)->toIso8601String(),
                    ]);

                if (!$response->successful()) {
                    throw new \Exception("Erreur API Ulys: " . $response->body());
                }

                $transactions = $response->json()['data'] ?? [];

                // --- Fin Simulation ---

                /*
                // --- VRAI EXEMPLE (Simulation) ---
                $transactions = [
                    [
                        'id' => 'trans_' . uniqid(),
                        'date' => now()->subDay()->toIso8601String(),
                        'amount' => 12.50,
                        'peage' => 'St-Arnoult',
                        'direction' => 'Paris > Chartres'
                    ]
                ];
                // --- Fin VRAI EXEMPLE ---
                */
                foreach ($transactions as $tx) {
                    // [cite: 2025_11_12_143043_create_vehicle_toll_logs_table.php]
                    VehicleTollLog::updateOrCreate(
                        [
                            'provider_transaction_id' => $tx['id'],
                        ],
                        [
                            'vehicule_id' => $vehicule->id,
                            'transaction_date' => $tx['date'],
                            'amount' => $tx['amount'],
                            'peage' => $tx['peage'],
                            'direction' => $tx['direction'],
                            'provider' => 'ulys',
                            // Le 'chantiers_id' est null par défaut et doit être affecté manuellement
                        ]
                    );
                }
                $this->info(count($transactions) . ' transaction(s) importée(s).');
            } catch (\Exception $e) {
                Log::error("Échec import Ulys pour {$vehicule->name}: " . $e->getMessage());
                $this->error("Échec pour {$vehicule->name}.");
            }
        }

        $this->info('Importation Ulys terminée.');
    }
}

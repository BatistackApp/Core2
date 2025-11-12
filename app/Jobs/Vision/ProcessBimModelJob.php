<?php

namespace App\Jobs\Vision;

use App\Enums\Vision\BimModelStatus;
use App\Models\Vision\BimModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Log;

class ProcessBimModelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 1200; // 20 minutes


    public function __construct(private readonly BimModel $bimModel)
    {
    }

    public function handle(): void
    {
        // 1. Marquer le modèle comme "en cours de traitement"
        $this->bimModel->update([
            'processing_status' => BimModelStatus::PROCESSING
        ]);

        try {
            // --- ÉTAPE A : CONVERSION DU FICHIER (Ex: IFC -> GLB) ---

            // Simule l'exécution d'un binaire serveur (ex: ifc-convert)
            // $sourcePath = Storage::disk('local')->path($this->bimModel->source_file_path);
            // $targetPath = 'public/bim_models/' . $this->bimModel->id . '.glb';
            // exec("ifc-convert {$sourcePath} " . Storage::disk('public')->path($targetPath));

            // --- Simulation (on copie juste le fichier) ---
            $targetPath = 'bim_models/' . $this->bimModel->id . '.glb';
            Storage::disk('public')->put($targetPath, Storage::disk('local')->get($this->bimModel->source_file_path));
            // --- Fin Simulation ---

            // --- ÉTAPE B : EXTRACTION DES MÉTADONNÉES (IFC -> JSON) ---

            // Simule l'utilisation d'un parseur IFC
            // $parser = new IfcParser($sourcePath);
            // $metadata = $parser->getObjects();
            // $metadata = [ ['guid' => 'guid-123', 'type' => 'IfcWall', 'name' => 'Mur RDC', 'props' => [...]], ... ]

            // --- Simulation (données factices) ---
            $metadata = [
                ['object_guid' => '1a2b3c-GUID-MUR-001', 'object_type' => 'IfcWall', 'name' => 'Mur extérieur RDC', 'properties' => ['longueur' => 10, 'hauteur' => 2.5]],
                ['object_guid' => '1a2b3c-GUID-PORTE-001', 'object_type' => 'IfcDoor', 'name' => 'Porte Entrée', 'properties' => ['largeur' => 0.9]],
            ];
            // --- Fin Simulation ---

            // 3. Enregistrer les métadonnées extraites
            foreach ($metadata as $objectData) {
                // [cite: app/Models/ThreeDVision/BimObjectMetadata.php]
                $this->bimModel->objects()->create([
                    'object_guid' => $objectData['object_guid'],
                    'object_type' => $objectData['object_type'],
                    'name' => $objectData['name'],
                    'properties' => $objectData['properties'],
                ]);
            }

            // 4. Mettre à jour le statut et le chemin du fichier converti
            $this->bimModel->update([
                'web_viewable_file_path' => $targetPath,
                'processing_status' => BimModelStatus::COMPLETED
            ]);

        } catch (\Exception $e) {
            // En cas d'échec
            $this->bimModel->update([
                'processing_status' => BimModelStatus::FAILED
            ]);
            Log::error("Échec du traitement BIM pour le modèle ID {$this->bimModel->id}: " . $e->getMessage());
            $this->fail($e);
        }
    }
}

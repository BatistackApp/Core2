<?php

namespace App\Observer\GED;

use App\Models\GED\Document;
use App\Models\GED\DocumentVersion;
use Auth;

class DocumentObserver
{
    public function updating(Document $document): void
    {
        // On vérifie si le champ 'current_file_path' est en train d'être modifié.
        // C'est notre indicateur qu'un nouveau fichier a été uploadé.
        if ($document->isDirty('current_file_path')) {

            // 1. Créer une nouvelle entrée 'DocumentVersion'
            //    en utilisant les *anciennes* données (avant la mise à jour)
            // [cite: app/Models/DocumentVersion.php]
            DocumentVersion::create([
                'document_id' => $document->id,
                'user_id' => Auth::id(), // L'utilisateur qui effectue la mise à jour

                // On utilise getOriginal() pour récupérer les données AVANT la modif
                'version_number' => $document->getOriginal('current_version_number'),
                'file_path' => $document->getOriginal('current_file_path'),
                'filename' => $document->getOriginal('current_filename'),
                'mime_type' => $document->getOriginal('current_mime_type'),
                'size' => $document->getOriginal('current_size'),

                // On peut récupérer les notes de version depuis la requête
                'notes' => request('version_notes'),
            ]);

            // 2. Inrémenter le numéro de version sur le modèle Document
            //    (qui contient déjà les *nouvelles* informations de fichier)
            $document->current_version_number = $document->getOriginal('current_version_number') + 1;
        }
    }
}

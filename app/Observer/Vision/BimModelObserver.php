<?php

namespace App\Observer\Vision;

use App\Enums\Vision\BimModelStatus;
use App\Jobs\Vision\ProcessBimModelJob;
use App\Models\Vision\BimModel;

class BimModelObserver
{
    public function created(BimModel $bimModel): void
    {
        // On s'assure que le statut est bien "pending"
        if ($bimModel->processing_status === BimModelStatus::PENDING) {
            // On lance le Job de traitement en file d'attente
            ProcessBimModelJob::dispatch($bimModel);
        }
    }
}
